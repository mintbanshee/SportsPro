<?php 
declare(strict_types=1); 

require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_admin.php'; 
require __DIR__ . '/../header.php';


$stmt = $pdo->query('SELECT * FROM users'); // gather all the users from the database 
$users = $stmt->fetchAll(PDO::FETCH_ASSOC); 

?>
<!doctype html> 
<html> 
<head><meta charset="utf-8"><title>Admin Dashboard</title></head> 
<body> 

<div class="text-center mb-5">
    <h1 class="fw-bold">Admin Dashboard</h1>
    <p class="lead text-muted">
        Welcome <?= htmlspecialchars($_SESSION['user']['name']) ?>! 
    </p>
</div>

<h2 class="mb-4">Manage Users</h2>
<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>  <!-- loop through the users and display their info in a table --> 
      <tr>
        <td><?= htmlspecialchars($u['first_name'].' ' . $u['last_name']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['role'] ?? '—') ?></td>
        <td>
          <a class="btn btn-sm btn-secondary"
            href="user_edit.php?id=<?= (int)$u['user_id'] ?>">
            Edit
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>



<a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-danger">Logout</a>
<a href="../../index.php" class="btn btn-secondary">Back to Home</a> 
<a href="<?= BASE_URL ?>/views/customers/index.php" class="btn btn-primary">My Account</a> 

</body> 
</html> 

<?php require __DIR__ . '/../footer.php'; ?>

