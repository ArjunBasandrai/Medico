<?php 
    require_once "pdo.php";
    session_start();
    if ((isset($_COOKIE['lat']) && isset($_COOKIE['long']))) {
        $_SESSION['lat'] = $_COOKIE['lat'];
        $_SESSION['long'] = $_COOKIE['long'];
        unset($_COOKIE['lat']);
        unset($_COOKIE['long']);
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
        <title>Medico: Locate nearby hospitals</title>
    </head>
    <body onload="getLocation()">
        <?php require_once "nav.php" ?>
        <section>
            <?php
                if (isset($_SESSION['lat']) && isset($_SESSION['long'])) {
                    $sql = "SELECT name,address,contact,site,SQRT(POWER((:lat-ST_X(coordinates))*110.574,2) + POWER((:long-ST_Y(coordinates))*111.320*COS(ST_X(coordinates)),2)) AS distance FROM hospitals WHERE SQRT(POWER((:lat-ST_X(coordinates))*110.574,2) + POWER((:long-ST_Y(coordinates))*111.320*COS(ST_X(coordinates)),2)) < 10";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ":lat" => $_SESSION['lat'],
                        ":long" => $_SESSION['long']
                    ));
                    $row = $stmt->fetchAll();
                    foreach ($row as $r) {
            ?>
            <div class="hpt-card flexbox">
                <div>
                    <h2><a href="<?= $r['site'] ?>" class="hptl"><?= $r['name'] ?></a></h2>
                    <p><?= $r['address'] ?></p>
                    <p><a href="tel:<?=$r['contact']?>">Contact</a></p>
                </div>
            </div>
            <?php
                    }
                } else {
            ?>
            <div class="head ref flexbox">
                <h1>OOPS! Medico is unable to detect your location</h1>
                <h2>Allow location access from your browser settings and Refresh the page</h2>
                <button class="ref" onclick="location.reload()">Refresh</button>
            </div>
            <?php
                }
            ?>
            
    </section>
    <script src="location.js"></script>
</body>
</html>