<?php 
declare(strict_types=1); 
require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_admin.php'; 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?> 

<!doctype html> 
<html> 
<head><meta charset="utf-8"><title>Admin Dashboard</title></head> 
<body> 
<h1>Admin Dashboard</h1> 
<p>Welcome <?= htmlspecialchars($_SESSION['user']['email']) ?>!</p> 

<ul> 
  <li><a href="<?= BASE_URL ?>/views/customers/index.php">Go to Account</a></li> 
  <li><a href="<?= BASE_URL ?>/auth/logout.php">Logout</a></li> 
</ul> 
</body> 
</html> 