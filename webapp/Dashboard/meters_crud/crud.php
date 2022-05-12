<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <link rel="stylesheet" href="../css/styles.css">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>ELECTRICTY-PROTECT</h1>
        </div>
        <ul>
            <li><img src="../img/dashboard (2).png"  alt="">&nbsp; <span>Dashboard</span> </li>
            <li><img src="../img/reading-book (1).png" alt="">&nbsp;<span>Problem Meters</span> </li>
            <li><img src="../img/teacher2.png" alt="">&nbsp;<span>Utility Staff</span> </li>
            <li><img src="../img/school.png" alt="">&nbsp;<span>Statistics</span> </li>
            <li><img src="../img/help-web-button.png" alt="">&nbsp; <span>Help</span></li>
            <li><img src="../img/settings.png" alt="">&nbsp;<span>Settings</span> </li>
        </ul>
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Meter Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Meter</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "../config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM meter";
                    if($result = mysqli_query($db, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Meter ID</th>";
                                        echo "<th>Digital Address</th>";
                                        echo "<th>City</th>";
                                        echo "<th>Date issued</th>";
                                        echo "<th>Security code</th>";
                                        echo "<th>Operational</th>";
                                        echo "<th>Theft</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['Meter_ID'] . "</td>";
                                        echo "<td>" . $row['Digitaladdress'] . "</td>";
                                        echo "<td>" . $row['City'] . "</td>";
                                        echo "<td>" . $row['Date_issued'] . "</td>";
                                        echo "<td>" . $row['Security_code'] . "</td>";
                                        echo "<td>" . $row['Operational'] . "</td>";
                                        echo "<td>" . $row['Theft'] . "</td>";
                                        
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['Meter_ID'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['Meter_ID'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['Meter_ID'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($db);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>