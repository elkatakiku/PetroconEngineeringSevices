<?php

class ProjectModel extends Model {

    private static $tblProject = "tbl_project";
    private static $tblClient = "tbl_client";
    private static $tblTask = "tbl_task";
    private static $tblTaskBar = "tbl_taskbar";
    private static $tblLegend = "tbl_legend";

    private $projectId;

    public function setProjectId($projectId) {
        $this->projectId = $projectId;
    }

    public function setProject(
        $id, $name, $location, $buildingNumber, $purchaseOrder, $awardDate, $status, $active,
        $company, $compRepresentative, $compContact) {
        
        echo "Inserting project into database";

        $sql = "INSERT INTO ".self::$tblProject."
                    (id, name, location, building_number, status, active, purchase_ord, award_date,
                    company, comp_representative, comp_contact)
                VALUES
                    (:id, :name, :location, :building_number, :status, :active, :purchase_ord, :award_date,
                    :company, :comp_representative, :comp_contact)";

        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':building_number', $buildingNumber);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':purchase_ord', $purchaseOrder);
        $stmt->bindParam(':award_date', $awardDate);
        $stmt->bindParam(':company', $company);
        $stmt->bindParam(':comp_representative', $compRepresentative);
        $stmt->bindParam(':comp_contact', $compContact);
        
        $stmt->execute();
    }

    public function getProject() {

        echo "Getting project <pre>";

        $sqlProject = "SELECT 
                            p.proj_NAME, p.proj_DESC, p.proj_LOC, p.proj_blgd_num, p.proj_status
                        FROM   
                            ".self::$tblProject." p INNER JOIN ".self::$tblClient." c
                        ON 
                            p.proj_client_ID = c.clnt_ID
                        WHERE 
                            proj_ID = :projID";

        // Prepare statement
        $stmtProject = $this->connect()->prepare($sqlProject);

        // Bind params
        $stmtProject->bindParam(":projID", $this->projectId);

        // Execute statement
        if($stmtProject->execute()) {
            return false;
        }

        $project = $stmtProject->fetchAll();

        var_dump($project);
    }

    private function getClient() {
        // Client
        $sqlClient = "  SELECT 
                            c.clnt_name, c.clnt_company, c.clnt_contact_num, c.clnt_email
                        FROM 
                            ".self::$tblProject." p INNER JOIN ".self::$tblClient." c
                        ON 
                            p.proj_client_ID = c.clnt_ID
                        WHERE 
                            proj_ID = :projID";

        // Prepare statement
        $stmtClient = $this->connect()->prepare($sqlClient);

        // Bind params
        $stmtClient->bindParam(":projID", $projectId);

        // Execute statement
        if(!$stmtClient->execute()) {
            return false;
        }

        $client = $stmtClient->fetchAll();

        var_dump($client);
    }

    private function getTasks() {
        $sql = "SELECT task_ID, task_NAME, task_order_no, task_STATUS
                FROM ".self::$tblTask."
                WHERE task_proj_ID = :projID";
        
        $stmt = $this->connect()->prepare($sql);

        $stmt->bindParam(":projID", $this->projectId);

        if (!$stmt->execute()) {
            return false;
        }

        $tasks = $stmt->fetchAll();

        var_dump($tasks);
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

}