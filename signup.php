<?php 
    require_once "pdo.php";
    session_start();
    if (isset($_SESSION['uname'])) {
        header('Location: index.php');
        return;
    }
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['uname']) && isset($_POST['email']) %% isset($_POST['pass']) && isset($_POST['cpass'])) {
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up to Medico</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="icon" type="image/x-icon" href="static/imgs/favicon.ico">
    <style>
    body {
        background: rgba(142, 116, 255,.1);
        justify-content: center;
        align-items: center;
        display: flex;
        min-height: 100vh;
    } 
    </style>
</head>
<body>
    <div class="main">
        <div class="signin">
            <h1 class="sn-h">Signup to Medico</h1>
            <form method="post" action="signup.php" class="signup-form">
                <div class="sn-row flexbox flexrow">
                    <div>
                        <label for="fname">First Name</label>
                        <input type="text" placeholder="Enter your first name" name="fname" id="fname" required>
                    </div>
                    <div>
                        <label for="lname">Last Name</label>
                        <input type="text" placeholder="Enter your last name" name="lname" id="lname" required>
                    </div>
                </div>
                    
                <div class="sn-row flexbox flexrow">
                    <div>
                        <label for="uname">Username</label>
                        <input type="text" placeholder="Enter a username" name="uname" id="uname" required>
                    </div>
                    <div>
                        <label for="email">Email Address</label>
                        <input type="email" placeholder="Enter your email" name="email" id="email" required>
                    </div>
                </div>

                <div class="sn-row flexbox flexrow">
                    <div>
                        <label for="pass">Password</label>
                        <input type="password" placeholder="Enter your password" name="pass" id="pass" required>
                    </div>
                    <div>
                        <label for="cpass">Confirm Password</label>
                        <input type="password" placeholder="Re-enter your password" name="cpass" id="cpass" required>
                    </div>
                </div>

                <input type="submit" value="Register">
            </form>
        </div>
    </div>
</body>
</html>