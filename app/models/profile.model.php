<?php

class ProfileModel extends Model {

    private static $tblRegister = "tbl_register";
    private static $tblAccount = "tbl_account";

    //Profile
    public function updateProfile(User $profiles) {
        
        echo "Inserting data into database";

        $sql = "UPDATE ".self::$tblRegister."
                SET 
                    firstname=:firstName, middlename=:middleName, lastname=:lastName, 
                    email=:email, address=:address, contact_number=:contactNo, dob=:birthdate
                WHERE 
                    id=:id";
        //Prepare 
        $stmt = $this->connect()->prepare($sql);
        //Bind
        $stmt->bindValue(':id', $profiles->getId());
        $stmt->bindValue(':firstName', $profiles->getFirstname());
        $stmt->bindValue(':middleName', $profiles->getMiddlename());
        $stmt->bindValue(':lastName', $profiles->getLastname());
        $stmt->bindValue(':email', $profiles->getEmail());
        $stmt->bindValue(':address', $profiles->getAddress());
        $stmt->bindValue(':contactNo', $profiles->getEmail());
        $stmt->bindValue(':birthdate', $profiles->getBirthdate());

        $result = true;

        if(!$stmt->execute()) {
            // Closes pdo connection
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    public function getProfile($profileId) {

        $sqlProfile = "SELECT 
                            id, firstname, middlename, lastname, email, address, contact_number, birthdate, log_id
                        FROM   
                            '.self::$tblRegister.'
                        WHERE 
                            id = :profID";

        // Prepare statement
        $stmtProfile = $this->connect()->prepare($sqlProfile);

        // Bind params
        $stmtProfile->bindParam(":profID", $profileId);

        // Execute statement
        try {
            if(!$stmt->execute()) {
                throw new PDOException("Error Processing Sql Statement", 1);
            }
            $result = $stmt->fetchAll()[0];
        } catch (PDOException $PDOE) {
            $result = -1;
        }

        $stmt = null;
        return $result;
    }

    public function getUserAccount($userId){

        $sqlProfile = "SELECT *
                        FROM   
                            ".self::$tblAccount."
                        WHERE 
                            id = :id";      
        //Prepare 
        $stmt = $this->connect()->prepare($sqlProfile);

        //Bind
        $stmt->bindParam(':id', $userId);

        // Execute statement
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