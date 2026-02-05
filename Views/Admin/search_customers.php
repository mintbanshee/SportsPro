<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../header.php';

// Optional admin-only guard:
// require __DIR__ . '/../../config/app.php';
// require __DIR__ . '/../../auth/require_admin.php';

$lastName = trim($_GET['lastName'] ?? '');
$customers = [];

if ($lastName !== '') {
    $stmt = $db->prepare("
        SELECT customerID, firstName, lastName, email, city, countryCode
        FROM customers
        WHERE lastName LIKE :ln
        ORDER BY lastName, firstName
    ");
    $stmt->execute(['ln' => $lastName . '%']);
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<h2 class="mb-3">Search Customers</h2>

<form class="row g-2 mb-3" method="get" action="search_customers.php" style="max-width: 700px;">
  <div class="col-md-8">
    <label class="form-label">Last Name</label>
    <input class="form-control" name="lastName" value="<?= htmlspecialchars($lastName) ?>" required>
  </div>
  <div class="col-md-4 d-flex align-items-end">
    <button class="btn btn-primary w-100" type="submit">Search</button>
  </div>
</form>

<?php if ($lastName !== ''): ?>
  <div class="card shadow-sm">
    <div class="card-body">
      <?php if (!$customers): ?>
        <div class="alert alert-warning mb-0">
          No customers found with last name starting with <strong><?= htmlspecialchars($lastName) ?></strong>.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-striped table-bordered mb-0">
            <thead class="table-dark">
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Country</th>
                <th style="width:110px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customers as $c): ?>
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
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

<a href="../../index.php" class="btn btn-secondary mt-3">Back to Home</a>

<?php require __DIR__ . '/../footer.php'; ?>
