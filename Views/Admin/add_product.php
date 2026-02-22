<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../header.php';

?>

<h2 class="mb-3">Add Product</h2>

<form method="post" action="<?= BASE_URL ?>controllers/product_controller.php?action=create_product" class="card p-3 shadow-sm" style="max-width: 600px;">
  <input type="hidden" name="action" value="create_product">
  <div class="mb-3">
    <label class="form-label">Product Code</label>
    <input name="productCode" class="form-control" required maxlength="10">
  </div>

  <div class="mb-3">
    <label class="form-label">Name</label>
    <input name="name" class="form-control" required maxlength="255">
  </div>

  <div class="mb-3">
    <label class="form-label">Version</label>
    <input name="version" class="form-control" required maxlength="20">
  </div>

  <div class="mb-3">
    <label class="form-label">Release Date</label>
    <input type="date" name="releaseDate" class="form-control" required>
  </div>

  <div class="d-flex gap-2">
    <a href="<?= BASE_URL ?>controllers/product_controller.php?action=manage_products" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>


