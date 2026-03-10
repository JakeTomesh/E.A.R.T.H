<?php 
require_once('../include/bootstrap.php');
require_once('../model/HelperEmission.php');

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
//*
//*
//----------EMISSION INPUT NAV-----------//
if($controllerAction == 'emission_input_nav'){
    //gather data for emission input page
    //emission types from db
    try{
        $emissionTypes = EmissionDb::getEmissionTypes();
        $unitTypes = EmissionDb::getUnitTypes();
        //unitTypes filters out BASE unit of CO2e. 
        
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    //load emission input page
    include('emission_input.php');
}//----------EMISSION LOGS NAV-----------//
else if($controllerAction == 'emission_logs_nav'){
    //get all emission logs from db
    try{
        $userLicenseeId = $_SESSION['user']->getLicenseeId();
        $emissionLogs = EmissionDb::getAllEmissionLogsByLicensee($userLicenseeId);
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('emission_logs.php');
}//----------EMISSION LOG DETAILS NAV-----------//
else if($controllerAction == 'emission_log_details_nav'){
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
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('emission_log_details.php');
}//----------THRESHOLD MANAGEMENT NAV-----------//
else if($controllerAction == 'manage_thresholds_nav'){
    if (!isset($_SESSION['user'])) {
        // optional flash
        $_SESSION['error_message'] = "Please log in to continue.";
        header('Location: ../index.php'); //send to login 
        exit();
    }
    //gather threshold limit data from db
    try{
        $userLicenseeId = $_SESSION['user']->getLicenseeId();
        $thresholds = EmissionDb::getAllEmissionThresholdsByLicensee($userLicenseeId);
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('emission_thresholds.php');
}//----------EDIT THRESHOLD NAV-----------//
else if($controllerAction == 'edit_threshold_nav'){
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
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('edit_threshold.php');
}//----------ALERT LOGS NAV-----------//
else if($controllerAction == 'alert_logs_nav'){
    //get all alert logs from db
    try{
        $userLicenseeId = $_SESSION['user']->getLicenseeId();
        $alertLogs = EmissionDb::getAllAlertLogsByLicensee($userLicenseeId);
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('alert_logs.php');
}//----------ALERT LOG DETAILS NAV-----------//
else if($controllerAction == 'alert_log_details_nav'){
    $alertLogId = filter_input(INPUT_POST, 'alert_log_id', FILTER_VALIDATE_INT);
    $emissionLogId = filter_input(INPUT_POST, 'emission_log_id', FILTER_VALIDATE_INT);
    if($alertLogId === false || $alertLogId === null || $emissionLogId === false || $emissionLogId === null){
        $_SESSION['error_message'] = 'Invalid log ID.';
        header('Location: index.php?controllerRequest=alert_logs_nav');
        exit();
    }
    try{
        $alertLogDetails = EmissionDb::getAlertLogById($alertLogId);
        $emissionLogDetails = EmissionDb::getEmissionLogById($emissionLogId);
        if(!$alertLogDetails || !$emissionLogDetails){
            $_SESSION['error_message'] = 'Log entry not found.';
            header('Location: index.php?controllerRequest=alert_logs_nav');
            exit();
        }
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('alert_log_details.php');
}//----------EMISSION FACTORS MANAGEMENT NAV-----------//
else if($controllerAction == 'manage_emission_factors_nav'){
    //get emission factors from db
    try{
        $userLicenseeId = $_SESSION['user']->getLicenseeId();
        $emissionFactors = EmissionDb::getAllEmissionFactorsByLicensee($userLicenseeId);
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('emission_factors.php');
}//----------EDIT EMISSION FACTOR NAV-----------//
else if($controllerAction == 'edit_emission_factor_nav'){
    $emissionFactorId = filter_input(INPUT_GET, 'emission_factor_id', FILTER_VALIDATE_INT);
    if($emissionFactorId === false || $emissionFactorId === null){
        $_SESSION['error_message'] = 'Invalid emission factor ID.';
        header('Location: index.php?controllerRequest=manage_emission_factors_nav');
        exit();
    }
    //get emission factor details from db
    try{
        $emissionFactorToEdit = EmissionDb::getEmissionFactorById($emissionFactorId);
        if(!$emissionFactorToEdit){
            $_SESSION['error_message'] = 'Emission factor not found.';
            header('Location: index.php?controllerRequest=manage_emission_factors_nav');
            exit();
        }
        $emissionTypes = EmissionDb::getEmissionTypes();
        $unitTypes = EmissionDb::getUnitTypes();
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('edit_emission_factor.php');
}//----------ADD EMISSION FACTOR NAV-----------//
else if($controllerAction == 'add_emission_factor_nav'){
    //get emission types and unit types for add form
    try{
        $emissionTypes = EmissionDb::getEmissionTypes();
        $unitTypes = EmissionDb::getUnitTypes();
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
    include('add_emission_factor.php');
}
//-----------FUNCTIONAL CONTROLS-----------//
//*
//*
//----------SAVE ADD EMISSION FACTOR-----------//
else if($controllerAction == 'save_add_emission_factor'){
    $emissionTypeId = filter_input(INPUT_POST, 'emission_type', FILTER_VALIDATE_INT);
    $unitTypeId = filter_input(INPUT_POST, 'emission_unit_type', FILTER_VALIDATE_INT);
    $factor = filter_input(INPUT_POST, 'emission_factor', FILTER_VALIDATE_FLOAT);
    $licenseeId = $_SESSION['user']->getLicenseeId();
    if($emissionTypeId === false || $emissionTypeId === null){
        $_SESSION['error_message'] = 'Invalid emission type selection.';
        header('Location: index.php?controllerRequest=add_emission_factor_nav');
        exit();
    }
    if($unitTypeId === false || $unitTypeId === null){
        $_SESSION['error_message'] = 'Invalid unit type selection.';
        header('Location: index.php?controllerRequest=add_emission_factor_nav');
        exit();
    }
    if($factor === false || $factor < 0){
        $_SESSION['error_message'] = 'Invalid emission factor. Must be a non-negative number.';
        header('Location: index.php?controllerRequest=add_emission_factor_nav');
        exit();
    }
    try{
        $licenseeId = $_SESSION['user']->getLicenseeId();
        EmissionDb::addEmissionFactor($licenseeId, $emissionTypeId, $unitTypeId, $factor);
        $_SESSION['user_message'] = 'Emission factor added successfully.';
        header('Location: index.php?controllerRequest=manage_emission_factors_nav');
        exit();
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
}
//----------SAVE EDIT EMISSION FACTOR-----------//
else if($controllerAction == 'save_edit_emission_factor'){
    $emissionFactorId = filter_input(INPUT_POST, 'emission_factor_id', FILTER_VALIDATE_INT);
    $factor = filter_input(INPUT_POST, 'emission_factor', FILTER_VALIDATE_FLOAT);
    if($emissionFactorId === false || $emissionFactorId === null){
        $_SESSION['error_message'] = 'Invalid emission factor ID.';
        header('Location: index.php?controllerRequest=manage_emission_factors_nav');
        exit();
    }
    if($factor === false || $factor < 0){
        $_SESSION['error_message'] = 'Invalid emission factor. Must be a non-negative number.';
        header('Location: index.php?controllerRequest=edit_emission_factor_nav&emission_factor_id=' . $emissionFactorId);
        exit();
    }
    try{
        EmissionDb::updateEmissionFactor($emissionFactorId, $factor);
        $_SESSION['user_message'] = 'Emission factor updated successfully.';
        header('Location: index.php?controllerRequest=manage_emission_factors_nav');
        exit();
    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
}
//----------SAVE EDIT THRESHOLD-----------//
else if($controllerAction == 'save_edit_threshold'){
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
        $_SESSION['error_trace'] = $e->getTraceAsString();
        include('../include/error.php');
        exit();
    }
}//----------SUBMIT EMISSION INPUT-----------//
else if($controllerAction == 'submit_emission_input'){
    //filter input
    $emissionTypeId = filter_input(INPUT_POST, 'emission_type', FILTER_VALIDATE_INT);
    $unitTypeId = filter_input(INPUT_POST, 'unit_type', FILTER_VALIDATE_INT);
    $unitQuantity = filter_input(INPUT_POST, 'unit_quantity', FILTER_VALIDATE_FLOAT);
    $emissionStartDate = filter_input(INPUT_POST, 'emission_start_date');
    $emissionEndDate = filter_input(INPUT_POST, 'emission_end_date');
    $notes = sanitizeString(filter_input(INPUT_POST, 'notes'));
    $licenseeId = $_SESSION['user']->getLicenseeId();
    $userId = $_SESSION['user']->getId();

    //save old input for holding state on invalidation
    $_SESSION['old_input'] = [
        'emission_type' => $emissionTypeId,
        'unit_type' => $unitTypeId,
        'unit_quantity' => $unitQuantity,
        'emission_start_date' => $emissionStartDate,
        'emission_end_date' => $emissionEndDate,
        'notes' => $notes
    ];

    //validate input
    if(!HelperEmission::validateInput($emissionTypeId, 'emission_type')){
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if(!HelperEmission::validateInput($unitTypeId, 'unit_type')){
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if(!HelperEmission::validateInput($unitQuantity, 'unit_quantity')){
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if(!HelperEmission::validateInputDates($emissionStartDate, $emissionEndDate)){
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    //input data is valid, remove old input from session
    unset($_SESSION['old_input']);
    
    //off put all calculation process to helper class. 
    $isValidConversion = HelperEmission::calculateCo2eConversion($licenseeId, $emissionTypeId, $unitTypeId, $unitQuantity);

    if(!$isValidConversion){
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }

    //save to db
    try{
        $licenseeId = $_SESSION['user']->getLicenseeId();

        //return new emission ID
        $newEmissionId = EmissionDb::addEmissionLog($licenseeId, $userId, $emissionTypeId, $unitTypeId, $unitQuantity,  $co2eQuantity, $emissionFactor['id'], $notes, $emissionStartDate, $emissionEndDate);

        $_SESSION['user_message'] = 'Emission log added successfully.';

    }catch(Exception $e){
        $error_message = $e->getMessage();
        $_SESSION['error_message'] = $error_message;
        $_SESSION['error_trace'] = $e->getTraceAsString();

        include('../include/error.php');
        exit();
    }

    if(!$newEmissionId || $newEmissionId <= 0){
        $_SESSION['error_message'] = 'Failed to save emission log. Please try again.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }

    //******************************************************************
    //********** REFACTOR STOPPED HERE ******************************* */
    //*******************************************************************
    

    //emission input is successful

    $isAlertTriggered = HelperEmission::calculateThresholdAndAlert($licenseeId, $newEmissionId, $emissionTypeId, $co2eQuantity, $emissionStartDate, $emissionEndDate);

    if(!$isAlertTriggered){
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }

    //display pop up message to user via 'show_popup'. If alert was triggered, include that message in pop up as well.
    if($newEmissionId > 0 && $newEmissionId !== false ){
        $_SESSION['input_message'] = 'Emission log added successfully.';

        //create flag to trigger pop up in view
        $_SESSION['show_popup'] = true;

        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    //end of emission input
}
//----------DEFAULT - DASHBOARD NAV-----------//
//**
//**  
else{
    //default action - go to dashboard
    header('Location: ../dashboard_manager/index.php?controllerRequest=dashboard_nav');
    exit();
}
//end of file