<?php 

declare(strict_types=1); 

require __DIR__ . '/../config/app.php';
require __DIR__ . '/../db/database.php'; 
require __DIR__ . '/../views/header.php';

if(session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$email = '';
$first = '';
$last = '';
$role = 'student'; 

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = strtolower(trim($_POST['email'] ?? '')); 
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm_password'] ?? '';
  $first = $_POST['first_name'] ?? '';
  $last = $_POST['last_name'] ?? '';
  $role = ($_POST['role'] ?? 'student'); 

  // basic validation
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required";
  if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";
  if ($password !== $confirm) $errors[] = "Passwords do not match.";

  // Prevent users from self-registering as admin
    if (!in_array($role, ['student', 'user'], true)) $role = 'student';

    if (!$errors){
 
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email"); // check if the email is already registered
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
      $errors[] = "That email is already registered.";
    } else {
  
    $hash = password_hash($password, PASSWORD_DEFAULT); // hash the password for security
 
    // Insert the new user into the database
      $stmt = $pdo->prepare("
      INSERT INTO users (email, password_hash, role, first_name, last_name) 
      VALUES (:email, :hash, :role, :first, :last)");
          $stmt->execute([
                'email' => $email,
                'hash'  => $hash,
                'role'  => $role,
                'first' => $first ?: null,
                'last'  => $last ?: null,
            ]);
 
            // Auto-login after signup
            $newId = (int)$pdo->lastInsertId();
            $_SESSION['user'] = [
                'user_id' => $newId,
                'email'   => $email,
                'role'    => $role,
                'name'    => trim("$first $last"),
            ];
 
            // redirect based on role
            header('Location: ' . BASE_URL . '/views/customers/index.php');
            exit;
        }
    }
}
?>

<!doctype html> 
<html> 
<head><meta charset="utf-8"><title>Login</title></head> 
<body> 
 
<?php if ($errors): ?>
  <ul style="color:red;">
    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
  </ul>
<?php endif; ?>

<h2 class="mb-3">Sign Up</h2>

<form method="post" class="card p-3 shadow-sm" style="max-width: 650px;">
  <div class="mb-3">
    <label class="form-label">First Name</label> 
    <input name="first_name" class="form-control" required value="<?= htmlspecialchars($first) ?>">
  </div>

 <div class="mb-3">
    <label class="form-label">Last Name</label> 
    <input name="last_name" class="form-control" required value="<?= htmlspecialchars($last) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Email</label> 
    <input name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label> 
    <input name="password" type="password" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Confirm Password</label> 
    <input name="confirm_password" type="password" class="form-control" required>
  </div>
 
  <!-- For your students: keep it simple -->
  <label>Account Type
    <select name="role">
      <option value="student" <?= $role==='student'?'selected':'' ?>>Student</option>
      <option value="user" <?= $role==='user'?'selected':'' ?>>User</option>
    </select>
  </label><br><br>
 
<div class="d-flex gap-2">
    <a href="../index.php" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Create</button>
  </div>
</form>
 
<p>Already have an account? <a href="<?= BASE_URL ?>/auth/login.php">Login</a></p>

</body>
</html>

<?php require __DIR__ . '/../views/footer.php'; ?>