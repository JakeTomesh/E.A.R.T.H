<?php
class HelperEmission{

    public static function validateInput($input, $strOfInput){
        switch($strOfInput){
            case 'emission_type': 
                $emissionTypeId = $input;
                if($emissionTypeId === false || $emissionTypeId === null){
                    return false;
                }else{
                    return true;
                }
                break;
            case 'unit_type':
                $unitTypeId = $input;
                if($unitTypeId === false || $unitTypeId === null){
                    return false;
                }else{
                    return true;
                }
                break;
            case 'unit_quantity':
                $unitQuantity = $input;
                if($unitQuantity === false || $unitQuantity < 0){
                    return false;
                }else{
                    return true;
                }
                break;
            default:
                $_SESSION['error_message'] = 'Invalid input validation type.';
                $_SESSION['error_trace'] = 'HelperEmission::validateInput received an invalid $strOfInput value: ' . $strOfInput;
                include('../include/error.php');
                exit();
        }
    }

    public static function validateInputDates($inputDateStart, $inputDateEnd){
        $emissionStartDate = $inputDateStart;
        $emissionEndDate = $inputDateEnd;

        if($emissionStartDate === false || $emissionStartDate === null || $emissionEndDate === false || $emissionEndDate === null){
            $_SESSION['error_message'] = 'Invalid emission date(s). Please provide valid start and end dates.';
            return false;
        }
        if($emissionStartDate > date('Y-m-d') || $emissionEndDate > date('Y-m-d')){
            $_SESSION['error_message'] = 'Emission dates cannot be in the future.';
            return false;
        }
        if($emissionEndDate < $emissionStartDate){
            $_SESSION['error_message'] = 'Emission end date cannot be before start date.';
            return false;
        }
    }
}