<?php

namespace Controller;

// Core
use \Core\Controller as MainController;

class Signup extends MainController {

    private $userService;

    public function __construct() {
        $this->setType(MainController::AUTH);
        $this->userService = new \Service\UserService();
    }

    // Displays login frontend
    public function index() {
        $this->view("auth", "signup");
    }

    // SignUp
    public function run() 
    {
        if (isset($_POST['form'])) 
        {
            echo $this->userService->signup($_POST['form']);
            
            // $signupResult = $this->userService->signup($_POST);
            
            // if ($signupResult->isSuccess()) 
            // {   // Account creation success
            //     header("Location: ".SITE_URL."/login?signup=success");
            //     exit();
            //     return;
            // } else {
            //     header("Location: ".SITE_URL."/signup?error=".$signupResult->getMessage());
            // }
        }
    }
}