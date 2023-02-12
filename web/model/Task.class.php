<?php

namespace Model;

class Task {

    private string $id;
    private string $desc;
    private string $start;
    private string $end;
    private int $progress;
    private bool $stopped;
    private int $orderNo;
    private $status;
    private string $createdAt;
    private $active;
    private string $projID;
    private string $last_update;

    /**
     * @param string $id
     * @param string $desc
     * @param string $start
     * @param string $end
     * @param int $progress
     * @param bool $stopped
     * @param int $orderNo
     * @param $status
     * @param string $createdAt
     * @param $active
     * @param string $projID
     * @param string $last_update
     */
    public function set(string $id, string $desc, string $start, string $end, int $progress, bool $stopped,
                        int $orderNo, $status, string $createdAt, $active, string $projID, string $last_update)
    {
        $this->id = $id;
        $this->desc = $desc;
        $this->start = $start;
        $this->end = $end;
        $this->progress = $progress;
        $this->stopped = $stopped;
        $this->orderNo = $orderNo;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->active = $active;
        $this->projID = $projID;
        $this->last_update = $last_update;
    }

    public function create($projID, $orderNo, $desc, $start, $end) {

        $this->set(
            uniqid("PTRCN-TSK-"), $desc, $start, $end, 0, false, $orderNo, '',
            '', true, $projID, ''
        );
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function getDesc() {
        return $this->desc;
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

    /**
     * @return int
     */
    public function getProgress(): int
    {
        return $this->progress;
    }

    /**
     * @param int $progress
     */
    public function setProgress(int $progress): void
    {
        $this->progress = $progress;
    }

    /**
     * @return bool
     */
    public function isStopped(): bool
    {
        return $this->stopped;
    }

    /**
     * @param bool $stopped
     */
    public function setStopped(bool $stopped)   : void
    {
        $this->stopped = $stopped;
    }

    /**
     * @return int
     */
    public function getOrderNo(): int
    {
        return $this->orderNo;
    }

    /**
     * @param int $orderNo
     */
    public function setOrderNo(int $orderNo): void
    {
        $this->orderNo = $orderNo;
    }

    /**
     * @return string
     */
    public function getLastUpdate(): string
    {
        return $this->last_update;
    }

    /**
     * @param string $last_update
     */
    public function setLastUpdate(string $last_update): void
    {
        $this->last_update = $last_update;
    }

    public function setOrder($orderNo) {
        $this->orderNo = $orderNo;
    }

    public function getOrder() {
        return $this->orderNo;
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

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setProjID($projID) {
        $this->projID = $projID;
    }

    public function getProjectId() {
        return $this->projID;
    }
}