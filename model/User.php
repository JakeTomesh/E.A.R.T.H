<?php 
class User{
    private $id, $liscenceId, $email, $firstName, $lastName, $passwordHash, $role, $dataCreated, $dateUpdated;
    public function __construct($liscenceId, $email, $firstName, $lastName, $passwordHash, $role){
        $this->liscenceId = $liscenceId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
    }
    //OVERLOADED CONSTRUCTORS
    public static function withDates($liscenceId, $email, $firstName, $lastName, $passwordHash, $role, $dateCreated, $dateUpdated){
        $instance = new self($liscenceId, $email, $firstName, $lastName, $passwordHash, $role);
        $instance->dateCreated = $dateCreated;
        $instance->dateUpdated = $dateUpdated;
        return $instance;
    }
    //GETTERS
    public function getId(){
        return $this->id;
    }
    public function getLiscenceId(){
        return $this->liscenceId;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getFirstName(){
        return $this->firstName;
    }
    public function getLastName(){
        return $this->lastName;
    }
    public function getPasswordHash(){
        return $this->passwordHash;
    }
    public function getRole(){
        return $this->role;
    }
    public function getDateCreated(){
        return $this->dateCreated;
    }
    public function getDateUpdated(){
        return $this->dateUpdated;
    }
}



?>