<?php
declare(strict_types=1);

// get all of the products information from database but return it as
// as array so I can use it in a loop later 
function getProducts(): array { 
  try {
    $pdo = Database::getDB();

    $sql = "SELECT * FROM products ORDER BY name"; // get products data
    $statement = $pdo->prepare($sql);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC); // return the data 
  
  } catch (PDOException $e) { // catch the crash if SQL fails 
      $error_message = $e->getMessage(); // show error instead of crash 
      include __DIR__ . '/../views/admin/error.php';
      exit();
  } // close catch 
} // close function


// delete a product from database and return nothing (void)
// need to call on the $productCode to perform the function
function deleteProduct(string $productCode): void {
  try {
    $pdo = Database::getDB();

    $statement = $pdo->prepare("DELETE FROM products WHERE productCode = :code");
    $statement->execute(['code' => $productCode]);
  
  } catch (PDOException $e) { 
      $error_message = $e->getMessage(); 
      include __DIR__ . '/../views/admin/error.php';
      exit();
  } // close catch
} // close function 


// add a new product to the database but don't return anything
// need to call on the product code, name, version and date to perform this function
function addProduct(string $productCode, string $name, float $version, string $releaseDate): void {
  try {    
    $pdo = Database::getDB();

    $statement = $pdo->prepare ("
      INSERT INTO products (productCode, name, version, releaseDate)
      VALUES (:code, :name, :version, :date)
    ");

    $statement->execute([
      'code' => $productCode,
      'name' => $name,
      'version' => $version,
      'date' => $releaseDate
    ]);

  } catch (PDOException $e) { 
      $error_message = $e->getMessage(); 
      include __DIR__ . '/../views/admin/error.php';
      exit();
  } // close catch
} // close function 

// ensure the product being added does not already exist
// return a boolean true/false exists/doesn't exist 
function isDuplicateProduct(string $productCode): bool {
  try {
    $pdo = Database::getDB();

    $statement = $pdo->prepare("SELECT productCode FROM products 
      WHERE productCode = :code");
    $statement->execute(['code' => $productCode]);

    return $statement->fetch() !== false;  
    // if not duplicate will return false
    // if duplicate will return true

  } catch (PDOException $e) {
      $error_message = $e->getMessage();
      include __DIR__ . '/../views/admin/error.php';
      exit();
  } // close catch
} // close function 