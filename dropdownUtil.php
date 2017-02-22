<?php

class DropdownUtils
{

  private static function getDropdownContentsFromTable($tableName, $con) {

    $query = "SELECT * FROM " . $tableName;

    return $con->select($query);

  }

  public static function populateDropdownFromTable($tableName, $selectedId, $con) {

    $result = self::getDropdownContentsFromTable($tableName, $con);

    if ($result != false) {
      echo "<td><select name='title' class='form-control'>";

      foreach($result as $row) {
        $id = $row['titleId'];
        echo "<option value={$id} " . (($selectedId==$id) ? "selected='selected'" : "") . ">{$row['title']}</option>";

      }


    } else {
      echo "<td><select name='title' class='form-control' disable='disabled'>";
      echo "<option value='null'>ERROR</option>";
    }

    echo "</select></td>";

  }
}


 ?>
