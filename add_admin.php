<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are filled
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['telephone'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $telephone = $_POST['telephone'];

        // Check if password and confirm password match
        if ($password !== $confirm_password) {
            $error = "Password and confirm password do not match!";
        } else {
            // Hash the password before storing in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Your database connection code goes here
            $servername = "127.0.0.2:3306";
            $dbusername = "root";
            $dbpassword = "root";
            $dbname = "signin"; // Change this to your database name

            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute the SQL query to add the new admin
            $stmt = $conn->prepare("INSERT INTO admins (email, password, telephone, role) VALUES (?, ?, ?, 'admin')");
            $stmt->bind_param("sss", $email, $hashed_password, $telephone);
            $result = $stmt->execute();

            if ($result) {
                $success_message = "New admin account added successfully!";
            } else {
                $error = "Error adding admin account: " . $conn->error;
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        $error = "All fields are required!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin Account</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: beige;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            color: rgb(179, 128, 57);
            text-align: center;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            margin-bottom: 10px;
            text-align: center;
        }

        .success {
            color: green;
            margin-bottom: 10px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #d2b48c; 
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #b8860b; 
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
    <div class="form-container">
        <h2>Add Admin Account</h2>
        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if(isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>
            <label for="telephone">Telephone:</label>
            <input type="tel" id="telephone" name="telephone" required><br><br>
            <input type="submit" value="Add Admin">
        </form>
    </div>
</body>
</html>
