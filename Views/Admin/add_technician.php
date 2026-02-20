<?php
require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../header.php';
require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_admin.php';
?>

<h2 class="mb-3">Add Technician</h2>

<form method="post" action="<?= BASE_URL ?>controllers/technician_controller.php?action=create_technician" class="card p-3 shadow-sm" style="max-width: 650px;">
  <div class="mb-3">
    <label class="form-label">First Name</label>
    <input name="firstName" class="form-control" required maxlength="50">
  </div>

  <div class="mb-3">
    <label class="form-label">Last Name</label>
    <input name="lastName" class="form-control" required maxlength="50">
  </div>

  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required maxlength="255">
  </div>

  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input name="phone" class="form-control" required maxlength="20">
  </div>

  <div class="d-flex gap-2">
    <a href="<?= BASE_URL ?>controllers/technician_controller.php?action=manage_technicians" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Add Technician</button>

  </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>
