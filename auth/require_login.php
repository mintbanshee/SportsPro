<?php 
declare(strict_types=1); 

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../db/database.php'; 

if(session_status() === PHP_SESSION_NONE) session_start(); 

if(empty($_SESSION["user"])) {
  // save the current URL to redirect back to
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
  // redirect to login page
  header('Location: ' . BASE_URL . '/auth/login.php'); 
  exit;
}