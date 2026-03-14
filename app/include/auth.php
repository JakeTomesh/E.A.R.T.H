<?php
// auth.php — assumes session is already started (via bootstrap.php)

$timeoutSeconds = 15 * 60; // 15 minutes

// If user is logged in, enforce inactivity timeout
if (isset($_SESSION['user'])) {

    if (isset($_SESSION['LAST_ACTIVITY']) &&
        (time() - $_SESSION['LAST_ACTIVITY']) > $timeoutSeconds) {

        session_unset();
        session_destroy();

        // Start a new session for the flash message
        session_start();
        $_SESSION['error_message'] = "Your session timed out due to inactivity. Please log in again.";
        header('Location: ../index.php');
        exit();
    }

    // Update timestamp on every request
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Auth gate (must be after timeout handling)
if (!isset($_SESSION['user'])) {
    $_SESSION['error_message'] = "Please log in to continue.";
    header('Location: ../index.php');
    exit();
}
