<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Model\Account;
use Service\UserService;

class App extends MainController {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // var_dump($_SESSION['accType']);
        switch ($_SESSION['accType']) {
            case Account::ADMIN_TYPE:
                $this->settype(MainController::ADMIN);
                $this->view("dashboard", "dashboard");
                echo "ADMIN";
                break;
            case Account::EMPLOYEE_TYPE:
            case Account::WORKER_TYPE:
                $this->settype(MainController::ADMIN);
                echo "WORKER/EMPLOYEE";
                break;
            case Account::CLIENT_TYPE:
                $this->settype(MainController::CLIENT);
                $this->setPage(1);
                $this->view("home", "client");
                break;
                        
            
            default:
                break;
        }
    }

    public function home()
    {
        $this->index();
    }

    // Profile
    public function profile($userId)
    {
        $userService = new UserService;
        $this->setPage(7);
        $user = json_decode($userService->getUser($userId), true);

        if ($user['statusCode'] == 200) {
            $this->view("profile", "profile", $user['data']);
        } else {
            $this->goToLanding();
        }
    }

    // Change password view
    public function password()
    {
        $this->view("profile", "changepass", ['id' => $_SESSION['accID']]);
    }

}