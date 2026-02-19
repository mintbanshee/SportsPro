<?php
require __DIR__ . '/../header.php';
?>

<h2 class="mb-3">View/Update Customer</h2>

<p>
  <a href="<?= BASE_URL ?>controllers/customer_controller.php?action=manage_customers&lastName=<?php echo urlencode($lastNameSearch); ?>">
    Search Customers
  </a>
</p>

<form method="post" action="<?= BASE_URL ?>controllers/customer_controller.php" onsubmit="return confirm('Save changes to customer?');" class="card p-3 shadow-sm" style="max-width: 800px;">
  <input type="hidden" name="customerID" value="<?= (int)$customer['customerID'] ?>">
  <input type="hidden" name="lastNameSearch" value="<?= htmlspecialchars($lastNameSearch ?? '') ?>">
  <input type="hidden" name="action" value="update_customer">

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">First Name</label>
      <input name="firstName" class="form-control" required value="<?= htmlspecialchars($customer['firstName']) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Last Name</label>
      <input name="lastName" class="form-control" required value="<?= htmlspecialchars($customer['lastName']) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($customer['email']) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Phone</label>
      <input name="phone" class="form-control" required value="<?= htmlspecialchars($customer['phone']) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Address</label>
      <input name="address" class="form-control" required value="<?= htmlspecialchars($customer['address']) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">City</label>
      <input name="city" class="form-control" required value="<?= htmlspecialchars($customer['city']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">State</label>
      <input name="state" class="form-control" required value="<?= htmlspecialchars($customer['state']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Postal Code</label>
      <input name="postalCode" class="form-control" required value="<?= htmlspecialchars($customer['postalCode']) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Country</label>
      <select name="countryCode" class="form-select" required>
        <?php foreach ($countries as $country): ?>
          <option value="<?= htmlspecialchars($country['countryCode']) ?>"
          <?= ($customer['countryCode'] === $country['countryCode']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($country['countryCode']) . ' - ' . $country['countryName'] ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="d-flex gap-2 mt-3">
<!-- Back without saving -->
    <a class="btn btn-secondary"
       href="<?= BASE_URL ?>controllers/customer_controller.php?action=manage_customers&lastName=<?php echo urlencode($lastNameSearch); ?>">
      Back 
      <!-- I changed this to manage customers since I added search bar to manage customers page --> 
    </a>
    <button type="submit" class="btn btn-primary">Update Customer</button>

  </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>
