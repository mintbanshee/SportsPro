<?php 
declare(strict_types=1); 
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../db/database.php'; 


if (session_status() === PHP_SESSION_NONE) session_start(); 

$pdo = Database::getDB();

$error = ''; 
$email = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
  $email = strtolower(trim($_POST['email'] ?? '')); 
  $password = $_POST['password'] ?? ''; 

// starting with an empty slot
// then will try each account table to find which one is logging in
// this will allow us to have various roles from different tables that are not connected
// if I had the time I would redo it so they are all "user" and the user has
// either admin, technician or customer role which would be changeable on admin dashboard

  $account = null; 

  // try users tables
  $statement = $pdo->prepare("
    SELECT user_id, email, password_hash, role, first_name, last_name
    FROM users
    WHERE email = :email
  "); 
  $statement->execute([':email' => $email]); 
  $user = $statement->fetch(PDO::FETCH_ASSOC); 

  if ($user && password_verify($password, $user['password_hash'])) {
    $account = [
      'role' => $user['role'],               
      'id'   => (int)$user['user_id'],
      'email'=> $user['email'],
      'name' => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
    ];
  }

  // next try technicians table
  if (!$account) {
    $statement = $pdo->prepare("
      SELECT techID, email, passwordHash, firstName, lastName
      FROM technicians
      WHERE email = :email
    ");
    $statement->execute([':email' => $email]);
    $tech = $statement->fetch(PDO::FETCH_ASSOC);

    if ($tech && password_verify($password, $tech['passwordHash'])) {
      $account = [
        'role' => 'technician',
        'id'   => (int)$tech['techID'],
        'email'=> $tech['email'],
        'name' => trim(($tech['firstName'] ?? '') . ' ' . ($tech['lastName'] ?? '')),
      ];
    }
  }

  // lastly try customers table
  if (!$account) {
    $statement = $pdo->prepare("
      SELECT customerID, email, passwordHash, firstName, lastName
      FROM customers
      WHERE email = :email
    ");
    $statement->execute([':email' => $email]);
    $cust = $statement->fetch(PDO::FETCH_ASSOC);

    if ($cust && password_verify($password, $cust['passwordHash'])) {
      $account = [
        'role' => 'customer',
        'id'   => (int)$cust['customerID'],
        'email'=> $cust['email'],
        'name' => trim(($cust['firstName'] ?? '') . ' ' . ($cust['lastName'] ?? '')),
      ];
    }
  }

  // if none of the tables were logging in - fail the login 
  if (!$account) {
    $error = "Invalid email or password.";
  } else {
    session_regenerate_id(true);

    
    $_SESSION['user'] = [
      'role'  => $account['role'],
      'id'    => $account['id'],
      'email' => $account['email'],
      'name'  => $account['name'],
    ];

    // Redirect override
    if (!empty($_SESSION['redirect_url'])) { 
      $destination = $_SESSION['redirect_url'];
      unset($_SESSION['redirect_url']);
      header('Location: ' . $destination);
      exit;
    }

    // admin dashboard
    if ($_SESSION['user']['role'] === 'admin') {
      header('Location: ' . BASE_URL . 'views/admin/dashboard.php');
      exit;
    }

    // technician dashboard
    if ($_SESSION['user']['role'] === 'technician') {
      header('Location: ' . BASE_URL . '/controllers/incident_controller.php?action=tech_dashboard');
      exit;
    }

    // customer - My Account
    header('Location: ' . BASE_URL . 'views/customers/index.php');
    exit;
  }
}

require_once __DIR__ . '/../views/header.php';

?> 

<h2 class="mb-3">Login</h2>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<!-- action ensures user returns even if they mistype password and then they get sent again to login page --> 
<form method="post" action="login.php"  class="card p-3 shadow-sm" style="max-width: 650px;">
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
