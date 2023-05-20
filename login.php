<?php 
    require_once "pdo.php";
    session_start();
    if (isset($_SESSION['uname'])) {
        header('Location: index.php');
        return;
    }
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] != "Invalid") {
        $_SESSION['status'] = 'ud';
        }
    }
    if (isset($_POST['uname']) && isset($_POST['pass'])) {
        unset($_SESSION['uname']);

        $sql = "SELECT username FROM users";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['status'] = 'Invalid';
            if ($row['username'] == $_POST['uname']) {
                $_SESSION['status'] = 'ud';
                break;
            }
        }
        if ($_SESSION['status'] != "Invalid") {
            $sql = "SELECT password FROM users WHERE username=:name";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ':name' => $_POST['uname']
            ));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['password']==md5($_POST['pass'])) {
                print_r($row['password']);
                $_SESSION['uname'] = $_POST['uname'];
                $_SESSION['status'] = 'Logged in';
                header('Location: index.php');
                return;
            } 
            else {
                $_SESSION['status'] = 'Invalid';
                header('Location: login.php');
                return;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medico Login</title>
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
            <h1>Login to Medico</h1>
            <?php
                if (isset($_SESSION['status']) && $_SESSION['status']=="Invalid") {
                    echo "<p class='errpass' style='margin-bottom:10px;'>*Incorrect Username/Password</p>";
                    unset($_SESSION['status']);
                }
                if (isset($_SESSION['sgn'])) {
                    print("<p style='color:green;margin-bottom:10px;'>".$_SESSION['sgn']."</p>");
                    unset($_SESSION['sgn']);
                }
            ?>
            <form method="post" action="" class="login-form">
                <label for="uname">Username</label>
                <input type="text" placeholder="Enter your username" name="uname" id="uname" required>
                <label for="pass">Password</label>
                <input type="password" placeholder="Enter your password" name="pass" id="pass" required>
                <br><a href="#">Forget Password?</a><br><br>
                <input type="submit" value="Login">
                <p>Dont have an account? <a href="signup.php">Sign up</a></p>
            </form>
        </div>
    </div>
</body>
</html>