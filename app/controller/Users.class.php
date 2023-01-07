<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use \Service\UserService;

class Users extends MainController {

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


    
}

