<?php

namespace Model;

class Task implements Expose {

    private $id;
    private $desc;
    private $orderNo;
    private $status;
    private $createdAt;
    private $active;
    private $projID;

    public function set(
        $id, $desc, $orderNo, $status, 
        $createdAt, $active, $projID) {

        $this->id = $id;
        $this->desc = $desc;
        $this->orderNo = $orderNo;
        $this->status = $status;
        $this->active = $active;
        $this->createdAt = $createdAt;
        $this->projID = $projID;
    }

    public function create(
        $desc, $orderNo, $projID) {

        $this->set(
            uniqid("PTRCN-TSK-"), $desc, $orderNo, false, 
            '', true, $projID
        );
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function setOrder($orderNo) {
        $this->orderNo = $orderNo;
    }

    public function getOrder() {
        return $this->orderNo;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getActive() {
        return $this->active;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setProjID($projID) {
        $this->projID = $projID;
    }

    public function getProjID() {
        return $this->projID;
    }

    public function expose() {
        
    }

    public static function build(
        $id, $desc, $orderNo, $status, 
        $createdAt, $active, $projID
    ) {
        $task = new self;
        $task->set($id, $desc, $orderNo, $status, $createdAt, $active, $projID);
        return $task;
    }
}