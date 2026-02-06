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
    }catch(Exception $e){
        $error_message = $e->getMessage();
        include('../errors/error.php');
        exit();
    }
    //load emission input page
    include('emission_input.php');
}else if($controllerAction == 'emission_logs_nav'){
    include('emission_logs.php');
}