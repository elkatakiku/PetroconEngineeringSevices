<?php

namespace Model;

class Invitation implements Expose {

    private $id;
    private $name;
    private $email;
    private $code;
    private $projID;
    private $used;
    private $created_at;
    private $username;
    private $password;

    public function set($id, $name, $email, $code, $projID, $used, $username, $password) {

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->code = $code;
        $this->projID = $projID;
        $this->used = $used;
        $this->username = $username;
        $this->password = $password;
    }

    public function create(string $name, string $email, string $code, string $projID,
                           string $username, string $password) {
        $this->set(
            uniqid("PTRCN-INVTTN-"),
            $name, $email, $code, $projID, false,
            $username, $password);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function getCode() {
        return $this->code;
    }

    public function setProjID($projID) {
        $this->projID = $projID;
    }

    public function getProjectId() {
        return $this->projID;
    }

    public function setUsed($used) {
        $this->used = $used;
    }

    public function isUsed() {
        return $this->used;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function expose() {
        
    }
}