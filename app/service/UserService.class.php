<?php

namespace Service;

// Models

use Core\Service;
use \Model\Result as Result;
use \Model\Login as Login;
use \Model\Register as Register;
use \Model\Account as Account;

// Tools
use DateTime;


class UserService extends Service{

    private $userRepository;

    public function __construct() {
        $this->userRepository = new \Repository\UserRepository;
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

    // Get
    public function getUser($userId) {
        $cleanId = $this->sanitizeString($userId);

        if ($cleanId) {
            // Gets the user
            if ($profile = $this->userRepository->getUser($userId)) {
                $response['data'] = $profile;
                $response['statusCode'] = 200;
             } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }
        return json_encode($response);
    }
    
    //Update User
    public function updateUser($userInfo) 
    {       
        if (!$this->emptyInput($userInfo['required'])) {
            $this->userRepository->update(array_merge($userInfo['required'], $userInfo['notRequired']));
            $response['statusCode'] = 200;
        } else {
            $response['message'] = "Please fill all the required inputs";
            $response['statusCode'] = 400;
        }

        return json_encode($response);
    }

    // Changes password
    public function changePassword(array $form)
    {
        $input = [
            'id' => $this->sanitizeString($form['id']),
            'oldPass' => $this->sanitizeString($form['oldPass']),
            'newPass' => $this->sanitizeString($form['newPass']),
            'newPassRepeat' => $this->sanitizeString($form['newPassRepeat'])
        ];

        if (!$this->emptyInput($input)) {
            $login = $this->userRepository->getLoginById($input['id']);

            if (!password_verify($input['oldPass'], $login->getPassword())) 
            {
                $response['statusCode'] = 400;
                $response['message'] = "Current password is incorrect.";
            } 
            else if ($input['newPass'] !== $input['newPassRepeat']) 
            {
                $response['statusCode'] = 400;
                $response['message'] = "New password is does not match.";
            } else {   
                $this->userRepository->changePassword($input['newPass'], $input['id']);
                $response['statusCode'] = 200;
            }
        } else {
            $response['statusCode'] = 400;
            $response['message'] = "Please fill all the required inputs.";
        }

        return json_encode($response);
    }

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