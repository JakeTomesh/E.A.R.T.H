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
switch($controllerAction){
    case 'emission_input_nav':
        // save form state in the controller so the view stays presentation-only
        $oldInput = $_SESSION['old_input'] ?? [];
        $selectedEmissionTypeId = $oldInput['emission_type'] ?? '';
        $selectedUnitTypeId = $oldInput['unit_type'] ?? '';
        $unitQuantity = $oldInput['unit_quantity'] ?? '';
        $emissionStartDate = $oldInput['emission_start_date'] ?? '';
        $emissionEndDate = $oldInput['emission_end_date'] ?? '';
        $notes = $oldInput['notes'] ?? '';

        // consume one-time form state on page load
        unset($_SESSION['old_input']);

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
        break;
    //----------EMISSION LOGS NAV-----------//
    case 'emission_logs_nav':
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
        break;
    //----------EMISSION LOG DETAILS NAV-----------//
    case 'emission_log_details_nav':
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
        break;
    //----------THRESHOLD MANAGEMENT NAV-----------//
    case 'manage_thresholds_nav':
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
        break;
    //----------EDIT THRESHOLD NAV-----------//
    case 'edit_threshold_nav':
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
        break;
    //----------ALERT LOGS NAV-----------//
    case 'alert_logs_nav':
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
        break;
    //----------ALERT LOG DETAILS NAV-----------//
    case 'alert_log_details_nav':
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
        break;
    //----------EMISSION FACTORS MANAGEMENT NAV-----------//
    case 'manage_emission_factors_nav':
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
        break;
    //----------EDIT EMISSION FACTOR NAV-----------//
    case 'edit_emission_factor_nav':
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
        break;
    //----------ADD EMISSION FACTOR NAV-----------//
    case 'add_emission_factor_nav':
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
        break;
    //-----------FUNCTIONAL CONTROLS-----------//
    //*
    //*
    //----------SAVE ADD EMISSION FACTOR-----------//
    case 'save_add_emission_factor':
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
        break;
    //----------SAVE EDIT EMISSION FACTOR-----------//
    case 'save_edit_emission_factor':
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
        break;
    //----------SAVE EDIT THRESHOLD-----------//
    case 'save_edit_threshold':
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
        break;
    //----------SUBMIT EMISSION INPUT-----------//
    case 'submit_emission_input':
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
        try{
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
        }catch(Exception $e){
            $error_message = $e->getMessage();
            $_SESSION['error_message'] = $error_message;
            $_SESSION['error_trace'] = $e->getTraceAsString();
            include('../include/error.php');
            exit();
        }
        //off put all calculation process to helper class. 
        try{
            $isValidConversion = HelperEmission::calculateCo2eConversion($licenseeId, $emissionTypeId, $unitTypeId, $unitQuantity);
        }catch(Exception $e){
            $error_message = $e->getMessage();
            $_SESSION['error_message'] = $error_message;
            $_SESSION['error_trace'] = $e->getTraceAsString();
            include('../include/error.php');
            exit();
        }

        if(!$isValidConversion){
            header('Location: index.php?controllerRequest=emission_input_nav');
            exit();
        }

        $co2eQuantity = $isValidConversion['co2e_quantity'];
        $emissionFactorId = $isValidConversion['emission_factor_id'];
        //save to db
        try{
            //return new emission ID
            $newEmissionId = EmissionDb::addEmissionLog($licenseeId, $userId, $emissionTypeId, $unitTypeId, $unitQuantity,  $co2eQuantity, $emissionFactorId, $notes, $emissionStartDate, $emissionEndDate);

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

        //emission input is successful

        try{
            $isThresholdCheckValid = HelperEmission::calculateThresholdAndAlert($licenseeId, $newEmissionId, $emissionTypeId, $co2eQuantity, $emissionStartDate, $emissionEndDate);
        }catch(Exception $e){
            $error_message = $e->getMessage();
            $_SESSION['error_message'] = $error_message;
            $_SESSION['error_trace'] = $e->getTraceAsString();
            include('../include/error.php');
            exit();
        }

        if(!$isThresholdCheckValid){
            header('Location: index.php?controllerRequest=emission_input_nav');
            exit();
        }

        //clear old input from session
        unset($_SESSION['old_input']);

        //display pop up message to user via 'show_popup'. If alert was triggered, include that message in pop up as well.

        $_SESSION['input_message'] = 'Emission log added successfully.';

        //create flag to trigger pop up in view
        $_SESSION['show_popup'] = true;

        if(isset($_SESSION['alert_message'])){
            $_SESSION['input_message'] .= ' ' . $_SESSION['alert_message'];
            unset($_SESSION['alert_message']);
        }

        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();

        //end of emission input  
        break;
    case 'reset_emission_input':
        //clear old input from session
        unset($_SESSION['old_input']);
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
        break;
    //----------DEFAULT - DASHBOARD NAV-----------// 
    default:
        //default action - go to dashboard
        header('Location: ../dashboard_manager/index.php?controllerRequest=dashboard_nav');
        exit();
    break;
}//end of switch
//end of file