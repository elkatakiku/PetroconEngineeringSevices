<?php

class DashboardController extends Controller {

    public function __construct() {
        $this->setType(Controller::ADMIN);
        $this->setPage(1);
    }

    public function index($name = '') {
        $this->view("dashboard/dashboard", ['dashboard' => 'dashboard']);
    }
}