<?php

class Controller {

    const AUTH = "auth";
    const CLIENT = "client";
    const ADMIN = "admin";
    
    private $type;
    private $pageNumber;

    private $model;

    protected function setModel($model) {
        require_once '../app/models/' . $model . '.model.php';
        $this->model = new $model();
    }

    protected function getModel() {
        return $this->model;
    }

    protected function createEntity($entity) {
        require_once '../app/entities/' . $entity . '.class.php';
        return new $entity();
    }

    public function view($view, $data = []) {
        require_once '../app/views/structure/header.php';
        require_once '../app/views/' . $view . '.php';
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

    protected function getPage() {
        $pages = [
            Controller::CLIENT => ["home"], 
            Controller::ADMIN => ["dashboard", "projects", "messages", "team", "users", "profile"]
        ];

        return $pages[$this->type][$this->pageNumber];
    }
}