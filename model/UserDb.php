<?php
require_once('Database.php');
require_once('User.php');
class UserDb{
    public static function validateUserLogin($username, $password){
        $db = Database::getDB();
        $query = 'SELECT password_hash FROM EarthUser WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row){
            $hashedPassword = $row['password_hash'];
            return password_verify($password, $hashedPassword);
        } else {
            return false;
        }
    }

    public static function getUserByUsername($username){
        $db = Database::getDB();
        $query = 'SELECT eu.*, l.company FROM EarthUser eu
                            JOIN Licensee l ON eu.licensee_id = l.id
         WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row){
            $user = User::withDates(
                $row['id'],
                $row['licensee_id'],
                $row['email'],
                $row['first_name'],
                $row['last_name'],
                $row['password_hash'],
                $row['role_type_id'],
                $row['is_active'],
                $row['date_created'],
                $row['date_updated']
            );
            $user->setCompanyName($row['company']);
            return $user;
        } else {
            throw new Exception("User not found.");
        }
    }

    public static function checkForExistingUser($username){
        $db = Database::getDB();
        $query = 'SELECT id FROM EarthUser WHERE username = :username';
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        if(count($result) > 0){
            return true;
        }
        return false;
    }

    public static function validateLicenseeKey($licenseeKey){
        $db = Database::getDB();
        $query = 'SELECT id FROM Licensee WHERE company_key = :company_key';
        $statement = $db->prepare($query);
        $statement->bindValue(':company_key', $licenseeKey);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row){
            return (int)$row['id'];
        }
        return false;
    }

    public static function registerUser($firstName, $lastName, $email, $username, $password, $role, $licenseeId){
        $db = Database::getDB();
        $query = 'INSERT INTO EarthUser (first_name, last_name, email, username, password_hash, role_type_id, licensee_id, date_created, date_updated)
                  VALUES (:first_name, :last_name, :email, :username, :password_hash, :role_type_id, :licensee_id, NOW(), NOW())';
        $statement = $db->prepare($query);
        $statement->bindValue(':first_name', $firstName);
        $statement->bindValue(':last_name', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password_hash', $password);
        $statement->bindValue(':role_type_id', $role);
        $statement->bindValue(':licensee_id', $licenseeId);
        try {
         $statement->execute();
        } catch (PDOException $e) {
            throw new Exception(
                "Insert failed. role_type_id={$role}, licensee_id={$licenseeId}. " . $e->getMessage()
            );
        }
        //$statement->execute();
        $rowsInserted = $statement->rowCount();
        $result = ($rowsInserted > 0);
        $statement->closeCursor();
        return $result;
    }

    public static function getAllUsersFromCompanyLicense($licenseeId){
        $db = Database::getDB();
        $query = 'SELECT * FROM EarthUser WHERE licensee_id = :licensee_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':licensee_id', $licenseeId);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $users = [];
        foreach($rows as $row){
            $user = User::withDates(
                $row['id'],
                $row['licensee_id'],
                $row['email'],
                $row['first_name'],
                $row['last_name'],
                $row['password_hash'],
                $row['role_type_id'],
                $row['is_active'],
                $row['date_created'],
                $row['date_updated']
            );
            $users[] = $user;
        }
        return $users;
    }

    public static function getUserById($userId){
        $db = Database::getDB();
        $query = 'SELECT * FROM EarthUser WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $userId);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        if($row){
            $user = User::withDates(
                $row['id'],
                $row['licensee_id'],
                $row['email'],
                $row['first_name'],
                $row['last_name'],
                $row['password_hash'],
                $row['role_type_id'],
                $row['is_active'],
                $row['date_created'],
                $row['date_updated']
            );
            return $user;
        } else {
            throw new Exception("User not found.");
        }
    }   

    public static function updateUser($userId, $firstName, $lastName, $email, $role, $isActive){
        $db = Database::getDB();
        $query = 'UPDATE EarthUser SET first_name = :first_name,
                                        last_name = :last_name,
                                        email = :email,
                                        role_type_id = :role_type_id,
                                        is_active = :is_active,
                                        date_updated = NOW() WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':first_name', $firstName);
        $statement->bindValue(':last_name', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':role_type_id', $role);
        $statement->bindValue(':is_active', $isActive);
        $statement->bindValue(':id', $userId);
        try {
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception(
                "Update failed. userId={$userId},
                                firstName={$firstName},
                                lastName={$lastName},
                                role_type_id={$role},
                                is_active={$isActive}. " . $e->getMessage()
            );
        }
        //$statement->execute();
        $rowsUpdated = $statement->rowCount();
        $result = ($rowsUpdated > 0);
        $statement->closeCursor();
        return $result;
    }

    public static function searchUsersByNameOrEmail($searchTerm, $licenseeId){
        $db = Database::getDB();
        $query = 'SELECT * FROM EarthUser WHERE (first_name LIKE :search OR last_name LIKE :search OR email LIKE :search) AND licensee_id = :licensee_id';
        $statement = $db->prepare($query);
        $likeTerm = '%' . $searchTerm . '%';
        $statement->bindValue(':search', $likeTerm);
        $statement->bindValue(':licensee_id', $licenseeId);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();
        $users = [];
        foreach($rows as $row){
            $user = User::withDates(
                $row['id'],
                $row['licensee_id'],
                $row['email'],
                $row['first_name'],
                $row['last_name'],
                $row['password_hash'],
                $row['role_type_id'],
                $row['is_active'],
                $row['date_created'],
                $row['date_updated']
            );
            $users[] = $user;
        }
        return $users;
    }
}

//end of file