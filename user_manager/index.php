<?php 
//import models
require_once '../models/User.php';

//set session
if(session_id() == ''){
    $lifetime = 60 *60 * 24 * 7; // 1 week
    session_set_cookie_params($lifetime, '/');
    session_start();
}

//string sanitization function
function sanitizeString(?string $input): string {
    if ($input === null) return '';
    $clean = trim($input);
    return htmlspecialchars($clean, ENT_QUOTES, 'UTF-8');
}

//declare controller action
$controllerAction = filter_input(INPUT_POST, 'controllerRequest');

//controller actions 
if($controllerAction == NULL){
    $controllerAction = filter_input(INPUT_GET, 'controllerRequest');
    if($controllerAction == NULL){
        $controllerAction = '';
    }
}


//-----------USER LOGIN-----------//
if($controllerAction == 'user_login'){
    $_SESSION = array(); //clear session
    session_destroy();
    session_start();

    $username = sanitizeString(filter_input(INPUT_POST, 'username'));
    $password = sanitizeString(filter_input(INPUT_POST, 'password'));
    try{
        $isValidUser = UserDb::validateUserLogin($username, $password);
        if($isValidUser){
            $user = UserDb::getUserByUsername($username);
            $_SESSION['user'] = $user;
            $message = $user->getFirstName() . ", help us save Earth!";
            //load data here for next page


            //forward to dashboard
            include('../dashboard_manager/dashboard.php');
        }else{
            $errorMessage = "Invalid username or password. Please try again.";
            //need to send to login page with error*******
            include("index.php");
        }
    } catch (Exception $e) {
        $error = "Login failed: " . $e->getMessage();
        include('../include/error.php');
        exit();
    }
}

?>