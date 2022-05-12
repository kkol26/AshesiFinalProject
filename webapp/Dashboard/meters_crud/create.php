<?php
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$meter_id = $digiaddress = $city = $date = $code = $operational = $theft =  "";
$meter_id_err = $digiaddress_err = $city_err = $date_err = $code_err = $operational_err = $theft_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate digital address
    $input_meter_id = trim($_POST["Meter_ID"]);
    if(empty($input_meter_id)){
        $meter_id_err = "Please enter the Meter ID.";     
    } else{
        $meter_id = $input_meter_id;
    }

    
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
        $operational = $input_operational;
    }

    // Validate theft
    $input_theft = trim($_POST["theft"]);
    if(empty($input_theft)){
        $theft_err = "Please enter if the theft status.";     
    } 
    else{
        $theft = $input_theft;
    }
    
    // Check input errors before inserting in database
    if(empty($digiaddress_err) && empty($city_err) && empty($date_err) && empty($code_err) && 
        empty($operational_err) && empty($theft_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO meter (Meter_ID,Digitaladdress,City,Date_issued,Security_code,Operational,Theft) VALUES 
                (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){

            
            // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "sssssss", $param_meter_id, $param_digiaddress, $param_city, $param_date, $param_code,
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                            <input type="date" name="Date_issued" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
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
