<?php session_start(); ?>
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
        <h1 class="ee">Contactez-nous</h1>
            <div>
                <h2>Call Us On</h2>
            </div>
            <div>
                <h3>2670028903-0022576984</h3>
            </div>
            <div>
                <img src="local.jpg"  class="f9">
            </div>
           <a href="https://www.google.com/maps/@36.8635279,10.1597457,16.24z?hl=fr&entry=ttu" class="mmmm" target="_blank">Découvrez notre<br> emplacement à<br> Ennasr, Tunisie.</a>
           <div>
            <h6 class="bb">Cliquez sur la photo pour <br> découvrir notre emplacement</h6>
           </div> 
           <div>
            <h3 class="hor">Horaires de l'entreprise</h3>
            <table class="tab">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Matin</th>
                        <th>Après-midi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Lundi</td>
                        <td>8h00 - 12h00</td>
                        <td>13h00 - 17h00</td>
                    </tr>
                    <tr>
                        <td>Mardi</td>
                        <td>8h00 - 12h00</td>
                        <td>13h00 - 17h00</td>
                    </tr>
                    <tr>
                        <td>Mercredi</td>
                        <td>8h00 - 12h00</td>
                        <td>13h00 - 17h00</td>
                    </tr>
                    <tr>
                        <td>Jeudi</td>
                        <td>8h00 - 12h00</td>
                        <td>13h00 - 17h00</td>
                    </tr>
                    <tr>
                        <td>Vendredi</td>
                        <td>8h00 - 12h00</td>
                        <td>13h00 - 16h00</td>
                    </tr>
                </tbody>
            </table>
           </div>
        </div>
</body>