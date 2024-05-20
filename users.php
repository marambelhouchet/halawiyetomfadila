<?php
session_start();

// Check if the user is logged in and has admin role
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Database connection parameters
$servername = "127.0.0.2:3306";
$dbusername = "root";
$dbpassword = "root";
$dbname_signin = "signin";
$dbname_achat = "achat"; // Add the new database name here

// Create connection for the signin database
$conn_signin = new mysqli($servername, $dbusername, $dbpassword, $dbname_signin);

// Create connection for the achat database
$conn_achat = new mysqli($servername, $dbusername, $dbpassword, $dbname_achat);

// Check connections
if ($conn_signin->connect_error || $conn_achat->connect_error) {
    die("Connection failed: " . $conn_signin->connect_error . " - " . $conn_achat->connect_error);
}

// Function to delete a user
function deleteUser($conn, $email) {
    $sql = "DELETE FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->close();
}

// Function to cancel a purchase
function cancelPurchase($conn, $purchase_id) {
    $sql = "DELETE FROM purchases WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $purchase_id);
    $stmt->execute();
    $stmt->close();
}

// Check if delete user button is clicked
if (isset($_POST['delete_user']) && isset($_POST['user_email'])) {
    $email = $_POST['user_email'];
    deleteUser($conn_signin, $email);
}

// Check if cancel purchase button is clicked
if (isset($_POST['cancel_purchase']) && isset($_POST['purchase_id'])) {
    $purchase_id = $_POST['purchase_id'];
    cancelPurchase($conn_achat, $purchase_id);
}

// Fetch users and their purchases from the databases
$sql = "SELECT users.email, users.tel, purchases.id as purchase_id, purchases.product, purchases.quantity, purchases.purchase_date, purchases.price 
        FROM $dbname_signin.users 
        LEFT JOIN $dbname_achat.purchases ON users.email = purchases.email";
$result = $conn_signin->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #ccc;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
            <li><a href="settings.php">Settings</a></li>
            <li><a href="users.php">Users and commands</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </header>

    <div class="content">
        <h1 class="ee">Liste des Utilisateurs et leurs Achats</h1>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Date d'Achat</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["tel"] . "</td>";
                        echo "<td>" . $row["product"] . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "<td>" . $row["purchase_date"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>";
                        echo "<form method='post' onsubmit='return confirmDelete()'>";
                        echo "<input type='hidden' name='user_email' value='{$row["email"]}'>";
                        echo "<button type='submit' name='delete_user'>Delete User</button>";
                        echo "</form>";
                        echo "<form method='post' onsubmit='return confirmCancel()'>";
                        echo "<input type='hidden' name='purchase_id' value='{$row["purchase_id"]}'>";
                        echo "<button type='submit' name='cancel_purchase'>Cancel Purchase</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this user?");
        }
        
        function confirmCancel() {
            return confirm("Are you sure you want to cancel this purchase?");
        }
    </script>
</body>
</html>
