<?php

declare(strict_types=1);

require_once __DIR__ . '/../db/database.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../models/technician.php';
require_once __DIR__ . '/../models/technician_db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action') ?? 'select_incident';

$pdo = Database::getDB();

switch ($action) {

  case 'select_incident':
    if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { 
      header("Location: " . BASE_URL . "auth/login.php"); 
      exit; 
    }

    try {
      // grab needed information from incidents, customers and products
      // join them together to create the incidents table 
      $statement = $pdo->prepare ("
        SELECT  i.incidentID,
                i.dateOpened,
                i.title,
                i.description,
                c.firstName,
                c.lastName,
                p.name AS productName
        FROM incidents i
        LEFT JOIN customers c ON i.customerID = c.customerID
        LEFT JOIN products p ON i.productCode = p.productCode
        WHERE i.techID IS NULL
        ORDER BY i.dateOpened
        ");

      $statement->execute();
      $incidents = $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include __DIR__ . '/../views/admin/error.php';
        exit;
    }  // close catch 

    include __DIR__ . '/../views/admin/select_incident.php';
    break;
    
    case 'store_incident':
      if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { 
        header("Location: " . BASE_URL . "auth/login.php"); 
        exit; 
      }
      // get the incidentID from the select incident page
      $incident_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

      if (!$incident_id) {
        $error_message = "Missing or invalid incident ID.";
        include __DIR__ . '/../views/admin/error.php';
        exit;
      }

      // save the session for later
      $_SESSION['incident_id'] = $incident_id;

      header("Location: " . BASE_URL . "controllers/incident_controller.php?action=select_technician");
      exit;
      break;

  case 'select_technician':
    if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { 
      header("Location: " . BASE_URL . "auth/login.php"); 
      exit; 
    }
    // if landed by accident
    if (empty($_SESSION['incident_id'])) {
      header("Location: " . BASE_URL . "controllers/incident_controller.php?action=select_incident");
      exit;
    }

    try {
      // check open incidents per technician
      $statement = $pdo->prepare ("
        SELECT t.techID,
                t.firstName,
                t.lastName,
            (SELECT COUNT(*)
              FROM incidents i
              WHERE i.techID = t.techID
                AND i.dateClosed IS NULL)
            AS openIncidents
        FROM technicians t
        ORDER BY t.lastName, t.firstName
      ");

      $statement->execute();
      $technicians = $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include __DIR__ . '/../views/admin/error.php';
        exit;
    } // close catch

    include __DIR__ . '/../views/admin/select_technician.php';
    break;

  case 'store_technician':
    if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { 
      header("Location: " . BASE_URL . "auth/login.php"); 
      exit; 
    }    
    // remember the technician selected 
    $tech_id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);

    if (!$tech_id) {
      $error_message = "Missing or invalid technician ID.";
      include __DIR__ . '/../views/admin/error.php';
      exit;
    }

    $_SESSION['tech_id'] = $tech_id;

    header("Location: " . BASE_URL . "controllers/incident_controller.php?action=assign_incident");
    exit;

  case 'assign_incident':
    if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { 
      header("Location: " . BASE_URL . "auth/login.php"); 
      exit; 
    }
    if (empty($_SESSION['incident_id']) || empty($_SESSION['tech_id'])) {
      header("Location: " . BASE_URL . "controllers/incident_controller.php?action=select_incident");
      exit;
    }  

    $incident_id = (int)$_SESSION['incident_id'];
    $tech_id = (int)$_SESSION['tech_id'];

    try {
      // gather incident, customer and product together
      $statement = $pdo->prepare ("
        SELECT  i.incidentID,
                i.productCode,
                i.title,
                i.description,
                c.firstName,
                c.lastName,
                p.name AS productName
        FROM incidents i
        JOIN customers c ON i.customerID = c.customerID
        JOIN products p ON i.productCode = p.productCode
        WHERE i.incidentID = :incident_id 
      ");

      $statement->execute([':incident_id' => $incident_id]);
      $incident = $statement->fetch(PDO::FETCH_ASSOC);

      if (!$incident) {
        $error_message = "Incident not found.";
        include __DIR__ . '/../views/admin/error.php';
        exit;
      }

      $statement = $pdo->prepare ("
        SELECT techID, firstName, lastName
        FROM technicians
        WHERE techID = :tech_id
      ");

      $statement->execute([':tech_id' => $tech_id]);
      $technician = $statement->fetch(PDO::FETCH_ASSOC);

      if (!$technician) {
        $error_message = "Technician not found.";
        include __DIR__ . '/../views/admin/error.php';
        exit;
      }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include __DIR__ . '/../views/admin/error.php';
        exit;
    } // close catch

    include __DIR__ . '/../views/admin/assign_incident.php';
    exit;
    break;

  case 'update_incident':
     if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { 
      header("Location: " . BASE_URL . "auth/login.php"); 
      exit; 
    }   
    if (empty($_SESSION['incident_id']) || empty($_SESSION['tech_id'])) {
      header("Location: " . BASE_URL . 'controllers/incident_controller.php?action=select_incident');
      exit;
    }

    $incident_id = (int)$_SESSION['incident_id'];
    $tech_id = (int)$_SESSION['tech_id'];

    try {

        $statement = $pdo->prepare ("
          UPDATE incidents
          SET techID = :tech_id
          WHERE incidentID = :incident_id
        ");

        $statement->execute([':tech_id' => $tech_id, ':incident_id' => $incident_id]);

    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include __DIR__ . '/../views/admin/error.php';
        exit;
    } // close catch

    unset($_SESSION['incident_id'], $_SESSION['tech_id']);
    $_SESSION['flash_success'] = "Incident assigned successfully.";
    header("Location: " . BASE_URL . "controllers/incident_controller.php?action=select_incident");
    exit;
    break;

  case 'display_incidents':
    if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { 
      header("Location: " . BASE_URL . "auth/login.php"); 
      exit; 
    }

    try {
      // have both assigned and unassigned in 1 page with anchor links that scroll
      // unassigned table:
      $statement = $pdo->prepare ("
        SELECT  i.incidentID, i.dateOpened, i.title, i.description,
                c.firstName, c.lastName,
                p.name AS productName
        FROM incidents i
        JOIN customers c ON i.customerID = c.customerID
        JOIN products p ON i.productCode = p.productCode
        WHERE i.techID is NULL
        ORDER BY i.dateOpened DESC
      ");

      $statement->execute();
      $unassigned = $statement->fetchALL(PDO::FETCH_ASSOC);

      // assigned table:
      $statement = $pdo->prepare ("
        SELECT  i.incidentID, i.dateOpened, i.dateClosed, i.title, i.description,
                c.firstName AS customerFirst, c.lastName AS customerLast,
                p.name AS productName,
                t.firstName AS techFirst, t.lastName AS techLast
        FROM incidents i
        JOIN customers c ON i.customerID = c.customerID
        JOIN products p ON i.productCode = p.productCode
        JOIN technicians t ON i.techID = t.techID
        WHERE i.techID IS NOT NULL
        ORDER BY i.dateOpened DESC
      ");

      $statement->execute();
      $assigned = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include __DIR__ . '/../views/admin/error.php';
      exit;
    }// close catch

    include __DIR__ . '/../views/admin/display_incidents.php';
    exit;
    break;

  case 'tech_dashboard':
    // display the logged in technician's open inicdents on their user dashboard
    // ensure only techncian role can access a technician dashboard 
    if (empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'technician') {
      header("Location: " . BASE_URL . "auth/login.php");
      exit;
    }

    $tech_id = (int)$_SESSION['user']['id'];

    try {
      $statement = $pdo->prepare ("
        SELECT  i.incidentID, i.dateOpened, i.title, i.description,
                c.firstName AS customerFirst, c.lastName AS customerLast,
                p.name AS productName
        FROM incidents i
        JOIN customers c ON i.customerID = c.customerID
        JOIN products p ON i.productCode = p.productCode
        WHERE i.techID = :tech_id
          AND i.dateClosed IS NULL
        ORDER BY i.dateOpened DESC
      ");

      $statement->execute([':tech_id' => $tech_id]);
      $assigned = $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include __DIR__ . '/../views/admin/error.php';
        exit;
    } // close catch

    include __DIR__ . '/../views/technicians/tech_dashboard.php';
    exit;
    break;

} // close switch






    