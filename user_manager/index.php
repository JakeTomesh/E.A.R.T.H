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
    $_SESSION['error_message'] = ''; //clear any previous error messages
    include('register.php');
}else if($controllerAction == 'user_login_nav'){
    include('login.php');
}else if($controllerAction == 'admin_menu_nav'){
    
    //gather all users linked to admin's company license
    $adminUserCompnayLicenseId = $_SESSION['user']->getLicenseeId();
    try{
        $companyUsers = UserDb::getAllUsersFromCompanyLicense($adminUserCompnayLicenseId);
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error retrieving users: " . $e->getMessage();
        header('Location: ../include/error.php');
        exit();
    }
    include('../user_manager/admin_menu.php');
    exit();
}else if($controllerAction == 'edit_user_nav'){
    $_SESSION['error_message'] = ''; //clear any previous error messages
    $userId = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
    if($userId === false || $userId === null){
        $_SESSION['error_message'] = "Invalid user ID.";
        header('Location: ../include/error.php');
        exit();
    }
    try{
        $userToEdit = UserDb::getUserById($userId);
        if($userToEdit === null){
            $_SESSION['error_message'] = "User not found.";
            header('Location: ../include/error.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error retrieving user: " . $e->getMessage();
        header('Location: ../include/error.php');
        exit();
    }
    
    include('../user_manager/edit_user.php');
    exit();
}
else if($controllerAction == 'alert_logs_nav'){
    include('../alert_manager/alert_logs.php');
}
//-----------USER LOGIN-----------//
else if($controllerAction == 'user_login'){
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
            $_SESSION['user_welcome_message'] = $user->getFirstName() . ", help us save Earth!";

            // initialize inactivity timer (15-min timeout logic relies on this)
            $_SESSION['LAST_ACTIVITY'] = time();

            header('Location: ../dashboard_manager/dashboard.php');
            exit();
        }else{
            //handle error in session
            $_SESSION['error_message'] = "Invalid username or password. Please try again.";
            //regenerate session on failed login to mitigate session fixation
            session_regenerate_id(true); 
            //need to send to login page with error*******
            header('Location: ../index.php');
            exit();
        }
    } catch (Exception $e) {
        $error = "Login failed: " . $e->getMessage();
        include('../include/error.php');
        exit();
    }
}//-----------USER REGISTRATION-----------//
else if($controllerAction == 'user_register'){
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
}//-----------USER LOGOUT-----------//
else if($controllerAction == 'user_logout'){
    $_SESSION = array(); //clear session
    session_destroy();
    header('Location: ../index.php');
    exit();
}//-----------SAVE USER EDITS (ADMIN)-----------//
else if($controllerAction == 'save_edit_user'){
    $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $firstName = trim(sanitizeString(filter_input(INPUT_POST, 'first_name')));
    $lastName = trim(sanitizeString(filter_input(INPUT_POST, 'last_name')));
    $email = trim(sanitizeString(filter_input(INPUT_POST, 'email')));
    $role = filter_input(INPUT_POST, 'role', FILTER_VALIDATE_INT);
    $isActive = filter_input(INPUT_POST, 'is_active', FILTER_VALIDATE_INT);

    if (!$userId) {
        $_SESSION['error_message'] = "Invalid user id.";
        header('Location: index.php?controllerRequest=admin_menu_nav');
        exit();
    }
    try{
        $isUpdated = UserDb::updateUser($userId, $firstName, $lastName, $email, $role, $isActive);
        if($isUpdated){
            $_SESSION['user_message'] = "User updated successfully.";
            header('Location: index.php?controllerRequest=admin_menu_nav');
            exit();
        }else{
            $_SESSION['error_message'] = "Failed to update user. Please try again.";
            header('Location: edit_user.php?user_id=' . urlencode($userId));
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error updating user: " . $e->getMessage();
        header('Location: ../include/error.php');
        exit();
    }
}else if($controllerAction == 'admin_user_search'){
    $searchTerm = trim(sanitizeString(filter_input(INPUT_POST, 'search_term')));
    $userLicenseeId = $_SESSION['user']->getLicenseeId();
    try{
        $searchResults = UserDb::searchUsersByNameOrEmail($searchTerm, $userLicenseeId);
        $companyUsers = $searchResults; 
        if(empty($companyUsers)){
            $_SESSION['error_message'] = "No users found matching search criteria.";
            header('Location: index.php?controllerRequest=admin_menu_nav');
            exit();
        }
        //populate table in admin menu with $searchResults
            include('../user_manager/admin_menu.php');
            exit();
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error searching users: " . $e->getMessage();
        header('Location: ../include/error.php');
        exit();
    }
}
//-----------DEFAULT ACTION-----------//
 else {
    //default action: show login page
    header('Location: ../index.php');
    exit();
}
//end of file