<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $tel = $_POST['tel'];


    $servername = "127.0.0.2";
    $dbusername = "root";
    $dbpassword = "root";
    $dbname = "signin";

  
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

 
    $check_query = "SELECT * FROM users WHERE email=?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
    
        echo "email_exists";
        exit();
    } else {
       
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      
        $insert_query = "INSERT INTO users (email, password, address, tel) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bind_param("ssss", $email, $hashed_password, $address, $tel);

        if ($insert_stmt->execute()) {
            
            echo "registration_success";
        } else {
            
            echo "registration_failed";
        }
    }

   
    $check_stmt->close();
    $insert_stmt->close();
    $conn->close();
}
