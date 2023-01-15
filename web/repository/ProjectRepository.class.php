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
    private static $lnkProjectTeam = "lnk_project_team";

    public function getProjectCount()
    {
        $sql = "SELECT done, COUNT(*) AS count
                FROM ".self::$tblProject."
                GROUP BY done";

        return $this->query($sql);
    }

    public function projectsInYear(string $year)
    {
        $sql = "SELECT MONTH(created_at) AS 'month', COUNT(*) AS 'count'
                FROM ".self::$tblProject." 
                WHERE YEAR(created_at) = :year
                GROUP BY MONTH(created_at) DESC";

        $params = [':year' => $year];

        return $this->query($sql, $params);
    }

    public function getYears()
    {
        $sql = "SELECT MIN(YEAR(created_at)) AS 'year'
                FROM ".self::$tblProject;
                // GROUP BY YEAR(created_at) DESC

        return $this->query($sql);
    }

    // Project
    public function setProject(Project $project) {
        $sql = "INSERT INTO ".self::$tblProject."
                    (id, description, location, building_number, done, active, purchase_ord, award_date,
                    company, comp_representative, comp_contact)
                VALUES
                    (:id, :description, :location, :building_number, :done, :active, :purchase_ord, :award_date,
                    :company, :comp_representative, :comp_contact)";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindValue(':id', $project->getId());
        $stmt->bindValue(':description', $project->getName());
        $stmt->bindValue(':location', $project->getLocation());
        $stmt->bindValue(':building_number', $project->getBuildingNumber());
        $stmt->bindValue(':done', $project->getStatus());
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

    public function getProject($id) 
    {
        $sql = 'SELECT 
                    id, purchase_ord, DATE_FORMAT(award_date, "%Y-%m-%d") as award_date, 
                    description, location, building_number, done, company, comp_representative, 
                    comp_contact, active
                FROM   
                    '.self::$tblProject.'
                WHERE 
                    id = :projID';
        
        $params = [":projID" => $id];

        return $this->query($sql, $params);
    }

    public function getProjects($status) {

        $params = [':active' => true];

        // Query
        if (($status != 1 && $status != 0) || $status == "all") 
        {   // Selects all active projects
            $sql = "SELECT *
                FROM ".self::$tblProject."
                WHERE active = :active
                ORDER BY created_at DESC";
        } else 
        {   // Selects all projects with a matching status
            $sql = "SELECT *
                FROM ".self::$tblProject."
                WHERE active = :active AND done = :done
                ORDER BY created_at DESC";

            $params[':done'] = $status;
        }

        return $this->query($sql, $params);
    }

    public function update($project) {
        $sql = 'UPDATE 
                    '.self::$tblProject.'
                SET 
                    name = :name, 
                    location = :location, 
                    building_number = :building_number, 
                    purchase_ord = :purchase_ord, 
                    award_date = :award_date, 
                    company = :company, 
                    comp_representative = :comp_representative, 
                    comp_contact = :comp_contact
                WHERE 
                    id = :id';

        // Parameters' (:parameter) value
        $params = [
            ':id' => $project['id'],
            ':name' => $project['description'],
            ':location' => $project['location'],
            ':building_number' => $project['buildingNo'],
            ':purchase_ord' => $project['purchaseOrd'],
            ':award_date' => $project['awardDate'],
            ':company' => $project['company'],
            ':comp_representative' => $project['representative'],
            ':comp_contact' => $project['contact']
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function mark($id, $status) {
        $sql = 'UPDATE 
                    '.self::$tblProject.'
                SET 
                    done = :done
                WHERE 
                    id = :id';

        // Parameters' (:parameter) value
        $params = [
            ':id' => $id,
            ':done' => $status
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function delete(string $id) {
        $sql = 'UPDATE 
                    '.self::$tblProject.'
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
        $stmt->bindValue(':proj_id', $task->getProjectId());

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
        $stmt->bindValue(':proj_id', $legend->getProjectId());

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

    // Join people to project
    public function joinProject(string $projId, string $regId)
    {
        $sql = "INSERT INTO ".self::$lnkProjectTeam."
                    (acct_id, proj_id)
                VALUES
                    (:acct_id, :proj_id)";
        
        $params = [
            ':acct_id' => $regId,
            ':proj_id' => $projId
        ];

        // Result
        return $this->query($sql, $params);
    }

}