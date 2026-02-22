<?php

class TechnicianDB {
  public static function getTechnicians() {
    try {
      $db = Database::getDB(); // replaces global $pdo. 

      $sql = "SELECT * FROM technicians ORDER BY lastName";
      $statement = $db->prepare($sql);
      $statement->execute();

      $technicians = [];

      foreach ($statement as $row) {
        $tech = new Technician();
        $tech->techID = $row['techID'];
        $tech->firstName = $row['firstName'];
        $tech->lastName = $row['lastName'];
        $tech->email = $row['email'];
        $tech->phone = $row['phone'];

        $technicians[] = $tech;
      } 
      return $technicians;
    
    } catch (PDOException $e) { // catch the crash if SQL fails 
        $error_message = $e->getMessage(); // show error instead of crash 
        include __DIR__ . '/../views/admin/error.php';
        exit();
    } // close catch 
  } // close function  

  public static function addTechnician(Technician $tech) {
    try {
      $db = Database::getDB();
      $statement = $db->prepare("
        INSERT INTO technicians (firstName, lastName, email, phone)
        VALUES (:first, :last, :email, :phone)
      ");
      $statement->execute ([
        'first' => $tech->firstName,
        'last' => $tech->lastName,
        'email' => $tech->email,
        'phone' => $tech->phone,
      ]);
    } catch (PDOException $e) { // catch the crash if SQL fails 
        $error_message = $e->getMessage(); // show error instead of crash 
        include __DIR__ . '/../views/admin/error.php';
        exit();
    } // close catch 
  } // close function  
  
  public static function deleteTechnician($techID) {
    try {
      $db = Database::getDB();

      $statement = $db->prepare("DELETE FROM technicians WHERE techID = :id");
      $statement->execute(['id' => $techID]);

    } catch (PDOException $e) { // catch the crash if SQL fails 
        $error_message = $e->getMessage(); // show error instead of crash 
        include __DIR__ . '/../views/admin/error.php';
        exit();
    } // close catch 
  } // close function  
  
} // close class 