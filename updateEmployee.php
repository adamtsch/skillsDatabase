<?php
require_once("config/fileConstants.php");
require_once("dropdownUtil.php");
?>

<?php
//ENSURE THE PAGE WAS NAVIGATED TO USING GET THROUGH THE WEB APP
//
// get passed parameter value - the employee ID
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
    <link rel="stylesheet" href=<?php echo CSS_BOOTSTRAP_BILL_TURNER; ?> />

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

          // database configuration including
          require_once(DATABASE_CONFIG);

          $id = null;
          if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
          }

          if (!empty($_POST)) {

            // Validation input
            $fNameError = null;
            $lNameError = null;

            // Get POSTed values
            $fName = $_POST['fName'];
            $lName = $_POST['lName'];
            $titleId = $_POST['title'];

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

              // write update query
              // in this case, it seemed like we have so many fields to pass and
              // it is better to label them and not use question marks
              $query = "UPDATE employees SET firstName=:fName, lastName=:lName, employeeTitle=:titleId WHERE employeeId=:id";

              // posted values
              $fName=htmlspecialchars(strip_tags($fName));
              $lName=htmlspecialchars(strip_tags($lName));

              $dataArray = array(':fName' => $fName, ':lName' => $lName, ':titleId' => $titleId, ':id' => $id);

              $result = $con->update($query, $dataArray);

              // Execute the query
              if($result != false){
                echo "<div class='alert alert-success'>Record was updated.</div>";
              }else{
                echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
              }
          }
        } else {
            // read current employee records data
            // prepare query
            $query = "SELECT e.employeeId, e.firstName, e.lastName, e.employeeTitle, t.titleId, t.title FROM employees e, titles t WHERE e.employeeTitle=t.titleId AND e.employeeId=:id LIMIT 0, 1";

            $result = $con->select($query, array(':id' => $id));

            if ($result != false) {
              // fetch results
              $row = $result[0];

              // values to fill up the form
              $fName = $row['firstName'];
              $lName = $row['lastName'];
              $titleId = $row['titleId'];
              $titleName = $row['title'];
            } else {
              echo "<div class='alert alert-danger'>Error: Unable to fetch record. ID may not exist</div>";
              echo "<a href='" . READ_EMPLOYEES . "' class='btn btn-danger'>Back to Employees</a>";
              die();
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
                     <?php
                      DropdownUtils::populateDropdownFromTable("titles", $titleId, $con);
                      ?>
                 </tr>
                 <tr>
                     <td></td>
                     <td>
                         <input type='submit' value='Save Changes' class='btn btn-primary' />
                         <a href=<?php echo READ_EMPLOYEES; ?> class='btn btn-danger'>Back to Employees</a>
                     </td>
                 </tr>
             </table>
         </form>


    </div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src=<?php echo JQUERY_LIB; ?>></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src=<?php echo JS_BOOTSTRAP_BILL_TURNER; ?>></script>

</body>
</html>
