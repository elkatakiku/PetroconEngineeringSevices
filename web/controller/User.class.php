<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Faker\Factory;
use Model\Account as Account;
use Model\Register;
use Repository\ProjectRepository;
use \Service\UserService;

class User extends MainController
{

    private $userService;

    public function __construct()
    {
        parent::__construct();
        $this->setPage('#users');

        $this->userService = new UserService;

        if (!isset($_SESSION['accID'])) {
            $this->goToLogin();
        }
    }

    // || Views
    public function index()
    {
        header("Location: " . SITE_URL . "/user/list#all");
        exit();
    }

    public function list()
    {
        $this->view("user", "user-list", ['acctTypes' => $this->userService->getAccountTypes()]);
    }

    public function details(string $userId)
    {
        $user = json_decode($this->userService->getUserDetails($userId), true);

        if ($user['statusCode'] == 200) {
            $this->view("user", "user", ['account' => $user['data']]);
        } else {
            $this->goToIndex();
        }
    }

    public function new()
    {
        $this->view("user", "new-user", ['acctTypes' => $this->userService->getAccountTypes()]);
    }


    // || Functions
    public function getList()
    {
        if (isset($_GET['form'])) {
            echo $this->userService->getUserList($_GET['form']);
        }
    }

    public function newUser()
    {
        if (isset($_POST['form'])) {
            echo $this->userService->signup($_POST['form']);
        }
    }

    public function checkUserName()
    {
        if (isset($_GET['input'])) {
            echo $this->userService->checkUsername($_GET['input']);
        }
    }

    public function checkEmail()
    {
        if (isset($_GET['input'])) {
            echo $this->userService->checkEmail($_GET['input']);
        }
    }


    // || Profile
    public function updateUser()
    {
        if (isset($_POST['modifyProfile'])) {
            $inputs = [
                'required' => [
                    "id" => ucwords($this->sanitizeString($_POST['id'])), //every first letter of words is capital
                    "firstName" => ucwords($this->sanitizeString($_POST['firstName'])), //every first letter of words is capital
                    "lastName" => ucwords($this->sanitizeString($_POST['lastName'])),
                    "email" => $this->sanitizeString($_POST['email']), //all lower case/upper case
                    "address" => ucwords($this->sanitizeString($_POST['address'])),
                    "contactNo" => $this->sanitizeString($_POST['contactNo']),
                    "birthdate" => ucwords($this->sanitizeString($_POST['birthdate']))
                    //"username" => strtoupper($projectDesc[0]).strtolower(substr($projectDesc, 1, strlen($projectDesc))), //first letter first word lang ang capital
                ],
                'notRequired' => [
                    "middleName" => ucwords($this->sanitizeString($_POST['middleName']))
                ]
            ];

            $result = json_decode($this->userService->updateUser($inputs), true);
            $url = "Location: " . SITE_URL . "/account/profile";

            if ($result['statusCode'] != 200) {
                $url .= "?error=" . $result['message'];
            }

            header($url);
        } else {
            $this->goToLogin();
        }
    }

    // Change pass action
    public function changePass()
    {
        if (isset($_POST['changePassSubmit'])) {
            $result = json_decode($this->userService->changePassword($_POST), true);
            $url = "Location: " . SITE_URL . "/account/changepass";

            if ($result['statusCode'] == 200) {
                $url .= "?success=password changed";
            } else {
                $url .= "?error=" . $result['message'];
            }

            header($url);
        } else {
            $this->goToLogin();
        }
    }

    public function activate($uid, $key)
    {
        if ($uid && $key) {
            $this->userService->activateAccount($uid, $key);
        }
    }

    private function goToIndex()
    {
        header("Location: " . SITE_URL . "/user");
        exit();
    }

    public function remove()
    {
        if (isset($_POST['id'])) {
            echo $this->userService->remove($_POST['id']);
        }
    }

    public function generate()
    {
        echo 'Generate';
        $faker = Factory::create();

        echo 'Generate before';

        // Create login
        $login = new \Model\Login();
        $login->create($faker->userName, password_hash('123', PASSWORD_DEFAULT));

        // // Create register/user
        $register = new Register();
        $register->create(
            $faker->lastName, $faker->firstName, $faker->phoneNumber,
            $faker->date, $faker->safeEmail, $login->getId(), $faker->address
        );

        $register->setMiddlename($faker->firstName);

        // // Create Account
        $account = new Account();
        $account->createAccount(
            Account::EMPLOYEE_TYPE, $register->getId(), $login->getId()
        );

        echo 'Generating';
        $userService = new UserService();

        return $userService->setUser($login, $register, $account)->isSuccess();
    }
}

