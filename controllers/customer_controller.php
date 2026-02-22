<?php
require_once __DIR__ . '/../db/database.php';
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../auth/require_admin.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the action to perform
$action = filter_input(INPUT_POST, 'action') ?? filter_input(INPUT_GET, 'action')
    ?? 'manage_customers'; // default action for if not specified

    $pdo = Database::getDB();
    
switch ($action) {
    case 'manage_customers': // replace the manage_customers php from admin file
        $lastName = trim(filter_input(INPUT_GET, 'lastName') ?? ''); //get the search input
        $lastNameSearch = $lastName;

      try {
        if ($lastName !== '') {
          $stmt = $pdo->prepare("SELECT * FROM customers WHERE lastName LIKE :lastName");
          // used LIKE to be more user friendly
          $stmt->execute(['lastName' => $lastName . '%']);
          // used % as a wildcard to match incomplete last name search input
          $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
          $stmt = $pdo->prepare("SELECT * FROM customers ORDER BY lastName, firstName");
          $stmt->execute();
          $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
      } catch (PDOException $e) { // catch the crash if SQL fails 
          $error_message = $e->getMessage(); // show error instead of crash 
          include __DIR__ . '/../views/admin/error.php';
          exit();
      } // close catch 

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

      try {
        // the same fetch customer code as before but now in the controller instead of the admin file
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE customerID = :id");
        $stmt->execute(['id' => $id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // fetch the countries for the dropdown in the edit form 
        $countriesStmt = $pdo->prepare("SELECT * FROM countries ORDER BY countryName");
        $countriesStmt->execute();
        $countries = $countriesStmt->fetchAll(PDO::FETCH_ASSOC);

      } catch (PDOException $e) { // catch the crash if SQL fails 
          $error_message = $e->getMessage(); // show error instead of crash 
          include __DIR__ . '/../views/admin/error.php';
          exit();
      } // close catch 

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
          header("Location: " . BASE_URL . "controllers/customer_controller.php?action=manage_customers"); 
          exit;
        }

        $errors = [];
        // email must be valid
        if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";            
        }
        // state must be 1 - 50 chars
        if (strlen($fields['state']) < 1 || strlen($fields['state']) > 50) {
            $errors[] = "State must be 1-50 characters.";
        }
        // phone must be (999) 999-9999
        if (!preg_match('/^\(\d{3}\) \d{3}-\d{4}$/', $fields['phone'])) {
            $errors[] = "Phone must be in (999) 999-9999 format.";
        }

      try {
        if ($errors) {
            $customer = $fields;       
            $customer['customerID'] = $customerID; 
            $countriesStmt = $pdo->prepare("SELECT * FROM countries ORDER BY countryName");
            $countriesStmt->execute();
            $countries = $countriesStmt->fetchAll(PDO::FETCH_ASSOC); 
            $error = implode("<br>", $errors);
            include __DIR__ . '/../views/admin/customer_edit.php';
            exit;
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

        } catch (PDOException $e) {
            $customer = $fields;
            $customer['customerID'] = $customerID;
            $countriesStmt = $pdo->prepare("SELECT * FROM countries ORDER BY countryName");
            $countriesStmt->execute();
            $countries = $countriesStmt->fetchAll(PDO::FETCH_ASSOC);
            $error = "Database error: " . $e->getMessage();
            
            include __DIR__ . '/../views/admin/customer_edit.php';
            exit; 
        } // close catch 
            break;

} // close switch 