<?php

namespace Core;
use \PDO;
use \PDOException;

class Dbh {
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

            // include_once("../views/status/error.php");
            exit();
        }
    }

    protected function query(string $sql, $params = null, int $limit = 0) {

        // Modify query string to add limiter
        if ($limit > 0) {
            $sql .= " LIMIT ".$limit;
        }
        
        // Prepare the query string
        $stmt = $this->connect()->prepare($sql);
        
        // Validation and result
        $result = false;
        if($stmt->execute($params)) 
        {
            $result = true;
            
            switch(explode(' ', $sql)[0]) 
            {
                case 'SELECT' :
                    $result = $stmt->fetchAll();
                    break;
                case 'UPDATE' :
                    // echo "Success update";
                    // echo "<br>";
                    // echo $stmt->rowCount();
                    $result = $stmt->rowCount() > 0;
                    break;
            }
        }

        // echo "<br>";
        // var_dump($sql);

        // echo "<br>";
        // var_dump($params);

        // echo "<br>";
        // print_r($stmt->errorInfo());

        // echo "<br>";
        // var_dump($result);

        $stmt = null;
        return $result;
    }

    private function handle_sql_errors($query, $error_message) {
        echo '<pre>';
        echo $query;
        echo '</pre>';
        echo $error_message;
        die;
    }
}