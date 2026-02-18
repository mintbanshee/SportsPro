<?php
declare(strict_types=1);

require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_admin.php';
require __DIR__ . '/../../db/database.php';

$productCode = trim($_POST['productCode'] ?? '');

if($productCode === ''){
    header("Location: manage_products.php");
    exit;
}

// delete from the products where the productcode = : code 
$stmt = $pdo->prepare("DELETE FROM products WHERE productCode = :code");
$stmt->execute(['code' => $productCode]);

header("Location: manage_products.php");
exit;
?>