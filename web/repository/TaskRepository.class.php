<?php

namespace Repository;

use Core\Repository;

use Model\Stopage;
use \Model\Task as Task;

class TaskRepository extends Repository {

    private static $tblTask = "tbl_task";
    private static $tblStoppage = "tbl_stopage";
    
    // Creates a task
    public function setTask(Task $task) {
        // Query string
        $sql = "INSERT INTO ".self::$tblTask."
                    (id, description, start, end, order_no, proj_id)
                VALUES
                    (:id, :description, :start, :end, :order_no, :proj_id)";
        
        $params = [
            ':id' => $task->getId(),
            ':description' => $task->getDesc(),
            ':start' => $task->getStart(),
            ':end' => $task->getEnd(),
            ':order_no' => $task->getOrderNo(),
            ':proj_id' => $task->getProjectId()
        ];

        return $this->query($sql, $params);
    }

    // Updates a task
    public function updateTask(array $task, bool $stopped)
    {
        $sql = 'UPDATE 
                    '.self::$tblTask.'
                SET 
                    description = :description, start = :start, end = :end, progress = :progress, stopped = :stopped
                WHERE 
                    id = :id';

        $params = [
            ':description' => $task['description'],
            ':start' => $task['start'],
            ':end' => $task['end'],
            ':progress' => $task['progress'],
            ':stopped' => $stopped ? 1 : 0,
            ':id' => $task['id']
        ];
        
        // Result
        return $this->query($sql, $params);
    }

    public function updateProgress(array $task)
    {
        $sql = 'UPDATE 
                    '.self::$tblTask.'
                SET 
                    progress = :progress
                WHERE 
                    id = :id';

        $params = [
            ':progress' => $task['progress'],
            ':id' => $task['id']
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function haltTask(string $taskId, bool $stopped)
    {
        $sql = 'UPDATE 
                    '.self::$tblTask.'
                SET 
                    stopped = :stopped 
                WHERE 
                    id = :id';

        $params = [
            ':stopped' => $stopped,
            ':id' => $taskId
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function endStoppage(string $stoppageId, string $end)
    {
        $sql = 'UPDATE 
                    '.self::$tblStoppage.'
                SET 
                    end = :end 
                WHERE 
                    id = :id';

        $params = [
            ':end' => $end,
            ':id' => $stoppageId
        ];

        // Result
        return $this->query($sql, $params);
    }

    // Deletes a task
    public function removeTask(string $id)
    {
        $sql = 'UPDATE 
                    '.self::$tblTask.'
                SET 
                    active = :active
                WHERE 
                    id = :id';

        $params = [
            ':id' => $id,
            ':active' => false
        ];

        return $this->query($sql, $params);
    }

    // Gets all the tasks of a project
    public function getActiveTasks($id)
    {
        $sql = "SELECT *, DATE_FORMAT(start, '%Y-%m-%d') AS start, DATE_FORMAT(end, '%Y-%m-%d') AS end, DATE_FORMAT(last_update, '%m/%d/%Y | %h:%i %p') AS last_update
                FROM ".self::$tblTask." 
                WHERE proj_id = :proj_id AND active = :active";

        $params = [
            ":proj_id" => $id,
            ':active' => true
        ];

        return $this->query($sql, $params);
    }

    // Gets the number of tasks of a projects
    public function taskCount($projectId) {
        $sql = "SELECT 
                    COUNT(*) AS count
                FROM 
                    ".self::$tblTask." 
                WHERE 
                    proj_id = :proj_id AND active = :active
                LIMIT 1";

        $params = [':proj_id' => $projectId, ':active' => true];

        return $this->query($sql, $params)[0]['count'];
    }

//    || Stoppage
//    Creates stopage
    public function createStoppage(Stopage $stoppage) {
        $sql = "INSERT INTO ".self::$tblStoppage."
                    (id, task_id, description, end)
                VALUES
                     (:id, :task_id, :description, :end)";

        $params = [
            ':id' => $stoppage->getId(),
            ':task_id' => $stoppage->getTaskId(),
            ':description' => $stoppage->getDesc(),
            ':end' => $stoppage->getEnd()
        ];

        return $this->query($sql, $params);
    }

    public function getStoppage(string $taskId) {
        $sql = "SELECT 
                    *, DATE_FORMAT(start, '%Y-%m-%d') AS start, DATE_FORMAT(end, '%Y-%m-%d') AS end, DATE_FORMAT(last_update, '%m/%d/%Y | %h:%i %p') AS last_update
                FROM 
                    ".self::$tblStoppage."
                WHERE 
                    task_id  = :task_id";

        $params = [':task_id' => $taskId];

        return $this->query($sql, $params);
    }

    public function getTaskStoppage(string $taskId) {
        $sql = "SELECT * 
                FROM ".self::$tblStoppage." 
                WHERE task_id = :task_id
                ORDER BY start DESC";

        $params = [':task_id' => $taskId];

        return $this->query($sql, $params);
    }

    public function updateStoppage($haltId, array $halt, $haltEnd) {
        $sql = 'UPDATE 
                    '.self::$tblStoppage.'
                SET 
                    description = :description, start = :start, end = :end
                WHERE 
                    id = :id';

        $params = [
            ':id' => $haltId,
            ':description' => $halt['haltReason'],
            ':start' => $halt['haltStart'],
            ':end' => $haltEnd
        ];

        return $this->query($sql, $params);
    }

//  Gets project's progress
    public function getProgress(string $projectId) {
        $sql = "SELECT SUM(progress) AS 'progress', COUNT(*) AS 'count'
                FROM ".self::$tblTask." 
                WHERE proj_id = :proj_id AND active = :active";

        $params = [
            ":proj_id" => $projectId,
            ':active' => true
        ];

        return $this->query($sql, $params);
    }
}