<?php

class Controller {

    const AUTH = "auth";
    const CLIENT = "client";
    const ADMIN = "admin";
    
    private $type;
    private $pageNumber;

    private $model;

    private $isLogin;

    protected function __construct() {
        if (isset($_SESSION["accID"])) {
            $this->isLogin = true;
        }
    }

    protected function isLogin() {
        return $this->isLogin;
    }

    protected function setModel($model) {
        echo __METHOD__;
        echo "<br>Model<br>";
        require_once '../app/models/' . $model . '.model.php';
        $this->model = new ($model . "Model")();
        var_dump($this->model);
    }

    protected function getModel() {
        echo __METHOD__;
        echo "<br>Model<br>";
        var_dump($this->model);
        return $this->model;
    }

    protected function createEntity($entity) {
        require_once '../app/entities/' . $entity . '.class.php';
        return new $entity();
    }

    public function view($viewFolder, $view, $data = []) {
        require_once '../app/views/structure/header.php';
        require_once '../app/views/' . $viewFolder .DS. $view .'.php';
        require_once '../app/views/structure/footer.php';
    }

    protected function getType() {
        return $this->type;
    }

    protected function setType($type) {
        $this->type = $type;
    }

    protected function setPage($pageNumber) {
        $this->pageNumber = $pageNumber - 1;
    }

    protected function getPageNumber() {
        return $this->pageNumber;
    }

    protected function getPage() {
        $pages = [
            Controller::CLIENT => ["home"], 
            Controller::ADMIN => ["dashboard", "projects", "messages", "team", "users", "profile"]
        ];

        return $pages[$this->type][$this->pageNumber];
    }

    protected function sanitizeString($string) {
        return trim(htmlspecialchars(strip_tags($string)));
    }

    // Validate Inputs
    protected function emptyInput($inputs) {
        echo "<BR>";
        echo __METHOD__;
        echo "<BR>";
        var_dump($inputs);
        foreach ($inputs as $key => $value) {
            echo "<br>";
            var_dump($key);
            var_dump($value);
            var_dump(!$value);
            if (is_array($value)) {
                echo "<br>is array, Checking: <BR>";
                var_dump($key);
                if($this->emptyInput($value)) {
                    return true;
                }
            }
            if (!$value) {
                return true;
            }
        }

        return false;
    }
}