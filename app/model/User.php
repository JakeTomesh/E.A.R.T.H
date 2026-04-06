<?php 
class User{
    private $id, $licenseeId, $email, $firstName, $lastName, $passwordHash, $role, $dateCreated, $dateUpdated, $isActive, $companyName;
    
    public function __construct($id,$licenseeId, $email, $firstName, $lastName, $passwordHash, $role, $isActive){
        $this->id = $id;
        $this->licenseeId = $licenseeId;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->isActive = $isActive;
    }
    //OVERLOADED CONSTRUCTORS
    public static function withDates($id, $licenseeId, $email, $firstName, $lastName, $passwordHash, $role, $isActive, $dateCreated, $dateUpdated){
        $instance = new self($id, $licenseeId, $email, $firstName, $lastName, $passwordHash, $role, $isActive);
        $instance->dateCreated = $dateCreated;
        $instance->dateUpdated = $dateUpdated;
        return $instance;
    }
    //GETTERS
    public function getId(){
        return $this->id;
    }
    public function getLicenseeId(){
        return $this->licenseeId;
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
    public function getIsActive(){
        return $this->isActive;
    }
    public function getCompanyName(){
        return $this->companyName;
    }
    //SETTERS
    public function setCompanyName($companyName){
        $this->companyName = $companyName;
    }   
}

//end of file