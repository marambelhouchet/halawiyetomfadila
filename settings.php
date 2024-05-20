<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
        .settings-form {
            background-color: beige;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .settings-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .settings-form input[type="email"],
        .settings-form input[type="text"],
        .settings-form input[type="password"],
        .settings-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .settings-form input[type="submit"] {
            background-color: #d2b48c; /* Brown */
            color: white;
            border: none;
            cursor: pointer;
        }
        .settings-form input[type="submit"]:hover {
            background-color: #b8860b; /* Darker brown */
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
            color: rgb(179, 128, 57);
            transition: .4s;
        }
        .settings-container {
            margin-top: 50px;
        }
        .settings-option {
            margin-bottom: 10px;
        }
        .se {
            color: rgb(179, 128, 57);
        }
    </style>
</head>
<body>
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

<div class="settings-container">
    <div class="settings-form">
    <?php if(isset($_SESSION['email'])): ?>
            <div class="settings-option">
                <p> <?php echo $_SESSION['email']; ?></p>
            </div>
        <?php endif; ?>
        <h2 class="se">Settings</h2>
        
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
 
            <div class="settings-option">
                <a href="add_admin.php">Add Admin Account</a>
            </div>
        <?php else: ?>
            <div class="settings-option">
            <a href="reset.php">Reset Password</a>
        </div>
            <div class="settings-option">
                <button id="delete-account-btn">Delete Account</button>
            </div>
        <?php endif; ?>
        
        <div class="settings-option">
            <button id="logout-btn">Logout</button>
        </div>
    </div>
</div>


<script>
    document.getElementById('logout-btn').addEventListener('click', function() {
        var confirmLogout = confirm("Are you sure you want to logout?");
        if (confirmLogout) {
            window.location.href = 'logout.php';
        }
    });

    document.getElementById('delete-account-btn').addEventListener('click', function() {
        var confirmDelete = confirm("Are you sure you want to delete your account? This action cannot be undone.");
        if (confirmDelete) {
           
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_account.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert(xhr.responseText);
                    window.location.href = 'index.php'; 
                } else {
                    alert('Error: ' + xhr.responseText);
                }
            };
            xhr.send();
        }
    });

    
</script>
</body>
</html>

