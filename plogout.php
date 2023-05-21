<?php
    session_start();
    session_destroy();
    header('Location: plog.php');
    return;
?>