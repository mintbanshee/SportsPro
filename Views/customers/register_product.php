<?php 
declare(strict_types=1); 

require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../auth/require_login.php'; 

$pdo = Database::getDB();

if (session_status() === PHP_SESSION_NONE) session_start(); 

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['user']['user_id'];
    $statement = $pdo->prepare("SELECT * FROM customers WHERE customerID = :id");
    $statement->execute(['id' => $customer_id]);
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$customer) {
      die("Cannot register product: Customer not found in system.");
    }
    $product_code = $_POST['product_code'];
    $reg_date = date('Y-m-d H:i:s');

    // make sure product is not already registered to the user 
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM registrations 
    WHERE customerID = :cID AND productCode = :pCode");
    $checkStmt->execute(['cID' => $customer_id, 'pCode' => $product_code]);
    $count = $checkStmt->fetchColumn();

    // if already registered have error message 
    if ($count > 0) {
      $error_message = "This product is already registered to your account.";
    } else {

    // insert registered product to registration table in database 
    $stmt = $pdo->prepare("INSERT INTO registrations (customerID, productCode, registrationDate) 
      VALUES (:customerID, :productCode, :registrationDate)");
    $stmt->execute([
      'customerID' => $customer_id,
      'productCode' => $product_code,
      'registrationDate' => $reg_date
    ]);
    // if registration works have success message with product code 
    $success_message = "Product ($product_code) was registered successfully.";
  }
}
// get customer name
$sql = "SELECT first_name, last_name 
        FROM users
        ORDER BY last_name, first_name";
$users = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// get product info
$sql = "SELECT name, version, productCode
        FROM products
        ORDER BY name, version";
$products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . '/../header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
<div class="d-flex align-items-center justify-content-between mb-3">
  <h2 class="mb-0">Register Product</h2>
</div>

<!-- check if successful or not --> 
<?php if (isset($success_message) || (isset($error_message))) : ?>

<!-- if successful show success message --> 
  <?php if (isset($success_message)) : ?>
    <div class="alert alert-success" role="alert">
      <?= htmlspecialchars($success_message) ?>   
    </div>
  <?php endif; ?>

<!-- if it was already registered show error message --> 
  <?php if (isset($error_message)) : ?>
    <div class="alert alert-danger" role="alert">
      <?= htmlspecialchars($error_message) ?>
    </div>
  <?php endif; ?>

<!-- included Register another product button and back to home button for ease of use --> 
  <a href="../../index.php" class="btn btn-secondary">Back to Home</a> 
  <a href="register_product.php" class="btn btn-primary">Register Another Product</a>

<!-- the register a product screen with dropdown --> 
  <?php else : ?>
  
  <p>Customer Name: <?= htmlspecialchars($_SESSION['user']['name']) ?></p> <!-- display user name from stabase --> 
  <form method="post" action="register_product.php">
    <select name="product_code" class="form-select mb-3"> <!-- use primary key to pull information -->
    <?php foreach ($products as $p): ?> <!-- for each product, we shall call p... --> 
      <option value="<?= $p['productCode'] ?>">
        <?= htmlspecialchars($p['name'] . ' ' . $p['version']) ?> <!-- display the name and version # --> 
      </option>
    <?php endforeach; ?> 
    </select> 
    <a href="../../index.php" class="btn btn-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Register Product</button>
  
  </form>  
<?php endif; ?> 

</body>
</html>

<?php require __DIR__ . '/../footer.php'; ?>