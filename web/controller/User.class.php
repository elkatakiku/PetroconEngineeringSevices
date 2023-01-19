<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use \Service\UserService;

class User extends MainController {

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
    public function index() {
        header("Location: ".SITE_URL."/user/list#all");
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

    public function new() {
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
        if (isset($_POST['form'])) 
        {    
            // $signupResult = $this->userService->signup($_POST['form']);
            echo $this->userService->signup($_POST['form']);
            
            // if ($signupResult->isSuccess()) 
            // {   // Account creation success
            //     header("Location: ".SITE_URL."/user/list#all");
            //     exit();
            //     return;
            // } else {
            //     header("Location: ".SITE_URL."/user?error=".$signupResult->getMessage());
            // }
        }
    }

    public function checkUserName()
    {
        if (isset($_GET['input'])) 
        {    
            echo $this->userService->checkUsername($_GET['input']);
        }
    }

    public function checkEmail()
    {
        // echo __METHOD__;
        if (isset($_GET['input'])) 
        {
            echo $this->userService->checkEmail($_GET['input']);
        }
    }


    // || Profile
    public function updateUser()
    {
        if (isset($_POST['modifyProfile'])) 
        {
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
            $url = "Location: ".SITE_URL."/account/profile";

            if ($result['statusCode'] != 200) {
                $url .= "?error=".$result['message'];
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
            $url = "Location: ".SITE_URL."/account/changepass";

            if ($result['statusCode'] == 200) {
                $url .= "?success=password changed";
            } else {
                $url .= "?error=".$result['message'];
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
        
        // if (isset($_POST['verifySubmit'])) 
        // {
        //     $inputs = [
        //         'required' => [
        //             "id" => ucwords($this->sanitizeString($_POST['id'])), //every first letter of words is capital
        //             "firstName" => ucwords($this->sanitizeString($_POST['firstName'])), //every first letter of words is capital
        //             "lastName" => ucwords($this->sanitizeString($_POST['lastName'])),
        //             "email" => $this->sanitizeString($_POST['email']), //all lower case/upper case
        //             "address" => ucwords($this->sanitizeString($_POST['address'])),
        //             "contactNo" => $this->sanitizeString($_POST['contactNo']),
        //             "birthdate" => ucwords($this->sanitizeString($_POST['birthdate']))
        //             //"username" => strtoupper($projectDesc[0]).strtolower(substr($projectDesc, 1, strlen($projectDesc))), //first letter first word lang ang capital
        //         ],
        //         'notRequired' => [
        //             "middleName" => ucwords($this->sanitizeString($_POST['middleName']))
        //         ]
        //     ];

        //     $result = json_decode($this->userService->updateUser($inputs), true);
        //     $url = "Location: ".SITE_URL.US."app/profile/".$_SESSION['accID'];

        //     if ($result['statusCode'] != 200) {
        //         $url .= "?error=".$result['message'];
        //     }

        //     header($url);
        // } else {
        //     $this->goToLogin();
        // }
    }

    private function goToIndex() {
        header("Location: ".SITE_URL."/user");
        exit();
    }
}

