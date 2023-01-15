<?php

namespace Model;

class Payment implements Expose {

    private $id;
    private $description;
    private $amount;
    private $sent_at;
    private $proj_id;
    private $active;

    public function set(
        $id, $description, $amount, $sent_at, $proj_id, $active) {

        $this->id = $id;
        $this->description = $description;
        $this->amount = $amount;
        $this->sent_at = $sent_at;
        $this->proj_id = $proj_id;
        $this->active = $active;
    }

    public function create(
        $description, $amount, $sent_at, $proj_id) {

        $this->set(
            uniqid("PTRCN-PYMNT-"), $description, $amount, $sent_at, 
            $proj_id, true
        );
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setSentAt($sent_at) {
        $this->sent_at = $sent_at;
    }

    public function getSentAt() {
        return $this->sent_at;
    }

    public function setProjectId($proj_id) {
        $this->proj_id = $proj_id;
    }

    public function getProjectId() {
        return $this->proj_id;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getActive() {
        return $this->active;
    }

    public function expose() {
        
    }
}