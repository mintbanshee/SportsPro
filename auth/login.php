<?php 
declare(strict_types=1); 
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../db/database.php'; 


if (session_status() === PHP_SESSION_NONE) session_start(); 

$pdo = Database::getDB();

$error = ''; 
$email = ''; 
$return_url = $_GET['return'] ?? ''; // if coming from register_product page, GET the return URL from the redirect 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
  $email = strtolower(trim($_POST['email'] ?? '')); 
  $password = $_POST['password'] ?? ''; 

  $stmt = $pdo->prepare("SELECT user_id, email, password_hash, role, first_name, last_name FROM users WHERE email = :email"); 
  $stmt->execute(['email' => $email]); 
  $user = $stmt->fetch(PDO::FETCH_ASSOC); 

  if (!$user || !password_verify($password, $user['password_hash'])) { 
    $error = "Invalid email or password."; 
  } else { 
    session_regenerate_id(true); 

    $_SESSION['user'] = [ 
      'user_id' => (int)$user['user_id'], 
      'email' => $user['email'], 
      'role' => $user['role'], 
      'name' => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')), 
    ]; 

  // Redirects  
  if (!empty($_SESSION['redirect_url'])) { 
    $destination = $_SESSION['redirect_url'];
    unset($_SESSION['redirect_url']);
    header('Location: ' . $destination);
    exit;
  } 

  if ($user['role'] === 'admin') {
    header('Location: ' . BASE_URL . 'views/admin/dashboard.php');
  } else {
    header('Location: ' . BASE_URL . 'views/customers/index.php');
  }
  exit;
  }
}

require_once __DIR__ . '/../views/header.php';

?> 

<!doctype html> 
<html> 
<head><meta charset="utf-8"><title>Login</title></head> 
<body> 

<h2 class="mb-3">Login</h2>
<!-- action ensures user returns even if they mistype password and then they get sent again to login page --> 
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

</body> 
</html>

<?php require __DIR__ . '/../views/footer.php'; ?>
