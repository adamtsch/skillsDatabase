<? require_once("config/fileConstants.php") ?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Skills Database - Titles</title>

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
            <h1>Employee Titles</h1>
        </div>

        <?php
        // include database connection
        include DATABASE_CONFIG;

        // select all data
        $query = "SELECT titleId, title FROM titles ORDER BY titleId ASC";
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        //echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Title</a>";
        //check if more than 0 record found
        if($num>0){

            echo "<table class='table table-hover table-responsive table-bordered'>";//start table

                //creating our table heading
                echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Title</th>";
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
                        echo "<td>{$titleId}</td>";
                        echo "<td>{$title}</td>";
                    echo "</tr>";
                }

            // end table
            echo "</table>";
            echo "<a href=" . READ_EMPLOYEES . "class='btn btn-primary m-t-1em'>Back to Employees</a>";


        }

        // if no records found
        else {
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
