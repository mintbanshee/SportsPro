<?php
declare(strict_types=1);

// get all of the products information from database but return it as
// as array so I can use it in a loop later 
function getProducts(): array { 
    $pdo = Database::getDB();
    $sql = "SELECT * FROM products ORDER BY name";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


// delete a product from database and return nothing (void)
// need to call on the $productCode to perform the function
function deleteProduct(string $productCode): void {
  $pdo = Database::getDB();
  $statement = $pdo->prepare("DELETE FROM products WHERE productCode = :code");
  $statement->execute(['code' => $productCode]);
}


// add a new product to the database but don't return anything
// need to call on the product code, name, version and date to perform this function
function addProduct(string $productCode, string $name, float $version, string $releaseDate): void {
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
}

// ensure the product being added does not already exist
// return a boolean true/false exists/doesn't exist 
function isDuplicateProduct(string $productCode): bool {
  $pdo = Database::getDB();
  $statement = $pdo->prepare("SELECT productCode FROM products 
    WHERE productCode = :code");
  $statement->execute(['code' => $productCode]);
  return $statement->fetch() !== false;  
  // if not duplicate will return false
  // if duplicate will return true
}