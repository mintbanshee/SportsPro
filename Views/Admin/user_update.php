<?php
declare(strict_types=1);

require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../auth/require_admin.php';

$pdo = Database::getDB();

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT); 
$lastNameSearch = trim($_POST['lastNameSearch'] ?? ''); 

$fields = [
  'first_name'   => trim($_POST['firstName'] ?? ''),
  'last_name'    => trim($_POST['lastName'] ?? ''),
  'email'       => trim($_POST['email'] ?? ''),
  'role'        => ($_POST['role'] ?? ''),
];

if (!$user_id) { // if the user_id is not valid send back to dashboard 
  header("Location: /dashboard.php"); 
  exit;
}

foreach ($fields as $k => $v) { // if admin accidentally removed a field it wont save and will give error message
  if ($v === '') { 
    header("Location: " . BASE_URL . "views/admin/error.php?msg=required");
    exit;
  }
}

$stmt = $pdo->prepare("
  UPDATE users
  SET first_name = :first_name,
      last_name = :last_name,
      email = :email,
      role = :role
  WHERE user_id = :user_id
");

$stmt->execute($fields + ['user_id' => $user_id]); // do the update 

$redirect = BASE_URL . '/views/admin/dashboard.php'; // send back to dashboard
if ($lastNameSearch !== '') {
  $redirect .= "?lastName=" . urlencode($lastNameSearch);
}
header("Location: $redirect"); 
exit;
