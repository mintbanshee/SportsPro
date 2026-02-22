<?php 
declare(strict_types=1); 

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../db/database.php'; 
require_once __DIR__ . '/require_login.php';

if (!isset($_SESSION['user'])) { // if they are not logged in
  $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Store the current URL to return after login
  header('Location: ' . BASE_URL . '/views/auth/login.php'); 
  exit;
}

if(($_SESSION['user']['role'] ?? '') !== 'admin') { // if they are not admin
  header('Location: ' . BASE_URL . '/views/customers/index.php'); // go to my account page 
  exit; 
}