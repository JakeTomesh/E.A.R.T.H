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
if($controllerAction == 'emission_input_nav'){
    //gather data for emission input page
    //emission types from db
    try{
        $emissionTypes = EmissionDb::getEmissionTypes();
        $unitTypes = EmissionDb::getUnitTypes();
        //remove co2e unit types from input list
        array_splice($unitTypes, 9);
        
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        include('../include/error.php');
        exit();
    }
    //load emission input page
    include('emission_input.php');
}else if($controllerAction == 'emission_logs_nav'){
    //get all emission logs from db
    try{
        $userLicenseeId = $_SESSION['user']->getLicenseeId();
        $emissionLogs = EmissionDb::getAllEmissionLogsByLicensee($userLicenseeId);
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        include('../include/error.php');
        exit();
    }
    include('emission_logs.php');
}else if($controllerAction == 'log_details_nav'){
    $logId = filter_input(INPUT_POST, 'log_id', FILTER_VALIDATE_INT);
    if($logId === false || $logId === null){
        $_SESSION['error_message'] = 'Invalid log ID.';
        header('Location: index.php?controllerRequest=emission_logs_nav');
        exit();
    }
    try{
        $logDetails = EmissionDb::getEmissionLogById($logId);
        if(!$logDetails){
            $_SESSION['error_message'] = 'Log entry not found.';
            header('Location: index.php?controllerRequest=emission_logs_nav');
            exit();
        }
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        include('../include/error.php');
        exit();
    }
    include('emission_log_details.php');
}
else if($controllerAction == 'manage_thresholds_nav'){
    //gather threshold limit data from db
    try{
        $userLicenseeId = $_SESSION['user']->getLicenseeId();
        $thresholds = EmissionDb::getAllEmissionThresholdsByLicensee($userLicenseeId);
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        include('../include/error.php');
        exit();
    }
    include('emission_thresholds.php');
}else if($controllerAction == 'edit_threshold_nav'){
    $thresholdId = filter_input(INPUT_GET, 'threshold_id', FILTER_VALIDATE_INT);
    if($thresholdId === false || $thresholdId === null){
        $_SESSION['error_message'] = 'Invalid threshold ID.';
        header('Location: index.php?controllerRequest=manage_thresholds_nav');
        exit();
    }
    //get throshold details from db
    try{
        $thresholdToEdit = EmissionDb::getThresholdLimitById($thresholdId);
        if(!$thresholdToEdit){
            $_SESSION['error_message'] = 'Threshold not found.';
            header('Location: index.php?controllerRequest=manage_thresholds_nav');
            exit();
        }
        $emissionTypes = EmissionDb::getEmissionTypes();
        $unitTypes = EmissionDb::getUnitTypes();
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        include('../include/error.php');
        exit();
    }
    include('edit_threshold.php');
}else if($controllerAction == 'save_edit_threshold'){
    $thresholdId = filter_input(INPUT_POST, 'threshold_id', FILTER_VALIDATE_INT);
    $co2eLimit = filter_input(INPUT_POST, 'co2e_limit', FILTER_VALIDATE_FLOAT);
    if($thresholdId === false || $thresholdId === null){
        $_SESSION['error_message'] = 'Invalid threshold ID.';
        header('Location: index.php?controllerRequest=manage_thresholds_nav');
        exit();
    }
    if($co2eLimit === false || $co2eLimit < 0){
        $_SESSION['error_message'] = 'Invalid Co2e limit. Must be a non-negative number.';
        header('Location: index.php?controllerRequest=edit_threshold_nav&threshold_id=' . $thresholdId);
        exit();
    }
    try{
        EmissionDb::updateThresholdLimit($thresholdId, $co2eLimit);
        $_SESSION['user_message'] = 'Threshold updated successfully.';
        header('Location: index.php?controllerRequest=manage_thresholds_nav');
        exit();
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        include('../include/error.php');
        exit();
    }
}
else{
    //default action - go to dashboard
    header('Location: ../dashboard_manager/index.php?controllerRequest=dashboard_nav');
    exit();
}
//end of file