<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    // optional flash
    $_SESSION['error_message'] = "Please log in to continue.";
    header('Location: ../index.php'); //send to login 
    exit();
}
