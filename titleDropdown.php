<?php

require_once(DATABASE_CONFIG);

echo "<td><select name='title' class='form-control'>";

$result = $con->select("SELECT * FROM titles");

if(count( $result ) > 0){
  foreach($result as $row) {
    echo "<option value={$row['titleId']}>{$row['title']}</option>";
  }
}

echo "</select></td>";

 ?>
