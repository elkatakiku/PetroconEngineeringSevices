<?php

namespace Controller;

// Core
use \Core\Controller as MainController;

// Model
use \Model\Account as AccountModel;

class Login extends MainController {

    private $userService;

    public function __construct() {
        $this->setType(MainController::AUTH);
        $this->userService = new \Service\UserService();
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
            {   // Redirects user to their respective landing page
                switch ($_SESSION["accType"]) {
                    case AccountModel::ADMIN_TYPE:
                        header("Location: ".SITE_URL.US."dashboard");
                        exit();
                        break;
                    case AccountModel::EMPLOYEE_TYPE:
                    case AccountModel::WORKER_TYPE:
                        header("Location: ".SITE_URL.US."dashboard");
                        exit();
                        break;
                    case AccountModel::CLIENT_TYPE:
                        header("Location: ".SITE_URL.US."home/index");
                        exit();
                        break;
                    default:
                        echo "Different Account Type";
                        exit();
                        break;
                }
            } else {
                echo "<h1>Username or password does not match.</h1>";
                return;
            }
        } else {
            echo "<br>Please fill all required inputs.";
            $result =  -101;
        }
    }
}