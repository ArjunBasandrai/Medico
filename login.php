<?php 
    require_once "pdo.php";
    session_start();
    $_SESSION['status'] = 'ud';
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
                $_SESSION['status'] = 'Inavlid';
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
    <title>Login form</title>
    <link rel="stylesheet" href="static/css/style.css">
    <style>
    body {
        background: rgba(142, 116, 255,.4);
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
                if ($_SESSION['status']=="Invalid") {
                    echo "<p class='errpass'>Incorrect Username/Password</p>";
                    unset($_SESSION['status']);
                }
            ?>
            <form method="post" action="" class="login-form">
                <label for="uname">Username</label>
                <input type="text" placeholder="Enter your username" name="uname" id="uname" required>
                <label for="pass">Password</label>
                <input type="password" placeholder="Enter your password" name="pass" id="pass" required>
                <br><a href="#">Forget Password?</a><br><br>
                <input type="submit" value="Login">
                <p>Dont have an account? <a target="_blank" href="signup.php">Sign up</a></p>
            </form>
        </div>
    </div>
</body>
</html>

