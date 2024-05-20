<?php
$servername = "127.0.0.2";
$username = "root";
$password = "root";
$dbname = "achat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
