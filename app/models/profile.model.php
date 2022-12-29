<?php

class ProfileModel extends Model {

    private static $userTable = "userTable";

    //Profile
    public function updateProfile(User $profiles) {
        
        echo "Inserting data into database";

        $sql = "UPDATE ".self::$userTable."
                SET first_name=:firstName, middle_name=:middleName, last_name=:lastName, email=:email, address=:address, contact_no=:contactNo, birthdate=:birthdate
                WHERE id=123";

        $stmt = $this->connect()->prepare($sql);

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
                            id, first_name, middle_name, last_name, email, address, contact_no, birthdate, log_id
                        FROM   
                            '.self::$userTable.'
                        WHERE 
                            id = :profID";

        // Prepare statement
        $stmtProject = $this->connect()->prepare($sqlProfile);

        // Bind params
        $stmtProject->bindParam(":profID", $profileId);

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