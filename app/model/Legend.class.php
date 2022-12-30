<?php

namespace Model;

class Legend implements Expose {

    const PLAN = "#026aa7";
    const ACTUAL = "#5aac44";

    private $id;
    private $color;
    private $title;
    private $createdAt;
    private $projID;

    public function setLegend(
        $id, $color, $title, $createdAt, $projID) {

        $this->id = $id;
        $this->color = $color;
        $this->title = $title;
        $this->createdAt = $createdAt;
        $this->projID = $projID;
    }

    public function createLegend(
        $color, $title, $projID) {

        $this->setLegend(
            uniqid("PTRCN-LGND-"), $color, ucwords($title), '', $projID
        );
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function getColor() {
        return $this->color;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
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
}