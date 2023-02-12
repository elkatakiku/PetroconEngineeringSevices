<?php

namespace Core;
use \PDO;
use \PDOException;

class Dbh {
//    Server
//    private $host = "127.0.0.1:3306";
//    private $user = "u336867898_petrocon";
//    private $password = "^SjdAD7kj~8";
//    private $dbName = "u336867898_petrocon";

//    Local
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbName = "petrocon";

    protected function connect() {
        try {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';';
            $pdo = new PDO($dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            
            return $pdo;
        } catch (PDOException $e) {
            $error_message = "Database Error: ";
            $error_message .= $e->getMessage();
            echo $error_message;

            echo "<br>";
            $debug = debug_backtrace();
            echo 'Found in ' . $debug[0]['file'] . ' on line ' . $debug[0]['line'];
            exit();
        }
    }

    protected function query(string $sql, $params = null) {        
        // Prepare the query string
        $stmt = $this->connect()->prepare($sql);
        
        // Validation and result
        $result = false;
        if($stmt->execute($params)) 
        {
            $result = true;
            
            switch(trim(explode(' ', $sql)[0])) 
            {
                case 'SELECT' :
                    $result = $stmt->fetchAll();
                    break;
                case 'UPDATE' : case 'DELETE' :
                    $result = $stmt->rowCount() > 0;
                    break;
            }
        }

        $stmt = null;
        return $result;
    }

    public function setInactive(string $tblName, string $id)
    {
        $sql = 'UPDATE 
                    '.$tblName.'
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