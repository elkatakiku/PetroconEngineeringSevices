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
            // include_once("../views/status/error.php");
            exit();
        }
    }
}