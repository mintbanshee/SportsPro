<?php
require __DIR__ . '/../db/database.php';
require __DIR__ . '/../models/product_db.php';
require __DIR__ . '/../config/app.php';
require __DIR__ . '/../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? 'manage_products';

switch ($action) {
    case 'manage_products': 
      $products = getProducts();

      include __DIR__ . '/../views/admin/manage_products.php';
      break;
    
    case 'delete_product':
      $productCode = trim($_POST['productCode'] ?? '');

      if($productCode !== '') {
        deleteProduct($productCode);

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

        // validate the date's format and change it to the required format for the assignment
        $timestamp = strtotime($releaseDate);
        if ($timestamp) {
            $formattedDate = date('Y-m-d', $timestamp);
        } else {
            header("Location: " . BASE_URL . "views/admin/add_product.php?error=invalid_date");
            exit;
        }

        // make sure the product is not a duplicate
        if (isDuplicateProduct($productCode)) {
            header("Location: " . BASE_URL . "views/admin/add_product.php?error=exists");
            exit;
        }

        // insert the new product into the database
        addProduct($productCode, $name, $version, $formattedDate);

         $_SESSION['flash_success'] = "Product $name added successfully!";

        header("Location: " . BASE_URL . "controllers/product_controller.php?action=manage_products");
        exit;
        break;
}