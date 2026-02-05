<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../header.php'; 

$sql = "SELECT productCode, name, version, releaseDate FROM products ORDER BY name";
$products = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Manage Products</h2>
  <a href="add_product.php" class="btn btn-primary">Add Product</a>
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
        <td><?= htmlspecialchars($product['releaseDate']) ?></td>
        <td>
          <form method="post" action="delete_product.php" onsubmit="return confirm('Delete this product?');">
            <input type="hidden" name="productCode" value="<?= htmlspecialchars($product['productCode']) ?>">
            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="../../index.php" class="btn btn-secondary">Back to Home</a>

<?php require __DIR__ . '/../footer.php'; ?>
