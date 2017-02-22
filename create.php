<?php require_once("config/fileConstants.php") ?>

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
            <h1>Add New Employee to Skills Database</h1>
        </div>

        <?php
          if($_POST){
              // include database connection
              require_once(DATABASE_CONFIG);

              // insert query
              $query = "INSERT INTO employees SET firstName=:fName, lastName=:lName, employeeTitle=:title, dateCreated=:created";

              // posted values
              $fName=htmlspecialchars(strip_tags($_POST['fName']));
              $lName=htmlspecialchars(strip_tags($_POST['lName']));
              $title = $_POST['title'];


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

              // INSERT statement data values
              $dataArray = array(':fName' => $fName, ':lName' => $lName, ':title' => $title, ':created' => (date('Y-m-d H:i:s')));

				// Execute the query if valid
				if ( $valid ){
				  if($con->insert($query, $dataArray)){
					  echo "<div class='alert alert-success'>Record was saved.</div>";
				  }else{
					  echo "<div class='alert alert-danger'>Unable to save record.</div>";
				  }
				}
			}
		?>


        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='fName' value='<?php if($_POST){ echo $fName; }?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='lName' value='<?php if($_POST){ echo $lName; }?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Title</td>
                    <!-- <td><input type="text" name='titleName' class='form-control'> -->
                    <?php include "titleDropdown.php" ?>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href=<?php echo READ_EMPLOYEES ?> class='btn btn-danger'>Back to All Employees</a>
                    </td>
                </tr>
            </table>
        </form>


    </div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src=<?php echo JQUERY_LIB ?>></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src=<?php echo JS_BOOTSTRAP_BILL_TURNER ?>></script>

</body>
</html>
