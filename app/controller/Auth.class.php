<?php

namespace Controller;

// Core
use \Core\Controller as MainController;

// Model
use \Model\Account as AccountModel;



class Auth extends MainController {

    const LOGIN = "login";
    const SIGNUP = "signup";
    const RESET = "reset";

    private $userService;

    public function __construct() {
        $this->setType(MainController::AUTH);
        $this->userService = new \Service\UserService();
    }

    public function index() {
        $this->view("auth", "login");
    }

    // // Login
    // public function login() {
    //     // Redirect to login if not logging in
    //     if (!isset($_POST['loginSubmit'])) {
    //         $this->view("auth", "login");
    //         return;
    //     }

    //     // Gets the inputs
    //     $inputs = [
    //         "username" => $this->sanitizeString($_POST['usernameInput']),
    //         "password" => $this->sanitizeString($_POST['passwordInput'])
    //     ];

    //     if (!$this->emptyInput($inputs)) {

    //         if ($this->userService->loginUser($inputs)->isSuccess()) {

    //             // Redirects user to their respective landing page
    //             switch ($_SESSION["accType"]) {
    //                 case AccountModel::ADMIN_TYPE:
    //                     header("Location: ".SITE_URL.US."dashboard");
    //                     exit();
    //                     break;
    //                 case AccountModel::EMPLOYEE_TYPE:
    //                 case AccountModel::WORKER_TYPE:
    //                     header("Location: ".SITE_URL.US."dashboard");
    //                     exit();
    //                     break;
    //                 case AccountModel::CLIENT_TYPE:
    //                     header("Location: ".SITE_URL.US."home/index");
    //                     exit();
    //                     break;
    //                 default:
    //                     echo "Different Account Type";
    //                     exit();
    //                     break;
    //             }
    //         } else {
    //             echo "<h1>Username or password does not match.</h1>";
    //             return;
    //         }
    //     } else {
    //         echo "<br>Please fill all required inputs.";
    //         $result =  -101;
    //     }
    // }

    // SignUp
    // public function signup() {
    //     // Redirect to login if not signing up
    //     if (!isset($_POST['signupSubmit'])) {
    //         $this->view("auth", "login", ["action" => Auth::SIGNUP]);
    //         return;
    //     }
        
    //     // Gets inputs
    //     $inputs = [
    //         "lastname" => ucwords($this->sanitizeString($_POST['lNameInput'])),
    //         "firstname" => ucwords($this->sanitizeString($_POST['fNameInput'])),
    //         "middleName" => strtoupper($this->sanitizeString($_POST['mNameInput'])),
    //         "contactNumber" => filter_input(INPUT_POST, 'contactInput', FILTER_SANITIZE_NUMBER_INT),
    //         "birthdate" => $this->sanitizeString($_POST['dobInput']),
    //         "email" => filter_input(INPUT_POST, 'emailInput', FILTER_SANITIZE_EMAIL),

    //         "username" => $this->sanitizeString($_POST['usernameInput']),
    //         "password" => $this->sanitizeString($_POST['passwordInput']),
    //         "passwordRepeat" => $this->sanitizeString($_POST['passwordRepeatInput'])
    //     ];
        
    //     // Validates inputs
    //     // if($this->signupUser($inputs) < 0) {
    //     //     // Error Handling
    //     //     // Code here
    //     //     echo "<h1>Error occured signing up</h1>"; 
    //     //    return;
    //     // }

    //     // Account creation success
    //     // header("Location: ".SITE_URL."/auth/login?signup=success");
    //     // exit();
    // }

    // private function signupUser($inputs) {

    //     if (!$this->emptyInput($inputs)) {
    //         echo "<br>Please fill all required inputs.";
    //         return -101;
    //     }

    //     if (!$this->validUsername($inputs["username"])) {
    //         echo "<br>Invalid username.";
    //         return -102;
    //     }

    //     if (!$this->pwdMatch($inputs["password"], $inputs["passwordRepeat"])) {
    //         echo "<br>Password does not match.";
    //         return -103;
    //     }

    //     if ($this->checkUser($inputs["username"], $inputs["email"])) {
    //         echo "<br>Username or email is taken";
    //         return -104;
    //     }

    //     if (!$this->isOldEnough($inputs["birthdate"])) {
    //         echo "<br>Should be 18 and above.";
    //         return -105;
    //     }

    //     // Test: Testing validations
    //     // return;

    //     $register = $this->createEntity("Register");
    //     $login = $this->createEntity("Login");
    //     $account = $this->createEntity("Account");
        
    //     // Create login
    //     $login->create($inputs["username"], $inputs["password"]);

    //     // Create register/user
    //     $register->create(
    //         $inputs["lastname"], $inputs["firstname"], $inputs["middleName"], $inputs["contactNumber"], 
    //         $inputs["birthdate"], $inputs["email"], $login->getId()
    //     );
        
    //     // Create Account
    //     $account->createAccount(
    //         AccountModel::CLIENT_TYPE, $register->getId(), $login->getId()
    //     );

    //     // Insert Account
    //     if (!$this->getModel()->setUser($login, $register, $account)) {
    //         return -1;
    //     }

    //     return 1;
    // }

    public function reset() {

        if (!isset($_POST['signupSubmit'])) {
            $this->view("auth", "login", ["action" => Auth::RESET]);
            return;
        }


    }

    public function verify() {
        $this->view("auth", "verify");
    }

    public function logout() {
        session_unset();
        session_destroy();

        header("Location: ".SITE_URL.US."home/index");
    }

}