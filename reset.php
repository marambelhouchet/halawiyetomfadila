<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
            color: white;
            transition: .4s;
        }
        
    </style>
</head>
<body>
<header>
    <a href="index.php" class="logo">Halawiyet Fadhila <br>حلويات فضيلة حلويات أصيلة</a>
    <ul class="navbar">
        <?php if(isset($_SESSION['email'])): ?>
            <!-- Display navigation options for logged-in users -->
            <li><a href="index.php">Home</a></li>
            <li><a href="settings.php">Settings</a></li>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <!-- Display additional options for admin users -->
                <li><a href="users.php">Users and commands</a></li>
            <?php else: ?>
                <!-- Display "Liste d'achat" option for non-admin users -->
                <li><a href="liste_achat.php">Liste d'achat</a></li>
            <?php endif; ?>
        <?php else: ?>
            <!-- Display navigation options for non-logged-in users -->
            <li><a href="index.php">Home</a></li>
            <li><a href="s.php">Sign In</a></li>
            <li><a href="f.php">Login</a></li>
        <?php endif; ?>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</header>
    <form id="resetForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h2>Reset Your Password</h2>
        <div>
            <label for="password">Your new password:</label>
        </div>
        <input type="password" id="password" name="password" placeholder="Enter your new password" required>
        <div>
            <label for="passwordc">Confirm password:</label>
        </div>
        <input type="password" id="passwordc" name="passwordc" placeholder="Confirm password" required>
        <input type="submit" value="Reset">
    </form>
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
    // Check if passwords match
    if ($_POST['password'] === $_POST['passwordc']) {
        // Passwords match, proceed with reset
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); 

        // Retrieve email from session
        $email = $_SESSION['email'];

        // Update password in the database
        $sql_update_password = "UPDATE users SET password='$newPassword' WHERE email='$email'";

        if ($conn->query($sql_update_password) === TRUE) {
            echo "<script>alert('Password reset successfully!');</script>";
        } else {
            echo "<p>Error updating password: " . $conn->error . "</p>";
        }
    } else {
        // Passwords don't match, display an error message
        echo "<p>Passwords do not match!</p>";
    }
}

$conn->close();
?>


    <script>
        document.getElementById('resetForm').addEventListener('submit', function(event) {
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('passwordc');
            const password = passwordInput.value.trim();
            const passwordConfirm = passwordConfirmInput.value.trim();
            if (password !== passwordConfirm) {
                alert('Passwords do not match.');
                event.preventDefault(); 
            }
        });
    </script>
</body>
</html>
