<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../auth/require_login.php'; 
require_once __DIR__ . '/../header.php';

$pdo = Database::getDB();

?>

<!doctype html> 
<html> 
<head><meta charset="utf-8"><title>My Account</title></head> 
<body> 

<div class="text-center mb-5">
    <h1 class="fw-bold">My Account</h1>
    <p class="lead text-muted">
        Welcome <?= htmlspecialchars($_SESSION['user']['name']) ?>! 
    </p>
</div>


<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><?= htmlspecialchars($_SESSION['user']['name']) ?></td>
      <td><?= htmlspecialchars($_SESSION['user']['email']) ?></td>
      <td><?= htmlspecialchars($_SESSION['user']['role'] ?? '—') ?></td>
    </tr>
  </tbody>
</table>

<a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-danger">Logout</a>
<a href="../../index.php" class="btn btn-secondary">Back to Home</a> 

<?php if ($_SESSION['user']['role'] === 'admin'): ?> 
<a href="<?= BASE_URL ?>/views/admin/dashboard.php" class="btn btn-primary">Admin Dashboard</a>
<?php endif; ?> 


<?php require __DIR__ . '/../footer.php'; ?>

