<?php 
//set session
if(session_id() == ''){
    $lifetime = 60 *60 * 24 * 7; // 1 week
    session_set_cookie_params($lifetime, '/');
    session_start();
}
//import models
require_once '../model/Emission.php';
require_once '../model/EmissionDb.php';


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
if($controllerAction == 'view_metrics_nav'){
    include('metrics_static.php');
}