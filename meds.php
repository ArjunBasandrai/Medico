<?php
    session_start();
    require_once "pdo.php";
    if (!isset($_SESSION['status']) || !isset($_SESSION['uname'])) {
        header('Location: login.php');
        return;
    } else {
        if ((isset($_COOKIE['lat']) && isset($_COOKIE['long']))) {
            $_SESSION['lat'] = $_COOKIE['lat'];
            $_SESSION['long'] = $_COOKIE['long'];
            unset($_COOKIE['lat']);
            unset($_COOKIE['long']);
        }
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
    <title>Medico: Medicines</title>
</head>
<body onload="getLocation()">
    <?php require_once "nav.php"; ?>
    <section>
        <?php if (isset($_SESSION['lat']) && isset($_SESSION['long'])) { ?>
            <div class="head flexbox">
                <h1>Get Your Prescriptions Sorted</h1>
                <form method="get" action="meds.php" class="get-med-form flexbox flexrow">
                    <input type="text" class="get-med" name="med" placeholder="Enter medication name" required>
                    <input type="submit" value="Search Nearby">
                </form>
            </div>
            <?php
                if (isset($_GET['med'])) {
                    $sql = "SELECT stock.stock_id AS stock_id, pharm.address AS address, stock.rate AS rate,stock.stock AS stock,pharm.contact AS contact, SQRT(POWER((:lat-ST_X(pharm.coordinates))*110.574,2) + POWER((:long-ST_Y(pharm.coordinates))*111.320*COS(ST_X(pharm.coordinates)),2)) AS distance, pharm.name AS pharm, medicines.name AS med, salt.name AS salt, stock.stock AS count FROM stock JOIN salt JOIN medicines JOIN pharm ON salt.salt_id = medicines.salt_id AND pharm.pharm_id = stock.pharm_id AND medicines.med_id = stock.med_id WHERE medicines.name=:med OR salt.name=:med ORDER BY SQRT(POWER((:lat-ST_X(pharm.coordinates))*110.574,2) + POWER((:long-ST_Y(pharm.coordinates))*111.320*COS(ST_X(pharm.coordinates)),2))";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        ":lat" => $_SESSION['lat'],
                        ":long" => $_SESSION['long'],
                        ":med" => $_GET['med']
                    ));
                    $row = $stmt->fetchAll();
                    foreach ($row as $r) {
            ?>
            <div class="med-cards flexbox">
                <div class="med-card">
                    <h2><?= $r['pharm'] ?></h2>
                    <p style="max-width:40ch;margin:20px 0 10px;"><?= $r['address'] ?></p>
                    <p><b><?= round($r['distance'],2) ?> kms</b></p>
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
                        <input type="number" name="stock" id="quant" value="1" class="quant" min="0" max ="<?= $r['stock']?>" required>
                        <input type="submit" value="Order" class="sub">
                        </form>
                    </div>
                </div>
            </div>
                <?php }} ?>

        <?php } else {?>
            <div class="head ref flexbox">
                <h1>OOPS! Medico is unable to detect your location</h1>
                <h2>Allow location access from your browser settings and Refresh the page</h2>
                <button class="ref" onclick="location.reload()">Refresh</button>
            </div>
        <?php } ?>
    </section>
    <script src="location.js"></script>
</body>
</html>