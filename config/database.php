<?php



// Database parameters
$host = "localhost";
$db_name = "skillsdatabase";
$username = "root";
$password = "";

require_once("pdoUtilities.php");

$con = new DatabaseUtils($db_name, $host, $username, $password);

 ?>
