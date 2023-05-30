<?php

namespace Repository;

use Core\Repository as Repository;
use Model\Account as Account;
use Model\Activation;
use Model\Login as Login;
use Model\Register as Register;
use Model\Reset;

class UserRepository extends Repository {

    private static $tblRegister = "tbl_register"; // also a user
    private static $tblLogin = "tbl_login";
    private static $tblAccount = "tbl_account";
    private static $tblActivation = "tbl_activation";
    private static $tblLog = "tbl_Log";
    private static $tblAcctType = "pltbl_account_type";
    private static $tblPositions = "pltbl_employee_position";
    private static $tblReset = "tbl_reset";

    
    // Gets employee positions
    public function getEmployeePositions()
    {
        $sql = "SELECT * FROM ".self::$tblPositions;

        return $this->query($sql);
    }

    public function validateUsername(string $username)
    {
        return $this->validateInput('username', self::$tblLogin, $username);
    }

    public function isEmailTaken(string $email)
    {
        return $this->validateInput('email', self::$tblRegister, $email);
    }
    
    public function validateInput(string $column, string $table, $value)
    {
        $sql = "SELECT 
                    {$column}
                FROM 
                    {$table}
                WHERE 
                    {$column} = :input";

        // Binding params
        $params = [
            ":input" => $value
        ];

        return count($this->query($sql, $params)) > 0;
    }

    // Check user
    public function checkUser($username, $email) {

        $sql = "SELECT 
                    l.username, r.email
                FROM 
                    ".self::$tblLogin." l INNER JOIN ".self::$tblRegister." r
                ON l
                    .id = r.log_ID
                WHERE 
                    l.username = :username OR r.email = :email;";

        // Binding params
        $params = [
            ":username" => $username,
            ":email" => $email
        ];

        return count($this->query($sql, $params)) > 0;
    }

    public function setLogin(Login $login) 
    {
        $sql = 'INSERT INTO '.self::$tblLogin.'
                    (id, username, password)
                VALUES
                    (:id, :username, :password);';

        $params = [
            ":id" => $login->getId(),
            ":username" => $login->getUsername(),
            ":password" => $login->getPassword()
        ];
            
       return $this->query($sql, $params);
    }

    public function setRegister(Register $register) 
    {

        $sql = 'INSERT INTO '.self::$tblRegister.'
                    (id, lastname, firstname, middlename, contact_number, dob, email, log_id)
                VALUES 
                    (:regID, :lastname, :firstname, :middlename, :contactNumber, :dob, :email, :regLoginID)';
        
        $params = [
            ":regID" => $register->getId(),
            ":lastname" => $register->getLastname(),
            ":firstname" => $register->getFirstname(),
            ":middlename" => $register->getMiddlename(),
            ":contactNumber" => $register->getContactNumber(),
            ":dob" => $register->getBirthdate(),
            ":email" => $register->getEmail(),
            ":regLoginID" => $register->getLoginId()
        ];

        return $this->query($sql, $params);
    }

    public function setAccount(Account $account) 
    {
        $sql = " INSERT INTO ".self::$tblAccount." 
                            (id, type_id , register_id, login_id)
                        VALUES 
                            (:acctID, :accTypeID, :accRegisterID, :accLoginID);";

        $params = [
            ":acctID" => $account->getId(),
            ":accTypeID" => $account->getTypeId(),
            ":accRegisterID" => $account->getRegisterId(),
            ":accLoginID" => $account->getLoginId()
        ];

        return $this->query($sql, $params);
    }

    public function getLogin($username) 
    {
        $sql = "SELECT *
                FROM 
                    ".self::$tblLogin." 
                WHERE 
                    username = :username
                LIMIT 1";

        $params = [':username' => $username];

        $result = false;
        if ($row = $this->query($sql, $params)) {
            $result = Login::build(
                $row[0]['id'],
                $row[0]['username'],
                $row[0]['password']
            );
        }

        return $result;
    }

    public function getLoginById(string $id)
    {
        $sql = "SELECT *
                FROM 
                    ".self::$tblLogin." 
                WHERE 
                    id = :id
                LIMIT 1";
        
        $params = [':id' => $id];

        if ($res = $this->query($sql, $params)[0]) {

            $res = Login::build(
                $res['id'],
                $res['username'],
                $res['password']
            );
        }

        return $res;
    }

    public function getAccount(string $accId)
    {
        $sql = 'SELECT *
                FROM '.self::$tblAccount.'
                WHERE id = :id
                LIMIT 1';
        
        $params = [':id' => $accId];
        
        return $this->query($sql, $params)[0];
    }

    public function getAccountByLogin($logId) 
    {
        $sql = "SELECT 
                    a.id, a.type_id, a.register_id, a.login_id, 
                    l.username, l.password
                FROM
                    ".self::$tblAccount." a  INNER JOIN ".self::$tblLogin." l
                ON
                    a.login_id = l.id
                WHERE
                    l.id = :logID";

        $stmt = $this->connect()->prepare($sql);
        
        // Bind
        $stmt->bindParam(":logID", $logId);

        // Error handling
        $result = false;

        if($stmt->execute()) {
            if ($row = $stmt->fetch()) {
                $result = Account::build(
                    $row['id'],
                    $row['type_id'],
                    $row['register_id'],
                    $row['login_id']
                );
            }
        } 

        // Closes pdo connection
        $stmt = null;
        return $result;
    }

    public function getUsers(string $userType)
    {

        $sql = "SELECT a.id, r.firstname, r.lastname, r.middlename, r.email, l.username, l.password
                FROM  ".self::$tblAccount." a
                LEFT JOIN ".self::$tblRegister." r ON r.id = a.register_id
                LEFT JOIN ".self::$tblLogin." l ON l.id = a.login_id";
//                WHERE NOT a.type_id = '".Account::ADMIN_TYPE."'";

        $params = [];
        if (strlen(trim($userType)) > 0) {
            $sql .= " WHERE a.type_id = :userType";
            $params = [':userType' => $userType];
        }

        $sql .= " ORDER BY created_at DESC";

        return $this->query($sql, $params);


        // Query
        // if (($userType != 1 && $userType != 0) || $userType == "all") 
        // {   // Selects all active users
        //     $sql = "SELECT *
        //         FROM ".self::$tblRegister."
        //         WHERE active = :active
        //         ORDER BY created_at DESC";
        // } else 
        // {   // Selects all users with a matching status
        //     $sql = "SELECT *
        //         FROM ".self::$tblRegister."
        //         WHERE active = :active AND done = :done
        //         ORDER BY created_at DESC";

        //     $params[':done'] = $$userType;
        // }

    }

    public function getUserDetails(string $acctId)
    {
        $sql = "SELECT
                    r.id AS 'reg_id', r.lastname, r.firstname, r.middlename, r.contact_number, r.dob, r.email, r.address,
                    l.id AS 'log_id', l.username, l.password,
                    a.id AS 'acct_id',
                    t.name AS 'type'
                FROM ".self::$tblAccount." a
                INNER JOIN ".self::$tblLogin." l ON l.id = a.login_id
                INNER JOIN ".self::$tblRegister." r ON r.id = a.register_id
                INNER JOIN ".self::$tblAcctType." t ON t.id = a.type_id
                WHERE a.id = :acctID
                LIMIT 1";

        $params = [':acctID' => $acctId];

        // Result
        return $this->query($sql, $params)[0];
    }

    // Gets user info from register table
    public function getUserByLogin($userId) 
    {
        $sql = "SELECT  
                    r.id, r.lastname, r.firstname, r.middlename, r.contact_number, r.dob, r.email, r.address,
                    t.name as 'type'
                FROM ".self::$tblLogin." l
                INNER JOIN ".self::$tblAccount." a ON l.id = a.login_id
                INNER JOIN ".self::$tblRegister." r ON r.id = a.register_id
                INNER JOIN ".self::$tblAcctType." t ON t.id = a.type_id
                WHERE l.id = :userID";
    
        $params = [':userID' => $userId];

        // Result
        return $this->query($sql, $params)[0];
    }

    public function getRegister(string $regId)
    {
        $sql = 'SELECT * 
                FROM '.self::$tblRegister.'
                WHERE id = :id
                LIMIT 1';
        
        $params = [':id' => $regId];

        return $this->query($sql, $params)[0];
    }

    public function getRegisterByAccount(string $acctId)
    {
        $sql = 'SELECT 
                    r.id, r.lastname, r.firstname, r.middlename, r.contact_number, r.dob,
                    r.email, r.log_ID, r.address, t.name as "type"
                FROM '.self::$tblAccount.' a
                INNER JOIN '.self::$tblRegister.' r ON a.register_id = r.id
                INNER JOIN '.self::$tblAcctType.' t ON t.id = a.type_id
                WHERE a.id = :id
                LIMIT 1';
        
        $params = [':id' => $acctId];

        return $this->query($sql, $params)[0];
    }

    public function getRegisterByEmail(string $email) {
        $sql = "SELECT * 
                FROM ".self::$tblRegister."
                WHERE email = :email";

        $params = [':email' => $email];

        return $this->query($sql, $params);
    }

    // Updates user's password
    public function changePassword(string $password, string $id)
    {
        $sql = 'UPDATE 
                    '.self::$tblLogin.'
                SET 
                    password = :password
                WHERE 
                    id = :id';
    
        $params = [
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':id' => $id
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function update(array $user)
    {
        var_dump($user);
        
        $sql = 'UPDATE 
                    '.self::$tblRegister.'
                SET 
                    lastname = :lastname, firstname = :firstname, middlename = :middlename, 
                    contact_number = :contact_number, dob = :dob, email = :email, address = :address
                WHERE 
                    id = :id';

        $params = [
            ':lastname' => $user['lastName'],
            ':firstname' => $user['firstName'],
            ':middlename' => $user['middleName'],
            ':contact_number' => $user['contactNo'],
            ':dob' => $user['birthdate'],
            ':email' => $user['email'],
            ':address' => $user['address'],
            ':id' => $user['id']
        ];

        // Result
        return $this->query($sql, $params);
    }

    public function getAccountType(string $logId)
    {
        $sql = 'SELECT * 
                FROM '.self::$tblAccount.' 
                WHERE login_id = :log_id';

        $params = [':log_id' => $logId];

        $this->query($sql, $params);
    }

    // || Verification
    public function verifyActivation($uid)
    {
        $sql = 'SELECT * 
                FROM '.self::$tblActivation.' 
                WHERE acc_id = :id';

        $params = [':id' => $uid];

        var_dump($sql, $params);

        return $this->query($sql, $params);
    }

    public function createActivation(Activation $activation)
    {
        var_dump($activation);
        $sql = 'INSERT INTO '.self::$tblActivation.' 
                    (id, code, acc_id) 
                VALUES 
                    (:id, :code, :acc_id)';

        $params = [
            ':id' => $activation->getId(),
            ':code' => $activation->getCode(),
            ':acc_id' => $activation->getAccId()
        ];

        return $this->query($sql, $params);
    }

    public function updateActivationCode(string $activationId, string $code)
    {
        $sql ='UPDATE 
                    '.self::$tblActivation.'
                SET 
                    code = :code, sent_at = NOW()
                WHERE 
                    id = :id';

        $params = [
            ':code' => $code,
            ':id' => $activationId
        ];

        return $this->query($sql, $params);
    }

    public function matchActivation($uid, $key)
    {
        $sql = 'SELECT *
                FROM '.self::$tblActivation.'
                WHERE 
                    acc_id = :id AND code = :code';
                
        $params = [
            ':id' => $uid,
            ':code' => $key
        ];

        return $this->query($sql, $params);
    }

    public function activateAccount($accId)
    {
        $sql ='UPDATE 
                    '.self::$tblAccount.'
                SET 
                    activated = :activated
                WHERE 
                    id = :id';

        $params = [
        ':activated' => true,
        ':id' => $accId
        ];

        return $this->query($sql, $params);
    }

    // Account Types
    public function getAccountTypes()
    {
        $sql = "SELECT *
                FROM ".self::$tblAcctType;
//                WHERE NOT id = '".Account::ADMIN_TYPE."'";

        return $this->query($sql);
    }

    // || Reset Password
    public function getUserByEmail(string $email)
    {
        $sql = 'SELECT *
                FROM '.self::$tblRegister."
                WHERE email = :email
                LIMIT 1";

        $params = [':email' => $email];

        return $this->query($sql, $params);
    }

    public function createResetRequest(Reset $reset)
    {
        $sql = "INSERT INTO ".self::$tblReset." 
                    (id, log_id)
                VALUES 
                    (:id, :log_id)";

        $params = [
            ":id" => $reset->getId(),
            ":log_id" => $reset->getLoginId()
        ];

        return $this->query($sql, $params);
    }

    public function getResetRequest(string $resetId)
    {
        $sql = 'SELECT *
                FROM '.self::$tblReset."
                WHERE id = :id
                LIMIT 1";

        $params = [':id' => $resetId];

        return $this->query($sql, $params);
    }

    public function exhaustReset(string $id)
    {
        $sql = 'UPDATE 
                    '.self::$tblReset.'
                SET 
                    used = :used
                WHERE 
                    id = :id';

        $params = [
            ':id' => $id,
            ':used' => true
        ];

        // Result
        return $this->query($sql, $params);
    }

    // Removes User
    public function remove(string $id)
    {
        $sql = 'UPDATE 
                    '.self::$tblAccount.'
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