<? require_once("config/fileConstants.php") ?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Skills Database - Employees</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="libs/bootstrap-3.3.7/css/bootstrap.min.css" />

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
        include 'config/database.php';

        // select all data
        $query = "SELECT e.employeeId, e.firstName, e.lastName, t.title, e.lastUpdate, e.dateCreated FROM employees e, titles t WHERE e.employeeTitle=t.titleId ORDER BY e.employeeId ASC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='create.php' class='btn btn-primary m-b-1em m-r-1em'>Create New Employee</a>";


        // echo "<a href='readTitle.php' class='btn btn-primary m-b-1em'>Show Employee Titles</a>";

        //check if more than 0 record found
        if($num>0){
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

                // retrieve our table contents
                // fetch() is faster than fetchAll()
                // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                    // extract row
                    // this will make $row['firstname'] to
                    // just $firstname only
                    extract($row);

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
                            echo "<a href=" . READ_ONE_EMPLOYEE . ".?id={$employeeId}' class='btn btn-info m-r-1em'>Read</a>";
                            // Update employee record
                            echo "<a href=". UPDATE_EMPLOYEE . "?id={$employeeId}' class='btn btn-primary m-r-1em'>Edit</a>";
                            // Delete employee
                            echo "<a href='#' onclick='delete_user({$employeeId});'  class='btn btn-danger'>Delete</a>";
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
<script src="libs/jquery-3.1.1.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="libs/bootstrap-3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
