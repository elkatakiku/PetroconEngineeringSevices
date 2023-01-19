<?php

namespace Controller;

use \Core\Controller as MainController;
use Service\UserService;

class Account extends MainController {

    // Service
    private $userService;
    private $user;

    public function __construct() {
        parent::__construct();
        $this->setPage('#profileMenu');
        
        $this->userService = new UserService;

        if (!isset($_SESSION['accID'])) {
            $this->goToLogin();
        }
    }

    public function index() {
        $this->view("account", "profile");
    }

    // Employee positions list
    public function positions()
    {
        echo $this->userService->getEmployeePositions();
    }

    public function changepass()
    {
        $this->view("account", "changepass");
    }

}