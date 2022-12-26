<?php

class ProjectModel extends Model {

    private static $tblProject = "tbl_project";
    private static $tblClient = "tbl_client";
    private static $tblTask = "tbl_task";
    private static $tblTaskBar = "tbl_taskbar";
    private static $tblLegend = "tbl_legend";
    private static $lnkProjectPlan = "lnk_project_plan";

    private $projectId;

    // Project
    public function setProject(Project $project) {
        
        echo "Inserting project into database";

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
        
        if(!$stmt->execute()) {
            $stmt = null;
            return false;
        }

        return true;
    }

    public function getProject($projectId) {

        $sqlProject = 'SELECT 
                            id, purchase_ord, DATE_FORMAT(award_date, "%Y-%m-%d") as award_date, name, location, building_number, status, company, comp_representative, comp_contact
                        FROM   
                            '.self::$tblProject.'
                        WHERE 
                            id = :projID';

        // Prepare statement
        $stmtProject = $this->connect()->prepare($sqlProject);

        // Bind params
        $stmtProject->bindParam(":projID", $projectId);

        // Execute statement
        if(!$stmtProject->execute()) {
            return false;
        }

        $project = $stmtProject->fetchAll();

        // var_dump($project);

        return $project[0];
    }

    public function getProjects($status) {
        // Query
        $sql = "SELECT id, name, location, company, status 
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
            $stmt = null;
            $result = false;
        }

        return $result;
    }

    public function getTasks($projectId) {
        $sql = "SELECT 
                    id, description, order_no, status
                FROM 
                    ".self::$tblTask." 
                WHERE 
                    proj_id = :proj_id";

        // echo $sql;

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

        $result = $this->executeReturn($stmt);

        if($result != -1) {
            $result = $result[0]['count'];
        }

        return $result;

    }

    // Legend
    public function setLegend(Legend $legend) {
        echo __METHOD__;
        echo '<br>';
        echo $legend->getTitle();
        echo '<br>';
        $sql = "INSERT INTO ".self::$tblLegend."
                    (id, color, title, proj_id)
                VALUES
                    (:id, :color, :title, :proj_id)";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindValue(':id', $legend->getId());
        $stmt->bindValue(':color', $legend->getColor());
        $stmt->bindValue(':title', $legend->getTitle());
        $stmt->bindValue(':proj_id', $legend->getProjID());
        
        echo '<br>';
        var_dump($stmt);
        echo '<br>';

        $result = true;

        if(!$stmt->execute()) {
            // Closes pdo connection
            $stmt = null;
            $result = false;
        }

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
            $stmt = null;
            $result = false;
        }

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
            $stmt = null;
            $result = false;
        }

        return $result;
    }

    public function getPlanId($projectId) {
        $sql = "SELECT leg_id AS plan
                FROM ".self::$lnkProjectPlan."
                WHERE proj_id = :proj_id";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(':proj_id', $projectId);

        $stmt->execute();

        return $stmt->fetchAll()[0]['plan'];
    }

    // Timeline
    public function getTimeline($projectId) {
        $planId = $this->getPlanId($projectId);
        $sql = "SELECT 
                    t.id, t.description, t.order_no, t.status, tb.start, tb.end
                FROM 
                    ".self::$tblTask." t INNER JOIN ".self::$tblTaskBar." tb
                ON
                    t.id = tb.task_id
                WHERE 
                    t.proj_id = :proj_id AND tb.leg_id = :leg_id";

        // echo $sql;

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(":proj_id", $projectId);
        $stmt->bindParam(":leg_id", $planId);

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

    private function getLegends() {
        $sql = "SELECT leg_Color, leg_Title
                FROM ".self::$tblLegend."
                WHERE leg_proj_ID = :projID";
        
        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(":projID", $this->projectId);

        if (!$stmt->execute()) {
            return false;
        }

        $legends = $stmt->fetchAll();

        var_dump($legends);
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

        $stmt->bindParam(":projID", $this->projectId);

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