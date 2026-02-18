<?php
require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../header.php';
require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_admin.php';

$sql = "SELECT techID, firstName, lastName, email, phone
        FROM technicians
        ORDER BY lastName, firstName";
$techs = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Manage Technicians</h2>
  <a href="add_technician.php" class="btn btn-primary">Add Technician</a>
</div>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th style="width:120px;">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($techs as $t): ?>
      <tr>
        <td><?= htmlspecialchars($t['firstName'] . ' ' . $t['lastName']) ?></td>
        <td><?= htmlspecialchars($t['email']) ?></td>
        <td><?= htmlspecialchars($t['phone']) ?></td>
        <td>
          <form method="post" action="delete_technician.php"
                onsubmit="return confirm('Delete this technician?');">
            <input type="hidden" name="techID" value="<?= (int)$t['techID'] ?>">
            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="../../index.php" class="btn btn-secondary">Back to Home</a>

<?php require __DIR__ . '/../footer.php'; ?>

