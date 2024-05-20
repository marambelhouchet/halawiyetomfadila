<?php 
session_start(); 
// Check if user is logged in
if(!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: f.php");
    exit();
}

// Include database connection
include 'db_connection.php';

// Fetch purchases for the logged-in user
$email = $_SESSION['email'];
$sql = "SELECT * FROM purchases WHERE email = '$email'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Liste d'Achat</title>
<link rel="stylesheet" href="style.css">
<style>
    /* Table style */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    
    th {
        background-color: #f2f2f2;
    }
    
    /* Alternate row color */
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    
    /* Header style */
    .ee {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 20px;
        color: #4CAF50;
    }
    
    /* Content style */
    .content {
        width: 80%;
        margin: 0 auto;
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
        
            <li><a href="index.php">Home</a></li>
            <li><a href="settings.php">Settings</a></li>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            
                <li><a href="users.php">Users and commands</a></li>
            <?php else: ?>
               
                <li><a href="liste_achat.php">Liste d'achat</a></li>
            <?php endif; ?>
        <?php else: ?>
            
            <li><a href="index.php">Home</a></li>
            <li><a href="s.php">Sign up</a></li>
            <li><a href="f.php">Login</a></li>
        <?php endif; ?>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</header>

    <div class="content">
        <h1 class="ee">Liste d'Achat</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom de la Pâtisserie</th>
                    <th>Quantité (kg)</th>
                    <th>Prix (DT)</th>
                    <th>Numéro de téléphone</th>
                    <th>Adresse</th>
                    <th>Date de la Commande</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0) {
                   
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["product"] . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "<td>" . $row["purchase_date"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Aucun achat trouvé.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
