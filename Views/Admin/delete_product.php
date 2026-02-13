<?php
declare(strict_types=1);

//after testing I can add the admin login and force them to be admin to view the page 
// require __DIR__ . '/../../config/app.php';
//require __DIR__ . '/../../auth/require_admin.php';
//need to recreate this from the example learned in session and cookies week 3
//also need to create the database table users to perform this task


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