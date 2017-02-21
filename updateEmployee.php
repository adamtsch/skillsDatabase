<? require_once("config/fileConstants.php") ?>
<?php
//ENSURE THE PAGE WAS NAVIGATED TO USING GET THROUGH THE WEB APP
//
$id=null;
if ( !empty($_GET['id']) ) {
  $id = $_REQUEST['id'];
}

if ( $id == null) {
  header("Location: " . HOMEPAGE);
  die();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Update Employee Information</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="libs/bootstrap-3.3.7/css/bootstrap.min.css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <!-- container -->
    <div class="container">

        <div class="page-header">
            <h1>Update Employee</h1>
        </div>

        <?php
          // get passed parameter value - the employee ID
          // isset() is a PHP function used to verify if a value is there or not
          // $id=isset($_GET['id']) ? $_GET['id'] : die("ERROR: Record ID not found.");
          // database configuration including
          include 'config/database.php';

          $id = null;
          if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
          }

          if (!empty($_POST)) {
            // Validations
            $fNameError = null;
            $lNameError = null;
            $titleError = null;

            // Get POSTed values
            $fName = $_POST['fName'];
            $lName = $_POST['lName'];

            // Validate Input
            $valid = true;
            if(empty($fName)) {
              echo "<div class='alert alert-danger'>Provide Employee First Name</div>";
              $valid = false;
            }

            if (empty($lName)) {
              echo "<div class='alert alert-danger'>Provide Employee Last Name</div>";
              $valid = false;
            }

            if ($valid) {
              try{

                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE employees SET firstName=:fName, lastName=:lName WHERE employeeId = :id";

                // prepare query for excecution
                $stmt = $con->prepare($query);

                // posted values
                $fName=htmlspecialchars(strip_tags($_POST['fName']));
                $lName=htmlspecialchars(strip_tags($_POST['lName']));
                // $price=htmlspecialchars(strip_tags($_POST['price']));

                // bind the parameters
                $stmt->bindParam(':fName', $fName);
                $stmt->bindParam(':lName', $lName);
                $stmt->bindParam(':id', $id);

                // Execute the query
                if($stmt->execute()){
                  echo "<div class='alert alert-success'>Record was updated.</div>";
                }else{
                  echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch(PDOException $exception){
              die('ERROR: ' . $exception->getMessage());
            }
          }
        } else {
            // read current employee records data
            try {
              // prepare query
              $query = "SELECT e.employeeId, e.firstName, e.lastName, e.employeeTitle, t.title FROM employees e, titles t WHERE e.employeeTitle=t.titleId AND e.employeeId = ? LIMIT 0, 1";
              $stmt = $con->prepare( $query );

              // first questionmark
              $stmt->bindParam(1, $id);
              $stmt->execute();

              $row = $stmt->fetch(PDO::FETCH_ASSOC);

              // values to fill up the form
              $fName = $row['firstName'];
              $lName = $row['lastName'];
              // $title = $row['employeeTitle']

            } catch (PDOException $exception) {
              die('ERROR: ' . $exception->getMessage());
            }
          }
      ?>


         <!--we have our html form here where new user information will be entered-->
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
             <table class='table table-hover table-responsive table-bordered'>
                 <tr>
                     <td>First Name</td>
                     <td><input type='text' name='fName' value="<?php echo htmlspecialchars($fName, ENT_QUOTES);  ?>" class='form-control' /></td>
                 </tr>
                 <tr>
                     <td>Last Name</td>
                     <td><input type='text' name='lName' value="<?php echo htmlspecialchars($lName, ENT_QUOTES);  ?>" class='form-control' /></td>
                 </tr>
                 <tr>
                     <td>Title</td>
                     <td><textarea name='title' class='form-control'>TEST TITLE TEXT</textarea></td>
                 </tr>
                 <tr>
                     <td></td>
                     <td>
                         <input type='submit' value='Save Changes' class='btn btn-primary' />
                         <a href='read.php' class='btn btn-danger'>Back to Employees</a>
                     </td>
                 </tr>
             </table>
         </form>


    </div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="libs/jquery-3.1.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="libs/bootstrap-3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
