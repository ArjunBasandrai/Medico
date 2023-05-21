<?php
    require_once "pdo.php";
    if (isset($_POST['address']) && isset($_POST['uid'])) {
        $sql = "SELECT * FROM cart WHERE user_id = :uid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ":uid" => $_POST['uid']
        ));
        $row = $stmt->fetchAll();
        foreach($row as $r) {
            $sql = "INSERT INTO orders(user_id, stock_id,stock,status, address) VALUES (:uid, :sid, :stock, 0, :add)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ":uid" => $_POST['uid'],
                ":sid" => $r['stock_id'],
                "stock" => $r['stock'],
                ":add" => $_POST['address']
            ));

            $sql = "DELETE FROM cart WHERE cart_id = :cid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ":cid" => $r['cart_id']
            ));

            $sql = "UPDATE stock SET stock = stock - :stock WHERE stock_id = :stock_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                ":stock" => $r['stock'],
                ":stock_id" => $r['stock_id']
            ));   

            header("Location: profile.php");
            return;
        }
    }
?>