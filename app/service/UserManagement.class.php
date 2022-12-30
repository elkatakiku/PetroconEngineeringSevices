<?php

namespace Service;

// Models
use \Model\Result as Result;
use \Model\Login as Login;
use \Model\Register as Register;
use \Model\Account as Account;

// Tools
use DateTime;


class UserManagement {

    private $userRepository;

    public function __construct() {
        $this->userRepository = new \Repository\User;
    }

    // Login
    public function login($input) {

        $result = new Result();

        if ($login = $this->userRepository->getLogin($input['username'])) {
            if (password_verify($input['password'], $login->getPassword())) {

                $account = $this->userRepository->getAccount($login->getId());

                $_SESSION["accID"] = $account->getId();
                $_SESSION["accType"] = $account->getTypeId();
                $_SESSION["accRegister"] = $account->getRegisterId();

                $result->setStatus(true);
            } else {
                $result->setStatus(false);
                $result->setMessage("Password does not match");
            }
        } else {
            $result->setStatus(false);
            $result->setMessage("User not found");
        }

        return $result;
    }

    // Signup
    public function signup($input) {
        $result = new Result();

        if (!$this->validUsername($input["username"])) {
            $result->setStatus(false);
            $result->setMessage("Invalid username.");
            return $result;
        }

        if (!$this->pwdMatch($input["password"], $input["passwordRepeat"])) {
            $result->setStatus(false);
            $result->setMessage("Password does not match.");
            return $result;
        }

        if ($this->checkUser($input["username"], $input["email"])) {
            $result->setStatus(false);
            $result->setMessage("Username or email is taken.");
            return $result;
        }

        if (!$this->isOldEnough($input["birthdate"])) {
            $result->setStatus(false);
            $result->setMessage("Should be 18 and above.");
            return $result;
        }

        
        $register = new Register();
        $login = new Login();
        $account = new Account();

        // Create login
        $login->create($input["username"], $input["password"]);

        // Create register/user
        $register->create(
            $input["lastname"], $input["firstname"], $input["middleName"], $input["contactNumber"], 
            $input["birthdate"], $input["email"], $login->getId(), $input["address"]
        );
        
        // Create Account
        $account->createAccount(
            Account::CLIENT_TYPE, $register->getId(), $login->getId()
        );

        // Insert Account
        $signupResult = $this->setUser($login, $register, $account);
        if ($signupResult->isSuccess()) {
            // Account creation success
            header("Location: ".SITE_URL."/login?signup=success");
            exit();
            $result->setStatus(true);
            return $result;
        } else {
            $result->setStatus($signupResult->isSuccess());
        }

        return $result;
    }

    private function setUser($login, $register, $account) {

        $result = new Result();
        $result->setStatus(true);

        if (!$this->userRepository->setLogin($login)) {
            $result->setStatus(false);
            // $result->setMessage("Password does not match");
        }

        if (!$this->userRepository->setRegister($register)) {
            $result->setStatus(false);
            // $result->setMessage("Password does not match");
        }

        if (!$this->userRepository->setAccount($account)) {
            $result->setStatus(false);
            // $result->setMessage("Password does not match");
        }

        return $result;
    }

    // Reset

    // Verify

    // Update

    

    // Inputs validation
    private function validUsername($username) {
        return preg_match("/^[a-zA-Z0-9]*$/", $username);
    }

    private function pwdMatch($password, $passwordRepeat) {
        return $password === $passwordRepeat;
    }

    private function checkUser($username, $email) {
        echo "<br>Will check user";
        return $this->userRepository->checkUser($username, $email);
    }

    private function isOldEnough($birthdate) {
        $birthdate = new DateTime($birthdate);
        $currentDate =  new DateTime(date('Y-m-d'));
        $diff = $birthdate->diff($currentDate);
        return $diff->y >= 18;
    }
}