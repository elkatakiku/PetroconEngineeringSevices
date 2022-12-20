<?php

class Client implements Expose {
    
    private $id;
    private $name;
    private $company;
    private $contactNumber;
    private $email;
    private $active;
    
    public function setClient($id, $name, $company, $contactNumber, $email, $active) {
        $this->id = $id;
        $this->name = $name;
        $this->company = $company;
        $this->contactNumber = $contactNumber;
        $this->email = $email;
        $this->active = $active;
    }

    public function createClient(string $id, $name, $company, $contactNumber, $email, $active) {

        $this->setClient(
            uniqid("PTRCN-CLNT-"), $name, $company, $contactNumber, $email, $active
        );
    }

    public function setId(string $id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName(string $lastname, string $firstname, string $middlename = "") {
        $this->name = $lastname;
    }

    public function expose() {

    }
}