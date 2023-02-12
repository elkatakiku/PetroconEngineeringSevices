<?php

namespace Controller;

// Core
use \Core\Controller as MainController;

// Model
use \Model\Account as AccountModel;
use Service\UserService;

class Login extends MainController {

    private $userService;

    public function __construct() {
        $this->setType(MainController::AUTH);
        $this->userService = new UserService();

        if (isset($_SESSION['accID'])) {
            header("Location: ".SITE_URL."/dashboard");
        }
    }

    // Displays login frontend
    public function index() {
        $this->view("auth", "login");
    }

    // Login
    public function run() {
        // Redirect to login if not logging in
        if (!isset($_POST['loginSubmit'])) {
            $this->view("auth", "login");
            return;
        }

        // Gets the inputs
        $inputs = [
            "username" => $this->sanitizeString($_POST['usernameInput']),
            "password" => $this->sanitizeString($_POST['passwordInput'])
        ];

        if (!$this->emptyInput($inputs)) 
        {
            if ($this->userService->login($inputs)->isSuccess()) 
            {
                header("Location: ".SITE_URL."/dashboard");
                exit();
            } else {
                echo "<h1>Username or password does not match.</h1>";
            }
        } 
        else 
        {
            echo "<br>Please fill all required inputs.</h1>";
        }
    }
}