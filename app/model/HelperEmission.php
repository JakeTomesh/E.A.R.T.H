<?php
//import models via bootstrap
require_once('../include/bootstrap.php');

class HelperEmission{
    //emission input validation sans date
    public static function validateInput($input, $strOfInput){
        switch($strOfInput){
            case 'emission_type': 
                $emissionTypeId = $input;
                if($emissionTypeId === false || $emissionTypeId === null){
                    $_SESSION['error_message'] = 'Invalid emission type selection.';
                    return false;
                }
                return true;
            case 'unit_type':
                $unitTypeId = $input;
                if($unitTypeId === false || $unitTypeId === null){
                    $_SESSION['error_message'] = 'Invalid unit type selection.';
                    return false;
                }
                return true;
            case 'unit_quantity':
                $unitQuantity = $input;
                if($unitQuantity === false || $unitQuantity === null || $unitQuantity < 0){
                    $_SESSION['error_message'] = 'Invalid unit quantity. Must be a non-negative number.';
                    return false;
                }
                return true;
            default:
                throw new Exception('HelperEmission::validateInput received an invalid $strOfInput value: ' . $strOfInput);
        }
    }
    //emission date input validation
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
        //default
        return true;
    }

    public static function calculateCo2eConversion($licenseeId, $emissionTypeId, $unitTypeId, $unitQuantity){
            
        //calculate co2e quantity based on emission factor for the selected type/unit
        $selectedUnitType = EmissionDb::getUnitTypeById($unitTypeId);
        if ($selectedUnitType === false || $selectedUnitType === null) {
            $_SESSION['error_message'] = 'Selected unit type not found.';
            return false;
        }
        
        if(!isset($selectedUnitType['conversion_factor']) || !is_numeric($selectedUnitType['conversion_factor'])){
            $_SESSION['error_message'] = 'Unit type data is invalid (missing conversion factor).';
            return false;
        }

        //conversion factor for unit type to convert to standard unit for emission factor calculation
        $conversionFactor = (float)$selectedUnitType['conversion_factor'];
        if ($conversionFactor <= 0) {
            $_SESSION['error_message'] = 'Unit type conversion factor must be greater than 0.';
            return false;
        }

        //convert submitted quantity to BASE units for emission factor calculation
        $baseQuantity = (float)$unitQuantity * $conversionFactor;
        if(!is_finite($baseQuantity) || $baseQuantity < 0){
            $_SESSION['error_message'] = 'Calculated base quantity is invalid.';
            return false;
        }
        /* Debugging code to check base quantity calculation
        //get BASE unit type id for this group
        $baseUnitType = EmissionDb::getBaseUnitTypeById($selectedUnitType['base_unit_type_id']);
        if($baseUnitType === false || $baseUnitType === null){
            $_SESSION['error_message'] = 'Base unit type not found for selected unit type.';
            return false;
        }
                */
        //get emission factor for this emission type and BASE unit type
        $emissionFactor = EmissionDb::getEmissionFactorBasedOnUnitType($licenseeId, $emissionTypeId, $selectedUnitType['id']);

        if ($emissionFactor === false || $emissionFactor === null) {
            $_SESSION['error_message'] = 'No emission factor found for the selected emission type (base unit).';
            return false;
        }
        if (!isset($emissionFactor['factor']) || !is_numeric($emissionFactor['factor'])) {
            $_SESSION['error_message'] = 'Emission factor data is invalid (missing factor).';
            return false;
        }

        //cast factor to float for calculation
        $factor = (float)$emissionFactor['factor'];

        if ($factor <= 0) {
            $_SESSION['error_message'] = 'Emission factor must be greater than 0 for this unit/type.';
            return false;
        }

        //convert to co2e quantity and round to 2 decimal places
        $co2eQuantity = round($baseQuantity * $factor, 2);

        if (!is_finite($co2eQuantity) || $co2eQuantity < 0) {
            $_SESSION['error_message'] = 'Calculated CO₂e value is invalid.';
            return false;
        }

        return [
            'co2e_quantity' => $co2eQuantity,
            'emission_factor_id' => $emissionFactor['id']
        ];
    }

    public static function calculateThresholdAndAlert($licenseeId, $newEmissionId, $emissionTypeId, $co2eQuantity, $emissionStartDate, $emissionEndDate){
            
        //now check if this log entry exceeds any thresholds and if so, create alert log entry
        //must compare thresholds by unit type, so get threshold limits for this emission's unit type
        $threshold = EmissionDb::getThresholdLimitByEmissionType($licenseeId, $emissionTypeId);


        if($threshold === false || $threshold === null){
            //no threshold set for this emission type, so skip alert log check
            $threshold = null;
        }else{
            if(!isset($threshold['co2e_limit']) || !is_numeric($threshold['co2e_limit'])) {
                $_SESSION['error_message'] = 'Threshold data is invalid (missing CO₂e limit).';
                return false;
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
                
                //exception caught in controller.
                $isValidAlertLog = EmissionDb::addAlertLog($licenseeId, $newEmissionId, $emissionTypeId, $co2eDailyRate, $threshold['id'], $emissionTypeMessage);
            }

            if(!isset($isValidAlertLog)){
                //no alert triggered, so this variable is not set. Set to null to avoid null errors
                $isValidAlertLog = null; 
            }

            //check if alert was triggered, set message.
            if($isValidAlertLog === false){
                $_SESSION['error_message'] = 'Failed to create alert log entry for threshold exceedance. Please check your alert logs to confirm if an alert was created.';
                return false;
            }else if($isValidAlertLog === true){
                $_SESSION['alert_message'] = ' Alert log created for threshold exceedance.';
            }
        }
        //default
        return true;
    }
}