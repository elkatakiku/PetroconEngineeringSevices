<?php

class Login implements Expose {

    private $id;
    private $username;
    private $password;

    public function createLogin($username, $password) {
        $this->setLogin(
            uniqid("PTRCN-USR-"), $username, password_hash($password, PASSWORD_DEFAULT)
        );
    }

    public function setLogin($id, $username, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function expose() {
        return get_object_vars($this);
    }
}