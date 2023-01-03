<?php

namespace Repository;

use Core\Repository;

use \Model\Task as Task;
use \Model\Legend as Legend;
use \Model\TaskBar as TaskBar;

use \PDO;
use \PDOException;

class TaskRepository extends Repository {

    private static $tblTask = "tbl_task";
    private static $tblTaskBar = "tbl_taskbar";
    private static $lnkProjectPlan = "lnk_project_plan";
    
    // Creates a task
    public function setTask(Task $task) {
        // Query string
        $sql = "INSERT INTO ".self::$tblTask."
                    (id, description, order_no, status, proj_id)
                VALUES
                    (:id, :description, :order_no, :status, :proj_id)";
        
        // Prepare
        $stmt = $this->connect()->prepare($sql);

        // Binds values to parameters (:parameter)
        $stmt->bindValue(':id', $task->getId());
        $stmt->bindValue(':description', $task->getDesc());
        $stmt->bindValue(':order_no', $task->getOrder());
        $stmt->bindValue(':status', $task->getStatus());
        $stmt->bindValue(':proj_id', $task->getProjID());

        // Validation and result
        $result = true;

        if(!$stmt->execute()) {
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    // Updates a task
    public function updateTask($id, $description) {
        // echo __METHOD__;
        
        // Query
        // , order_no = :order_no, status = :status
        $sql = 'UPDATE 
                    '.self::$tblTask.'
                SET 
                    description = :description
                WHERE 
                    id = :id';

        // Parameters' (:parameter) value
        $params = [
            ':description' => $description,
            // ':order_no' => $order_no,
            // ':status' => $status
            ':id' => $id
        ];

        // echo "<br>";
        // var_dump($params);
        
        // Result
        return $this->query($sql, $params);
    }

    // Deletes a task
    public function deleteTask(string $id) {
        
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
    public function getActiveTasks($id) {
        $planId = $this->getPlanId($id);

        $sql = "SELECT 
                    t.id, t.description, t.order_no, t.status, 
                    DATE_FORMAT(tb.start, '%m-%d-%Y') AS plan_start, DATE_FORMAT(tb.end, '%m-%d-%Y') AS plan_end
                FROM 
                    ".self::$tblTask." t INNER JOIN ".self::$tblTaskBar." tb
                ON
                    t.id = tb.task_id
                WHERE 
                    t.proj_id = :proj_id AND t.active = :active";
                    //  AND tb.leg_id = :leg_id";

        $params = [
            ":proj_id" => $id,
            ':active' => true
        ];
            // ":leg_id" => $planId

        return $this->query($sql, $params);
    }

    // Gets the number of tasks of a projects
    public function taskCount($projectId) {
        $sql = "SELECT 
                    COUNT(*) AS count
                FROM 
                    ".self::$tblTask." 
                WHERE 
                    proj_id = :proj_id";

        $params = [':proj_id' => $projectId];

        return $this->query($sql, $params, 1)[0]['count'];

        // $stmt = $this->connect()->prepare($sql);

        // $stmt->bindParam(":proj_id", $projectId);

        // try {
        //     if(!$stmt->execute()) {
        //         throw new PDOException("Error Processing Sql Statement", 1);
        //     }
        //     $result = $stmt->fetchAll()[0]['count'];
        // } catch (PDOException $PDOE) {
        //     $result = -1;
        // }

        // $stmt = null;
        // return $result;
    }

    // Gets the plan legend id of a project
    public function getPlanId($id) {
        $sql = "SELECT 
                    leg_id AS plan
                FROM 
                    ".self::$lnkProjectPlan."
                WHERE 
                    proj_id = :proj_id";

        return $this->query($sql, [':proj_id' => $id])[0]['plan'];
    }

}