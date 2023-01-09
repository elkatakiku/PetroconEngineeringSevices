<?php

namespace Repository;

use Core\Repository;
use Model\Resource;

class PaymentRepository extends Repository {
    
    private static $tblPayment = "tbl_payment";

    public function create(Resource $resource)
    {
        $sql = "INSERT INTO ".self::$tblPayment."
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

    public function update(array $resource)
    {
        // Query
        $sql = 'UPDATE 
                    '.self::$tblPayment.'
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

    public function remove(string $id) 
    {
        $sql = 'UPDATE 
                    '.self::$tblPayment.'
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

    public function getAll(string $projectId)
    {
        $sql = "SELECT pay.bill, pay.amount, pay.sent_at, proj.company
                FROM ".self::$tblPayment." pay 
                INNER JOIN tbl_project proj ON pay.proj_id = proj.id
                WHERE pay.proj_id = :proj_id";

        $params = [
            ':proj_id' => $projectId
        ];

        // Result
        return $this->query($sql, $params);
    }

}