<?php

class Controller {

    const AUTH = "auth";
    const CLIENT = "client";
    const ADMIN = "admin";
    
    private $type;

    protected function model($model) {
        require_once '../app/models/' . $model . '.model.php';
        return new $model();
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
}