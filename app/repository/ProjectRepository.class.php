<?php

namespace Repository;

use Core\Repository;

use \Model\Project as Project;
use \Model\Task as Task;
use \Model\Legend as Legend;
use \Model\TaskBar as TaskBar;

use \PDO;
use \PDOException;

class ProjectRepository extends Repository {

    private static $tblProject = "tbl_project";
    private static $tblTask = "tbl_task";
    private static $tblTaskBar = "tbl_taskbar";
    private static $tblLegend = "tbl_legend";
    private static $lnkProjectPlan = "lnk_project_plan";


    // Project
    public function setProject(Project $project) {
        $sql = "INSERT INTO ".self::$tblProject."
                    (id, name, location, building_number, status, active, purchase_ord, award_date,
                    company, comp_representative, comp_contact)
                VALUES
                    (:id, :name, :location, :building_number, :status, :active, :purchase_ord, :award_date,
                    :company, :comp_representative, :comp_contact)";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindValue(':id', $project->getId());
        $stmt->bindValue(':name', $project->getName());
        $stmt->bindValue(':location', $project->getLocation());
        $stmt->bindValue(':building_number', $project->getBuildingNumber());
        $stmt->bindValue(':status', $project->getStatus());
        $stmt->bindValue(':active', $project->getActive());
        $stmt->bindValue(':purchase_ord', $project->getPurchaseOrder());
        $stmt->bindValue(':award_date', $project->getAwardDate());
        $stmt->bindValue(':company', $project->getCompany());
        $stmt->bindValue(':comp_representative', $project->getCompRepresentative());
        $stmt->bindValue(':comp_contact', $project->getCompContact());

        $result = false;

        if($stmt->execute()) {
            // Closes pdo connection
            $result = true;
        }
        
        $stmt = null;
        return $result;
    }

    public function getProject($id) {

        $sql = 'SELECT 
                    id, purchase_ord, DATE_FORMAT(award_date, "%Y-%m-%d") as award_date, 
                    name, location, building_number, status, company, comp_representative, 
                    comp_contact, active
                FROM   
                    '.self::$tblProject.'
                WHERE 
                    id = :projID';

        // Prepare statement
        $stmt = $this->connect()->prepare($sql);

        // Bind params
        $stmt->bindParam(":projID", $id);
 
        $result = false;

        // Execute statement
        if($stmt->execute()) {
            $result = $stmt->fetch();
        }
        
        // Closes pdo connection
        $stmt = null;
        return $result;
    }

    public function getProjects($status) {
        // Query
        $sql = "SELECT *
                FROM ".self::$tblProject;

        // Modify Query
        if ($status) {
            $sql .= " WHERE status = :status";
        }

        // Prepare
        $stmt = $this->connect()->prepare($sql);

        // Bind
        if ($status) {
            $stmt->bindParam(":status", $status);
        }

        // Execute
        try {
            if(!$stmt->execute()) {
                throw new PDOException("Error Processing Request", 1);
            }

            $result = $stmt->fetchAll();
        } catch (PDOException $PDOE) {
            $result = -1;
        }

        // Return result
        return $result;
    }


    // Task
    public function setTask(Task $task) {
        $sql = "INSERT INTO ".self::$tblTask."
                    (id, description, order_no, status, proj_id)
                VALUES
                    (:id, :description, :order_no, :status, :proj_id)";
        
        $stmt = $this->connect()->prepare($sql);

        $stmt->bindValue(':id', $task->getId());
        $stmt->bindValue(':description', $task->getDesc());
        $stmt->bindValue(':order_no', $task->getOrder());
        $stmt->bindValue(':status', $task->getStatus());
        $stmt->bindValue(':proj_id', $task->getProjID());

        $result = true;

        if(!$stmt->execute()) {
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    public function getTasks($projectId) {
        $sql = "SELECT 
                    id, description, order_no, status
                FROM 
                    ".self::$tblTask." 
                WHERE 
                    proj_id = :proj_id";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(":proj_id", $projectId);

        try {
            if(!$stmt->execute()) {
                throw new PDOException("Error Processing Sql Statement", 1);
            }
            $result = $stmt->fetchAll();
        } catch (PDOException $PDOE) {
            $result = -1;
        }

        $stmt = null;
        return $result;
    }

    public function getTasksCount($projectId) {
        $sql = "SELECT 
                    COUNT(*) AS count
                FROM 
                    ".self::$tblTask." 
                WHERE 
                    proj_id = :proj_id";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(":proj_id", $projectId);

        try {
            if(!$stmt->execute()) {
                throw new PDOException("Error Processing Sql Statement", 1);
            }
            $result = $stmt->fetchAll()[0]['count'];
        } catch (PDOException $PDOE) {
            $result = -1;
        }

        $stmt = null;
        return $result;
    }


    // Legend
    public function setLegend(Legend $legend) {
        $sql = "INSERT INTO ".self::$tblLegend."
                    (id, color, title, proj_id)
                VALUES
                    (:id, :color, :title, :proj_id)";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindValue(':id', $legend->getId());
        $stmt->bindValue(':color', $legend->getColor());
        $stmt->bindValue(':title', $legend->getTitle());
        $stmt->bindValue(':proj_id', $legend->getProjID());

        $result = true;

        if(!$stmt->execute()) {
            // Closes pdo connection
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    public function getLegends($projectId) {
        $sql = "SELECT id, color, title
                FROM ".self::$tblLegend."
                WHERE proj_id = :proj_id";
        
        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(":proj_id", $projectId);

        try {
            if(!$stmt->execute()) {
                throw new PDOException("Error Processing Sql Statement", 1);
            }
            $result = $stmt->fetchAll();
        } catch (PDOException $PDOE) {
            $result = -1;
        }

        $stmt = null;
        return $result;
    }

    // TaskBar
    public function setTaskBar(TaskBar $taskBar) {
        $sql = "INSERT INTO ".self::$tblTaskBar."
                    (id, task_id, leg_id, start, end)
                VALUES
                    (:id, :task_id, :leg_id, :start, :end)";
        
        $stmt = $this->connect()->prepare($sql);

        $stmt->bindValue(':id', $taskBar->getId());
        $stmt->bindValue(':task_id', $taskBar->getTaskId());
        $stmt->bindValue(':leg_id', $taskBar->getLegendId());
        $stmt->bindValue(':start', $taskBar->getStart());
        $stmt->bindValue(':end', $taskBar->getEnd());

        $result = true;

        if(!$stmt->execute()) {
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    public function getTaskBars($taskId) {
        $sql = "SELECT *
                FROM ".self::$tblTaskBar."
                WHERE task_id = :task_id";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(':task_id', $taskId);

        $result = false;

        if($stmt->execute()) {
            $result = $stmt->fetchAll();
        }
        
        // Closes pdo connection
        $stmt = null;
        return $result;
    }

    public function getTaskActivities($taskId) {
        $sql = "SELECT tb.id, l.id AS legendId, l.title,  l.color, DATE_FORMAT(tb.start, '%Y-%m-%d') AS 'start', DATE_FORMAT(tb.end, '%Y-%m-%d') AS 'end'
                FROM ".self::$tblTask." t
                    INNER JOIN ".self::$tblTaskBar." tb
                        ON t.id = tb.task_id
                    INNER JOIN ".self::$tblLegend." l
                        ON tb.leg_id = l.id
                WHERE 
                    t.id = :id";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(':id', $taskId);
        
        try {
            if(!$stmt->execute()) {
                throw new PDOException("Error Processing Sql Statement", 1);
            }
            $result = $stmt->fetchAll();
        } catch (PDOException $PDOE) {
            $result = -1;
        }

        $stmt = null;
        return $result;
    }


    // Project Plan
    public function setProjectPlan($projectId, $planId) {
        $sql = "INSERT INTO ".self::$lnkProjectPlan."
                    (proj_id, leg_id)
                VALUES
                    (:proj_id, :leg_id)";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(':proj_id', $projectId);
        $stmt->bindParam(':leg_id', $planId);

        $result = true;

        if(!$stmt->execute()) {
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    public function getPlanId($projectId) {
        $sql = "SELECT leg_id AS plan
                FROM ".self::$lnkProjectPlan."
                WHERE proj_id = :proj_id";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(':proj_id', $projectId);

        $result = false;

        if($stmt->execute()) {
            $result = $stmt->fetchAll()[0]['plan'];
        }
        
        // Closes pdo connection
        $stmt = null;
        return $result;
    }

    
    // Timeline
    public function getTimeline($projectId) {

        
    }

    private function getTaskBar() {
        $sql = "SELECT 
                    tb.tbar_ID, tb.tbar_start, tb.tbar_end, 
                    l.leg_Color, l.leg_Title
                FROM ".self::$tblTask." t
                    INNER JOIN ".self::$tblTaskBar." tb
                        ON t.task_ID = tbar_task_ID
                    INNER JOIN ".self::$tblLegend." l
                        ON tbar_leg_ID = leg_ID
                WHERE task_proj_ID = :projID";
        
        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(":projID", $projectId);

        if (!$stmt->execute()) {

            return false;
        }

        $taskBars = $stmt->fetchAll();

        var_dump($taskBars);
    }
    
    private function executeReturn($stmt) {
        try {
            if(!$stmt->execute()) {
                throw new PDOException("Error Processing Sql Statement", 1);
            }
            $result = $stmt->fetchAll();
        } catch (PDOException $PDOE) {
            $result = -1;
        }

        return $result;
    }

}