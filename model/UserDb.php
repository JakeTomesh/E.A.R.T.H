<?php
require_once('Database.php');
require_once('User.php');
class UserDb{
    public static function validateUserLogin($username, $password){
        $db = Database::getDB();
        $query = 'SELECT password_hash FROM EarthUser WHERE liscenceId = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row){
            $hashedPassword = $row['passwordHash'];
            return password_verify($password, $hashedPassword);
        } else {
            return false;
        }
    }

    public static function getUserByUsername($username){
        $db = Database::getDB();
        $query = 'SELECT * FROM users WHERE liscenceId = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row){
            $user = User::withDates(
                $row['liscenceId'],
                $row['email'],
                $row['firstName'],
                $row['lastName'],
                $row['passwordHash'],
                $row['role'],
                $row['dateCreated'],
                $row['dateUpdated']
            );
            return $user;
        } else {
            throw new Exception("User not found.");
        }
    }
}



?>