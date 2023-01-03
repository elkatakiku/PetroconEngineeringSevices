<?php

namespace Repository;

use Core\Repository;
use Model\Legend;

class LegendRepository extends Repository {

    private static $tblTaskBar = "tbl_taskbar";
    private static $tblTask = "tbl_task";
    private static $tblLegend = "tbl_legend";

    public function create(Legend $legend) {
        $sql = "INSERT INTO ".self::$tblLegend."
                    (id, color, title, proj_id)
                VALUES
                    (:id, :color, :title, :proj_id)";
        
        $params = [
            ':id' => $legend->getId(),
            ':color' => $legend->getColor(),
            ':title' => $legend->getTitle(),
            ':proj_id' => $legend->getProjID()
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function update(string $id, array $legend) {        
        // Query
        $sql = 'UPDATE 
                    '.self::$tblLegend.'
                SET 
                    color = :color, title = :title
                WHERE 
                    id = :id';

        // Parameters' (:parameter) value
        $params = [
            ':color' => $legend['color'],
            ':title' => $legend['title'],
            ':id' => $id
        ];
        
        // Result
        return $this->query($sql, $params);
    }

    public function remove(string $id) {
        // Query
        $sql = 'UPDATE 
                    '.self::$tblLegend.'
                SET 
                    active = :active
                WHERE 
                    id = :id';

        // Parameters' (:parameter) value
        $params = [
            ':id' => $id,
            ':active' => false
        ];
        
        // Result
        return $this->query($sql, $params);
    }

    public function getAll(string $id, bool $active) {
        $sql = "SELECT * 
                FROM ".self::$tblLegend."
                WHERE proj_id = :proj_id AND active = :active";

        $params = [
            ':proj_id' => $id,
            ':active' => $active
        ];

        // Result
        return $this->query($sql, $params);
    }
}