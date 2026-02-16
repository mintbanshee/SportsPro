<?php

require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../header.php';
require __DIR__ . '/../../config/app.php';
require __DIR__ . '/../../auth/require_admin.php';

$sql = "SELECT customerID, firstName, lastName, email, city, countryCode
        FROM customers
        ORDER BY lastName, firstName";
$customers = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Manage Customers</h2>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
  <form method="get" action="search_customers.php">
    <label class="form-label">Last Name</label>
    <input type="text" name="lastName">
    <button class="btn btn-sm btn-primary" type="submit">Search</button>
  </form>
</div>


<table class="table table-striped table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>City</th>
      <th>Country</th>
      <th style="width:120px;">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($customers as $c): ?> <!-- changed the t's from technician page to c's for customer --> 
      <tr>
        <td><?= htmlspecialchars($c['firstName'] . ' ' . $c['lastName']) ?></td>
        <td><?= htmlspecialchars($c['email']) ?></td>
        <td><?= htmlspecialchars($c['city']) ?></td>
        <td><?= htmlspecialchars($c['countryCode']) ?></td> 
        <td>
          <a class="btn btn-sm btn-secondary"
            href="customer_edit.php?id=<?= (int)$c['customerID'] ?>">
            Select
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="../../index.php" class="btn btn-secondary">Back to Home</a>

<?php require __DIR__ . '/../footer.php'; ?>

