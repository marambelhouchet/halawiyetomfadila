<?php
session_start();
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receive form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection parameters
    $servername = "127.0.0.2";
    $dbusername = "root";
    $dbpassword = "root";
    $dbname = "signin";

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch user data
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // User exists, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, login successful
            $_SESSION['email'] = $email;

            // Check if the user is an admin
            if ($email === "root@gmail.com" && $password === "root") {
                $_SESSION['role'] = 'admin';
            }

            header("Location: index.php");
            exit();
        } else {
            // Password is incorrect, store error message in session
            $_SESSION['error'] = "Incorrect password";
            header("Location: f.php");
            exit();
        }
    } else {
        // User does not exist, store error message in session
        $_SESSION['error'] = "User does not exist";
        header("Location: f.php");
        exit();
    }
    if ($stmt !== false) {
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer une Commande de Pâtisserie</title>
    <link rel="stylesheet" href="style.css">
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
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          
                    <li><a href="users.php">Users and commands</a></li>
                <?php else: ?>
                    <!-- Display "Liste d'achat" option for non-admin users -->
                    <li><a href="liste_achat.php">Liste d'achat</a></li>
                <?php endif; ?>
            <?php else: ?>
                <!-- Display navigation options for non-logged-in users -->
                <li><a href="index.php">Home</a></li>
                <li><a href="s.php">Sign up</a></li>
                <li><a href="f.php">Login</a></li>
            <?php endif; ?>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </header>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="content">
            <h2>You cannot place an order as an admin.</h2>
        </div>
    <?php else: ?>
        <div class="content">
            <h1 class="ee">Passer une Commande de Pâtisserie</h1>
            <form action="submit_order.php" method="POST" id="orderForm">
                <div>
                    <label for="hlou" class="nom">Nom de la Pâtisserie (Hlou) :</label>
                </div>
                <div>
                    <select id="hlouu" name="hlou" class="name1" onchange="calculatePrice()">
                    <option value="kaak louz" data-price="50">kaak louz (50 DT/kg)</option>
                    <option value="kaak warka" data-price="50">kaak warka (50 DT/kg)</option>
                    <option value="Dawama amande" data-price="50">Dawama amande (50 DT/kg)</option>
                    <option value="kaak fosdok bondek" data-price="70">kaak fosdok bondek (70 DT/kg)</option>
                    <option value="Bjaouia" data-price="52">Bjaouia (52 DT/kg)</option>
                    <option value="zrir sesame" data-price="4.400">zrir sesame (4.400 DT/kg)</option>
                    <option value="coupe asida zgougo" data-price="5.200">coupe asida zgougo (5.200 DT/kg)</option>
                    <option value="biscuit laada" data-price="5.200">biscuit laada (5.200 DT/kg)</option>
                    <option value="mlabes louz" data-price="50">mlabes louz (50 DT/kg)</option>
                    <option value="kaak anber" data-price="50">kaak anber (50 DT/kg)</option>
                    <option value="kaaber bondok" data-price="88">kaaber bondok (88 DT/kg)</option>
                    <option value="hlou omk fadhila" data-price="10">hlou omk fadhila (10 DT/kg)</option>
                    <option value="yoyo" data-price="20">yoyo (20 DT/kg)</option>
                    <option value="corne de gazeille" data-price="30">corne de gazeille (30 DT/kg)</option>
                    <option value="zouza" data-price="50">zouza (50 DT/kg)</option>
                    <option value="makrouth" data-price="20">makrouth (20 DT/kg)</option>
                    <option value="samsa" data-price="26">samsa (26 DT/kg)</option>
                    <option value="jeljlaniya" data-price="38">jeljlaniya (38 DT/kg)</option>
                    <option value="graiba" data-price="26">graiba (26 DT/kg)</option>
                    <option value="sablé" data-price="16">sablé (16 DT/kg)</option>
                    <option value="chapeau soltane" data-price="70">chapeau soltane (70 DT/kg)</option>
                </select>
                </div>
                <div>
                    <label for="quantite" class="quan">Quantité (kg):</label>
                </div>
                <div>
                    <input type="number" name="quantite" id="quantite" min="1" required onchange="calculatePrice()">
                </div>
                <div>
                    <label for="tel" class="tele">Numéro de téléphone :</label>
                </div>
                <div>
                    <input type="tel" placeholder="donner votre numéro" id="telephone" name="telephone" required pattern="[0-9]{8}">
                </div>
                <div>
                    <label for="add" class="tele">votre adresse :</label>
                </div>
                <div>
                    <input type="text" placeholder="donner votre adresse" id="address" name="address" required>
                </div>
                <div>
                    <label for="prix" class="tele">Prix (DT):</label>
                </div>
                <div>
                    <input type="text" id="prix" name="prix" readonly value="0 DT">
                </div>
                <button type="submit" class="sub">Passer la Commande</button>
                <button type="reset" class="resett" onclick="resetForm()">Annuler la Commande</button>
            </form>
        </div>
    <?php endif; ?>
    <script>
        const telephoneInput = document.getElementById('telephone');
        telephoneInput.addEventListener('input', function() {
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }
        });

        function calculatePrice() {
            // Get the selected option
            var select = document.getElementById("hlouu");
            var selectedOption = select.options[select.selectedIndex];
            
            // Get the price per kilogram
            var pricePerKg = parseFloat(selectedOption.getAttribute("data-price"));
            
            // Get the quantity
            var quantity = parseFloat(document.getElementById("quantite").value);
            
            // Calculate the total price
            var totalPrice = pricePerKg * quantity;
            
            // Update the price field
            document.getElementById("prix").value = totalPrice.toFixed(2) + " DT";
        }

        // Call calculatePrice initially to set the initial value
        calculatePrice();

        // Function to reset the form fields
        function resetForm() {
            document.getElementById("orderForm").reset();
            document.getElementById("prix").value = "0 DT";
        }
        <?php if(isset($_GET['success']) && $_GET['success'] == 'true'): ?>
            window.location.href = 'index.php';
        <?php endif; ?>
    </script>
</body>
</html>
