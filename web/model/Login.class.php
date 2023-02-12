<?php

namespace Model;

class Login {

    private $id;
    private $username;
    private $password;

    public function create($username, $password) {
        $this->set(
            uniqid("PTRCN-USR-"), $username, password_hash($password, PASSWORD_DEFAULT)
        );
    }

    public function set($id, $username, $password) {
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

    public static function build($id, $username, $password) {
        $login = new self;
        $login->set($id, $username, $password);
        return $login;
    }
}