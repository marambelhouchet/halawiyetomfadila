<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
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
        input[type="submit"],
        input[type="reset"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"],
        input[type="reset"] {
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover,
        input[type="reset"]:hover {
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
            color: rgb(29, 22, 22);
            transition: .4s;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="logo">Halawiyet Fadhila <br>حلويات فضيلة حلويات أصيلة</a>
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="s.php">Sign up</a></li>
            <li><a href="f.php">Login</a></li>
            <li><a href="contact.php">contact</a></li>
        </ul>
    </header>
    <form id="signinForm" action="submit.php" method="POST">
        <h2>Sign In</h2>
        <div>
            <label for="email">Email</label>
        </div>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div>
            <label for="passwordConfirm">Confirm Password</label>
            <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirm your password" required>
        </div>
        <div>
            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Enter your address" required>
        </div>
        <div>
            <label for="tel">Phone Number</label>
            <input type="text" id="tele" name="tel" placeholder="Enter your phone number" required>
        </div>
        <input type="submit" value="Sign In">
        <input type="reset" value="Reset Sign In" class="resett">
    </form>
    <script>
        document.getElementById('signinForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const telephoneInput = document.getElementById('tele');
            const tel = telephoneInput.value.trim(); // Get the telephone input value
            if (tel.length !== 8 || isNaN(tel)) {
                alert('Please enter a valid phone number with 8 digits.');
                return; 
            }
            
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('passwordConfirm');
            const password = passwordInput.value.trim();
            const passwordConfirm = passwordConfirmInput.value.trim();
            if (password !== passwordConfirm) {
                alert('Passwords do not match.');
                return;
            }
    
            
            var formData = new FormData(this);
    
            
            var xhr = new XMLHttpRequest();
            
            xhr.open('POST', 'submit.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            

            xhr.onload = function() {
                if (xhr.status === 200) {
            
                    if (xhr.responseText === "email_exists") {
                        alert("This email is already registered.");
                    } else {
                        
                        document.getElementById('email').value = "";
                        passwordInput.value = "";
                        passwordConfirmInput.value = ""; // Clear both password fields
                        document.getElementById('address').value = "";
                        telephoneInput.value = "";
                        alert("Signin successful!");
                    }
                } else {
                  
                    alert('Error: ' + xhr.responseText);
                }
            };
            
          
            xhr.send(new URLSearchParams(formData));
        });
    </script>
</body>
</html>
