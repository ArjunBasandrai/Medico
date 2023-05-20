<?php 
    require_once "pdo.php";
    session_start();
    if (isset($_SESSION['uname'])) {
        header('Location: index.php');
        return;
    }
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['cpass']) && isset($_POST['date'])) {
        if(strlen($_POST['pass']) < 8) {
            $_SESSION['sgnerr'] = "Password must be atleast 8 characters long";
            header("Location: signup.php");
            return;
        }
        if ($_POST['pass'] != $_POST['cpass']) {
            $_SESSION['sgnerr'] = "Passwords should match";
            header("Location: signup.php");
            return;
        }
        $sql = "SELECT user_id FROM users WHERE username = :uname";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":uname" => $_POST['uname']
        ));
        if ($stmt->fetchALL()) {
            $_SESSION['sgnerr'] = "Username already exists. Choose a different one";
            header("Location: signup.php");
            return;
        }
        if (!strpos($_POST['email'],"@") or !strpos($_POST['email'], ".com")) {
            $_SESSION['sgnerr'] = "Enter valid email address";
            header("Location: signup.php");
            return;
        }
        $sql = "INSERT INTO users(fname, lname,email,username,dob,password) VALUES (:fname, :lname, :email, :uname, :dob, :pass)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":fname" => $_POST['fname'],
            ":lname" => $_POST['lname'],
            ":email" => $_POST['email'],
            ":uname" => $_POST['uname'],
            ":dob" => date("Y-m-d", strtotime($_POST["date"])),
            ":pass" => md5($_POST['pass'])
        ));
        $sql = "SELECT user_id FROM users WHERE username = :uname";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":uname" => $_POST['uname']
        ));
        if ($stmt->fetchALL()) {
            $_SESSION['sgn'] = "Successfully registered to Medico. Login to your account";
            header("Location: login.php");
            return;
        }
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
            <?php
                if (isset($_SESSION['sgnerr'])) { ?>
            <p class="errpass" style="margin-bottom: 35px;">*<?= $_SESSION['sgnerr'] ?></p>
            <?php
                    unset($_SESSION['sgnerr']);
                } ?>
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
                        <label for="date">Date of Birth</label>
                        <input type="date" placeholder="Enter your date of birth" name="date" id="date" required>
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