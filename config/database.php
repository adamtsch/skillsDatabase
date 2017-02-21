<?php

// Database parameters
$host = "localhost";
$db_name = "skillsdatabase";
$username = "root";
$password = "";

try {
  $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);

}

// Errors?
catch(PDOException $exception){
  echo "Connection error: " . $exception->getMessage();
}



 ?>
