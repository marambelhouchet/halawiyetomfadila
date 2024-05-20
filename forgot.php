<?php
    $servername = "127.0.0.2";
    $username = "root";
    $password = "root";
    $dbname = "signin";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve email from the form
        $email = $_POST['email'];
    
        // Check if the email exists in the database
        $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email_sql);
    
        if ($result->num_rows > 0) {
            // Email exists in the database, proceed with password reset
            if ($_POST['password'] === $_POST['passwordc']) {
                // Passwords match, proceed with reset
                $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the new password
    
                // Update password in the database
                $sql_update_password = "UPDATE users SET password='$newPassword' WHERE email='$email'";
    
                if ($conn->query($sql_update_password) === TRUE) {
                    $reset_success_message = "Password reset successfully!";
                    // JavaScript alert to notify the user
                    echo "<script>alert('Password changed successfully!');</script>";
                } else {
                    $reset_error_message = "Error updating password: " . $conn->error;
                    // JavaScript alert to notify the user of the error
                    echo "<script>alert('$reset_error_message');</script>";
                }
            } else {
                // Passwords don't match, display an error message
                $reset_error_message = "Passwords do not match!";
                // JavaScript alert to notify the user of the error
                echo "<script>alert('$reset_error_message');</script>";
            }
        } else {
            // Email does not exist in the database
            $reset_error_message = "User does not exist!";
            // JavaScript alert to notify the user of the error
            echo "<script>alert('$reset_error_message');</script>";
        }
    }
    
    $conn->close();
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حلاويات فضيلة حلاويات أصيلة </title>
    <audio autoplay volume="1">
        <source src="ii.mp3">
    <link rel="stylesheet" href="style.css">
    </audio>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image:url("w.avif");
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="email"],
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        header {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            height: min-content;
            padding: 12.5px 100px;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.6s;
            background: beige;
            text-align: center;
        }

        .logo {
            color: rgb(165, 114, 42);
            text-transform: uppercase;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 2px;
            margin-left: 150px;
        }

        .navbar {
            list-style-type: none;
            display: flex;
            text-decoration: none;
        }
        .navbar a {
            color: rgb(154, 96, 15);
            font-weight: 500;
            font-size: 1.1rem;
            padding: 10px 20px;
            transition: 0.3s;
            text-decoration: none;
        }
        .navbar a:hover {
            color: black;
            transition: .4s;
        }

        .menu-icon {
            font-size: 2rem;
            cursor: pointer;
            display: none;
        }
        .forgot {
            color: #9aa045;
        }        label {
            width: 150px; 
            display: inline-block;
            text-align: right;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <audio autoplay volume="1">
        <source src="ii.mp3">
    </audio>
    <header>
        <a href="index.php" class="logo">Halawiyet Fadhila <br>حلويات فضيلة حلويات أصيلة</a>
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="s.php">Sign up</a></li>
            <li><a href="f.php">Login</a></li>
            <li><a href="contact.php">contact</a></li>
        </ul>
    </header>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2>Forgot Password</h2>
        <div>
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div>
            <label for="tel">Your phone number:</label>
            <input type="text" id="tel" name="tel" placeholder="Enter your phone number" required>
        </div>
        <div>
            <label for="password">Your new password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your new password" required>
        </div>
        <div>
            <label for="passwordc">Confirm password:</label>
            <input type="password" id="passwordc" name="passwordc" placeholder="Confirm your new password" required>
        </div>
        <input type="submit" value="Reset">
    </form>

    

    <script>
        document.getElementById('signinForm').addEventListener('submit', function(event) {
            event.preventDefault(); 
            const emailInput = document.getElementById('email');
        const email = emailInput.value.trim();

            const telephoneInput = document.getElementById('tel');
            const tel = telephoneInput.value.trim();
            if (tel.length !== 8 || isNaN(tel)) {
                alert('Please enter a valid phone number with 8 digits.');
                return; 
            }
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('passwordc');
            const password = passwordInput.value.trim();
            const passwordConfirm = passwordConfirmInput.value.trim();
            if (password !== passwordConfirm) {
                alert('Passwords do not match.');
                event.preventDefault(); // Prevent form submission if passwords don't match
            }
        });
    </script>
</body>
</html>
