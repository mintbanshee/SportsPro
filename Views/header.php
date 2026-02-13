<?php 
// 1. Pathing Anchor
require_once __DIR__ . '/../config/app.php'; 

// 2. Session Handshake
if (session_status() === PHP_SESSION_NONE) session_start(); 

// 3. Your existing variable for CSS/Images
$base_url = '/PHPAssignments/SportsPro'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SportsPro Technical Support</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>index.php">
            SportsPro Technical Support
        </a>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>index.php">Home</a>
                </li>

                <?php if (!empty($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <span class="navbar-text me-3 text-light">
                            Welcome, <?= htmlspecialchars($_SESSION['user']['firstName'] ?? $_SESSION['user']['email']) ?>
                        </span>
                    </li>
                    
                    <li class="nav-item">
                        <a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>auth/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL ?>auth/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">