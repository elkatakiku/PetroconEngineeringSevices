<?php

namespace Model;

class Reset implements Expose {

    private $id;
    private $logId ;
    private $createdAt;
    private $used;

    public function set(
        $id, $logId , $createdAt, $used) {

        $this->id = $id;
        $this->logId  = $logId ;
        $this->createdAt = $createdAt;
        $this->used = $used;
    }

    public function create(
        $logId) {

        $this->set(
            uniqid("PTRCN-RST-"), $logId , '', false
        );
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setLoginId($logId) {
        $this->logId  = $logId ;
    }

    public function getLoginId() {
        return $this->logId ;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
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