<?php 

declare(strict_types=1); 

require __DIR__ . '/../config/app.php';
require __DIR__ . '/../db/database.php'; 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if(session_status() === PHP_SESSION_NONE) session_start();

$errors = [];
$email = '';
$first = '';
$last = '';
$role = 'student'; // default for students

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = strtolower(trim($_POST['email'] ?? '')); // convert to lowercase and trim out whitespace
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm_password'] ?? '';
  $first = $_POST['first_name'] ?? '';
  $last = $_POST['last_name'] ?? '';
  $role = ($_POST['role'] ?? 'student'); // allows 'student' as the user

  // basic validation
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required";
  if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters.";
  if ($password !== $confirm) $errors[] = "Passwords do not match.";

  // Prevent users from self-registering as admin
    if (!in_array($role, ['student', 'user'], true)) $role = 'student';

    if (!$errors){
    // check if email exists
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
      $errors[] = "That email is already registered.";
    } else {
    // hash tag default in password with mysql and php 
    $hash = password_hash($password, PASSWORD_DEFAULT);
    // insert into users ( email, password, role, first name, lastname  values email, :hash, role, first, last )
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
<head><meta charset="utf-8"><title>Sign Up</title></head>
<body>
<h2>Sign Up</h2>
 
<?php if ($errors): ?>
  <ul style="color:red;">
    <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
  </ul>
<?php endif; ?>
 
<form method="post">
  <label>First Name <input name="first_name" value="<?= htmlspecialchars($first) ?>"></label><br>
  <label>Last Name <input name="last_name" value="<?= htmlspecialchars($last) ?>"></label><br>
  <label>Email <input name="email" value="<?= htmlspecialchars($email) ?>" required></label><br>
  <label>Password <input type="password" name="password" required></label><br>
  <label>Confirm <input type="password" name="confirm_password" required></label><br>
 
  <!-- For your students: keep it simple -->
  <label>Account Type
    <select name="role">
      <option value="student" <?= $role==='student'?'selected':'' ?>>Student</option>
      <option value="user" <?= $role==='user'?'selected':'' ?>>User</option>
    </select>
  </label><br><br>
 
  <button type="submit">Create Account</button>
</form>
 
<p>Already have an account? <a href="<?= BASE_URL ?>/auth/login.php">Login</a></p>
</body>
</html>