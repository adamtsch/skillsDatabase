<? require_once("config/fileConstants.php") ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>

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
            <h1>Read One</h1>
        </div>

        <?php
          // get passed parameter value, in this case, the record ID
          // isset() is a PHP function used to verify if a value is there or not
          $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record Employee ID not found.');

          //include database connection
          include 'config/database.php';

          // read current record's data
          try {
              // prepare select query
              $query = "SELECT e.employeeId, e.firstName, e.lastName, t.title, e.lastUpdate, e.dateCreated FROM employees e, titles t WHERE e.employeeTitle=t.titleId AND e.employeeId = ? LIMIT 0,1";
              $stmt = $con->prepare( $query );

              // this is the first question mark
              $stmt->bindParam(1, $id);

              // execute our query
              $stmt->execute();

              // store retrieved row to a variable
              $row = $stmt->fetch(PDO::FETCH_ASSOC);

              // values to fill up our form
              $fName = $row['firstName'];
              $lName = $row['lastName'];
              $title = $row['title'];
              $created = $row['dateCreated'];
              $updated = $row['lastUpdate'];
              $updated = ($updated==null) ? "Never": $updated;

          }

          // show error
          catch(PDOException $exception){
              die('ERROR: ' . $exception->getMessage());
          }
        ?>
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
