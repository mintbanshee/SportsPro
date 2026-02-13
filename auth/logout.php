<?php 

declare(strict_types=1); 

require __DIR__ . '/../config/app.php';
require __DIR__ . '/../db/database.php'; 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) session_start(); 

$_SESSION = []; 
if (ini_get("session.use_cookies")) { 
  $params = session_get_cookie_params(); 
  setcookie(session_name(), '', time() - 42000, 
  $params["path"], $params["domain"], $params["secure"], $params["httponly"] 
); 
} 
session_destroy(); 

header('Location: ' . BASE_URL . '/auth/login.php'); 
exit; 

?>
 

 