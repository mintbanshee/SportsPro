<?php 

declare(strict_types=1); 
require __DIR__ . '/../config/app.php';
require __DIR__ . '/../db/database.php'; 
require __DIR__ . '/../views/header.php';

if (session_status() === PHP_SESSION_NONE) session_start(); 

$error = ''; 
$email = ''; 
$return_url = $_GET['return'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
  $email = strtolower(trim($_POST['email'] ?? '')); 
  $password = $_POST['password'] ?? ''; 

  // changed $pdo to $db 
  $stmt = $pdo->prepare("SELECT user_id, email, password_hash, role, first_name, last_name FROM users WHERE email = :email"); 
  $stmt->execute(['email' => $email]); 
  $user = $stmt->fetch(PDO::FETCH_ASSOC); 

  if (!$user || !password_verify($password, $user['password_hash'])) { 
    $error = "Invalid email or password."; 
  } else { 
    // Good login: regenerate session id (prevents fixation) 
    session_regenerate_id(true); 

    $_SESSION['user'] = [ 
      'user_id' => (int)$user['user_id'], 
      'email' => $user['email'], 
      'role' => $user['role'], 
      'name' => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')), 
    ]; 

  // Redirect based on role 
  if ($user['role'] === 'admin') { 
    header('Location: ' . BASE_URL . '/views/admin/dashboard.php'); 
    } elseif  
      (!empty($return_url)) {
      header('Location: ' . BASE_URL . '/views/customers/' . $return_url);
    } else {
    header('Location: ' . BASE_URL . '/views/customers/index.php'); 
  } 
  exit; 
  } 
} 
?> 

<!doctype html> 
<html> 
<head><meta charset="utf-8"><title>Login</title></head> 
<body> 

<h2 class="mb-3">Login</h2>

<form method="post" action="login.php?return=<?=htmlspecialchars($return_url) ?>"  class="card p-3 shadow-sm" style="max-width: 650px;">
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input name="email" class="form-control" required maxlength="50" value="<?= htmlspecialchars($email) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required maxlength="50">
  </div>

  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">Login</button>
    <a href="../index.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<p>No account? <a href="<?= BASE_URL ?>/auth/signup.php">Sign up</a></p> 

<?php require __DIR__ . '/../footer.php'; ?>
