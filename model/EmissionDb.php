<?php
require_once('Database.php');
require_once('Emission.php');
class EmissionDb{
    public static function getEmissionTypes(){
        $db = Database::getDB();
        $query = 'SELECT * FROM EmissionType ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        return $statement;
    }

    public static function getUnitTypes(){
        $db = Database::getDB();
        $query = 'SELECT * FROM UnitType ORDER BY id';
        $statement = $db->prepare($query);
        $statement->execute();
        return $statement;
    }
}
