<?php

namespace Controller;

use Core\Controller as MainController;
use Service\UserService;

class Login extends MainController {

    private UserService $userService;

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
        // Redirect to log in if not logging in
        if (isset($_POST['loginSubmit']))
        {
            $result = $this->userService->loginUser($_POST);
            if ($result->isSuccess()) {
                header("Location: " . SITE_URL . "/dashboard");
                exit();
            } else {
                header("Location: " . SITE_URL . "?error=".$result->getMessage());
                exit();
            }
        } else {
            $this->goToLogin();
        }
    }
}