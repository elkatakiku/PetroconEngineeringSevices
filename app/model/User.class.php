<?php

class User implements Expose {

    private $id;
    private $first_name;
    private $middle_name;
    private $last_name;
    private $email;
    private $position;
    private $address;
    private $contact_no;
    private $birthdate;
    private $log_id;

    public function setUser(
        $id, $first_name, $middle_name, $last_name, $email, $position, $address, $contact_no,
        $birthdate, $log_id) {//parameter

        $this->id = $id; //need ng this to access nilagay sa private = parameter
        $this->first_name = $first_name;
        $this->middle_name= $middle_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->position = $position;
        $this->address = $address;
        $this->contact_no = $contact_no;
        $this->birthdate = $birthdate;
        $this->log_id =  $log_id;
        
    }

    public function createUser(
        $id, $first_name, $middle_name, $last_name, $email, $position, $address, $contact_no,
        $birthdate, $log_id) {//parameter

        $this->setUser(
            uniqid("PTRCN-USR-"), $first_name, $middle_name, $last_name, $email, $position, $address, $contact_no,
            $birthdate, $log_id
        );
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setFirstName($first_name) {
        $this->id = $first_name;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function setMiddleName($middle_name) {
        $this->id = $middle_namee;
    }

    public function getMiddletName() {
        return $this->middle_name;
    }

    public function setLastName($last_name) {
        $this->id = $last_name;
    }

    public function getLasttName() {
        return $this->last_name;
    }

    public function setEmail($email) {
        $this->id = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setPosition($position) {
        $this->id = $position;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setAddress($address) {
        $this->id = $address;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setContactNo($contact_no) {
        $this->id = $contact_no;
    }

    public function getContactNo() {
        return $this->contact_no;
    }

    public function setBirthdate($birthdate) {
        $this->id = $birthdate;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function setLogId($log_id) {
        $this->id = $log_id;
    }

    public function getLogId() {
        return $this->log_id;
    }

    public function expose() {
        
    }
}