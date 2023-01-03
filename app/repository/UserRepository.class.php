<?php

namespace Repository;

/* Imports */
// Repository
use \Core\Repository as Repository;

// Model
use \Model\Login as Login;
use \Model\Register as Register;
use \Model\Account as Account;

// Tools
use \PDO;

class UserRepository extends Repository {

    private static $tblRegister = "tbl_register";
    private static $tblLogin = "tbl_login";
    private static $tblAccount = "tbl_account";
    private static $tblLog = "tblLog";

    // Check user
    public function checkUser($username, $email) {

        $sql = "SELECT 
                    l.username, r.email
                FROM 
                    ".self::$tblLogin." l INNER JOIN ".self::$tblRegister." r
                WHERE 
                    l.username = :username OR r.email = :email;";

        // Preparing Statement
        $stmt = $this->connect()->prepare($sql);

        // Binding params
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);

        // Execute
        if(!$stmt->execute()) {
            $result = false;
        }

        $result = $stmt->rowCount() > 0;
        
        // Closes PDO and returns result
        $stmt = null;
        return $result;
    }

    public function setLogin(Login $login) {
        // Insert into login
        $sqlLogin = '   INSERT INTO '.self::$tblLogin.'
                            (id, username, password)
                        VALUES
                            (:id, :username, :password);';

        $stmt = $this->connect()->prepare($sqlLogin);

        $stmt->bindValue(":id", $login->getId());
        $stmt->bindValue(":username", $login->getUsername());
        $stmt->bindValue(":password", $login->getPassword());

        $result = true;

        if(!$stmt->execute()) {
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    public function setRegister(Register $register) {

        $sqlRegister = 'INSERT INTO '.self::$tblRegister.'
                            (id, lastname, firstname, middlename, contact_number, dob, email, log_id)
                        VALUES 
                            (:regID, :lastname, :firstname, :middlename, :contactNumber, :dob, :email, :regLoginID)';

        $stmt = $this->connect()->prepare($sqlRegister);

        $stmt->bindValue(":regID", $register->getId());
        $stmt->bindValue(":lastname", $register->getLastname());
        $stmt->bindValue(":firstname", $register->getFirstname());
        $stmt->bindValue(":middlename", $register->getMiddlename());
        $stmt->bindValue(":contactNumber", $register->getContactNumber());
        $stmt->bindValue(":dob", $register->getBirthdate());
        $stmt->bindValue(":email", $register->getEmail());
        $stmt->bindValue(":regLoginID", $register->getLoginId());

        $result = true;

        if(!$stmt->execute()) {
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    public function setAccount(Account $account) {
        // // Insert into accounts
        $sqlAccount = " INSERT INTO ".self::$tblAccount." 
                            (id, type_id , register_id, login_id)
                        VALUES 
                            (:acctID, :accTypeID, :accRegisterID, :accLoginID);";

        $stmt = $this->connect()->prepare($sqlAccount);

        $stmt->bindValue(":acctID", $account->getId());
        $stmt->bindValue(":accTypeID", $account->getTypeId());
        $stmt->bindValue(":accRegisterID", $account->getRegisterId());
        $stmt->bindValue(":accLoginID", $account->getLoginId());

        $result = true;

        if(!$stmt->execute()) {
            $result = false;
        }
        
        $stmt = null;
        return $result;
    }

    public function getLogin($username) {
        $sql = "SELECT *
                FROM 
                    ".self::$tblLogin." 
                WHERE 
                    username = :username;";

        // Prepare
        $stmt = $this->connect()->prepare($sql);

        // Bind
        $stmt->bindParam(':username', $username);

        $result = false;

        if($stmt->execute()) {
            if ($row = $stmt->fetch()) {
                $result = Login::build(
                    $row['id'],
                    $row['username'],
                    $row['password']
                );
            }
        }
        
        // Closes pdo connection
        $stmt = null;
        return $result;
    }

    public function getAccount($logId) {
        $sql = "SELECT *
                FROM
                    ".self::$tblAccount." tA  INNER JOIN ".self::$tblLogin." tL
                ON
                    tA.login_id = tL.id
                WHERE
                    tL.id = :logID";

        $stmt = $this->connect()->prepare($sql);
        
        // Bind
        $stmt->bindParam(":logID", $logId);

        // Error handling
        $result = false;

        if($stmt->execute()) {
            if ($row = $stmt->fetch()) {
                echo "<pre>";
                var_dump($row);
                $result = Account::build(
                    $row['id'],
                    $row['type_id'],
                    $row['register_id'],
                    $row['login_id']
                );
                var_dump($result);
            }
        } 

        // Closes pdo connection
        $stmt = null;
        return $result;
    }
}