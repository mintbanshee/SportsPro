<?php
declare(strict_types=1);

require_once __DIR__ . '/../db/database.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../auth/require_admin.php';
require_once __DIR__ . '/../models/technician.php';
require_once __DIR__ . '/../models/technician_db.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? 'manage_technicians';

$pdo = Database::getDB();

switch ($action) {

  case 'manage_technicians': 
    $technicians = TechnicianDB::getTechnicians();

    include __DIR__ . '/../views/admin/manage_technicians.php';
    break;
    
  case 'delete_technician': 
    $techID = filter_input(INPUT_POST, 'techID', FILTER_VALIDATE_INT);

    if ($techID) {
      TechnicianDB::deleteTechnician($techID);
      $_SESSION['flash_success'] = 'Technician deleted successfully.';
    }

    header("Location: " . BASE_URL . "controllers/technician_controller.php?action=manage_technicians");
    exit;
    break;

  case 'create_technician': 
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');

    // Validate: every field required
    if ($firstName === '' || $lastName === '' || $email === '' || $phone === '') {
        header("Location: " . BASE_URL . "views/admin/add_technician.php?error=required");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: " . BASE_URL . "views/admin/add_technician.php?error=invalid_email");
        exit;
    }

    $tech = new Technician();
    $tech->firstName = $firstName;
    $tech->lastName = $lastName;
    $tech->email = $email;
    $tech->phone = $phone;

    TechnicianDB::addTechnician($tech);

    $_SESSION['flash_success'] = "Technician " . $tech->getFullName() . " created successfully.";

    header("Location: " . BASE_URL . "controllers/technician_controller.php?action=manage_technicians");
    exit;

}