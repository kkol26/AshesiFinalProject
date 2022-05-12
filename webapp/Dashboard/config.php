<?php
session_start();

// connect to the database
$url='localhost:3307';
$username='root';
$password='';
$database = 'utility_data';
$db=mysqli_connect($url,$username,$password,$database);
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

?>
