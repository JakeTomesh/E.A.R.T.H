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
        $query = 'SELECT * FROM UnitType ORDER BY id';
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

}
