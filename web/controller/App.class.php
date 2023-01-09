<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Model\Account;
use Repository\UserRepository;
use Service\UserService;

class App extends MainController {

    private $userRepository;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $userRepository = new UserRepository;
        
        // var_dump($_SESSION['accType']);
        $user = $userRepository->getUserByRegister($_SESSION['accRegister']);
        $account = $userRepository->getAccount($_SESSION['accID']);
        switch ($_SESSION['accType']) {
            case Account::ADMIN_TYPE:
                $this->settype(MainController::ADMIN);
                $this->view("dashboard", "dashboard", $user);
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
                $this->view("home", "client", ['user' => $user, 'acct' => $account]);
                break;
                        
            
            default:
                break;
        }
    }

    public function home()
    {
        $this->index();
    }

    // Change password view
    public function password()
    {
        $this->view("profile", "changepass", ['id' => $_SESSION['accID']]);
    }

    public function messages()
    {
        $this->setPage(3);
        $this->view('message', 'message');
    }

    public function payment()
    {
        $this->setPage(5);
        $this->view('payment', 'list');
    }

    public function invoice()
    {
        $this->setPage(6);
        $this->view('invoice', 'list');
    }

    // Profile
    public function profile()
    {
        $userService = new UserService;
        $this->setPage(7);
        $user = json_decode($userService->getUser($_SESSION['accID']), true);

        if ($user['statusCode'] == 200) {
            $this->view("profile", "profile", $user['data']);
        } else {
            // $this->goToLanding();
        }
    }

}