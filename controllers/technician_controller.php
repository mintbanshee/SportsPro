<?php
require __DIR__ . '/../db/database.php';
require __DIR__ . '/../config/app.php';
require __DIR__ . '/../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? 'manage_technicians';

switch ($action) {

  case 'manage_technicians': // copied from views/admin/manage_technicians.php
    $sql = "SELECT techID, firstName, lastName, email, phone
            FROM technicians
            ORDER BY lastName, firstName";
    $technicians = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    include __DIR__ . '/../views/admin/manage_technicians.php';
    break;
    
  case 'delete_technician': // copied from views/admin/delete_technician.php
    $techID = filter_input(INPUT_POST, 'techID', FILTER_VALIDATE_INT);

    if (!$techID) {
      header('Location: error.php?msg=invalid');
      exit;
    }

    $stmt = $pdo->prepare("DELETE FROM technicians WHERE techID = :id");
    $stmt->execute(['id' => $techID]);

    $_SESSION['flash_success'] = 'Technician deleted successfully.';

    header("Location: " . BASE_URL . "controllers/technician_controller.php?action=manage_technicians");
    exit;

  case 'create_technician': // copied from views/admin/create_technician.php
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');

    // Validate: every field required
    if ($firstName === '' || $lastName === '' || $email === '' || $phone === '') {
        header('Location: error.php?msg=required');
        exit;
    }

    $stmt = $pdo->prepare("
      INSERT INTO technicians (firstName, lastName, email, phone)
      VALUES (:firstName, :lastName, :email, :phone)
    ");
    $stmt->execute([
      'firstName' => $firstName,
      'lastName'  => $lastName,
      'email'     => $email,
      'phone'     => $phone
    ]);

    $_SESSION['flash_success'] = "Technician $firstName $lastName created successfully.";

    header("Location: " . BASE_URL . "controllers/technician_controller.php?action=manage_technicians");
    exit;

}