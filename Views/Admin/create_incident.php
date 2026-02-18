<?php
require __DIR__ . '/../../db/database.php';
require __DIR__ . '/../../auth/require_admin.php';
require __DIR__ . '/../header.php';

$sql = "SELECT * FROM customers WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $_GET['email'] ?? '']);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

$sqlProducts = "SELECT productCode, name, version FROM products";
$products = $pdo->query($sqlProducts)->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Create Incident</h2>
</div>

<p>You must search for a customer by their email to create an incident.</p>
<div class="d-flex align-items-center justify-content-between mb-3">
  <form method="get" action="create_incident.php">
    <label class="form-label">Customer Email:</label>
    <input type="text" name="email">
    <button class="btn btn-sm btn-primary" type="submit">Search Customer</button>
  </form>
</div>

<?php if ($customer): ?>
  <div class="alert alert-success">
    Customer Selected: <strong><?php echo $customer['firstName'] . ' ' . $customer['lastName']; ?></strong>
  </div>
  <?php elseif (isset($_GET['email'])): ?>
  <div class="alert alert-danger">Customer not found.</div>
<?php endif; ?>



<form method="post" action="create_incident.php" onsubmit="return confirm('Incident successfully created.');" class="card p-3 shadow-sm" style="max-width: 800px;"> 
  <input type="hidden" name="lastNameSearch" value="<?= htmlspecialchars($lastNameSearch) ?>"> 
  

  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Customer Name:</label>
      <input name="name" class="form-control" value="<?= htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']) ?>" readonly>
    </div>

    <div class="col-md-4">
      <label class="form-label">Product</label>
      <select name="productCode" class="form-select" required>
        <?php foreach ($products as $product): ?>
          <option value="<?php echo $product['productCode']; ?>">
            <?php echo htmlspecialchars($product['name'] . ' ' . $product['version']); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
        
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Incident Title:</label>
      <input name="title" input type="text" class="form-control" required>
    </div>
  
    <div class="col-md-6">
      <label class="form-label">Description of Issue:</label>
      <textarea name="description" class="form-control" rows="5"required></textarea>
    </div>
  </div>

  <div class="d-flex gap-2 mt-3">
    <a href="../../index.php" class="btn btn-secondary">Back to Home</a>
    <button type="submit" class="btn btn-primary">Create Incident</button>

  </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>