<?php
require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../header.php';
require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_admin.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id"); // gather the user data
$stmt->execute(['user_id' => $id]); // we are going to us $id to keep things easy
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) { // if this user doesn't exist, return to the dashboard
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
  $stmt = $pdo->prepare("UPDATE users SET role = :role WHERE user_id = :user_id"); // update the role in the database
  $stmt->execute([
    'role' => $_POST['role'], // use the role inputed in the form to update the database 
    'user_id' => $id
  ]); 
  header("Location: dashboard.php"); // return to the dashboard after updating 
  exit;
}

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit User</title>
 </head>
 <body>
  
 </body>
 </html>
<h2 class="mb-3">View/Edit User</h2>


<form method="post" action="user_update.php" onsubmit="return confirm('User information successfully updated.');" class="card p-3 shadow-sm" style="max-width: 800px;">
  <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>"> <!-- this hidden input tells the update page which user to update --> 
  <input type="hidden" name="lastNameSearch" value="<?= htmlspecialchars($lastNameSearch) ?>"> 
  

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">First Name</label>
      <input name="firstName" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Last Name</label>
      <input name="lastName" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Role</label>
      <select name="role" class="form-select" required>
        <?php 
        $roles = ['student' => 'Student', 'user' => 'User', 'admin' => 'Admin']; // array of the possible roles 
        
        foreach ($roles as $role => $label): // loop through the roles to create the options for the dropdown 
          $selected = ($role === $user['role']) ? 'selected' : ''; // mark the current role as selected
          ?>
          <option value="<?= htmlspecialchars($role) ?>" <?= $selected ?>>  
            <?= htmlspecialchars($label) ?> 
          </option>
        <?php endforeach; ?>
      </select>
    </div>

  </div>

  <div class="d-flex gap-2 mt-3">
    <a class="btn btn-secondary"
       href="dashboard.php<?= $lastNameSearch ? '?lastName=' . urlencode($lastNameSearch) : '' ?>"> 
      Back 
    </a>
    <button type="submit" class="btn btn-primary">Update User</button>

  </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>
