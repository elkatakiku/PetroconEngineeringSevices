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

    public function setLegend($id, $name, $email, $code, $projID, $used) {

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->code = $code;
        $this->projID = $projID;
        $this->used = $used;
    }

    public function create(string $name, string $email, string $code, string $projID) {
        $this->setLegend(uniqid("PTRCN-LGND-"), $name, $email, $code, $projID, false);
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

    public function expose() {
        
    }
}