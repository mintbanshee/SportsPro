<?php
declare(strict_types=1);

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../db/database.php';

// Optional admin-only guard:
// require __DIR__ . '/../../config/app.php';
// require __DIR__ . '/../../auth/require_admin.php';

$customerID = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
$lastNameSearch = trim($_POST['lastNameSearch'] ?? '');

$fields = [
  'firstName'   => trim($_POST['firstName'] ?? ''),
  'lastName'    => trim($_POST['lastName'] ?? ''),
  'email'       => trim($_POST['email'] ?? ''),
  'phone'       => trim($_POST['phone'] ?? ''),
  'address'     => trim($_POST['address'] ?? ''),
  'city'        => trim($_POST['city'] ?? ''),
  'state'       => trim($_POST['state'] ?? ''),
  'postalCode'  => trim($_POST['postalCode'] ?? ''),
  'countryCode' => trim($_POST['countryCode'] ?? ''),
];

if (!$customerID) {
  header("Location: /manage_customers.php"); // changed to manage customers 
  exit;
}

// Validate required fields (per spec)
foreach ($fields as $k => $v) {
  if ($v === '') {
    header("Location: error.php?msg=required");
    exit;
  }
}

$stmt = $db->prepare("
  UPDATE customers
  SET firstName=:firstName,
      lastName=:lastName,
      email=:email,
      phone=:phone,
      address=:address,
      city=:city,
      state=:state,
      postalCode=:postalCode,
      countryCode=:countryCode
  WHERE customerID=:id
");

$stmt->execute($fields + ['id' => $customerID]);

// changed this to return to manage customers page as i have the search bar on the manage customers page
// I felt it has a better flow this way 
$redirect = "manage_customers.php";
if ($lastNameSearch !== '') {
  $redirect .= "?lastName=" . urlencode($lastNameSearch);
}
header("Location: $redirect");
exit;
