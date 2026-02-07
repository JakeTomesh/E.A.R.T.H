<?php
//load all classes and start session
require_once '../model/User.php';
require_once '../model/UserDb.php';
require_once '../model/EmissionDb.php';
require_once '../model/Emission.php';


if (session_status() === PHP_SESSION_NONE) {
    $lifetime = 60 * 60 * 24 * 7;
    session_set_cookie_params($lifetime, '/');
    session_start();
}