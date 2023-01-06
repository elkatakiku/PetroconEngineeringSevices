<?php

namespace Repository;

use Core\Repository;

use \Model\Task as Task;
use \Model\Legend as Legend;
use \Model\TaskBar as TaskBar;

use \PDO;
use \PDOException;

class ActivityRepository extends Repository {

    private static $tblTaskBar = "tbl_taskbar";
    private static $tblTask = "tbl_task";
    private static $tblLegend = "tbl_legend";

    public function getActiveActivities($id) {

        $sql = "SELECT 
                    tb.id, 
                    l.id AS legendId, 
                    CASE 
                        WHEN l.active = 0 THEN 'Activity'
                        WHEN l.active = 1 THEN l.title
                    END AS 'title',
                    CASE 
                        WHEN l.active = 0 THEN '#a5a3aa'
                        WHEN l.active = 1 THEN l.color
                    END AS 'color',  
                    DATE_FORMAT(tb.start, '%Y-%m-%d') AS 'start', 
                    DATE_FORMAT(tb.end, '%Y-%m-%d') AS 'end'

                FROM ".self::$tblTask." t
                    INNER JOIN ".self::$tblTaskBar." tb
                        ON t.id = tb.task_id
                    INNER JOIN ".self::$tblLegend." l
                        ON tb.leg_id = l.id
                WHERE 
                    t.id = :id AND tb.active = :tbactive";

        $params = [
            ':id' => $id,
            ':tbactive' => true
            // ':lactive' => true
        ];

        return $this->query($sql, $params);
    }

    public function setActivities($activities) {

        // Query
        $sql = "INSERT INTO ".self::$tblTaskBar."
                    (id, task_id, leg_id, start, end)
                VALUES
                    ";

        // Modify query based on number of activities
        for ($i=0; $i < count($activities); $i++) {
            $sql .= "(:id{$i}, :task_id{$i}, :leg_id{$i}, :start{$i}, :end{$i}),";
        }

        // Removes comma from end of query string
        $sql = rtrim($sql, ",");

        $params = [];

        // Sets parameters
        for ($i=0; $i < count($activities); $i++) {
            $params[":id{$i}"] = $activities[$i]->getId();
            $params[":task_id{$i}"] = $activities[$i]->getTaskId();
            $params[":leg_id{$i}"] = $activities[$i]->getLegendId();
            $params[":start{$i}"] = $activities[$i]->getStart();
            $params[":end{$i}"] = $activities[$i]->getEnd();
        }

        return $this->query($sql, $params);
    }

    public function updateActivities($activities) {
        
        $sql = 'UPDATE 
                    '.self::$tblTaskBar.'
                SET 
                    start = :start, end = :end, active = :active
                WHERE 
                    id = :id';

        $result = true;

        // Query every activities modified
        for ($i=0; $i < count($activities); $i++) 
        {
            // Sets parameters
            $params = [
                'id' => $activities[$i][0],
                'start' => $activities[$i][1],
                'end' => $activities[$i][2],
                'active' => $activities[$i][3],
            ];
            
            if (!$this->query($sql, $params)) {
                $result = false;
            }
        }

        return $result;
    }

}