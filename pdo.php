<?php
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=medico','root','zappeysfc');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>