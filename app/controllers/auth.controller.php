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

        // echo "<h1>Signup Controller</h1>";
        // echo "<hr>";

        $this->action = "login";

        // echo "signup submitted";

        $username = htmlspecialchars(strip_tags($_POST['usernameInput']));
        $password = htmlspecialchars(strip_tags($_POST['passwordInput']));

        // echo "<br>";
        // var_dump(!$lastname);
        // echo "<hr>";
        // echo $username;
        // echo "<br>";
        // echo $password;
        // echo "<hr>";

        $loginController = new LoginController(
            $username, 
            $password
        );

        // echo "<pre>";
        if($loginController->loginUser() < 0) {
            // Error Handling
            // echo '<hr>';
            // echo "Error here";
            return;
        }
        
        
        // echo "<hr>";
        // echo "Login success from " . __METHOD__;
        // echo "<hr>";

        // echo $_SESSION["accType"];
        // echo "<hr>";
        // echo Account::ADMIN_TYPE;
        
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
                # code...
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

        // echo "<h1>Signup Controller</h1>";
        // echo "<hr>";

        $this->action = "signup";

        // echo "signup submitted";
        
        $lastname = htmlspecialchars(strip_tags($_POST['lNameInput']));
        $firstname = htmlspecialchars(strip_tags($_POST['fNameInput']));
        $middleName = htmlspecialchars(strip_tags($_POST['mNameInput']));
        $contactNumber = htmlspecialchars(strip_tags($_POST['contactInput']));
        $birthdate = htmlspecialchars(strip_tags($_POST['dobInput']));
        $email = htmlspecialchars(strip_tags($_POST['emailInput']));

        $username = htmlspecialchars(strip_tags($_POST['usernameInput']));
        $password = htmlspecialchars(strip_tags($_POST['passwordInput']));
        $passwordRepeat = htmlspecialchars(strip_tags($_POST['passwordRepeatInput']));

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

        // echo "<pre>";
        if($signupController->signupUser() > 0) {
            // echo "<hr>";
            // echo "Account creation success";
            // echo "<hr>";

            header("Location: ".SITE_URL."/auth/login?signup=success");
            exit();
        }

        // Error Handling
        // echo "<br>";
        // echo __METHOD__;


        // echo "End";
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

    public function getAction() {
        return $this->action;
    }
}