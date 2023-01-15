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
        $this->setPage(6);

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

    public function getList()
    {
        if (isset($_GET['form'])) {
            echo $this->userService->getUserList($_GET['form']);
        }
    }

    public function details(string $userId)
    {
        $user = json_decode($this->userService->getUserDetails($userId), true);

        if ($user['statusCode'] == 200) {
            $this->view("user", "user", ['account' => $user['data']]);
            // $this->view("user", "user");
            return;
        } else {
            $this->goToIndex();
        }
    }

    //CREATES NEW USER
    public function new() {

        $this->view("user", "new-user", ['acctTypes' => $this->userService->getAccountTypes()]);

        // if (isset($_POST['createUser'])) {
        //     $inputs = [
        //             "lastname" => ucwords($this->sanitizeString($_POST['lastname'])),
        //             "firstname" => ucwords($this->sanitizeString($_POST['firstname'])),
        //             "middleName" => ucwords($this->sanitizeString($_POST['middleName'])), // pag ucwords captal everyfirstletter
        //             "username" => ($this->sanitizeString($_POST['username'])),
        //             "email" => ($this->sanitizeString($_POST['email'])),
        //             "password" =>  ($this->sanitizeString($_POST['password'])), 
        //             "passwordRepeat" =>  ($this->sanitizeString($_POST['passwordRepeat'])),//pag str capital every first word first lettter
        //             "position" => ucwords($this->sanitizeString($_POST['position'])),
        //             "address" => ($this->sanitizeString($_POST['address'])),
        //             "contactNumber" => strtoupper($this->sanitizeString($_POST['contactNumber'])),
        //             "birthdate" => ($this->sanitizeString($_POST['birthdate']))
        //         ];
        // }
        // var_dump($inputs);// displaying all info about the data
        // var_dump($this->userService->signup($inputs));


        // if($this->emptyInput($inputs)) {
        //     // Error Handling
        //     // Code here
        //     echo "<br>Please fill all required user inputs.";
        //     return;
        // }





        
        // $login = $this->createEntity('Login');//object
        //  // Create login
        // $login->createLogin($inputs["username"], $inputs["password"]);
        // $login->getId();// will return id

        //  $idcontainer =  $login->getId();

        //  $user = $this->createEntity('User'); //object
        //  $user->getId();
        //  $user->createUser(
        //     $inputs['name'],
        //     $inputs['uname'],
        //     $inputs['email'],
        //     $inputs['pass'],
        //     $inputs['passr'],
        //     $inputs['position'],
        //     $inputs['address'],
        //     $inputs['contact'],
        //     $inputs['bdate'],
        //     $login->getId()
        // ) //access
        
        // $account = $this->createEntity("Account");
        //  // Create Account
        //  $account->createAccount(
        //     Account::CLIENT_TYPE, $user->getId(), $login->getId());

        

        // $user = $this->getModel()->getsetUser($user);
    }


    // || Functions
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

