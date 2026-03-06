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

    //validate input
    if($emissionTypeId === false || $emissionTypeId === null){
        $_SESSION['error_message'] = 'Invalid emission type selection.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if($unitTypeId === false || $unitTypeId === null){
        $_SESSION['error_message'] = 'Invalid unit type selection.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if($unitQuantity === false || $unitQuantity < 0){
        $_SESSION['error_message'] = 'Invalid unit quantity. Must be a non-negative number.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if($emissionStartDate === false || $emissionStartDate === null || $emissionEndDate === false || $emissionEndDate === null){
        $_SESSION['error_message'] = 'Invalid emission date(s). Please provide valid start and end dates.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if($emissionStartDate > date('Y-m-d') || $emissionEndDate > date('Y-m-d')){
        $_SESSION['error_message'] = 'Emission dates cannot be in the future.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if($emissionEndDate < $emissionStartDate){
        $_SESSION['error_message'] = 'Emission end date cannot be before start date.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    

    //calculate co2e quantity based on emission factor for the selected type/unit
    $selectedUnitType = EmissionDb::getUnitTypeById($unitTypeId);
    if ($selectedUnitType === false || $selectedUnitType === null) {
        $_SESSION['error_message'] = 'Selected unit type not found.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if(!isset($selectedUnitType['conversion_factor']) || !is_numeric($selectedUnitType['conversion_factor'])){
        $_SESSION['error_message'] = 'Unit type data is invalid (missing conversion factor).';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }

    //conversion factor for unit type to convert to standard unit for emission factor calculation
    $conversionFactor = (float)$selectedUnitType['conversion_factor'];
    if ($conversionFactor <= 0) {
        $_SESSION['error_message'] = 'Unit type conversion factor must be greater than 0.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }

    //convert submitted quantity to BASE units for emission factor calculation
    $baseQuantity = (float)$unitQuantity * $conversionFactor;
    if(!is_finite($baseQuantity) || $baseQuantity < 0){
        $_SESSION['error_message'] = 'Calculated base quantity is invalid.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    //get BASE unit type id for this group
    $baseUnitType = EmissionDb::getBaseUnitTypeByGroup($selectedUnitType['base_unit_type_id']);
    if(!$baseUnitType || $baseUnitType === false || $baseUnitType === null){
        $_SESSION['error_message'] = 'Base unit type not found for selected unit type.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }

    //get emission factor for this emission type and BASE unit type
    $emissionFactor = EmissionDb::getEmissionFactorBasedOnUnitType($licenseeId, $emissionTypeId, $baseUnitType['id']);



    if ($emissionFactor === false || $emissionFactor === null) {
        $_SESSION['error_message'] = 'No emission factor found for the selected emission type (base unit).';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    if (!isset($emissionFactor['factor']) || !is_numeric($emissionFactor['factor'])) {
        $_SESSION['error_message'] = 'Emission factor data is invalid (missing factor).';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    //cast factor to float for calculation
    $factor = (float)$emissionFactor['factor'];

    if ($factor <= 0) {
        $_SESSION['error_message'] = 'Emission factor must be greater than 0 for this unit/type.';
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
    //convert to co2e quantity and round to 2 decimal places
    $co2eQuantity = round($baseQuantity * $factor, 2);

    if (!is_finite($co2eQuantity) || $co2eQuantity < 0) {
        $_SESSION['error_message'] = 'Calculated CO₂e value is invalid.';
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
    //emission input is successful
    //now check if this log entry exceeds any thresholds and if so, create alert log entry
    //must compare thresholds by unit type, so get threshold limits for this emission's unit type
    $threshold = EmissionDb::getThresholdLimitByEmissionType($licenseeId, $emissionTypeId);


    if($threshold === false || $threshold === null){
        //no threshold set for this emission type, so skip alert log check
        $threshold = null;
    }else{
        if(!isset($threshold['co2e_limit']) || !is_numeric($threshold['co2e_limit'])) {
            $_SESSION['error_message'] = 'Threshold data is invalid (missing CO₂e limit).';
            header('Location: index.php?controllerRequest=emission_input_nav');
            exit();
        }

        //thresholds are a rate of co2e per day.
        $limit = (float)$threshold['co2e_limit']; 

        //calculate number of days in emission period for this log entry
        $startDate = new DateTime($emissionStartDate);
        $endDate = new DateTime($emissionEndDate);
        $interval = $startDate->diff($endDate);
        $days = $interval->days + 1; //include both start and end date

        //daily rate of co2e for this log entry
        $co2eDailyRate = round($co2eQuantity / $days, 2);

        
        //compare co2e daily rate to threshold rate.
        if($co2eDailyRate > $limit){
            //exceeds threshold, create alert log entry
            try{
                //switch statment for alert message based on emission type
                
                switch($emissionTypeId){
                    case 1: //Electricity - Grid
                        $emissionTypeMessage = 'Electricity consumption from grid exceeds threshold.';
                        break;
                    case 2: //Electricity - Renewable
                        $emissionTypeMessage = 'Electricity consumption from renewable sources exceeds threshold.';
                        break;
                    case 3: //Natural Gas - On-site Combustion
                        $emissionTypeMessage = 'Natural gas usage exceeds threshold.';
                        break;
                    case 4: //Diesel Fuel - Backup Generators
                        $emissionTypeMessage = 'Diesel fuel usage exceeds threshold.';
                        break;
                    case 5: //Refrigerant Leakage - Cooling Systems
                        $emissionTypeMessage = 'Refrigerant leakage from cooling systems exceeds threshold.';
                        break;
                    case 6: //Water Usage - Cooling Systems
                        $emissionTypeMessage = 'Water usage from cooling systems exceeds threshold.';
                        break;
                    case 7: //Waste - Electronic (E-waste)
                        $emissionTypeMessage = 'Electronic waste generation exceeds threshold.';
                        break;
                    case 8: //Waste - General/Landfilled
                        $emissionTypeMessage = 'General waste generation exceeds threshold.';
                        break;
                    default:
                        $emissionTypeMessage = 'An emission entry exceeds threshold.';
                }
                $isvalidAlertLog = EmissionDb::addAlertLog($licenseeId, $newEmissionId, $emissionTypeId, $co2eDailyRate, $threshold['id'], $emissionTypeMessage);
            }catch(Exception $e){
                $error_message = $e->getMessage();
                $_SESSION['error_message'] = $error_message;
                $_SESSION['error_trace'] = $e->getTraceAsString();
                include('../include/error.php');
                exit();
            }
        }
        if(!isset($isvalidAlertLog)){
            //no alert triggered, so this variable is not set. Set to null to avoid null errors
            $isvalidAlertLog = null; 
        }
        //check if alert was triggered, set message.
        if($isvalidAlertLog === false){
            $_SESSION['error_message'] = 'Failed to create alert log entry for threshold exceedance. Please check your alert logs to confirm if an alert was created.';
            header('Location: index.php?controllerRequest=emission_input_nav');
            exit();
        }else if($isvalidAlertLog === true){
            $_SESSION['alert_message'] = ' Alert log created for threshold exceedance.';
        }
        
    }

    //display pop up message to user via 'show_popup'. If alert was triggered, include that message in pop up as well.
    if($newEmissionId > 0 && $newEmissionId !== false ){
        $_SESSION['input_message'] = 'Emission log added successfully.';
        //create flag to trigger pop up in view
        $_SESSION['show_popup'] = true;
        header('Location: index.php?controllerRequest=emission_input_nav');
        exit();
    }
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