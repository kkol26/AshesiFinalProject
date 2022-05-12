<?php
session_start();

// initializing variables
$email    = "";
$first_name = "";
$last_name ="";
$staff_id ="";
$contact_no ="";
$errors = array(); 


// connect to the database
$url='localhost:3307';
$username='root';
$password='';
$database = 'utility_data';
$db=mysqli_connect($url,$username,$password,$database);
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $staff_id = mysqli_real_escape_string($db, $_POST['staff_id']);
  $first_name = mysqli_real_escape_string($db, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($staff_id)) { array_push($errors, "Staff ID is required"); }
  if (empty($first_name)) { array_push($errors, "First Name is required"); }
  if (empty($last_name)) { array_push($errors, "Last Name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same email or staff_id
  $user_check_query = "SELECT * FROM Utility_Staff WHERE StaffID='$staff_id' OR Email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['StaffID'] === $staff_id) {
      array_push($errors, "Staff ID already exists");
    }

    if ($user['Email'] === $email) {
      array_push($errors, "Email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = $password_1;

  	$query = "INSERT INTO utility_staff (StaffID,First_Name, Last_Name, Contact_No, Email, Password) 
  			  VALUES('$staff_id', '$first_name', '$last_name','$contact_no','$email','$password')";
  	mysqli_query($db, $query);
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: ../Dashboard/home.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
  
    if (empty($email)) {
        array_push($errors, "email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $query = "SELECT * FROM Utility_Staff WHERE Email='$email' AND Password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          $_SESSION['email'] = $email;
          $_SESSION['success'] = "You are now logged in";
          header('location: ../Dashboard/home.php');
        }else {
            array_push($errors, "Wrong email/password combination");
        }
    }
  }
  
?>