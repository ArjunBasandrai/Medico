<?php
    session_start();
    require_once "pdo.php";
    if (!isset($_SESSION['status']) || !isset($_SESSION['uname'])) {
        header('Location: login.php');
        return;
    } else {
        $sql = "SELECT fname, lname, email, year FROM users WHERE username=:name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":name" => $_SESSION['uname']
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['year'])) {
        if ($_POST['fname'] != $row['fname'] || $_POST['lname'] != $row['lname'] || $_POST['email'] != $row['email'] || $_POST['year'] != $row['year']) {
            $sql = "UPDATE users SET fname=:fname, lname=:lname, email=:email, year=:year WHERE username=:uname";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ":fname" => $_POST['fname'],
                ":lname" => $_POST['lname'],
                ":email" => $_POST['email'],
                ":year" => $_POST['year'],
                ":uname" => $_SESSION['uname']
            ));
        } 
        header("Location: profile.php");
        return;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/css/nav.css">
    <title>Medico: Your profile</title>
</head>
<body>
    <?php require_once "nav.php"; ?>
    <section class="profile-container">
        <div class="member-top flexbox flexrow">
            <div class="member">
                <h1><?= $row['fname'] , " ", $row['lname']; ?></h1>
                <p>Medico Member</p>
            </div>
            <div class="logout flexbox">
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <hr>
        <div class="p-info">
            <h2>Personal Information</h2>
            <p>Edit personal information and contact details</p>
            <br>
            <form class="p-info-form" method="post" action="profile.php">
                <div class="info-row flexbox flexrow">
                    <div>
                        <label for="name"><h3>First Name</h3></label>
                        <input type="text" name="fname" value="<?= $row['fname']; ?>" required>
                    </div>
                    <div>
                        <label for="name"><h3>Last Name</h3></label>
                        <input type="text" name="lname" value="<?= $row['lname']; ?>" required>
                    </div>
                </div>
                <br>
                <div class="info-row flexbox flexrow">
                    <div>
                        <label for="name"><h3>Email Address</h3></label>
                        <input type="email" name="email" value="<?= $row['email']; ?>" required>
                    </div>
                    <div>
                        <label for="name"><h3>Year of Birth</h3></label>
                        <input type="number" name="year" value="<?= $row['year']; ?>" required>
                    </div>
                </div>
                <div class="info-row flexbox flexrow">
                    <input type="submit" value="Make Changes">
                </div>
            </form>
        </div>
        <hr>
        <div class="records">
            <a href="records.php">
                <div>
                    <h2>Medical History</h2>
                    <p>See your medical records and history</p>
                </div>
            </a>
        </div>
        <hr>
    </section>
</body>
</html>