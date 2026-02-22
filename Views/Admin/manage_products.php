<?php
require_once __DIR__ . '/../header.php'; 
require_once __DIR__ . '/../../config/app.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Manage Products</h2>
  <a href="<?= BASE_URL ?>/views/admin/add_product.php" class="btn btn-primary">Add Product</a>
</div>

<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Product Code</th>
      <th>Name</th>
      <th>Version</th>
      <th>Release Date</th>
      <th style="width: 120px;">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $product): ?>
      <tr>
        <td><?= htmlspecialchars($product['productCode']) ?></td>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= htmlspecialchars($product['version']) ?></td>
        <td>
            <?php 
              $date = new DateTime($product['releaseDate']);
              echo $date->format('n/j/Y'); // the n and the j remove the leading zeros 
            ?>
        </td>
        <td>
          <form method="post" action="<?= BASE_URL ?>/controllers/product_controller.php?action=delete_product" onsubmit="return confirm('Delete this product?');">
            <input type="hidden" name="productCode" value="<?= htmlspecialchars($product['productCode']) ?>">
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
