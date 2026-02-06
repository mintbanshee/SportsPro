<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../header.php';

// Optional admin-only guard:
// require __DIR__ . '/../../config/app.php';
// require __DIR__ . '/../../auth/require_admin.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: search_customers.php");
    exit;
}

$stmt = $db->prepare("SELECT * FROM customers WHERE customerID = :id");
$stmt->execute(['id' => $id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    header("Location: search_customers.php");
    exit;
}

// Keep lastName search value so "Back" returns nicely
$lastNameSearch = trim($_GET['lastName'] ?? '');
?>

<h2 class="mb-3">View/Update Customer</h2>

<p>
  <a href="search_customers.php<?= $lastNameSearch ? '?lastName=' . urlencode($lastNameSearch) : '' ?>">
    Search Customers
  </a>
</p>

<!-- added an onsubmit popup for update successful --> 
<form method="post" action="customer_update.php" onsubmit="return confirm('Customer information successfully updated.');" class="card p-3 shadow-sm" style="max-width: 800px;">
  <input type="hidden" name="customerID" value="<?= (int)$customer['customerID'] ?>">
  <input type="hidden" name="lastNameSearch" value="<?= htmlspecialchars($lastNameSearch) ?>">

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
        <?php
          // Minimum list; US must exist per spec
          $countries = ['US' => 'United States', 'CA' => 'Canada', 'JP' => 'Japan']; // added Japan 
          foreach ($countries as $code => $label):
            $selected = ($customer['countryCode'] === $code) ? 'selected' : '';
        ?>
          <option value="<?= $code ?>" <?= $selected ?>>
            <?= htmlspecialchars("$code - $label") ?>
          </option>
        <?php endforeach; ?>
      </select>
      <div class="form-text">US is the country code for the United States.</div>
    </div>
  </div>

  <div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-primary">Update Customer</button>

    <!-- Back without saving -->
    <a class="btn btn-secondary"
       href="manage_customers.php<?= $lastNameSearch ? '?lastName=' . urlencode($lastNameSearch) : '' ?>">
      Back 
      <!-- I changed this to manage customers since I added search bar to manage customers page --> 
    </a>
  </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>
