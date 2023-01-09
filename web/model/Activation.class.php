<?php

namespace Model;

class Activation implements Expose {

    private $id;
    private $code;
    private $sent_at;
    private $acc_id;

    public function set($id, $code, $sent_at, $acc_id) {
        $this->id = $id;
        $this->code = $code;
        $this->sent_at = $sent_at;
        $this->acc_id = $acc_id;
    }

    public function create($code, $acc_id) {

        $this->set(
            uniqid("PTRCN-ACTVTN-"), $code, '', $acc_id
        );
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setCode($code) {
        $this->code = $code;
    }
    
    public function getCode() {
        return $this->code;
    }

    public function setSentAt($sent_at) {
        $this->sent_at = $sent_at;
    }
    
    public function getSentAt() {
        return $this->sent_at;
    }

    public function setAccId($acc_id) {
        $this->acc_id = $acc_id;
    }

    public function getAccId() {
        return $this->acc_id;
    }

    public function expose() {
        return get_object_vars($this);
    }

    public static function build($id, $code, $sent_at, $acc_id) {
        $activation = new self;
        $activation->set($id, $code, $sent_at, $acc_id);
        return $activation;
    }
}