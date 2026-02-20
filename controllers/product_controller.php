<?php
require __DIR__ . '/../db/database.php';
require __DIR__ . '/../config/app.php';
require __DIR__ . '/../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? 'manage_products';

switch ($action) {
    case 'manage_products': // copied from manage_products.php but changed to SELECT * 
      $sql = "SELECT * FROM products ORDER BY name";
      $products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

      include __DIR__ . '/../views/admin/manage_products.php';
      break;
    
    case 'delete_product': // copied from delete_product.php with minor changes
      $productCode = trim($_POST['productCode'] ?? '');

      if($productCode !== '') {
        $stmt = $pdo->prepare("DELETE FROM products WHERE productCode = :code");
        $stmt->execute(['code' => $productCode]);
        $_SESSION['flash_success'] = "Product $productCode deleted.";

        header("Location: " . BASE_URL . "controllers/product_controller.php?action=manage_products");
        exit;
      }
      break;

      case 'create_product': 
        // pass the products code, name, version and realeasedate 
        $productCode = trim($_POST ['productCode'] ?? ''); 
        $name = trim($_POST ['name'] ?? ''); 
        $version = trim($_POST ['version'] ?? ''); 
        $releaseDate = trim($_POST ['releaseDate'] ?? ''); 

        if($productCode === '' || $name === '' || $version === '' || $releaseDate === ""){
            header("Location: " . BASE_URL . "views/admin/add_product.php?error=required");
            exit;
        }

        // make sure the product is not a duplicate
        $check = $pdo->prepare("SELECT productCode FROM products WHERE productCode = :code");
        $check->execute(['code' => $productCode]);
        if ($check->fetch()) {
            header("Location: " . BASE_URL . "views/admin/add_product.php?error=exists");
            exit;
        }

        // insert the new product into the database
        $stmt = $pdo->prepare("
            INSERT INTO products (productCode, name, version, releaseDate)
            VALUES (:code, :name, :version, :date)
        ");

        // execute the statement 
        $stmt->execute([
            'code'    => $productCode,
            'name'    => $name,
            'version' => $version,
            'date'    => $releaseDate
        ]);

        header("Location: " . BASE_URL . "controllers/product_controller.php?action=manage_products");
        exit;
        break;
}