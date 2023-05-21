<?php
    session_start();
    require_once "pdo.php";
    if (!isset($_SESSION['status']) || !isset($_SESSION['p_id'])) {
        header('Location: plog.php');
        return;
    }
    
    $sql = "SELECT pharm.name AS name, medicines.name AS med, salt.name AS salt, stock, rate FROM stock JOIN medicines JOIN salt JOIN padmin JOIN pharm ON pharm.pharm_id = padmin.pharm_id AND padmin.pharm_id = stock.pharm_id AND salt.salt_id = medicines.salt_id AND stock.med_id = medicines.med_id WHERE padmin.p_id = :pid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ":pid" => $_SESSION['p_id']
    ));
    $row = $stmt->fetchAll();

    if (isset($_POST['med']) && isset($_POST['salt']) && isset($_POST['stock']) && isset($_POST['rate']) && isset($_SESSION['p_id'])) {
        $sql = "SELECT pharm.pharm_id AS pharm_id FROM pharm JOIN padmin ON padmin.pharm_id = pharm.pharm_id WHERE padmin.p_id = :pid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":pid" => $_SESSION['p_id']
        ));
        $pharm_id = ($stmt->fetch(PDO::FETCH_ASSOC))['pharm_id'];

        $sql = "SELECT med_id FROM medicines WHERE name = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":name" => $_POST['med']
        ));
        $med_id = ($stmt->fetch(PDO::FETCH_ASSOC))['med_id'];

        $sql = "UPDATE stock SET stock = :stock, rate = :rate WHERE med_id = :med_id AND pharm_id = :pharm_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":pharm_id" => $pharm_id,
            ":med_id" => $med_id,
            ":stock" => $_POST['stock'],
            ":rate" => $_POST['rate']
        ));
        header("Location: pharm.php");
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
    <title>Medico: Pharmacy ID</title>
</head>
<body>
    <section class="profile-container p-med-info">
        <div class="member-top flexbox flexrow">
            <div class="member">
                <h1><?= $row[0]['name']; ?></h1>
                <p>Medico Partner</p>
            </div>
            <div class="logout flexbox">
                <a href="plogout.php">Logout</a>
            </div>
        </div>
        <hr>
        <div class="p-info">
            <h2>Medicines Stock</h2>
            <p>Edit medicines stock and rate</p>
            <br>
            <?php foreach($row as $r) { ?>
            <form class="p-info-form" method="post" action="pharm.php">
                <div class="info-row p-info-row flexbox flexrow">
                    <div>
                        <label for="name"><h3>Medicine</h3></label>
                        <input type="text" name="med" value="<?= $r['med']?>" required>
                    </div>
                    <div>
                        <label for="name"><h3>Salt</h3></label>
                        <input type="text" name="salt" value="<?= $r['salt']?>" required>
                    </div>
                    <div>
                        <label for="name"><h3>Stock</h3></label>
                        <input type="number" name="stock" value="<?= $r['stock']?>" required>
                    </div>
                    <div>
                        <label for="name"><h3>Rate (in ₹)</h3></label>
                        <input type="number" step="0.1" name="rate" value="<?= $r['rate']?>" required>
                    </div>
                </div>
                <br>
                <div class="info-row flexbox flexrow">
                    <input type="submit" value="Update Stock">
                </div>
            </form>
            <hr class="ph-hr">
            <?php } ?>
        </div>
    </section>
</body>
</html>