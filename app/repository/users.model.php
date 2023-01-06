<?php

class UsersModel extends Model {

    private static $tblUser = "tbl_user";// asign variable for table = table that you created in db
    private static $tblLoghistory = "tbl_loghistory";
    private static $tblJoinedproject = "tbl_joined_project";

    // User
    public function setUser(User $user) {//another function name (parameter)
        
        echo "Inserting project into database";

        $sql = "INSERT INTO ".self::$tblUser."
                    (id, first_name, middle_name, last_name, email, position, address, contact_no,
                    birthdate, log_id)
                VALUES
                    (:id, :first_name, :middle_name, :last_name, :email, :position, :address, :contact_no,
                    :birthdate, :log_id)";

        $stmt = $this->connect()->prepare($sql); //

        $stmt->bindValue(':id', $user->getId());
        $stmt->bindValue(':first_name', $user->getFirstName());
        $stmt->bindValue(':middle_name', $user->getMiddleName());
        $stmt->bindValue(':last_name', $user->getLastName());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':position', $user->getPosition());
        $stmt->bindValue(':address', $user->getAddress());
        $stmt->bindValue(':contact_no', $user->getContactNo());
        $stmt->bindValue(':birthdate', $user->getBirthdate());
        $stmt->bindValue(':log_id', $user->getLogId());
        
        
        $result = true; // if success

        if(!$stmt->execute()) { //error handling
            $stmt = null;
            $result = false; // if error
        }

        return $result;
    }

    public function getUser($projectId) {
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
    
}