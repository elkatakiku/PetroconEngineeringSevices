<?php

class AuthController extends Controller {
    private $action;

    public function __construct() {
        $this->setType(Controller::AUTH);
    }

    public function index() {
        $this->view("auth/login");
    }

    public function login() {
        // if (!isset($_POST['loginSubmit'])) {
        //     return;
        // }
        // View
        $this->view("auth/login");
    }

    public function loginUser() {
        // Control inputs
        if (!isset($_POST['loginSubmit'])) {
            header("Location: ".SITE_URL."/auth/login");
            return;
        }

        require_once "login.controller.php";

        $this->action = "login";

        $username = htmlspecialchars(strip_tags($_POST['usernameInput']));
        $password = htmlspecialchars(strip_tags($_POST['passwordInput']));

        $loginController = new LoginController(
            $username, 
            $password
        );

        if($loginController->loginUser() < 0) {
            // Error Handling
            // Code here
            echo "<h1>Username or password does not match.</h1>";
            return;
        }
        
        // Login Success
        switch ($_SESSION["accType"]) {
            case Account::ADMIN_TYPE:
                header("Location: ".SITE_URL.US."dashboard");
                exit();
                break;
            case Account::EMPLOYEE_TYPE:
            case Account::WORKER_TYPE:
                header("Location: ".SITE_URL.US."dashboard");
                exit();
                break;
            case Account::CLIENT_TYPE:
                header("Location: ".SITE_URL.US."home/index");
                exit();
                break;
            default:
                echo "Different Account Type";
                exit();
                break;
        }
        
    }

    // SignUp
    public function signup() {
        if (!isset($_POST['signupSubmit'])) {
            $this->index();
            return;
        }
        
        require_once "signup.controller.php";

        $this->action = "signup";
        
        $lastname = ucwords(trim(htmlspecialchars(strip_tags($_POST['lNameInput']))));
        $firstname = ucwords(trim(htmlspecialchars(strip_tags($_POST['fNameInput']))));
        $middleName = strtoupper(trim(htmlspecialchars(strip_tags($_POST['mNameInput']))));
        $contactNumber = trim(htmlspecialchars(strip_tags($_POST['contactInput'])));
        $birthdate = trim(htmlspecialchars(strip_tags($_POST['dobInput'])));
        $email = trim(htmlspecialchars(strip_tags($_POST['emailInput'])));

        $username = trim(htmlspecialchars(strip_tags($_POST['usernameInput'])));
        $password = trim(htmlspecialchars(strip_tags($_POST['passwordInput'])));
        $passwordRepeat = trim(htmlspecialchars(strip_tags($_POST['passwordRepeatInput'])));

        $signupController = new SignupController(
            $lastname, 
            $firstname, 
            $middleName, 
            $contactNumber, 
            $birthdate, 
            $email, 
            $username, 
            $password, 
            $passwordRepeat
        );


        if($signupController->signupUser() < 0) {
            // Error Handling
            // Code here
            echo "<h1>Error occured signing up</h1>"; 
           return;
        }


        // Account creation success
        header("Location: ".SITE_URL."/auth/login?signup=success");
        exit();
    }

    public function reset() {
        $this->action = "reset";
        $this->view("auth/login");
    }

    public function verify() {
        $this->view("auth/verify");
    }

    public function recover_password() {
    }

    public function logout() {
        session_unset();
        session_destroy();

        header("Location: ".SITE_URL.US."home/index");
    }

    public function getAction() {
        return $this->action;
    }
}