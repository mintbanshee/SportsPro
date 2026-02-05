<?php
require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../header.php';
?>

<h2 class="mb-3">Add Product</h2>

<form method="post" action="create_product.php" class="card p-3 shadow-sm" style="max-width: 600px;">
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
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="manage_products.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>


