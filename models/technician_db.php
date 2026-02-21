<?php

class TechnicianDB {
  public static function getTechnicians() {
    $db = Database::getDB(); // replaces global $pdo. 
    $statement = $db->query("SELECT * FROM technicians ORDER BY lastName");

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
  }

  public static function addTechnician(Technician $tech) {
    $db = Database::getDB();
    $statement = $db->prepare("
      INSERT INTO technicians (firstName, lastName, email, phone, password)
      VALUES (:first, :last, :email, :phone, :password)
    ");
    $statement->execute ([
      'first' => $tech->firstName,
      'last' => $tech->lastName,
      'email' => $tech->email,
      'phone' => $tech->phone,
      'password' => password_hash($tech->password, PASSWORD_DEFAULT)
    ]);
  }
  
  public static function deleteTechnician($techID) {
    $db = Database::getDB();
    $statement = $db->prepare("DELETE FROM technicians WHERE techID = :id");
    $statement->execute(['id' => $techID]);
  }
}