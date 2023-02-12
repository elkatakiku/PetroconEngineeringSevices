<?php

namespace Repository;

use Core\Repository;
use Model\Payment;

class PaymentRepository extends Repository {
    
    private static $tblPayment = "tbl_payment";

    public function create(Payment $resource)
    {
        $sql = "INSERT INTO ".self::$tblPayment."
                    (id, description, amount, sent_at, proj_id, active)
                VALUES
                    (:id, :description, :amount, :sent_at, :proj_id, :active)";
        
        $params = [
            ':id' => $resource->getId(),
            ':description' => $resource->getDescription(),
            ':amount' => $resource->getamount(),
            ':sent_at' => $resource->getSentAt(),
            ':proj_id' => $resource->getProjectId(),
            ':active' => $resource->getActive()
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function update(array $payment)
    {
        // Query
        $sql = 'UPDATE 
                    '.self::$tblPayment.'
                SET 
                    description = :description, amount = :amount,
                    sent_at = :sent_at
                WHERE 
                    id = :id';

        // Parameters' (:parameter) value
        $params = [
            ':description' => $payment['description'],
            ':amount' => $payment['amount'],
            ':sent_at' => $payment['sent_at'],
            ':id' => $payment['id']
        ];
        
        // Result
        return $this->query($sql, $params);
    }

    public function remove(string $id) 
    {
        $this->setInactive(self::$tblPayment, $id);
    }

    public function getAll(string $projectId)
    {
        $sql = "SELECT 
                    pay.id, pay.description, pay.amount,  DATE_FORMAT(pay.sent_at, '%Y-%m-%d') AS sent_at, proj.company
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