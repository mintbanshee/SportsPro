<?php
declare(strict_types=1);

// created a class to hold technician data
class Technician {
  public $techID;
  public $firstName;
  public $lastName;
  public $email;
  public $phone;
  public $password;

  // created a helper function to return the full name of a technician
  public function getFullName() {
    return $this->firstName . ' ' . $this->lastName;
  }
}