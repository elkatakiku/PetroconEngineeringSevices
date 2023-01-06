<?php

namespace Controller;
use \Core\Controller as MainController;

class Dashboard extends MainController {

    public function __construct() {
        $this->setType(MainController::ADMIN);
        $this->setPage(1);
    }

    public function index($name = '') {
        $this->view("dashboard", "dashboard", ['dashboard' => 'dashboard']);
    }
}