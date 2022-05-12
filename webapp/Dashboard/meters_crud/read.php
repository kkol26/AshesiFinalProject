<?php
// Check existence of id parameter before processing further
if(isset($_GET["Meter_ID"]) && !empty(trim($_GET["Meter_ID"]))){
    // Include config file
    require_once "../config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM meter WHERE Meter_ID = ?";
    
    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["Meter_ID"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $digiaddress = $row["Digitaladdress"];
                $city = $row['City'];
                $date = $row['Date_issued'];
                $code = $row['Security_code'];
                $operational = $row['Operational'];
                $theft = $row['Theft'];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($db);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Meter ID</label>
                        <p><b><?php echo $row["Meter_ID"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Digital address</label>
                        <p><b><?php echo $row["Digitaladdress"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <p><b><?php echo $row["City"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Date Issued</label>
                        <p><b><?php echo $row["Date_issued"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Security code</label>
                        <p><b><?php echo $row["Security_code"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Operational</label>
                        <p><b><?php echo $row["operational"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Theft Detected</label>
                        <p><b><?php echo $row["theft"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>