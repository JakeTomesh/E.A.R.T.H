<?php 
require_once('../include/bootstrap.php');

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
}else if($controllerAction == 'admin_menu_nav'){
    include('../user_manager/admin_menu.php');
}else if($controllerAction == 'alert_logs_nav'){
    include('../alert_manager/alert_logs.php');
}
//-----------USER LOGIN-----------//
else if($controllerAction == 'user_login'){
    //start session if not already started
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    $username = sanitizeString(filter_input(INPUT_POST, 'username'));
    $password = sanitizeString(filter_input(INPUT_POST, 'password'));
    try{
        $isValidUser = UserDb::validateUserLogin($username, $password);

        if($isValidUser){
            //prevent session fixation
            session_regenerate_id(true); 
            //get user object
            $user = UserDb::getUserByUsername($username);
            //set session variables
            $_SESSION['user'] = $user;
            $_SESSION['user_message'] = $user->getFirstName() . ", help us save Earth!";
            header('Location: ../dashboard_manager/dashboard.php');
            exit();
        }else{
            //handle error in session
            $_SESSION['error_message'] = "Invalid username or password. Please try again.";
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
            $_SESSION['error_message'] = "User already exists. Please try logging in.";
            header('Location: register.php');
            exit();
        }
        //validate licensee key
        $isValidLicenseeKey = UserDb::validateLicenseeKey($licenseeKey);
        if($isValidLicenseeKey === false){
            $_SESSION['error_message'] = "Invalid Licensee Key. Please try again.";
            header('Location: register.php');
            exit();
        }
        //set licensee id for insert
        $licenseeId = $isValidLicenseeKey;
        //register user
        $isRegistered = UserDb::registerUser($firstName, $lastName, $email, $username, $password, $role, $licenseeId);
        if($isRegistered){
            $_SESSION['user_message'] = "Registration successful! Please log in.";
            header('Location: ../index.php');
            exit();
        }else{
            $_SESSION['error_message'] = "Registration failed. Please try again.";
            header('Location: register.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Registration failed: " . $e->getMessage();
        header('Location: ../include/error.php');
        exit();
    }
}else if($controllerAction == 'user_logout'){
    $_SESSION = array(); //clear session
    session_destroy();
    header('Location: ../index.php');
    exit();
}
 else {
    //default action: show login page
    header('Location: ../index.php');
    exit();
}
//end of file