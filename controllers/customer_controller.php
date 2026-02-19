<?php
require __DIR__ . '/../db/database.php';
require __DIR__ . '/../config/app.php';
require __DIR__ . '/../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the action to perform
$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action')
    ?? 'manage_customers'; // default action for if not specified

switch ($action) {
    case 'manage_customers': // replace the manage_customers php from admin file
        $lastName = filter_input(INPUT_GET, 'lastName'); //get the search input
        if ($lastName) {
          $stmt = $pdo->prepare("SELECT * FROM customers WHERE lastName LIKE :lastName");
          // used LIKE to be more user friendly
          $stmt->execute(['lastName' => $lastName . '%']);
          // used % as a wildcard to match incomplete last name search input
          $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
          $customers = []; // empty when page loads 
        }

        include __DIR__ . '/../views/admin/manage_customers.php';
        break;

    case 'edit_customer': // replace the customer_edit php from admin file
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // validate the id 
        if (!$id) {
            header("Location: .?action=manage_customers"); 
            // redirect to the actions page instead of search page now that we have a manage customers page
            exit;
        }

        // moved this over to the controller 
        $lastNameSearch = trim($_GET['lastName'] ?? ''); 

        // the same fetch customer code as before but now in the controller instead of the admin file
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE customerID = :id");
        $stmt->execute(['id' => $id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // fetch the countries for the dropdown in the edit form 
        $countries = $pdo->query("SELECT * FROM countries ORDER BY countryName")->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/admin/customer_edit.php';
        break;

    case 'update_customer':
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

        $stmt = $pdo->prepare("
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

        // redirect with success message and preserve search term if it exists
        $_SESSION['flash_success'] = "Customer updated successfully!";
        header("Location: " . BASE_URL . "controllers/customer_controller.php?action=manage_customers&lastName=" . urlencode($lastNameSearch));
        exit;
}