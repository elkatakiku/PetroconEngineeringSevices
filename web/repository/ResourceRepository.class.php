<?php

namespace Repository;

use Core\Repository;
use Model\Resource;

class ResourceRepository extends Repository {
    
    private static $tblResource = "tbl_resource";

//    Create
    public function create(Resource $resource)
    {
        $sql = "INSERT INTO ".self::$tblResource."
                    (id, item, quantity, price, total, notes, proj_id, active)
                VALUES
                    (:id, :item, :quantity, :price, :total, :notes, :proj_id, :active)";
        
        $params = [
            ':id' => $resource->getId(),
            ':item' => $resource->getItem(),
            ':quantity' => $resource->getQuantity(),
            ':price' => $resource->getPrice(),
            ':total' => $resource->getTotal(),
            ':notes' => $resource->getNotes(),
            ':proj_id' => $resource->getProjectId(),
            ':active' => $resource->getActive()
        ];

        // Result
        return $this->query($sql, $params);
    }

//    Read
    public function getActiveResources(string $projectId)
    {
        $sql = "SELECT * 
                FROM ".self::$tblResource."
                WHERE proj_id = :proj_id AND active = :active";

        $params = [
            ':proj_id' => $projectId,
            ':active' => true
        ];

        // Result
        return $this->query($sql, $params);
    }

//    Update
    public function update(array $resource)
    {
        // Query
        $sql = 'UPDATE 
                    '.self::$tblResource.'
                SET 
                    item = :item, quantity = :quantity, price = :price,
                    total = :total, notes = :notes
                WHERE 
                    id = :id';

        // Parameters' (:parameter) value
        $params = [
            ':item' => $resource['item'],
            ':quantity' => $resource['quantity'],
            ':price' => $resource['price'],
            ':total' => $resource['total'],
            ':notes' => $resource['notes'],
            ':id' => $resource['id']
        ];
        
        // Result
        return $this->query($sql, $params);
    }

    public function updateNotes(array $resource)
    {
        // Query
        $sql = 'UPDATE 
                    '.self::$tblResource.'
                SET 
                   notes = :notes
                WHERE 
                    id = :id';

        // Parameters' (:parameter) value
        $params = [
            ':notes' => $resource['notes'],
            ':id' => $resource['id']
        ];

        // Result
        return $this->query($sql, $params);
    }

//    Delete
    public function remove(string $id) 
    {
        $sql = 'UPDATE 
                    '.self::$tblResource.'
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

}