<?php 

declare(strict_types=1); 

require __DIR__ . '/../config/app.php';
require __DIR__ . '/../db/database.php'; 
require __DIR__ . 'require_login.php';

if(($_SESSION['user']['role'] ?? '') !== 'admin') { // if they are not admin
  header('Location: ' . BASE_URL . '/views/customers/index.php'); // go to user page 
  exit; 
}


?>