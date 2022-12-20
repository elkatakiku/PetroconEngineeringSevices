<?php

class Project implements Expose {

    private $id;
    private $name;
    private $location;
    private $buildingNumber;
    private $purchaseOrder;
    private $awardDate;
    private $status;
    private $active;
    private $company;
    private $compRepresentative;
    private $compContact;

    public function setProject(
        $id, $name, $location, $buildingNumber, $purchaseOrder, $awardDate, $status, $active,
        $company, $compRepresentative, $compContact) {

        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->buildingNumber = $buildingNumber;
        $this->purchaseOrder = $purchaseOrder;
        $this->awardDate = $awardDate;
        $this->status = $status;
        $this->active = $active;
        $this->company = $company;
        $this->compRepresentative = $compRepresentative;
        $this->compContact = $compContact;
    }

    public function createProject(
        $name, $location, $buildingNumber, $purchaseOrder, $awardDate, 
        $company, $compRepresentative, $compContact) {

        $this->setProject(
            uniqid("PTRCN-PRJCT-"), $name, $location, $buildingNumber, $purchaseOrder, $awardDate, false, true, 
            $company, $compRepresentative, $compContact
        );
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

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setBuildingNumber($buildingNumber) {
        $this->buildingNumber = $buildingNumber;
    }

    public function getBuildingNumber() {
        return $this->buildingNumber;
    }

    public function setPurchaseOrder($purchaseOrder) {
        $this->purchaseOrder = $purchaseOrder;
    }

    public function getPurchaseOrder() {
        return $this->purchaseOrder;
    }

    public function setAwardDate($awardDate) {
        $this->awardDate = $awardDate;
    }

    public function getAwardDate() {
        return $this->awardDate;
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

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompRepresentative($compRepresentative) {
        $this->compRepresentative = $compRepresentative;
    }

    public function getCompRepresentative() {
        return $this->compRepresentative;
    }

    public function setCompContact($compContact) {
        $this->compContact = $compContact;
    }

    public function getCompContact() {
        return $this->compContact;
    }

    public function expose() {
        
    }
}