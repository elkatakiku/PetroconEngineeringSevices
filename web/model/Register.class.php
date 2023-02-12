<?php

namespace Model;

class Register {

    private $id;
    private $lastname;
    private $firstname;
    private $middleName;
    private $contactNumber;
    private $birthdate;
    private $email;
    private $loginId;
    private $address;

    public function create(
        $lastname, $firstname, $contactNumber, $birthdate, $email, $loginId, $address) {
        
        $this->set(
            uniqid("PTRCN-RGSTR-"), $lastname, $firstname, '', 
            $contactNumber, $birthdate, $email, $loginId, $address
        );
    }

    public function temp($email, $loginId)
    {
        $this->set(
            uniqid("PTRCN-RGSTR-"), '', '', '', 
            '', date('Y-n-j'), $email, $loginId, ''
        );
    }

    public function set(
        $id, $lastname, $firstname, $middleName, 
        $contactNumber, $birthdate, $email, $loginId, $address) {
        
        $this->id = $id;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->middleName = $middleName;
        $this->contactNumber = $contactNumber;
        $this->birthdate = $birthdate;
        $this->email = $email;
        $this->loginId = $loginId;
        $this->address = $address;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }
    
    public function getLastname() {
        return $this->lastname;
    }

    public function setFirstname($firstname) {
        $this->lastname = $firstname;
    }
    
    public function getFirstname() {
        return $this->firstname;
    }
    
    public function setMiddlename($middleName) {
        $this->middleName = $middleName;
    }
    
    public function getMiddlename() {
        return $this->middleName;
    }

    public function setContactNumber($contactNumber) {
        $this->contactNumber = $contactNumber;
    }
    
    public function getContactNumber() {
        return $this->contactNumber;
    }

    public function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;
    }
    
    public function getBirthdate() {
        return $this->birthdate;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getEmail() {
        return $this->email;
    }

    public function setLoginId($loginId) {
        $this->loginId = $loginId;
    }
    
    public function getLoginId() {
        return $this->loginId;
    }

    public function setAddress($address) {
        $this->id = $address;
    }

    public function getAddress() {
        return $this->address;
    }
}