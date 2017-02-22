<?php require_once("config/fileConstants.php") ?>

<?php
  // get passed parameter value, in this case, the record ID
  // isset() is a PHP function used to verify if a value is there or not
  $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record Employee ID not found.');

  //include database connection
  include DATABASE_CONFIG;

  // read current record's data

  // prepare select query
  $query = "SELECT e.employeeId, e.firstName, e.lastName, t.title, e.lastUpdate, e.dateCreated FROM employees e, titles t WHERE e.employeeTitle=t.titleId AND e.employeeId = :id LIMIT 0,1";
  $result = $con->select($query, array(':id' => $id));

  if ($result != false) {

    // store retrieved row to a variable
    $row = $result[0];

    // values to fill up our form
    $fName = $row['firstName'];
    $lName = $row['lastName'];
    $title = $row['title'];
    $created = $row['dateCreated'];
    $updated = $row['lastUpdate'];
    $updated = ($updated==null) ? "Never": $updated;
  } else {
    echo "<div class='alert alert-danger'>Error: Unable to fetch record. ID may not exist</div>";
    echo "<a href='" . READ_EMPLOYEES . "' class='btn btn-danger'>Back to Employees</a>";
    die();
  }
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Skills Database - Employees</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href=<?php echo CSS_BOOTSTRAP_BILL_TURNER ?> />

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
            <h1>Employee Information - <?php echo $fName . " " . $lName ?></h1>
        </div>

        <!--we have our html table here where new user information will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>First Name</td>
                <td><?php echo htmlspecialchars($fName, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo htmlspecialchars($lName, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Title</td>
                <td><?php echo htmlspecialchars($title, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Last Skill Updated</td>
                <td><?php echo htmlspecialchars($updated, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Date Created</td>
                <td><?php echo htmlspecialchars($created, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href=<?php echo READ_EMPLOYEES ?> class='btn btn-danger'>Back to read employees</a>
                </td>
            </tr>
        </table>
        <!-- dynamic content will be here -->

    </div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src=<?php echo JQUERY_LIB ?>></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src=<?php echo JS_BOOTSTRAP_BILL_TURNER ?>></script>

</body>
</html>
