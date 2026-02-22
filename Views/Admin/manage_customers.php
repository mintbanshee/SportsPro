<?php
require_once __DIR__ . '/../header.php';
?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Manage Customers</h2>
</div>

<div class="d-flex align-items-center justify-content-between mb-3">
  <form method="get" action="<?= BASE_URL ?>controllers/customer_controller.php">
    <input type="hidden" name="action" value="manage_customers">

    <label class="form-label">Last Name</label>
    <input type="text" name="lastName" value="<?= htmlspecialchars($lastName ?? '') ?>">
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
          href="<?= BASE_URL ?>controllers/customer_controller.php?action=edit_customer&id=<?= $c['customerID'] ?>&lastName=<?= urlencode($lastName ?? '') ?>">
          Select
        </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<a href="<?= BASE_URL ?>index.php" class="btn btn-secondary">Back to Home</a>
<a class="btn btn-primary"
    href="<?= BASE_URL ?>controllers/customer_controller.php?action=add_customer&lastName=<?= urlencode($lastName ?? '') ?>">
    Add New Customer
</a>

<?php if (isset($_SESSION['flash_success'])): ?>
    <script>alert("<?= $_SESSION['flash_success'] ?>");</script>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>

<?php require __DIR__ . '/../footer.php'; ?>

