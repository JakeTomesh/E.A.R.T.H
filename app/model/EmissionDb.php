<?php
require_once('Database.php');
require_once('Emission.php');
class EmissionDb{
    public static function getEmissionTypes(){
        $db = Database::getDB();
        $query = 'SELECT * FROM EmissionType ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function getUnitTypes(){
        $db = Database::getDB();
        $query = 'SELECT * FROM UnitType WHERE base_unit_type_id != 4 ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function getAllEmissionThresholdsByLicensee($licenseeId){
        $db = Database::getDB();
        $query = 'SELECT
                    tl.id,
                    tl.licensee_id,
                    tl.emission_type_id,
                    et.name AS emission_type_name,
                    tl.co2e_unit_type_id,
                    ut.name AS unit_type_name,
                    tl.co2e_limit,
                    tl.date_updated
                FROM ThresholdLimit tl
                JOIN EmissionType et ON tl.emission_type_id = et.id
                JOIN UnitType ut ON tl.co2e_unit_type_id = ut.id
                WHERE tl.licensee_id = :licenseeId
                ORDER BY tl.id';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function getThresholdLimitById($thresholdId){
        $db = Database::getDB();
        $query = 'SELECT
                    tl.id,
                    tl.licensee_id,
                    tl.emission_type_id,
                    et.name AS emission_type_name,
                    tl.co2e_unit_type_id,
                    ut.name AS unit_type_name,
                    tl.co2e_limit,
                    tl.date_updated
                FROM ThresholdLimit tl
                JOIN EmissionType et ON tl.emission_type_id = et.id
                JOIN UnitType ut ON tl.co2e_unit_type_id = ut.id
                WHERE tl.id = :thresholdId';
                
        $statement = $db->prepare($query);
        $statement->bindValue(':thresholdId', $thresholdId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateThresholdLimit($thresholdId, $newCo2eLimit){
        $db = Database::getDB();
        $query = 'UPDATE ThresholdLimit SET co2e_limit = :co2eLimit, date_updated = NOW() WHERE id = :thresholdId';
        $statement = $db->prepare($query);
        $statement->bindValue(':co2eLimit', $newCo2eLimit);
        $statement->bindValue(':thresholdId', $thresholdId, PDO::PARAM_INT);
        return $statement->execute();
    }

    public static function getAllEmissionLogsByLicensee($licenseeId){
        $db = Database::getDB();
        $query = 'SELECT
                    el.id,
                    eu.username,
                    et.name AS emission_type_name,
                    ut2.name AS co2e_unit_type_name,
                    ut.name AS physical_unit_type_name,
                    el.physical_quantity,
                    el.co2e_quantity,
                    ef.factor AS emission_factor,
                    el.emission_start_date,
                    el.emission_end_date,
                    el.date_created
                FROM EmissionLog el
                JOIN EmissionType et ON el.emission_type_id = et.id
                JOIN UnitType ut ON el.unit_type_id = ut.id
                JOIN UnitType ut2 ON el.co2e_unit_type_id = ut2.id
                JOIN EarthUser eu ON el.user_id = eu.id
                JOIN EmissionFactor ef ON el.emission_factor_id = ef.id
                WHERE el.licensee_id = :licenseeId
                ORDER BY el.date_created DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function getEmissionLogById($logId){
        $db = Database::getDB();
        $query = 'SELECT
                    el.id,
                    eu.username,
                    et.name AS emission_type_name,
                    ut2.name AS co2e_unit_type_name,
                    ut.name AS physical_unit_type_name,
                    el.physical_quantity,
                    el.co2e_quantity,
                    ef.factor AS emission_factor,
                    el.notes,
                    el.emission_start_date,
                    el.emission_end_date,
                    el.date_created
                FROM EmissionLog el
                JOIN EmissionType et ON el.emission_type_id = et.id
                JOIN UnitType ut ON el.unit_type_id = ut.id
                JOIN UnitType ut2 ON el.co2e_unit_type_id = ut2.id
                JOIN EarthUser eu ON el.user_id = eu.id
                JOIN EmissionFactor ef ON el.emission_factor_id = ef.id
                WHERE el.id = :logId';
        $statement = $db->prepare($query);
        $statement->bindValue(':logId', $logId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllAlertLogsByLicensee($licenseeId){
        $db = Database::getDB();
        $query = 'SELECT
                    al.id,
                    et.name AS emission_type_name,
                    ut.name AS co2e_unit_type_name,
                    ut2.name AS co2e_limit_unit_type_name,
                    al.co2e_quantity,
                    al.emission_log_id,
                    tl.co2e_limit,
                    al.date_created
                FROM AlertLog al
                JOIN EmissionType et ON al.emission_type_id = et.id
                JOIN UnitType ut ON al.co2e_unit_type_id = ut.id
                JOIN UnitType ut2 ON al.co2e_unit_type_id = ut2.id
                JOIN EmissionLog el ON al.emission_log_id = el.id
                JOIN ThresholdLimit tl ON tl.emission_type_id = et.id AND tl.licensee_id = al.licensee_id
                WHERE al.licensee_id = :licenseeId
                ORDER BY al.date_created DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function getAlertLogById($alertLogId){
        $db = Database::getDB();
        $query = 'SELECT
                    al.id,
                    et.name AS emission_type_name,
                    ut.name AS co2e_unit_type_name,
                    ut2.name AS co2e_limit_unit_type_name,
                    al.co2e_quantity,
                    al.emission_log_id,
                    tl.co2e_limit,
                    al.message,
                    al.date_created
                FROM AlertLog al
                JOIN EmissionType et ON al.emission_type_id = et.id
                JOIN UnitType ut ON al.co2e_unit_type_id = ut.id
                JOIN UnitType ut2 ON al.co2e_unit_type_id = ut2.id
                JOIN EmissionLog el ON al.emission_log_id = el.id
                JOIN ThresholdLimit tl ON tl.emission_type_id = et.id AND tl.licensee_id = al.licensee_id
                WHERE al.id = :alertLogId';
        $statement = $db->prepare($query);
        $statement->bindValue(':alertLogId', $alertLogId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function getAllEmissionFactorsByLicensee($licenseeId){
        $db = Database::getDB();
        $query = 'SELECT
                    ef.id,
                    et.name AS emission_type_name,
                    ut.name AS unit_type_name,
                    ut2.name AS co2e_unit_type_name,
                    ef.factor,
                    ef.date_updated
                FROM EmissionFactor ef
                JOIN EmissionType et ON ef.emission_type_id = et.id
                JOIN UnitType ut ON ef.physical_unit_type_id = ut.id
                JOIN UnitType ut2 ON ef.co2e_unit_type_id = ut2.id
                WHERE ef.licensee_id = :licenseeId
                ORDER BY ef.id';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function getEmissionFactorById($emissionFactorId){
        $db = Database::getDB();
        $query = 'SELECT
                    ef.id,
                    et.name AS emission_type_name,
                    ut.name AS unit_type_name,
                    ut2.name AS co2e_unit_type_name,
                    ef.factor,
                    ef.date_updated
                FROM EmissionFactor ef
                JOIN EmissionType et ON ef.emission_type_id = et.id
                JOIN UnitType ut ON ef.physical_unit_type_id = ut.id
                JOIN UnitType ut2 ON ef.co2e_unit_type_id = ut2.id
                WHERE ef.id = :emissionFactorId';
        $statement = $db->prepare($query);
        $statement->bindValue(':emissionFactorId', $emissionFactorId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateEmissionFactor($emissionFactorId, $newFactor){
        $db = Database::getDB();
        $query = 'UPDATE EmissionFactor SET factor = :factor, date_updated = NOW() WHERE id = :emissionFactorId';
        $statement = $db->prepare($query);
        $statement->bindValue(':factor', $newFactor);
        $statement->bindValue(':emissionFactorId', $emissionFactorId, PDO::PARAM_INT);
        return $statement->execute();
    }

    public static function addEmissionFactor($licenseeId, $emissionTypeId, $physicalUnitTypeId, $factor){
        $db = Database::getDB();
        $query = 'INSERT INTO EmissionFactor (licensee_id, emission_type_id, physical_unit_type_id, factor, date_updated)
                  VALUES (:licenseeId, :emissionTypeId, :physicalUnitTypeId, :factor, NOW())';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId, PDO::PARAM_INT);
        $statement->bindValue(':emissionTypeId', $emissionTypeId, PDO::PARAM_INT);
        $statement->bindValue(':physicalUnitTypeId', $physicalUnitTypeId, PDO::PARAM_INT);
        $statement->bindValue(':factor', $factor);
        return $statement->execute();
    }

    public static function getEmissionFactorBasedOnUnitType($licenseeId, $emissionTypeId, $physicalUnitTypeId){
        $db = Database::getDB();
        $query = 'SELECT
                    ef.id,
                    ef.factor
                FROM EmissionFactor ef
                WHERE ef.licensee_id = :licenseeId AND ef.emission_type_id = :emissionTypeId AND ef.physical_unit_type_id = :physicalUnitTypeId';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId, PDO::PARAM_INT);
        $statement->bindValue(':emissionTypeId', $emissionTypeId, PDO::PARAM_INT);
        $statement->bindValue(':physicalUnitTypeId', $physicalUnitTypeId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function getThresholdLimitByEmissionType($licenseeId, $emissionTypeId){
        $db = Database::getDB();
        $query = 'SELECT
                    tl.id,
                    tl.co2e_limit
                FROM ThresholdLimit tl
                WHERE tl.licensee_id = :licenseeId 
                AND tl.emission_type_id = :emissionTypeId
                AND tl.co2e_unit_type_id = 10
                LIMIT 1';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId, PDO::PARAM_INT);
        $statement->bindValue(':emissionTypeId', $emissionTypeId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function addAlertLog($licenseeId, $newEmissionId, $emissionTypeId, $co2eQuantity, $thresholdId, $emissionMessage){
        $db = Database::getDB();
        $query = 'INSERT INTO AlertLog (licensee_id, emission_log_id, emission_type_id, co2e_quantity, threshold_limit_id, message, date_created)
                  VALUES (:licenseeId, :emissionLogId, :emissionTypeId, :co2eQuantity, :thresholdId, :message, NOW())';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId, PDO::PARAM_INT);
        $statement->bindValue(':emissionLogId', $newEmissionId, PDO::PARAM_INT);
        $statement->bindValue(':emissionTypeId', $emissionTypeId, PDO::PARAM_INT);
        $statement->bindValue(':co2eQuantity', $co2eQuantity);
        $statement->bindValue(':thresholdId', $thresholdId, PDO::PARAM_INT);
        $statement->bindValue(':message', $emissionMessage);
        return $statement->execute();
    }

    public static function addEmissionLog($licenseeId, $userId, $emissionTypeId, $unitTypeId, $physicalQuantity, $co2eQuantity, $emissionFactorId, $notes, $emissionStartDate, $emissionEndDate){
        $db = Database::getDB();
        $query = 'INSERT INTO EmissionLog (licensee_id, user_id, emission_type_id, unit_type_id, physical_quantity, co2e_quantity, emission_factor_id, notes, emission_start_date, emission_end_date, date_created)
                  VALUES (:licenseeId, :userId, :emissionTypeId, :unitTypeId, :physicalQuantity, :co2eQuantity, :emissionFactorId, :notes, :emissionStartDate, :emissionEndDate, NOW())';
        $statement = $db->prepare($query);
        $statement->bindValue(':licenseeId', $licenseeId, PDO::PARAM_INT);
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
        $statement->bindValue(':emissionTypeId', $emissionTypeId, PDO::PARAM_INT);
        $statement->bindValue(':unitTypeId', $unitTypeId, PDO::PARAM_INT);
        $statement->bindValue(':physicalQuantity', $physicalQuantity);
        $statement->bindValue(':co2eQuantity', $co2eQuantity);
        $statement->bindValue(':emissionFactorId', $emissionFactorId, PDO::PARAM_INT);
        $statement->bindValue(':notes', $notes);
        $statement->bindValue(':emissionStartDate', $emissionStartDate);
        $statement->bindValue(':emissionEndDate', $emissionEndDate);
        if($statement->execute()){
            return $db->lastInsertId();
        }else{
            return false;
        }
    }

    public static function getUnitTypeById($unitTypeId){
        $db = Database::getDB();
        $query = 'SELECT id, code, name, base_unit_type_id, is_base_unit, conversion_factor
                FROM UnitType
                WHERE id = :unitTypeId';
        $statement = $db->prepare($query);
        $statement->bindValue(':unitTypeId', $unitTypeId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function getBaseUnitTypeById($baseUnitId){
        $db = Database::getDB();
        $query = 'SELECT id, code, name, base_unit_type_id, is_base_unit, conversion_factor
                FROM UnitType
                WHERE id = :baseUnitId AND is_base_unit = 1
                LIMIT 1';
        $statement = $db->prepare($query);
        $statement->bindValue(':baseUnitId', $baseUnitId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
