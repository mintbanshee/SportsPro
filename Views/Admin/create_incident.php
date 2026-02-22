<?php
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../auth/require_admin.php';

$pdo = Database::getDB();

// create the incident when the form is submitted, then redirect to success page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customerID = $_POST['customerID'];
  $productCode = $_POST['productCode'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $dateOpened = date('Y-m-d H:i:s');

  $sql = "INSERT INTO incidents (customerID, productCode, title, description, dateOpened) 
          VALUES (:customerID, :productCode, :title, :description, :dateOpened)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    'customerID' => $customerID,
    'productCode' => $productCode,
    'title' => $title,
    'description' => $description,
    'dateOpened' => $dateOpened
  ]);

  header('Location: incident_success.php');
  exit;
}

require __DIR__ . '/../header.php';

$sql = "SELECT * FROM customers WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $_GET['email'] ?? '']);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// If a customer is found, fetch their registered products; otherwise, set products to an empty array
// this way the product dropdown only shows their registered products or is empty if no registered products
// using products. and registrations. because we are using 2 tables and need to specify which table to pull from 
$sqlProducts = []; // default to empty array
if ($customer) {
  $sqlProducts = "SELECT products.productCode, products.name, products.version
                  FROM products
                  JOIN registrations ON products.productCode = registrations.productCode
                  WHERE registrations.customerID = :customerID";
  $stmtProducts = $pdo->prepare($sqlProducts); 
  $stmtProducts->execute(['customerID' => $customer['customerID']]);
  $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC); 
}

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



<form method="post" action="create_incident.php" class="card p-3 shadow-sm" style="max-width: 800px;"> 
  <input type="hidden" name="customerID" value="<?= $customer['customerID'] ?? '' ?>">
  
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Customer Name:</label>
      <input name="name" class="form-control" value="<?= htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']) ?>" readonly>
      <!-- readonly so the customer's name cannot accidently be changed when creating an incident also name is autofilled when searched --> 
    </div>

    <!-- product dropdown, displays name and version. will only show products registered to the searched customer --> 
    <div class="col-md-4">
      <label class="form-label">Product</label>
      <select name="productCode" class="form-select" required>
        <?php if (empty($products)): ?>
          <option value="">- No registered products -</option>
        <?php else: ?>
          <option value="" disabled selected>- Select a product -</option>
        <?php foreach ($products as $product): ?>
          <option value="<?php echo $product['productCode']; ?>">
            <?php echo htmlspecialchars($product['name'] . ' ' . $product['version']); ?>
          </option>
        <?php endforeach; ?>
        <?php endif; ?>
      </select>
    </div>
  </div>
        
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Incident Title:</label>
      <input name="title" type="text" class="form-control" required>
    </div>
  
    <div class="col-md-6">
      <label class="form-label">Description of Issue:</label>
      <textarea name="description" class="form-control" rows="5"required></textarea>
    </div>
  </div>

  <div class="d-flex gap-2 mt-3">
    <a href="../../index.php" class="btn btn-secondary">Back to Home</a>

    <?php if (!empty($products)): ?>
      <button type="submit" class="btn btn-primary">Create Incident</button>
    <?php else: ?>
      <button type="button" class="btn btn-danger" disabled title="No registered products">Create Incident</button>
    <?php endif; ?>
  </div>
</form>

<?php require __DIR__ . '/../footer.php'; ?>