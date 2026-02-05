<?php
declare(strict_types=1);

require __DIR__ . '/../../db/database.php';

$firstName = trim($_POST['firstName'] ?? '');
$lastName  = trim($_POST['lastName'] ?? '');
$email     = trim($_POST['email'] ?? '');
$phone     = trim($_POST['phone'] ?? '');

// Validate: every field required
if ($firstName === '' || $lastName === '' || $email === '' || $phone === '') {
    header('Location: error.php?msg=required');
    exit;
}

$stmt = $db->prepare("
  INSERT INTO technicians (firstName, lastName, email, phone)
  VALUES (:firstName, :lastName, :email, :phone)
");
$stmt->execute([
  'firstName' => $firstName,
  'lastName'  => $lastName,
  'email'     => $email,
  'phone'     => $phone
]);

header("Location: manage_technicians.php");
exit;


?>