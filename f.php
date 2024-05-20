<?php session_start(); ?>

<?php
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = $_POST['email'];
    $password = $_POST['password'];

    $servername = "127.0.0.2";
    $dbusername = "root";
    $dbpassword = "root";
    $dbname = "signin";

   
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch user data from users table
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmtUsers = $conn->prepare($sql);
    $stmtUsers->bind_param("s", $email);
    $stmtUsers->execute();
    $resultUsers = $stmtUsers->get_result();

    // Check if user exists in users table
    if ($resultUsers->num_rows > 0) {
        // User exists in users table, verify password
        $rowUsers = $resultUsers->fetch_assoc();
        if (password_verify($password, $rowUsers['password'])) {
            // Password is correct, login successful
            $_SESSION['email'] = $email;

            // Check if the user exists in the admins table
            $sqlAdmins = "SELECT * FROM admins WHERE email = ?";
            $stmtAdmins = $conn->prepare($sqlAdmins);
            $stmtAdmins->bind_param("s", $email);
            $stmtAdmins->execute();
            $resultAdmins = $stmtAdmins->get_result();

            if ($resultAdmins->num_rows > 0) {
                // User exists in admins table, assign admin role
                $_SESSION['role'] = 'admin';
            }

            $stmtAdmins->close();
            $stmtUsers->close();
            $conn->close();

            header("Location: index.php");
            exit();
        } else {
            // Password is incorrect, store error message in session
            $_SESSION['error'] = "Incorrect password";
            header("Location: f.php");
            exit();
        }
    } else {
        // User does not exist in users table, store error message in session
        $_SESSION['error'] = "User does not exist";
        header("Location: f.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            color: rgb(4, 2, 2);
            transition: .4s;
        }

        .menu-icon {
            font-size: 2rem;
            cursor: pointer;
            display: none;
        }

        .forgot {
            color: #9aa045;
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
            <?php if(isset($_SESSION['email'])): ?>
                <!-- Display navigation options for logged-in users -->
                <li><a href="index.php">Home</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="liste_achat.php">Liste d'achat</a></li>
            <?php else: ?>
                <!-- Display navigation options for non-logged-in users -->
                <li><a href="index.php">Home</a></li>
                <li><a href="s.php">Sign up</a></li>
                <li><a href="f.php">Login</a></li>
            <?php endif; ?>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </header>
    <form action="f.php" method="POST">
        <h2>Login</h2>
        <label for="email">Your Gmail</label>
        <input type="email" id="email" name="email" placeholder="Enter your gmail" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <input type="submit" value="Login">

        <div>
            <a href="forgot.php" class="forgot">Forgot Password?</a>
        </div>
        <div>
            <a href="s.php" class="forgot">Don't have an account? Sign up</a>
        </div>
    </form>

    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="mr-auto">Error</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>
        </div>
    </div>

   

    <script>
        $(document).ready(function() {
            // Check if there is an error message stored in the session
            <?php if (isset($_SESSION['error'])): ?>
                // Display the error message as a toast
                $('.toast').toast({ delay: 3000 }); // Set the delay for the toast
                $('.toast').toast('show'); // Show the toast
            <?php endif; ?>

            // Remove the error message from the session after displaying it
            <?php unset($_SESSION['error']); ?>
        });
    </script>
</body>
</html>

