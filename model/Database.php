<?php
    class Database{
        private static $dsn = 'mysql:host=db;dbname=earth';
        private static $dbUsername = 'mgs_user';
        private static $dbPassword = 'password';
        private static $db;

        public static function getDb(){
            if(!isset(self::$db)){
                try {
                    self::$db = new PDO(self::$dsn, self::$dbUsername, self::$dbPassword);
                    self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    $error_message = $e->getMessage();
                    include('database_error.php');
                    exit();
                }
            }
            return self::$db;
        }
    }
?>