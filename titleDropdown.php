<?php

include 'config/database.php';


echo "<td><select name='title' class='form-control'>";


//query
$ddQuery = "SELECT * FROM titles";
$ddStatement = $con->prepare($ddQuery);
$ddStatement->execute();
$ddNum = $ddStatement->rowCount();

if($ddNum>0){
  while($row = $ddStatement->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    echo "<option value={$titleId}>{$title}</option>";
  }
}

echo "</select></td>";

 ?>
