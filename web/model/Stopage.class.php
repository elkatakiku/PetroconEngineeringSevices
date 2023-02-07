<?php

namespace Model;

class Stopage implements Expose {

    private string $id;
    private string $taskId;
    private string $desc;
    private string $start;
    private string $end;
    private string $createdAt;
    private string $last_update;

    /**
     * @param string $id
     * @param string $taskId
     * @param string $desc
     * @param string $start
     * @param string $end
     * @param string $createdAt
     * @param string $last_update
     */
    public function set(string $id, string $taskId, string $desc, string $start, string $end, string $createdAt, string $last_update)
    {
        $this->id = $id;
        $this->taskId = $taskId;
        $this->desc = $desc;
        $this->start = $start;
        $this->end = $end;
        $this->createdAt = $createdAt;
        $this->last_update = $last_update;
    }

    public function create(
        string $taskId, string $desc) {

        $this->set(
            uniqid("PTRCN-STPG-"), $taskId, $desc, '', '', '', ''
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTaskId(): string
    {
        return $this->taskId;
    }

    /**
     * @param string $taskId
     */
    public function setTaskId(string $taskId): void
    {
        $this->taskId = $taskId;
    }

    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     */
    public function setDesc(string $desc): void
    {
        $this->desc = $desc;
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
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
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

    public function expose() {

    }

    public static function build(
        $id, $desc, $orderNo, $status,
        $createdAt, $active, $projID
    ) {
        $task = new self;
        $task->set($id, $desc, $orderNo, $status, $createdAt, $active, $projID);
        return $task;
    }
}