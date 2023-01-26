<?php

namespace Model;

class Account implements Expose {

    const ADMIN_TYPE = "PTRCN-TYPE-c821d24e";
    const EMPLOYEE_TYPE = "PTRCN-TYPE-4b9e178f";
    const CLIENT_TYPE = "PTRCN-TYPE-18c19c59";

    private $id;
    private $typeId;
    private $registerId;
    private $loginId;

    public function setAccount($id, $typeId, $registerId, $loginId) {
        $this->id = $id;
        $this->typeId = $typeId;
        $this->registerId = $registerId;
        $this->loginId = $loginId;
    }

    public function createAccount($typeId, $registerId, $loginId) {

        $this->setAccount(
            uniqid("PTRCN-ACCT-"), $typeId, $registerId, $loginId
        );
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setTypeId($typeId) {
        $this->typeId = $typeId;
    }
    
    public function getTypeId() {
        return $this->typeId;
    }

    public function setRegisterId($registerId) {
        $this->registerId = $registerId;
    }
    
    public function getRegisterId() {
        return $this->registerId;
    }

    public function setLoginId($loginId) {
        $this->loginId = $loginId;
    }

    public function getLoginId() {
        return $this->loginId;
    }

    public function expose() {
        return get_object_vars($this);
    }

    public static function build($id, $typeId, $registerId, $loginId) {
        $account = new self;
        $account->setAccount($id, $typeId, $registerId, $loginId);
        return $account;
    }
}