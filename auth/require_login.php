<?php 

declare(strict_types=1); 

require __DIR__ . '/../config/app.php';
require __DIR__ . '/../db/database.php'; 

if(session_status() === PHP_SESSION_NONE) session_start(); 

if(empty($_SESSION["user"])) {
  header('Location: ' . BASE_URL . '/auth/login.php?return=register_product.php');
  // redirect from register_product to login page and tack on the return to register_product return URL 
  exit;
}

?>