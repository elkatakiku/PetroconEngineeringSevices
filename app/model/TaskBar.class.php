<?php

namespace Model;

class TaskBar implements Expose {

    private $id;
    private $taskID;
    private $legID;
    private $start;
    private $end;
    private $createdAt;
    private $active;

    public function set(
        $id, $taskID, $legID, $start, $end,
        $createdAt, $active) {

        $this->id = $id;
        $this->taskID = $taskID;
        $this->legID = $legID;
        $this->start = $start;
        $this->end = $end;
        $this->createdAt = $createdAt;
        $this->active = $active;
    }

    public function create(
        $taskID, $legID, $start, $end) {

        $this->set(
            uniqid("PTRCN-TSKBR-"), $taskID, $legID, $start, 
            $end, '', true
        );
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setTaskId($taskID) {
        $this->taskID = $taskID;
    }

    public function getTaskId() {
        return $this->taskID;
    }

    public function setLegendId($legID) {
        $this->legID = $legID;
    }

    public function getLegendId() {
        return $this->legID;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function getStart() {
        return $this->start;
    }

    public function setEnd($end) {
        $this->end = $end;
    }

    public function getEnd() {
        return $this->end;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
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