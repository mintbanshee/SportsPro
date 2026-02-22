<?php
require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../../config/app.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Manage Technicians</h2>
  <a href="<?= BASE_URL ?>views/admin/add_technician.php" class="btn btn-primary">Add Technician</a>
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
    <?php foreach ($technicians as $t): ?>
      <tr>
        <td><?= htmlspecialchars($t->firstName . ' ' . $t->lastName) ?></td>
        <td><?= htmlspecialchars($t->email) ?></td>
        <td><?= htmlspecialchars($t->phone) ?></td>
        <td>
          <form method="post" action="<?= BASE_URL ?>controllers/technician_controller.php?action=delete_technician"
                onsubmit="return confirm('Delete this technician?');">
            <input type="hidden" name="action" value="delete_technician">
            <input type="hidden" name="techID" value="<?= (int)$t->techID ?>">
            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?= BASE_URL ?>index.php" class="btn btn-secondary">Back to Home</a>

<?php if (isset($_SESSION['flash_success'])): ?>
    <script>alert("<?= $_SESSION['flash_success'] ?>");</script>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php require __DIR__ . '/../footer.php'; ?>

