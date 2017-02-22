<?php
/*
* DatabaseUtils.php - A class of simple database utilities.
*
* Performs CRUD operations using PDO (MySQL) prepared statements.
*
* Author: bencentra (https://gist.github.com/bencentra/92228e1f4139436c4153)
*/
class DatabaseUtils
{
  // Database connection object
  private $pdo;
  // Create a PDO object and connect to the database
  public function __construct($dbName, $dbHost, $dbUser, $dbPass) {
    try {
      // Instantiate the PDO object
      $this->pdo = new PDO(
        // Use MySQL database driver
        "mysql:dbname=$dbName;host=$dbHost",
        $dbUser,
        $dbPass,
        // Set some options
        array(
          // Return rows found, not changed, during inserts/updates
          PDO::MYSQL_ATTR_FOUND_ROWS => true,
          // Emulate prepares, in case the database doesn't support it
          PDO::ATTR_EMULATE_PREPARES => true,
          // Have errors get reported as exceptions, easier to catch
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          // Return associative arrays, good for JSON encoding
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        )
      );
    }
    catch (PDOException $e) {
        die('Database Connection Failed: ' . $e->getMessage());
    }
  }
  // Perform a SELECT query
  public function select($sql, $data = array()) {
    try {
      // Prepare the SQL statement
      $stmt = $this->pdo->prepare($sql);
      // Execute the statement
      if ($stmt->execute($data)) {
        // Return the selected data as an assoc array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
      else {
        return false;
      }
    }
    catch (Exception $e) {
      return false;
    }
  }
  // Perform an INSERT query
  public function insert($sql, $data = array()) {
    try {
      // Prepare the SQL statement
      $stmt = $this->pdo->prepare($sql);

      // Execute the statement
      if ($stmt->execute($data)) {
        // Return the number of rows affected
        return $stmt->rowCount();
      }
      else {
        return false;
      }
    }
    catch (Exception $e) {
      // echo $e->getMessage();
      return false;
    }
  }
  // Perform an UPDATE query
  public function update($sql, $data = array()) {
    return $this->insert($sql, $data);
  }
  // Perform a REPLACE query
  public function replace($sql, $data = array()) {
    return $this->replace($sql, $data);
  }
  // Perform a DELETE query
  public function delete($sql, $data = array()) {
    return $this->insert($sql, $data);
  }
  // Get the ID of the last row inserted
  public function lastInsertId() {
    return $this->pdo->lastInsertId();
  }
  /**
   * Replaces any parameter placeholders in a query with the value of that
   * parameter. Useful for debugging. Assumes anonymous parameters from
   * $params are are in the same order as specified in $query
   *
   * @param string $query The sql query with parameter placeholders
   * @param array $params The array of substitution parameters
   * @return string The interpolated query
   */
  public static function interpolateQuery($query, $params) {
      $keys = array();

      # build a regular expression for each parameter
      foreach ($params as $key => $value) {
          if (is_string($key)) {
              $keys[] = '/:'.$key.'/';
          } else {
              $keys[] = '/[?]/';
          }
      }

      $query = preg_replace($keys, $params, $query, 1, $count);

      #trigger_error('replaced '.$count.' keys');

      return $query;
  }


}



?>
