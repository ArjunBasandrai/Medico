<?php
    session_start();
    require_once "pdo.php";
    if (!isset($_SESSION['status']) || !isset($_SESSION['uname'])) {
        header('Location: login.php');
        return;
    } else {
        $sql = "SELECT fname, lname, email, dob FROM users WHERE username=:name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":name" => $_SESSION['uname']
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['dob'])) {
        if ($_POST['fname'] != $row['fname'] || $_POST['lname'] != $row['lname'] || $_POST['email'] != $row['email'] || $_POST['dob'] != $row['dob']) {
            $sql = "UPDATE users SET fname=:fname, lname=:lname, email=:email, dob=:dob WHERE username=:uname";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ":fname" => $_POST['fname'],
                ":lname" => $_POST['lname'],
                ":email" => $_POST['email'],
                ":dob" => date('Y-m-d',strtotime($_POST['dob'])),
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
    <link rel="icon" type="image/x-icon" href="static/imgs/favicon.ico">
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
                        <label for="dob"><h3>Date of Birth</h3></label>
                        <input type="date" name="dob" value="<?= date("Y-m-d", strtotime($row["dob"])); ?>" required>
                    </div>
                </div>
                <div class="info-row flexbox flexrow">
                    <input type="submit" value="Make Changes">
                </div>
            </form>
        </div>
        <hr>
        <div class="records">
            <div>
                <h2>Cart</h2>
                <?php 
                    $sql = "SELECT user_id FROM users WHERE username =:uname";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ":uname" => $_SESSION['uname']
                    ));
                    $user_id = ($stmt->fetch(PDO::FETCH_ASSOC))['user_id'];

                    $sql = "SELECT cart.status as stat, cart.stock_id as stock_id, medicines.name as med, cart.stock AS cstock,stock.stock AS stock, stock.rate AS rate FROM cart JOIN stock JOIN medicines ON medicines.med_id = stock.med_id AND cart.stock_id = stock.stock_id WHERE cart.user_id = :uid";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ":uid" => $user_id
                    ));

                    $row = $stmt->fetchAll();
                    if (isset($row[0]['cstock'])){
                    foreach($row as $r) {
                        if ($r['cstock'] > 0 && $r['stat'] == 0) {
                ?>
                    <div class="med-cards flexbox">
                        <div class="med-card">
                            <div class="med-ord flexbox">
                                <div class="med-det flexbox">
                                    <h3><?= $r['med'] ?></h3>
                                    <h2>₹<?= $r['rate'] ?></h2>
                                    <p><?= $r['stock']?> pieces available</p>
                                </div>
                                <form class="flexbox" method="post" action="order.php">
                                <input type="hidden" name="med" value="<?= $r['med'] ?>">
                                <input type="hidden" name="stock_id" value="<?= $r['stock_id'] ?>">
                                <label for="quant">Qty:</label>
                                <input type="number" name="stock" id="quant" value="<?= $r['cstock'] ?>" class="quant" min="0" max ="<?= $r['stock']?>" required>
                                <input type="submit" value="Update" class="sub">
                                </form>
                            </div>
                        </div>
                    </div>
                <?php }}?>

                <div class="head flexbox order">
                <form method="post" action="ordercart.php" class="get-med-form flexbox flexrow">
                <input type="text" class="get-med" name="address" placeholder="Enter delivery address" required>
                <input type="hidden" class="get-med" name="uid" value="<?= $user_id ?>" required>
                <input type="submit" value="Confirm Order">
                </form>
            
            <?php }?> 
            </div>
            
        </div>
        </div>
        <hr>
    </section>
    <?php require_once "footer.php"; ?>
</body>
</html>