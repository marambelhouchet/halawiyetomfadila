<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حلاويات فضيلة حلاويات أصيلة</title>
    <link rel="stylesheet" href="style.css">
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
            <li><a href="s.php">Sign up</a></li>
            <li><a href="f.php">Login</a></li>
        <?php endif; ?>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</header>

    <audio autoplay volume="1">
        <source src="ii.mp3">
    </audio>
    <a class="small-button" href="achat.php">&#128722;</a>  

    <div>
        <img src="k1.png" class="a">
    </div>
    <div>
        <img src="k2.png"  class="a1">
    </div>
    <div>
        <img src="k3.png"  class="a2">
    </div>
    <div>
        <img src="k7.png"  class="a3">
    </div>
    <div>
        <img src="zrir.png"  class="a4">
    </div>
    <div>
        <img src="h2.png"  class="a5">
    </div>
    <div>
        <img src="mlabes.png"  class="a6">
    </div>
    <div>
        <img src="asida.png"  class="a7">
    </div>
    <div>
        <img src="b.png"  class="a8">
    </div>
    <div>
        <button class="btn1"  ><a class="u" href="index.php">1</a></button>
    </div>
    <div>
        <button class="btn2" ><a class="u" href="p2.php">2</a></button>
    </div>
    <div>
        <button class="btn3" ><a class="u" href="p3.php">3</a></button>
    </div>
    <div>
        <img src="ff.png"  class="f">
    </div>
    <div>
        <img src="f.png"  class="f1">
    </div>
    <div class="d">Halawiyet Fadhila</div>
    <a class="tt">Découvrez notre magnifique chef culinaire qui excelle dans l'art de la gastronomie.<br>
         Avec son expertise et sa passion pour la cuisine,<br> elle crée des plats exquis qui émerveilleront vos papilles.<br>
          Rencontrez notre chef talentueuse et <br>laissez-vous séduire par ses créations culinaires uniques et raffinées</a>
    <div>
        <img src="fouchi.png" class="f2">
    </div>
    <a class="fouchi">Rencontrez notre beau livreur.</a>
    <div>
        <img src="local.jpg"  class="f3">
    </div>
    <a href="https://maps.app.goo.gl/ivbHJ3pSMQ9fqf6D6" class="e2" target="_blank">Découvrez notre<br> emplacement à<br> Ennasr, Tunisie.</a>
</body>
</html>
