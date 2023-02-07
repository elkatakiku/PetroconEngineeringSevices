<?php

namespace Model;

class Project {

    private string $id;
    private string $description;
    private string $location;
    private string $buildingNumber;
    private string $purchaseOrder;
    private string $awardDate;
    private string $start;
    private string $end;
    private bool $status;
    private bool $active;
    private string $company;
    private string $representative;
    private string $contact;

    /**
     * @param string $id
     * @param string $description
     * @param string $location
     * @param string $buildingNumber
     * @param string $purchaseOrder
     * @param string $awardDate
     * @param string $start
     * @param string $end
     * @param bool $status
     * @param bool $active
     * @param string $company
     * @param string $representative
     * @param string $contact
     */
    public function set(string $id, string $description, string $location, string $buildingNumber, string $purchaseOrder, string $awardDate, string $start, string $end, bool $status, bool $active, string $company, string $representative, string $contact)
    {
        $this->id = $id;
        $this->description = $description;
        $this->location = $location;
        $this->buildingNumber = $buildingNumber;
        $this->purchaseOrder = $purchaseOrder;
        $this->awardDate = $awardDate;
        $this->start = $start;
        $this->end = $end;
        $this->status = $status;
        $this->active = $active;
        $this->company = $company;
        $this->representative = $representative;
        $this->contact = $contact;
    }

    public function create(
        $name, $location, $buildingNumber, $purchaseOrder, $awardDate, $start, $end,
        $company, $representative, $contact) {

        $this->set(
            uniqid("PTRCN-PRJCT-"), $name, $location, $buildingNumber, $purchaseOrder, $awardDate, $start, $end,
            false, true, $company, $representative, $contact
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

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start;
    }

    /**
     * @param string $start
     */
    public function setStart(string $start): void
    {
        $this->start = $start;
    }

    /**
     * @return string
     */
    public function getEnd(): string
    {
        return $this->end;
    }

    /**
     * @param string $end
     */
    public function setEnd(string $end): void
    {
        $this->end = $end;
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
}