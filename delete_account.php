<?php
session_start();
$servername = "127.0.0.2";
$dbusername = "root"; 
$dbpassword = "root"; 
$dbname = "signin";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname); // Use correct variables here

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_SESSION['email'];

$sql = "DELETE FROM users WHERE email='$email'";
if ($conn->query($sql) === TRUE) {
 
    $_SESSION = array(); 
    session_destroy(); 
    echo "Your account has been successfully deleted.";
} else {
    echo "Error deleting account: " . $conn->error;
}

$conn->close();
