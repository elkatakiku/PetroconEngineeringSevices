<?php

namespace Repository;

use Core\Repository;
use Model\Invitation;
use Model\Resource;

class PeopleRepository extends Repository {
    
    private static $tblPeople = "lnk_project_team";
    private static $tblInvitation = "tbl_invitation";

    public function create(Resource $resource)
    {
        $sql = "INSERT INTO ".self::$tblPeople."
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
                    '.self::$tblPeople.'
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
                    '.self::$tblPeople.'
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

    public function getPeople(string $projectId)
    {
        $sql = "SELECT *
                FROM ".self::$tblPeople." t
                INNER JOIN tbl_account a ON t.acct_id = a.id
                INNER JOIN tbl_register r ON a.register_id = r.id
                WHERE proj_id = :proj_id";

        $params = [
            ':proj_id' => $projectId
        ];

        // Result
        return $this->query($sql, $params);
    }

    // || Invitations
    public function getInvitations(string $projectId)
    {
        $sql = "SELECT * 
                FROM ".self::$tblInvitation."
                WHERE proj_id = :proj_id AND used = :used
                ORDER BY created_at DESC";

        $params = [
            ':proj_id' => $projectId,
            ':used' => false
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function createInvitation(Invitation $invitation)
    {
        $sql = "INSERT INTO ".self::$tblInvitation."
                    (id, name, email, code, proj_id, used)
                VALUES
                    (:id, :name, :email, :code, :proj_id, :used)";
        
        $params = [
            ':id' => $invitation->getId(),
            ':name' => $invitation->getName(),
            ':email' => $invitation->getEmail(),
            ':code' => $invitation->getCode(),
            ':proj_id' => $invitation->getProjectId(),
            ':used' => $invitation->isUsed()
        ];

        // Result
        return $this->query($sql, $params);
    }

}