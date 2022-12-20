<?php

class AuthModel extends Model {

    private static $tblRegister = "tbl_register";
    private static $tblLogin = "tbl_login";
    private static $tblAccount = "tbl_account";
    private static $tblLog = "tblLog";

    // Check user
    public function checkUser($username, $email) {
        // Test
        echo "<br>Checking user";

        $sql = "SELECT l.logUsername, r.regEmail
                FROM ".self::$tblLogin." l INNER JOIN ".self::$tblRegister." r
                WHERE l.logUsername = :username OR r.regEmail = :email;";

        // Preparing Statement
        $stmt = $this->connect()->prepare($sql);

        // Binding params
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);

        // Execute 
        if (!$stmt->execute()) {
            $stmt = null;
            return -1;
            // Redirect
            // header('Location: .');
            // exit();
        }

        // Return if there's a gathered user from the db
        return $stmt->rowCount() > 0;
    }

    public function setUser(Login $login, Register $register, Account $account) {

        if (!$this->setLogin($login->getId(), $login->getUsername(), $login->getPassword())) {
            return -101;
        }

        if (!$this->setRegister(
            $register->getId(), $register->getLastname(), $register->getFirstname(), $register->getMiddlename(), 
            $register->getContactNumber(), $register->getBirthdate(), $register->getEmail(), $register->getLoginId()
        )) {
            return -102;
        }

        if (!$this->setAccount($account->getId(), $account->getTypeId(), $account->getRegisterId(), $account->getLoginId())) {
            return -103;
        }

        return 1;
    }

    private function setLogin($id, $username, $password) {
        // Insert into login
        $sqlLogin = '   INSERT INTO '.self::$tblLogin.'
                            (logID, logUsername, logPassword)
                        VALUES
                            (:id, :username, :password);';

        $stmtLogin = $this->connect()->prepare($sqlLogin);

        $stmtLogin->bindParam(":id", $id);
        $stmtLogin->bindValue(":username", $username);
        $stmtLogin->bindValue(":password", $password);

        if ($stmtLogin->execute()) {
            $stmtLogin = null;
            return true;
        }

        return false;
    }

    private function setRegister(
            $id, $lastname, $firstname, $middleName, 
            $contactNumber, $birthdate, $email, $loginId
        ) {

        $sqlRegister = 'INSERT INTO '.self::$tblRegister.'
                            (regID, regLastname, regFirstname, regMiddlename, regContactNumber, regDob, regEmail, regLoginID)
                        VALUES 
                            (:regID, :lastname, :firstname, :middlename, :contactNumber, :dob, :email, :regLoginID)';

        $stmtRegister = $this->connect()->prepare($sqlRegister);
        

        $stmtRegister->bindParam(":regID", $id);
        $stmtRegister->bindParam(":lastname", $lastname);
        $stmtRegister->bindParam(":firstname", $firstname);
        $stmtRegister->bindParam(":middlename", $middleName);
        $stmtRegister->bindParam(":contactNumber", $contactNumber);
        $stmtRegister->bindParam(":dob", $birthdate);
        $stmtRegister->bindParam(":email", $email);
        $stmtRegister->bindParam(":regLoginID", $loginId);

        if ($stmtRegister->execute()) {
            $stmtRegister = null;
            return true;
        }

        return false;
    }

    private function setAccount($id, $typeId, $regId, $logId) {

        // // Insert into accounts
        $sqlAccount = " INSERT INTO ".self::$tblAccount." 
                            (accID, accTypeID, accRegisterID, accLoginID)
                        VALUES 
                            (:acctID, :accTypeID, :accRegisterID, :accLoginID);";

        $stmtAccount = $this->connect()->prepare($sqlAccount);

        $stmtAccount->bindParam(":acctID", $id);
        $stmtAccount->bindParam(":accTypeID", $typeId);
        $stmtAccount->bindParam(":accRegisterID", $regId);
        $stmtAccount->bindParam(":accLoginID", $logId);

        if ($stmtAccount->execute()) {
            $stmtAccount = null;
            return true;
        }

        return false;
    }

    public function getUser($username, $password) {
        echo $username . $password;
        $sqlPass = "SELECT logID, logPassword 
                    FROM ".self::$tblLogin." 
                    WHERE logUsername = :username;";

        // Prepare
        $stmtPass = $this->connect()->prepare($sqlPass);

        // Bind
        // $stmtPass->bindParam(':tblLogin', self::$tblLogin);
        $stmtPass->bindParam(':username', $username);

        // echo '<hr>';
        // print_r($stmtPass);

        // Execute
        if (!$stmtPass->execute()) {
            $stmtPass = null;
            // echo '<hr>';
            // echo "Error in executing pass statement";
            // return some error
            return false;
        }

        if($stmtPass->rowCount() <= 0) {
            $stmtPass = null;
            // echo '<hr>';
            // echo "No matching username";
            // return some error
            return false;
        }

        
        $pwdHashed = $stmtPass->fetchAll();
        // print_r($pwdHashed);
        $checkPwd = password_verify($password, $pwdHashed[0]["logPassword"]);
        // echo $pwdHashed[0]["logPassword"];
        // echo "<br>";
        // var_dump(password_verify($password, $pwdHashed[0]["logPassword"]));

        if (!$checkPwd) {
            // echo '<hr>';
            // echo "Password does not match";
            $stmtPass = null;
            return false;
        }

        $stmtPass = null;

        $sqlAccount = " SELECT *
                        FROM
                            ".self::$tblAccount." tA  INNER JOIN ".self::$tblLogin." tL
                        ON
                            tA.accLoginID = tL.logID
                        WHERE
                            tL.logID = :logID";

        $stmtAccount = $this->connect()->prepare($sqlAccount);
        
        // Bind
        $stmtAccount->bindParam(":logID", $pwdHashed[0]["logID"]);
        
        // Execute
        if (!$stmtAccount->execute()) {
            $stmtAccount = null;
            // echo '<hr>';
            // echo "Error in executing account statement";
            // return some error
            return false;
        }

        if($stmtAccount->rowCount() <= 0) {
            // echo '<hr>';
            // echo "No matching login id";
            $stmtPass = null;
            // return some error
            return false;
        }

        $account = $stmtAccount->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION["accID"] = $account[0]['accID'];
        $_SESSION["accType"] = $account[0]['accTypeID'];
        $_SESSION["accRegister"] = $account[0]['accRegisterID'];

        $stmtAccount = null;
        return true;
    }
}