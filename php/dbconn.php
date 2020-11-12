<?php 
// Database configuration 
$dbHost     = "localhost"; 
$dbUsername = "root";       
$dbPassword = "1234";         
$dbName     = "hand_me_down";  
 
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 

if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 
?>