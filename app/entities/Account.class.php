<?php

class Account implements Expose {

    const ADMIN_TYPE = "PTRCN-TYPE-20221";
    const EMPLOYEE_TYPE = "PTRCN-TYPE-20222";
    const WORKER_TYPE = "PTRCN-TYPE-20223";
    const CLIENT_TYPE = "PTRCN-TYPE-20224";

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
}