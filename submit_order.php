<?php
session_start();


include 'db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $product = $_POST['hlou'];
    $quantity = $_POST['quantite'];
    $phone = $_POST['telephone'];
    $address = $_POST['address'];

    $email = $_SESSION['email'];

    
    $sql_price = "SELECT price FROM products WHERE product_name = '$product'";
    $result_price = $conn->query($sql_price);

    if ($result_price && $result_price->num_rows > 0) {
        
        $row = $result_price->fetch_assoc();
        $price_per_kg = $row['price'];
        
     
        $total_price = $quantity * $price_per_kg;

       
        $sql = "INSERT INTO purchases (email, product, quantity, phone, address, purchase_date, price)
                VALUES ('$email', '$product', '$quantity', '$phone', '$address', NOW(), '$total_price')";

        if ($conn->query($sql) === TRUE) {
            
            echo "<script>alert('Order placed successfully! Total price: " . $total_price . " DT'); window.location = 'index.php';</script>";
        } else {
           
            echo "<script>alert('Error placing order: " . $conn->error . "');</script>";
        }
    } else {
      
        echo "<script>alert('Error: Price not found for the selected product.');</script>";
    }
} else {
    
    header("Location: index.php");
    exit();
}


$conn->close();
