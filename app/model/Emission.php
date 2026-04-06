<?php

class Emission{
    private $id, $user_id, $emission_type_id, $physical_quantity, $unit_type_id, $notes, $log_date, $date_created, $co2e_quantity, $co2e_unit_type_id, $emission_factor_id;

    public function __construct($id, $user_id, $emission_type_id, $physical_quantity, $unit_type_id, $notes, $log_date){
        $this->id = $id;
        $this->user_id = $user_id;
        $this->emission_type_id = $emission_type_id;
        $this->physical_quantity = $physical_quantity;
        $this->unit_type_id = $unit_type_id;
        $this->notes = $notes;
        $this->log_date = $log_date;
    }

    //OVERLOADED CONSTRUCTORS
    public static function withCo2e($id, $user_id, $emission_type_id, $physical_quantity, $unit_type_id, $notes, $log_date, $date_created, $co2e_quantity, $co2e_unit_type_id, $emission_factor_id){
        $instance = new self($id, $user_id, $emission_type_id, $physical_quantity, $unit_type_id, $notes, $log_date, $date_created);
        $instance->co2e_quantity = $co2e_quantity;
        $instance->co2e_unit_type_id = $co2e_unit_type_id;
        $instance->emission_factor_id = $emission_factor_id;
        return $instance;
    }
    //GETTERS
    public function getId(){
        return $this->id;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function getEmissionTypeId(){
        return $this->emission_type_id;
    }
    public function getPhysicalQuantity(){
        return $this->physical_quantity;
    }
    public function getUnitTypeId(){
        return $this->unit_type_id;
    }
    public function getNotes(){
        return $this->notes;
    }
    public function getLogDate(){
        return $this->log_date;
    }
    public function getDateCreated(){
        return $this->date_created;
    }
    public function getCo2eQuantity(){
        return $this->co2e_quantity;
    }
    public function getCo2eUnitTypeId(){
        return $this->co2e_unit_type_id;
    }
    public function getEmissionFactorId(){
        return $this->emission_factor_id;
    }
    //SETTERS
    public function setId($id){
        $this->id = $id;
    }
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }
    public function setEmissionTypeId($emission_type_id){
        $this->emission_type_id = $emission_type_id;
    }
    public function setPhysicalQuantity($physical_quantity){
        $this->physical_quantity = $physical_quantity;
    }
    public function setUnitTypeId($unit_type_id){
        $this->unit_type_id = $unit_type_id;
    }
    public function setNotes($notes){
        return $this->notes = $notes;
    }
    public function setLogDate($log_date){
        $this->log_date = $log_date;
    }
    public function setDateCreated($date_created){
        $this->date_created = $date_created;
    }
    public function setCo2eQuantity($co2e_quantity){
        $this->co2e_quantity = $co2e_quantity;
    }
    public function setCo2eUnitTypeId($co2e_unit_type_id){
        $this->co2e_unit_type_id = $co2e_unit_type_id;
    }
    public function setEmissionFactorId($emission_factor_id){
        $this->emission_factor_id = $emission_factor_id;
    }
}