<?php

namespace Repository;

use Core\Repository;
use Model\Project as Project;

class ProjectRepository extends Repository {

    private static string $tblProject = "tbl_project";
    private static string $lnkProjectTeam = "lnk_project_team";

    public function getAllProjectCount()
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
                    (id, description, location, building_number, done, active, purchase_ord, award_date, start, end, 
                    company, comp_representative, comp_contact)
                VALUES
                    (:id, :description, :location, :building_number, :done, :active, :purchase_ord, :award_date, :start, :end, 
                    :company, :comp_representative, :comp_contact)";

        $params = [
            ':id' => $project->getId(),
            ':description' => $project->getDescription(),
            ':location' => $project->getLocation(),
            ':building_number' => $project->getBuildingNumber(),
            ':done' => $project->getStatus(),
            ':active' => $project->getActive(),
            ':purchase_ord' => $project->getPurchaseOrder(),
            ':award_date' => $project->getAwardDate(),
            ':start' => $project->getStart(),
            ':end' => $project->getEnd(),
            ':company' => $project->getCompany(),
            ':comp_representative' => $project->getRepresentative(),
            ':comp_contact' => $project->getContact()
        ];
        
        return $this->query($sql, $params);
    }

    public function getProject($id) 
    {
        $sql = 'SELECT 
                    *, DATE_FORMAT(award_date, "%Y-%m-%d") as award_date,
                    DATE_FORMAT(start, "%Y-%m-%d") as start,
                    DATE_FORMAT(end, "%Y-%m-%d") as end
                FROM   
                    '.self::$tblProject.'
                WHERE 
                    id = :projID';
        
        $params = [":projID" => $id];

        return $this->query($sql, $params);
    }

//    List
    public function getProjects($status) {

        $params = [':active' => true];

        // Query
        if (($status != 1 && $status != 0) || $status == "all") 
        {   // Selects all active projects
            $sql = "SELECT *
                FROM ".self::$tblProject."
                WHERE active = :active
                ORDER BY created_at DESC";
        }
        else
        {   // Selects all projects with a matching status
            $sql = "SELECT *
                FROM ".self::$tblProject."
                WHERE active = :active  AND done = :done
                ORDER BY created_at DESC";

            $params[':done'] = $status;
        }

        return $this->query($sql, $params);
    }

    public function getJoinedProjects(string $accountId, string $status) {
        $sql = "SELECT p.*, DATE_FORMAT(t.joined_at, '%m/%d/%Y | %h:%i %p') AS 'date'
                FROM ".self::$lnkProjectTeam." t
                INNER JOIN tbl_project p ON p.id = t.proj_id
                WHERE acct_id = :acct_id ".
                ((($status != 1 && $status != 0) || $status == "all") ? "" : " AND done = " . $status)."
                ORDER BY p.created_at DESC";

        $params = [':acct_id' => $accountId];

        return $this->query($sql, $params);
    }

//    Update
    public function update($project) {
        $sql = 'UPDATE 
                    '.self::$tblProject.'
                SET 
                    description = :name, 
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

    public function markAsDone($id, $status) {
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

    // Join people to project
    public function joinProject(string $projId, string $acctId)
    {
        $sql = "INSERT INTO ".self::$lnkProjectTeam."
                    (acct_id, proj_id)
                VALUES
                    (:acct_id, :proj_id)";
        
        $params = [
            ':acct_id' => $acctId,
            ':proj_id' => $projId
        ];

        // Result
        return $this->query($sql, $params);
    }

    //    Gets start and end dates of a project
    public function getCompletionDate(string $projectId)
    {
        $sql = "SELECT DATE_FORMAT(start, '%Y-%m-%d') AS 'start', DATE_FORMAT(end, '%Y-%m-%d') AS 'end'
                FROM tbl_project
                WHERE id = :proj_id AND active = :active";

        $params = [':proj_id' => $projectId, ':active' => true];

        return $this->query($sql, $params);
    }
}