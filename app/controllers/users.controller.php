<?php

class UsersController extends Controller {
    public function __construct() {
        $this->setModel(Model::USERS); //constant variable na nilagay sa model
        $this->setType(Controller::ADMIN);
        $this->setPage(4);// page kung pangilan sa sidemenu
    }

    public function index() {
        $this->view("user", "users-list"); // user = name ng folder sa view/ users-list = name ng file sa controller
    }

    public function list($userType) {//userType is parameter, ung value is ung nasa pangatlong slash or more sa url
        // echo $userType;
        $this->view("user", "users-list", ['user' => "user", 'hgvhg' => "value", 'type' => $userType]);// call "" sa view to print value
    }


    public function userman() { //function name - userman

         $_POST['name'];
         $_POST['uname'];
         $_POST['email'];
         $_POST['pass'];
         $_POST['position'];
         $_POST['address'];
         $_POST['contact'];
         $_POST['bdate'];
    }

    // Creates a project
    // public function new() {
    //     // echo __METHOD__;
    //     if (!isset($_POST['createUser'])) {
    //         $inputs = [
                
    //                 "name" => ucwords($this->sanitizeString($_POST['name'])), // pag ucwords captal everyfirstletter
    //                 "uname" => ($this->sanitizeString($_POST['uname'])),
    //                 "email" => ($this->sanitizeString($_POST['email'])),
    //                 "pass" =>  ($this->sanitizeString($_POST['pass'])), //pag str capital every first word first lettter
    //                 "position" => ucwords($this->sanitizeString($_POST['position'])),
    //                 "address" => ($this->sanitizeString($_POST['address'])),
    //                 "contact" => strtoupper($this->sanitizeString($_POST['contact'])),
    //                 "bdate" => ($this->sanitizeString($_POST['bdate']))
    //             ];
    //     }

    //     if($this->emptyInput($inputs)) {
    //         // Error Handling
    //         // Code here
    //         echo "<br>Please fill all required user inputs.";
    //         return;
    //     }
        
    //     $login = $this->createEntity('Login');//object
    //      // Create login
    //     $login->createLogin($inputs["username"], $inputs["password"]);
    //     $login->getId();// will return id

    //      $idcontainer =  $login->getId();

    //      $user = $this->createEntity('User'); //object
    //      $user->getId();
    //      $user->createUser(
    //         $inputs['name'],
    //         $inputs['uname'],
    //         $inputs['email'],
    //         $inputs['pass'],
    //         $inputs['position'],
    //         $inputs['address'],
    //         $inputs['contact'],
    //         $inputs['bdate'],
    //         $login->getId()
    //     ) //access
        
    //     $account = $this->createEntity("Account");
    //      // Create Account
    //      $account->createAccount(
    //         Account::CLIENT_TYPE, $user->getId(), $login->getId());

        

    //     // $user = $this->getModel()->getsetUser($user);
    // }



}

