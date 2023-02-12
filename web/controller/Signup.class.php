<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Service\UserService;

class Signup extends MainController {

    private $userService;

    public function __construct() {
        $this->setType(MainController::AUTH);
        $this->userService = new UserService();
    }

    // Displays login frontend
    public function index() {
        $this->goToLogin();
    }

    // SignUp
    public function run() 
    {
        echo "Run dis";
        if (isset($_POST['form'])) 
        {
            echo $this->userService->signup($_POST['form']);
        }
    }
}