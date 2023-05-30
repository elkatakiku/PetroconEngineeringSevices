<?php

namespace Service;

// Models

use Core\Service;
use DateTime;
use Exception;
use Includes\Mail;
use Model\Account as Account;
use Model\Activation;
use Model\Login as Login;
use Model\Register as Register;
use Model\Reset;
use Model\Result as Result;
use Repository\RoleRepository;
use Repository\UserRepository;

class UserService extends Service{

    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository;
    }

    // Login
    public function loginUser(array $form): Result
    {
        $input = [
            "username" => $this->sanitizeString($form['usernameInput']),
            "password" => $this->sanitizeString($form['passwordInput'])
        ];

        $result = new Result();
        $result->setStatus(false);

        if (!$this->emptyInput($input)) {
            $login = $this->userRepository->getLogin($input['username']);
            if ($login && password_verify($input['password'], $login->getPassword()))
            {
                $account = $this->userRepository->getAccountByLogin($login->getId());

                $_SESSION["accID"] = $account->getId();
                $_SESSION["accType"] = $account->getTypeId();
                $_SESSION["accRegister"] = $account->getRegisterId();

                $result->setStatus(true);
            } else {
                $result->setMessage("Username or password does not match.");
            }
        } else {
            $result->setMessage("Please fill all required inputs.");
        }

        return $result;
    }

    // Signup

    /**
     * @throws Exception
     */
    public function signup(string $form)
    {
        parse_str($form, $raw);
        // Gets inputs
        $input = [
            'required' => [
                "lastname" => ucwords($this->sanitizeString($raw['lastname'])),
                "firstname" => ucwords($this->sanitizeString($raw['firstname'])),
                "contactNumber" => filter_var($raw['contact'], FILTER_SANITIZE_NUMBER_INT),
                "address" => $this->sanitizeString($raw['address']),
                "birthdate" => $this->sanitizeString($raw['dob']),
                "email" => filter_var($raw['email'], FILTER_SANITIZE_EMAIL),
                
                "type" => $this->sanitizeString($raw['type']),
                "username" => $this->sanitizeString($raw['username']),
                "password" => $this->sanitizeString($raw['password']),
                "passwordRepeat" => $this->sanitizeString($raw['passwordRepeat'])
            ],
            'optional' => [
                "middlename" => strtoupper($this->sanitizeString($raw['middlename']))
            ]
        ];

        if ($this->emptyInput($input['required'])) {
            $response['statusCode'] = 400;
            $response['message'] = "Please fill all the required inputs.";
            return json_encode($response, JSON_NUMERIC_CHECK);
        } else if (!$this->isOldEnough($input['required']["birthdate"])) {
            $response['statusCode'] = 400;
            $response['message'] = "Should be 18 and above.";
            return json_encode($response, JSON_NUMERIC_CHECK);
        } else if (!$this->validUsername($input['required']["username"])) {
            $response['statusCode'] = 400;
            $response['message'] = "Invalid username.";
            return json_encode($response, JSON_NUMERIC_CHECK);
        } else if ($this->checkUser($input['required']["username"], $input['required']["email"])) {
            $response['statusCode'] = 400;
            $response['message'] = "Username or email is taken.";
            return json_encode($response, JSON_NUMERIC_CHECK);
        } else if (!$this->pwdMatch($input['required']["password"], $input['required']["passwordRepeat"])) {
            $response['statusCode'] = 400;
            $response['message'] = "Password does not match.";
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        $passValid = $this->validatePassword($input['required']["password"]);
        if (!$passValid['result']) {
            $response['statusCode'] = 400;
            $response['message'] = $passValid['message'];
            return json_encode($response, JSON_NUMERIC_CHECK);
        }
        
        $register = new Register();
        $login = new Login();
        $account = new Account();

        // Create login
        $login->create($input['required']["username"], $input['required']["password"]);

        $roleRepo = new RoleRepository();

        if (!$role = $roleRepo->find($input['required']['type'])) {
            $role = $roleRepo->get('client')->first();
        }

        // // Create register/user
        $register->create(
            $input['required']["lastname"], $input['required']["firstname"], $input['required']["contactNumber"], 
            $input['required']["birthdate"], $input['required']["email"], $login->getId(), $input['required']["address"]
        );
        if (isset($input['optional']["middlename"])) {
            $register->setMiddlename($input['optional']["middlename"]);
        }
        
        // // Create Account
        $account->createAccount(
            $role['id'], $register->getId(), $login->getId()
        );

        $response['statusCode']  = $this->setUser($login, $register, $account)->isSuccess() ? 200 : 500;
        
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function createAccount(array $invitation)
    {
        // Create login
        $login = new Login();
        $login->create($invitation['username'], $invitation['password']);

        // Create register/user
        $name = explode(",", $invitation['name']);
        $register = new Register();
        $register->temp($name[0], $name[1] ?? "", $invitation["email"], $login->getId());

        // Create Account
        $account = new Account();
        $account->createAccount($invitation['type_id'], $register->getId(), $login->getId());

        $this->setUser($login, $register, $account)->isSuccess();

        return $account->getId();
    }
    
    public function checkUsername(string $username)
    {
        return json_encode(['data' => !$this->userRepository->validateUsername($username)]);
    }

    public function checkEmail(string $email)
    {
        return json_encode(['data' => !$this->userRepository->isEmailTaken($email)]);
    }

    public function setUser($login, $register, $account): Result
    {
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

    public function getEmployeePositions()
    {
        $response['data'] = $this->userRepository->getEmployeePositions();
        $response['statusCode'] = 200;
        return json_encode($response, JSON_NUMERIC_CHECK);
    }


    // Get
    public function getUserRegister(string $regId)
    {
        $cleanId = $this->sanitizeString($regId);
        $response['data'] = [];

        if ($cleanId) 
        {
            if ($user = $this->userRepository->getRegister($cleanId)) {
                $response['data'] = $user;
                $response['statusCode'] = 200;
             } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    /**
     * @throws Exception
     */
    public function sendVerification(): bool
    {
        if ($request = $this->userRepository->verifyActivation($_SESSION['accID']))
        {
            $day = 86400;
            $sent_at = strtotime($request[0]['sent_at']);

            if (time() > ($sent_at + $day)) 
            {
                $code = bin2hex(random_bytes(32));
                
                if ($this->userRepository->updateActivationCode($request[0]['id'], $code)) 
                {
                    $user = $this->userRepository->getRegister($_SESSION['accRegister']);

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
        }
        else
        {
            echo "New code";
            $activation = new Activation;
            $activation->create(
                bin2hex(random_bytes(32)),
                $_SESSION['accID']
            );

            $this->userRepository->createActivation($activation);

            $user = $this->userRepository->getRegister($_SESSION['accRegister']);
            var_dump($user);

            return Mail::sendMail(
                'Account Verification',                         // Subject
                Mail::verify($user, $activation->getCode()),    // Body
                'elkatakiku@gmail.com'                          // Address / To
            );
        }

        return true;
    }

    public function activateAccount($uid, $key)
    {
        $cleanUid = $this->sanitizeString($uid);
        $cleanKey = $this->sanitizeString($key);

        if ($cleanUid && $cleanKey) {
            if ($activation = $this->userRepository->matchActivation($cleanUid, $cleanKey)) {
                echo "Match";
                if ($this->userRepository->activateAccount($activation[0]['acc_id'])) {
                    header("Location: ".SITE_URL."/account?account=activated");
                    exit();
                } else {
                    header("Location: ".SITE_URL);
                }
            }
        }

//        Error occurred
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

        return json_encode($response, JSON_NUMERIC_CHECK);
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

        if (!$this->emptyInput($input)) 
        {
            $passValid = $this->validatePassword($input['newPass']);
            if ($passValid && $passValid['result']) 
            {
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
                $response['message'] = $passValid['message'];
            }
        } else {
            $response['statusCode'] = 400;
            $response['message'] = "Please fill all the required inputs.";
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    // Get account types
    public function getAccountTypes()
    {
        return $this->userRepository->getAccountTypes();
    }

    // Get User List
    public function getUserList(string $form) 
    {
        parse_str($form, $input);
        $response['data'] = [];

        if (!$this->emptyInput($input)) 
        {
            if ($input['type'] == "all") {
                $input['type'] = '';
            }

            if ($projects = $this->userRepository->getUsers($input['type'])) {
                $response['data'] = $projects;
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 500;
                $response['message'] = 'An error occurred';
            }
        } else {
            $response['statusCode'] = 400;
        }
    
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getUserDetails(string $acctId)
    {
        $cleanId = $this->sanitizeString($acctId);
        $response['data'] = [];

        if ($cleanId) {
            // Gets the user details
            if ($user = $this->userRepository->getUserDetails($cleanId)) {
                $response['data'] = $user;
                $response['statusCode'] = 200;
             } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    // || Forgot Password
    public function forgotPassword(string $email)
    {
        $cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ($cleanEmail) 
        {    
            if ($user = $this->userRepository->getUserByEmail($cleanEmail)) 
            {
                $reset = new Reset;
                $reset->create($user[0]['log_id']);

                Mail::sendMail(
                    'Password Reset',
                    Mail::reset($reset),
                    $user[0]['email']
                );

                $this->userRepository->createResetRequest($reset);

                $response['statusCode'] = 200;
            } 
            else 
            {
                $response['statusCode'] = 500;
                $response['message'] = 'The email '.$cleanEmail.' does not match any account.';
            }
        } else {
            $response['statusCode'] = 400;
            $response['message'] = 'Enter your email address to reset password.';
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    // || Reset Password
    public function resetPassword(array $form)
    {
        $input = [
            "resetId" => $this->sanitizeString($form['id']),
            "password" => $this->sanitizeString($form['password']),
            "passwordRepeat" => $this->sanitizeString($form['passwordRepeat'])
        ];

        $response['resetId'] = $input['resetId'];

        // Checks if any input is empty
        if (!$this->emptyInput($input)) 
        {
            // Checks if passwords matched
            if ($this->pwdMatch($input['password'], $input['passwordRepeat'])) 
            {
                // Checks if a request has been made
                $reset = $this->userRepository->getResetRequest($input['resetId']);
                if ($reset && $reset[0]['used'] != 1)
                {
                    $this->userRepository->changePassword($input['password'], $reset[0]['log_id']);
                    $this->userRepository->exhaustReset($reset[0]['id']);
                    $response['statusCode'] = 200;
                } 
                else 
                {
                    $response['statusCode'] = 400;
                    $response['message'] = 'Unable to change the password.';
                }
            } 
            else 
            {
                $response['statusCode'] = 400;
                $response['message'] = 'Password does not match.';
            }
        } 
        else 
        {
            $response['statusCode'] = 400;
            $response['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function isResetUsed(string $resetId): bool
    {
        if ($reset = $this->userRepository->getResetRequest($resetId)) {
            return $reset[0]['used'] == 1;
        }

        return false;
    }

    // Inputs validation
    private function validUsername($username) {
        return preg_match("/^[a-zA-Z\d]*$/", $username);
    }

    public function validatePassword(string $password): array
    {
        $result['result'] = false;

        if (strlen($password) <= 8) {
            $result['message'] = "Your password must contain at least 8 characters!";
        }
        elseif(!preg_match("/\d+/",$password)) {
            $result['message'] = "Your password must contain at least 1 number!";
        }
        elseif(!preg_match("/[A-Z]+/",$password)) {
            $result['message'] = "Your password must contain at least 1 capital letter!";
        }
        elseif(!preg_match("/[a-z]+/",$password)) {
            $result['message'] = "Your password must contain at least 1 lowercase letter!";
        } else {
            $result['result'] = true;
        }
 
        return $result;
    }

    private function pwdMatch($password, $passwordRepeat): bool
    {
        return $password === $passwordRepeat;
    }

    private function checkUser($username, $email): bool
    {
        return $this->userRepository->checkUser($username, $email);
    }

    /**
     * @throws Exception
     */
    private function isOldEnough($birthdate): bool
    {
        $birthdate = new DateTime($birthdate);
        $currentDate =  new DateTime(date('Y-m-d'));
        $diff = $birthdate->diff($currentDate);
        return $diff->y >= 18;
    }

    public function remove(string $form)
    {
        parse_str($form, $input);

        if (!$this->emptyInput($input)) {
            $cleanId = $this->sanitizeString($input['id']);
            $result['statusCode'] = $this->userRepository->remove($cleanId) ? 200 : 500;
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }
}