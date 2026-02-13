<?php 

declare(strict_types=1); 

require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_login.php'; 
require __DIR__ . '/../header.php';

if (session_status() === PHP_SESSION_NONE) session_start(); 

$sql = "SELECT first_nmame, last_name
        FROM users
        ORDER BY last_name, first_name";
$users = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT name, version
        FROM products
        ORDER BY name, version";
$products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Register Product</h2>
</div>


<p>Customer Name: <?= htmlspecialchars($_SESSION['user']['name']) ?></p>




</body>
</html>