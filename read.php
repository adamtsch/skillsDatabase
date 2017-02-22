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

    <!-- custom css -->
    <style>
    .m-r-1em{ margin-right:1em; }
    .m-b-1em{ margin-bottom:1em; }
    .m-l-1em{ margin-left:1em; }
    </style>

</head>
<body>

    <!-- container -->
    <div class="container">

        <div class="page-header">
            <h1>Employees</h1>
        </div>

        <?php
        // include database connection
        include DATABASE_CONFIG;

        // select all data
        $query = "SELECT e.employeeId, e.firstName, e.lastName, t.title, e.lastUpdate, e.dateCreated FROM employees e, titles t WHERE e.employeeTitle=t.titleId ORDER BY e.employeeId ASC";
        $result = $con->select($query);

        // link to create record form
        echo "<a href='create.php' class='btn btn-primary m-b-1em m-r-1em'>Create New Employee</a>";


        // echo "<a href='readTitle.php' class='btn btn-primary m-b-1em'>Show Employee Titles</a>";

        //check if more than 0 record found
        if(count($result)>0){
            echo "<table class='table table-hover table-responsive table-bordered'>";//start table

                //creating our table heading
                echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>First Name</th>";
                    echo "<th>Last Name</th>";
                    echo "<th>Title</th>";
                    echo "<th>Last Skill Update</th>";
                    echo "<th>Date Created</th>";
                    echo "<th>Action</th>";
                echo "</tr>";

                foreach($result as $row) {

                    // Get data from array
                    $employeeId = $row['employeeId'];
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $title = $row['title'];
                    $lastUpdate = $row['lastUpdate'];
                    $dateCreated = $row['dateCreated'];

                    // creating new table row per record
                    echo "<tr>";
                        echo "<td>{$employeeId}</td>";
                        echo "<td>{$firstName}</td>";
                        echo "<td>{$lastName}</td>";

                        // Title Lookup
                        echo "<td>{$title}</td>";

                        //Last Update
                        echo "<td>".(($lastUpdate==NULL) ? "Never" : $lastUpdate)."</td>";

                        echo "<td>{$dateCreated}</td>";
                        echo "<td>";
                            // read one record
                            echo "<a href=" . READ_ONE_EMPLOYEE . ".?id={$employeeId} class='btn btn-info m-r-1em'>Read</a>";
                            // Update employee record
                            echo "<a href=". UPDATE_EMPLOYEE . "?id={$employeeId} class='btn btn-primary m-r-1em'>Edit</a>";
                            // Delete employee
                            echo "<a href='#' onclick='delete_user({$employeeId})'  class='btn btn-danger'>Delete</a>";
                        echo "</td>";
                    echo "</tr>";
                }

            // end table
            echo "</table>";

        }

        // if no records found
        else{
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>

    <!-- dynamic content will be here -->

    </div> <!-- end .container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src=<?php echo JQUERY_LIB ?>></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src=<?php echo JS_BOOTSTRAP_BILL_TURNER ?>></script>

</body>
</html>
