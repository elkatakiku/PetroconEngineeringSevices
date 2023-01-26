<?php

namespace Model;

class Project implements Expose {

    private string $id;
    private string $description;
    private string $location;
    private string $buildingNumber;
    private string $purchaseOrder;
    private string $awardDate;
    private bool $status;
    private bool $active;
    private string $company;
    private string $representative;
    private string $contact;

    public function set(
        $id, $name, $location, $buildingNumber, $purchaseOrder, $awardDate, $status, $active,
        $company, $representative, $contact) {

        $this->id = $id;
        $this->description = $name;
        $this->location = $location;
        $this->buildingNumber = $buildingNumber;
        $this->purchaseOrder = $purchaseOrder;
        $this->awardDate = $awardDate;
        $this->status = $status;
        $this->active = $active;
        $this->company = $company;
        $this->representative = $representative;
        $this->contact = $contact;
    }

    public function create(
        $name, $location, $buildingNumber, $purchaseOrder, $awardDate, 
        $company, $representative, $contact) {

        $this->set(
            uniqid("PTRCN-PRJCT-"), $name, $location, $buildingNumber, $purchaseOrder, $awardDate, false, true, 
            $company, $representative, $contact
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

    public function setRepresentative($representative) {
        $this->representative = $representative;
    }

    public function getRepresentative() {
        return $this->representative;
    }

    public function setContact($contact) {
        $this->contact = $contact;
    }

    public function getContact() {
        return $this->contact;
    }

    public function expose() {
        
    }

    public static function build(
        $id, $name, $location, $buildingNumber, $purchaseOrder, $awardDate, $status, $active,
        $company, $compRepresentative, $compContact) {
        
        $project = new self;
        $project->set(
            $id, 
            $name, 
            $location, 
            $buildingNumber, 
            $purchaseOrder, 
            $awardDate, 
            $status, 
            $active, 
            $company, 
            $compRepresentative, 
            $compContact
        );

        return $project;
    }
}