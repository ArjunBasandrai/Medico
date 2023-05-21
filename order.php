<?php 

    session_start();
    require_once "pdo.php";

    if (isset($_POST['med']) && isset($_POST['stock']) && isset($_POST['stock_id']) && isset($_SESSION['uname'])) {
        $sql = "SELECT user_id FROM users WHERE username =:uname";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":uname" => $_SESSION['uname']
        ));
        $user_id = ($stmt->fetch(PDO::FETCH_ASSOC))['user_id'];

        $sql = "SELECT med_id FROM medicines WHERE name =:med";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":med" => $_POST['med']
        ));
        $med_id = ($stmt->fetch(PDO::FETCH_ASSOC))['med_id'];        

        $sql = "SELECT cart_id FROM cart WHERE user_id =:uid AND stock_id = :sid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":uid" => $user_id,
            ":sid" => $_POST['stock_id'],
        ));
        $cart_id = ($stmt->fetch(PDO::FETCH_ASSOC))['cart_id'];
        if ($cart_id > 0) {
            $sql = "UPDATE cart SET  stock = :stock WHERE cart_id = :cid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ":cid" => $cart_id,
                ":stock" => $_POST['stock']
            ));
 
            header("Location: profile.php");
            return;
        } else {

        $sql = "INSERT INTO cart(user_id, stock_id,stock, status) VALUES (:uid, :sid, :stock, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":uid" => $user_id,
            ":sid" => $_POST['stock_id'],
            ":stock" => $_POST['stock']
        ));
        header("Location: profile.php");
        return;
    } }else {
        header("Location: meds.php");
        return;
    }

?>