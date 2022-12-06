<?php

class SignupController extends Controller {

    private Register $register;
    private Login $login;
    private Account $account;

    private $lastname;
    private $firstname;
    private $middleName;
    private $contactNumber;
    private $birthdate;
    private $email;

    private $username;
    private $password;
    private $passwordRepeat;

    public function __construct(
        $lastname, $firstname, $middleName, $contactNumber, 
        $birthdate, $email, $username, $password, $passwordRepeat) {

        $this->login = $this->createEntity("Login");
        $this->register = $this->createEntity("Register");
        $this->account = $this->createEntity("Account");

        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->middleName = $middleName;
        $this->contactNumber = $contactNumber;
        $this->birthdate = $birthdate;
        $this->email = $email;

        $this->username = $username;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;

        $this->setModel(Model::AUTH);
    }

    public function signupUser() {

        if ($this->emptyInput()) {
            echo "<br>Please fill all required inputs.";
            return -101;
        }

        if (!$this->validUsername()) {
            echo "<br>Invalid username.";
            return -102;
        }

        if (!$this->pwdMatch()) {
            echo "<br>Password does not match.";
            return -103;
        }

        if ($this->checkUser()) {
            echo "<br>Username or email is taken";
            return -104;
        }

        if (!$this->isOldEnough()) {
            echo "<br>Should be 18 and above.";
            return -105;
        }

        // Test: Testing validations
        // return;
        
        
        // Create login
        $this->login->createLogin($this->username, $this->password);

        // Create register/user
        $this->register->createRegister(
            $this->lastname, $this->firstname, $this->middleName, $this->contactNumber, 
            $this->birthdate, $this->email, $this->login->getId()
        );
        
        // Create Account
        $this->account->createAccount(Account::CLIENT_TYPE, $this->register->getId(), $this->login->getId());

        // Insert Account
        if (!$this->getModel()->setUser($this->login, $this->register, $this->account)) {
            return -1;
        }

        return 1;
    }

    private function emptyInput() {
        return  !$this->lastname || !$this->firstname || !$this->middleName || !$this->contactNumber || 
                !$this->birthdate || !$this->email || !$this->username || !$this->password || !$this->passwordRepeat;
    }

    private function validUsername() {
        return preg_match("/^[a-zA-Z0-9]*$/", $this->username);
    }

    private function pwdMatch() {
        return $this->password === $this->passwordRepeat;
    }

    private function checkUser() {
        echo "<br>Will check user";
        return $this->getModel()->checkUser($this->username, $this->email);
    }

    private function isOldEnough() {
        $birthdate = new DateTime($this->birthdate);
        $currentDate =  new DateTime(date('Y-m-d'));
        $diff = $birthdate->diff($currentDate);
        return $diff->y >= 18;
    }
}