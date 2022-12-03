<?php

class DashboardController extends Controller {

    public function __construct() {
        $this->setType(Controller::ADMIN);
    }

    public function index($name = '') {
        $this->view("dashboard/dashboard", ['dashboard' => 'dashboard']);
    }
}