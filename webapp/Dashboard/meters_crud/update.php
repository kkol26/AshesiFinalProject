<?php
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$meter_id = $digiaddress = $city = $date = $code = $operational = $theft =  "";
$meter_id_err = $digiaddress_err = $city_err = $date_err = $code_err = $operational_err = $theft_err =  "";
 
// Processing form data when form is submitted
if(isset($_POST["Meter_ID"]) && !empty($_POST["Meter_ID"])){
    // Get hidden input value
    $meter_id = $_POST["Meter_ID"];
    
    // Validate name
    // $input_name = trim($_POST["name"]);
    // if(empty($input_name)){
    //     $name_err = "Please enter a name.";
    // } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    //     $name_err = "Please enter a valid name.";
    // } else{
    //     $name = $input_name;
    // }
    
    // Validate digital address
    $input_address = trim($_POST["Digitaladdress"]);
    if(empty($input_address)){
        $dgiaddress_err = "Please enter an address.";     
    } else{
        $digiaddress = $input_address;
    }

    // Validate city
    $input_city = trim($_POST["City"]);
    if(empty($input_city)){
        $city_err = "Please enter the name of the City.";     
    } else{
        $city = $input_city;
    }

    // Validate date
    $input_date = trim($_POST["Date_issued"]);
    if(empty($input_date)){
        $date_err = "Please enter the date of issue.";     
    } else{
        $date = $input_date;
    }

    // Validate security code
    $input_code = trim($_POST["Security_code"]);
    if(empty($input_code)){
        $code_err = "Please enter the security code.";     
    } else{
        $code = $input_code;
    }
    
    // Validate operational
    $input_operational = trim($_POST["operational"]);
    if(empty($input_operational)){
        $operational_err = "Please enter the yes/no for operational.";     
    } 
    else{
        $operational = $input_oeprational;
    }

    // Validate theft
    $input_theft = trim($_POST["Theft"]);
    if(empty($input_theft)){
        $theft_err = "Please enter if the theft status.";     
    } 
    else{
        $theft = $input_theft;
    }
    
    
    // Check input errors before inserting in database
    if(empty($digiaddress_err) && empty($city_err) && empty($date_err) && empty($code_err) && 
        empty($operational_err) && empty($theft_err)){
        // Prepare an update statement
        $sql = "UPDATE employees SET Digitaladdress=?, City=?, Date_issued=? Security_code=? Operational=? Theft=? WHERE Meter_ID=?";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_digiaddress, $param_city, $param_date, $param_code,
                                                  $param_operational,$param_theft);
            
            // Set parameters
            $param_digiaddress = $digiaddress;
            $param_city = $city;
            $param_date = $date;
            $param_code = $code;
            $param_operational = $operational;
            $param_theft = $theft;
            $param_meter_id = $meter_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: crud.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($db);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["Meter_ID"]) && !empty(trim($_GET["Meter_ID"]))){
        // Get URL parameter
        $meter_id =  trim($_GET["Meter_ID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM meter WHERE Meter_ID = ?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_meter_id);
            
            // Set parameters
            $param_meter_id = $meter_id;
            
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
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Meter ID</label>
                            <input type="text" name="Meter_ID" class="form-control <?php echo (!empty($meter_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $meter_id; ?>">
                            <span class="invalid-feedback"><?php echo $meter_id_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Digital Address</label>
                            <input type="text" name="Digitaladdress" class="form-control <?php echo (!empty($digiaddress_err)) ? 'is-invalid' : ''; ?>"><?php echo $digiaddress; ?></textarea>
                            <span class="invalid-feedback"><?php echo $digiaddress_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="City" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                            <span class="invalid-feedback"><?php echo $city_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date Issued</label>
                            <input type="text" name="Date_issued" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Security code</label>
                            <input type="text" name="Security_code" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $code; ?>">
                            <span class="invalid-feedback"><?php echo $code_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Operational</label>
                            <select name="operational" class="form-control <?php echo (!empty($operational_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $operational; ?>">
                                <option value="">Select One</option>
                                <option value = "Yes">Yes</option>
                                <option value = "No">No</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $operational_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Theft detected</label>
                            <select name="theft" class="form-control <?php echo (!empty($theft_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $theft; ?>">
                                <option value="">Select One</option>
                                <option value = "Yes">Yes</option>
                                <option value = "No">No</option>
                            </select>
                            <span class="invalid-feedback"><?php echo $theft_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>