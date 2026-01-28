<?php 
//set session
if(session_id() == ''){
    $lifetime = 60 *60 * 24 * 7; // 1 week
    session_set_cookie_params($lifetime, '/');
    session_start();
}
//import models
require_once '../model/User.php';
require_once '../model/UserDb.php';

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
//-----------NAVIGATION CONTROLS-----------//
if($controllerAction == 'user_register_nav'){
    include('register.php');
}else if($controllerAction == 'user_login_nav'){
    include('login.php');
}
//-----------USER LOGIN-----------//
else if($controllerAction == 'user_login'){
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
            header('Location: ../index.php');
            exit();
        }
    } catch (Exception $e) {
        $error = "Login failed: " . $e->getMessage();
        include('../include/error.php');
        exit();
    }
}else if($controllerAction == 'user_register'){
    $firstName = trim(sanitizeString(filter_input(INPUT_POST, 'first_name')));
    $lastName = trim(sanitizeString(filter_input(INPUT_POST, 'last_name')));
    $email = trim(sanitizeString(filter_input(INPUT_POST, 'email')));
    $username = substr($firstName,0,1) . $lastName;
    $password = trim(sanitizeString(filter_input(INPUT_POST, 'password')));
    $role = filter_input(INPUT_POST, 'role', FILTER_VALIDATE_INT);
    $licenseeKey = trim(sanitizeString(filter_input(INPUT_POST, 'licensee_key')));

    //hash password
    $password = password_hash($password, PASSWORD_BCRYPT);
    try{
        //check if user exists
        $userExists = UserDb::checkForExistingUser($username);
        if($userExists == true){
            $errorMessage = "User already exists. Please try logging in.";
            include('register.php');
            exit();
        }
        //validate licensee key
        $isValidLicenseeKey = UserDb::validateLicenseeKey($licenseeKey);
        if($isValidLicenseeKey === false){
            $errorMessage = "Invalid Licensee Key. Please try again.";
            include('register.php');
            exit();
        }
        //set licensee id for insert
        $licenseeId = $isValidLicenseeKey;
        //register user
        $isRegistered = UserDb::registerUser($firstName, $lastName, $email, $username, $password, $role, $licenseeId);
        if($isRegistered){
            $message = "Registration successful! Please log in.";
            include('../index.php');
        }else{
            $errorMessage = "Registration failed. Please try again.";
            include('register.php');
        }
    } catch (Exception $e) {
        $error = "Registration failed: " . $e->getMessage();
        include('../include/error.php');
        exit();
    }
} else {
    //default action: show login page
    header('Location: ../index.php');
    exit();
}
//end of file