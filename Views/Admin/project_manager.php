<?php
require __DIR__ . '/../../db/database.php'; // back out to root then in to db 

$sql = "SELECT productCode, name, version, releaseDate FROM products";
$products = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . '/../header.php'; 
?>

<h2 class="mb-3">Product List</h2>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Product Code</th>
            <th>Name</th>
            <th>Version</th>
            <th>Release Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['productCode']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['version']) ?></td>
                <td>
                    <?= date('Y-m-d', strtotime($product['releaseDate'])) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="add_product.php" class="btn btn-primary">
    Add Product
</a>

<?php require __DIR__ . '/../footer.php'; ?>
