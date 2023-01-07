<?php

namespace Model;

class Resource implements Expose {

    private $id;
    private $item;
    private $quantity;
    private $price;
    private $total;
    private $notes;
    private $proj_id;
    private $active;

    public function create($item, $quantity, $price, $total, $notes, $proj_id) {
        
        $this->set(uniqid("PTRCN-RSRC-"), $item, $quantity, $price, $total, $notes, $proj_id, true);
    }

    public function set(
        $id, $item, $quantity, $price, $total, $notes, $proj_id, $active) {
        
        $this->id = $id;
        $this->item = $item;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->total = $total;
        $this->notes = $notes;
        $this->proj_id = $proj_id;
        $this->active = $active;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setItem($item) {
        $this->item = $item;
    }
    
    public function getItem() {
        return $this->item;
    }
    
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
    
    public function getQuantity() {
        return $this->quantity;
    }

    public function setPrice($price) {
        $this->price = $price;
    }
    
    public function getPrice() {
        return $this->price;
    }

    public function setTotal($total) {
        $this->total = $total;
    }
    
    public function getTotal() {
        return $this->total;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }
    
    public function getNotes() {
        return $this->notes;
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
        return get_object_vars($this);
    }
}
