<?php

namespace Service;

// Models

use Core\Service;
use \Model\Result as Result;
use \Model\Login as Login;
use \Model\Register as Register;
use \Model\Account as Account;
use \Model\Users as Users;

// Tools
use DateTime;
use Includes\Mail;
use Model\Activation;

class UserService extends Service{

    private $userRepository;

    public function __construct() {
        $this->userRepository = new \Repository\UserRepository;
    }

    // Login
    public function login($input) 
    {
        $result = new Result();

        if ($login = $this->userRepository->getLogin($input['username']))
        {
            if (password_verify($input['password'], $login->getPassword())) 
            {
                $account = $this->userRepository->getAccountByLogin($login->getId());
                var_dump($account);

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
    // public function signup($input) 
    // {
    //     echo __METHOD__;
    //     $result = new Result();

    //     if (!$this->validUsername($input["username"])) {
    //         $result->setStatus(false);
    //         $result->setMessage("Invalid username.");
    //         return $result;
    //     }

    //     if (!$this->pwdMatch($input["password"], $input["passwordRepeat"])) {
    //         $result->setStatus(false);
    //         $result->setMessage("Password does not match.");
    //         return $result;
    //     }

    //     if ($this->checkUser($input["username"], $input["email"])) {
    //         $result->setStatus(false);
    //         $result->setMessage("Username or email is taken.");
    //         return $result;
    //     }

    //     if (!$this->isOldEnough($input["birthdate"])) {
    //         $result->setStatus(false);
    //         $result->setMessage("Should be 18 and above.");
    //         return $result;
    //     }

        
    //     $register = new Register();
    //     $login = new Login();
    //     $account = new Account();

    //     // Create login
    //     $login->create($input["username"], $input["password"]);

    //     // Create register/user
    //     $register->create(
    //         $input["lastname"], $input["firstname"], $input["middleName"], $input["contactNumber"], 
    //         $input["birthdate"], $input["email"], $login->getId(), $input["address"]
    //     );
        
    //     // Create Account
    //     $account->createAccount(
    //         Account::CLIENT_TYPE, $register->getId(), $login->getId()
    //     );

    //     // Insert Account
    //     $signupResult = $this->setUser($login, $register, $account);
    //     if ($signupResult->isSuccess()) {
    //         // Account creation success
    //         // header("Location: ".SITE_URL."/login?signup=success");
    //         // exit();
    //         $result->setStatus(true);
    //         return $result;
    //     } else {
    //         $result->setStatus($signupResult->isSuccess());
    //     }

    //     return $result;
    // }

    // Signup
    public function signup(array $raw) 
    {
        // Gets inputs
        $input = [
            "lastname" => ucwords($this->sanitizeString($raw['lNameInput'])),
            "firstname" => ucwords($this->sanitizeString($raw['fNameInput'])),
            "middleName" => strtoupper($this->sanitizeString($raw['mNameInput'])),
            "contactNumber" => filter_var($raw['contactInput'], FILTER_SANITIZE_NUMBER_INT),
            "address" => $this->sanitizeString($raw['address']),
            "birthdate" => $this->sanitizeString($raw['dobInput']),
            "email" => filter_var($raw['emailInput'], FILTER_SANITIZE_EMAIL),

            "username" => $this->sanitizeString($raw['usernameInput']),
            "password" => $this->sanitizeString($raw['passwordInput']),
            "passwordRepeat" => $this->sanitizeString($raw['passwordRepeatInput'])
        ];

        $result = new Result();

        echo "<pre>";
        var_dump($input);

        if ($this->emptyInput($input)) {
            $result->setStatus(false);
            $result->setMessage("Please fill all the required inputs.");
            return $result;
        } else if (!$this->isOldEnough($input["birthdate"])) {
            $result->setStatus(false);
            $result->setMessage("Should be 18 and above.");
            return $result;
        } else if (!$this->validUsername($input["username"])) {
            $result->setStatus(false);
            $result->setMessage("Invalid username.");
            return $result;
        } else if ($this->checkUser($input["username"], $input["email"])) {
            $result->setStatus(false);
            $result->setMessage("Username or email is taken.");
            return $result;
        } else if (!$this->pwdMatch($input["password"], $input["passwordRepeat"])) {
            $result->setStatus(false);
            $result->setMessage("Password does not match.");
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
        // var_dump($login);
        // var_dump($register);
        // var_dump($account);

        // return;

        return $this->setUser($login, $register, $account);

        // $signupResult = $this->setUser($login, $register, $account);
        // if ($signupResult->isSuccess()) {
        //     // Account creation success
        //     // header("Location: ".SITE_URL."/login?signup=success");
        //     // exit();
        //     $result->setStatus(true);
        //     return $result;
        // } else {
        //     $result->setStatus($signupResult->isSuccess());
        // }

        // return $result;
    }

    private function setUser($login, $register, $account) {

        $result = new Result();
        $result->setStatus(true);

        if (!$this->userRepository->setLogin($login)) {
            $result->setStatus(false);
        }

        if (!$this->userRepository->setRegister($register)) {
            $result->setStatus(false);
        }

        if (!$this->userRepository->setAccount($account)) {
            $result->setStatus(false);
        }

        return $result;
    }

    // Reset

    // Verify


    // Get
    public function getUser($userId) {
        $cleanId = $this->sanitizeString($userId);
        $response['data'] = [];

        if ($cleanId) {
            // Gets the user
            if ($profile = $this->userRepository->getRegisterByAccount($cleanId)) {
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

    public function getUserRegister(string $regId)
    {
        $cleanId = $this->sanitizeString($regId);
        $response['data'] = [];

        if ($cleanId) 
        {
            if ($user = $this->userRepository->getUserByRegister($cleanId)) {
                $response['data'] = $user;
                $response['statusCode'] = 200;
             } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }

        return json_encode($response);
    }

    public function sendVerification()
    {
        echo __METHOD__;
        // if ($request = $this->userRepository->verifyActivation('PTRCN-ACCT-63aca07cd191')) {
        if ($request = $this->userRepository->verifyActivation($_SESSION['accID'])) {
            echo "Pending activation";

            $day = 86400;
            $sent_at = strtotime($request[0]['sent_at']);
            // var_dump($sent_at);
            // var_dump($sent_at + $day);
            // var_dump(time() > ($sent_at + $day));

            if (time() > ($sent_at + $day)) 
            {
                echo "Exceeds 24 hours";
                $code = bin2hex(random_bytes(32));
                
                if ($this->userRepository->updateActivationCode($request[0]['id'], $code)) 
                {
                    $user = $this->userRepository->getUserByRegister($_SESSION['accRegister']);

                    var_dump($user);

                    return Mail::sendMail(
                        'Account Verification',         // Subject
                        Mail::verify($user, $code),     // Body
                        'elkatakiku@gmail.com'          // Address / To
                    );
                } 
                else 
                {
                    echo "Error updating code";
                    return false;
                }
            }
        } else {
            echo "New code";
            $activation = new Activation;
            $activation->create(
                bin2hex(random_bytes(32)),
                $_SESSION['accID']
            );
            // var_dump($activation);

            $this->userRepository->createActivation($activation);

            $user = $this->userRepository->getUserByRegister($_SESSION['accRegister']);
            var_dump($user);

            return Mail::sendMail(
                'Account Verification',                         // Subject
                Mail::verify($user, $activation->getCode()),    // Body
                'elkatakiku@gmail.com'                          // Address / To
            );
        }

        return true;
        // $user = json_decode($this->getUserRegister($regId), true);
        // if ($user['statusCode'] == 200) {
        //     var_dump($user);
        //     var_dump($random_hash = bin2hex(random_bytes(32)));
        //     var_dump(Mail::verify($user['data'], $random_hash));
            // Mail::sendMail('Verify Account', 'BLAH BLAH', $user['email']);
            // if (Mail::sendMail('Verify Account', 'Ikaw din bih nanalo ka ng 10k', 'elkatakiku@gmail.com')) {
            //     echo "Sent";
            // } else {
            //     echo "Not sent";
            // }
        // }
    }

    public function activateAccount($uid, $key)
    {
        echo "<pre>";
        $cleanUid = $this->sanitizeString($uid);
        $cleanKey = $this->sanitizeString($key);

        var_dump($cleanUid, $cleanKey);

        if ($cleanUid && $cleanKey) {
            if ($activation = $this->userRepository->matchActivation($cleanUid, $cleanKey)) {
                echo "Match";
                if ($this->userRepository->activateAccount($activation[0]['acc_id'])) {
                    echo "Redirect";
                    header("Location: ".SITE_URL."/app?account=activated");
                    exit();
                    return;
                } else {
                    header("Location: ".SITE_URL."/app");
                }
            }
        }

        echo "An error occured";

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

    // 
    public function isActivated(string $accId)
    {
        $cleanId = $this->sanitizeString($accId);

        if ($cleanId) {        
            if ($account = $this->userRepository->getAccount($cleanId)) {
                var_dump($account);
                
            }
        }
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

    // Update

    // Get User List
    public function getUserList($form) { //form 
        // parse_str($form, $input);
        // $response['data'] = [];

        // if (!$this->emptyInput($input)) 
        // {            
        //     if ($input['status'] == "done") {
        //         $input['status'] = 1;
        //     } else if ($input['status'] == "ongoing") {
        //         $input['status'] = 0;
        //     }

        //     if (
                $projects = $this->userRepository->getUsers($form);
        //         ) {
                $response['data'] = $projects;
        //         $response['statusCode'] = 200;
        //     } else {
        //         $response['statusCode'] = 500;
        //         $response['message'] = 'An error occured';
        //     }
        // } else {
        //     $response['statusCode'] = 400;
        // }
    
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
        return $this->userRepository->checkUser($username, $email);
    }

    private function isOldEnough($birthdate) {
        $birthdate = new DateTime($birthdate);
        $currentDate =  new DateTime(date('Y-m-d'));
        $diff = $birthdate->diff($currentDate);
        return $diff->y >= 18;
    }
}