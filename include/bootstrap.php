<?php
// load all classes and start session
require_once '../model/User.php';
require_once '../model/UserDb.php';
require_once '../model/EmissionDb.php';
require_once '../model/Emission.php';

if (session_status() === PHP_SESSION_NONE) {

    // Session cookie (until browser is closed)
    $cookieLifetime = 0;

    session_set_cookie_params([
        'lifetime' => $cookieLifetime,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}
