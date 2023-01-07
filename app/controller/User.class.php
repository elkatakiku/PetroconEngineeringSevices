<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use \Service\UserService;

class User extends MainController {

    private $userService;

    public function __construct() {
        $this->setType(MainController::ADMIN);
        $this->setPage(4);// page kung pangilan sa sidemenu

        $this->userService = new UserService;
    }

    public function index() {
        $this->view("user", "users-list"); // user = name ng folder sa view/ users-list = name ng file sa controller
    }

    public function list($userType) {//userType is parameter, ung value is ung nasa pangatlong slash or more sa url
       // pang view / sa url
        $this->view("user", "users-list", ['type' => $userType]);// key value pair / call "" sa view to print value
    } 

    public function listUser() // pang api/ to get data
    {
        if (isset($_GET['type'])) {
            echo $this->userService->getUserList($_GET['type']);
        }
    }

    public function userman() { //function name - userman

       

        //  $_POST['name'];
        //  $_POST['uname'];
        //  $_POST['email'];
        //  $_POST['pass'];
        //  $_POST['passr'];
        //  $_POST['position'];
        //  $_POST['address'];
        //  $_POST['contact'];
        //  $_POST['bdate'];
    }


    //CREATES NEW USER
    public function new() { // button submit
        echo __METHOD__;
        if (isset($_POST['createUser'])) {
            $inputs = [
                    "lastname" => ucwords($this->sanitizeString($_POST['lastname'])),
                    "firstname" => ucwords($this->sanitizeString($_POST['firstname'])),
                    "middleName" => ucwords($this->sanitizeString($_POST['middleName'])), // pag ucwords captal everyfirstletter
                    "username" => ($this->sanitizeString($_POST['username'])),
                    "email" => ($this->sanitizeString($_POST['email'])),
                    "password" =>  ($this->sanitizeString($_POST['password'])), 
                    "passwordRepeat" =>  ($this->sanitizeString($_POST['passwordRepeat'])),//pag str capital every first word first lettter
                    "position" => ucwords($this->sanitizeString($_POST['position'])),
                    "address" => ($this->sanitizeString($_POST['address'])),
                    "contactNumber" => strtoupper($this->sanitizeString($_POST['contactNumber'])),
                    "birthdate" => ($this->sanitizeString($_POST['birthdate']))
                ];
        }
        var_dump($inputs);// displaying all info about the data
        var_dump($this->userService->signup($inputs));


        if($this->emptyInput($inputs)) {
            // Error Handling
            // Code here
            echo "<br>Please fill all required user inputs.";
            return;
        }
        
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


    
    // Profile
    public function profile($userId)
    {
        $this->setPage(7);// page kung pangilan sa sidemenu
        $user = json_decode($this->userService->getUser($userId), true);

        if ($user['statusCode'] == 200) {
            $this->view("profile", "profile", $user['data']);
        } else {
            $this->goToLanding();
        }
    }

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
            $url = "Location: ".SITE_URL.US."user/profile/".$_SESSION['accID'];

            if ($result['statusCode'] != 200) {
                $url .= "?error=".$result['message'];
            }

            header($url);
        } else {
            $this->goToLanding();
        }
    }

    // Change password view
    public function password()
    {
        $this->view("profile", "changepass", ['id' => $_SESSION['accID']]);
    }

    // Change pass action
    public function changePass()
    {
        if (isset($_POST['changePass'])) {
            unset($_POST['changePass']);

            $result = json_decode($this->userService->changePassword($_POST), true);
            $url = "Location: ".SITE_URL.US."profile/password";

            if ($result['statusCode'] == 200) {
                $url .= "?success=password changed";
            } else {
                $url .= "?error=".$result['message'];
            }

            header($url);
        } else {
            $this->goToLanding();
        }
    }
}

