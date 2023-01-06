<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
//use Service\ProfileService;

use \Service\UserService;

class Profile extends MainController {

    // Service
    private $userService;
    
    public function __construct() {
        $this->setType(MainController::ADMIN);
        $this->setPage(5);

        $this->userService = new UserService;
    }

    public function index($profileUserId) 
    {
        $user = json_decode($this->userService->getUser($profileUserId), true);

        if ($user['statusCode'] == 200) {
            $this->view("profile", "profile", $user['data']);
        } else {
            echo "hehe";
            // $this->goToLanding();
        }
    }

    //Modify Profile
    public function updateUser() 
    {
        if (isset($_POST['modifyProfile'])) 
        {
            $inputs = [
                'required' => [
                    "id" => ucwords($this->sanitizeString($_POST['id'])), //every first letter of words is capital
                    "firstName" => ucwords($this->sanitizeString($_POST['firstName'])), //every first letter of words is capital
                    "lastName" => ucwords($this->sanitizeString($_POST['lastName'])),
                    "email" => $this->sanitizeString($_POST['email']), //all lower case/upper case
                    "address" => ucwords($this->sanitizeString($_POST['address'])),
                    "contactNo" => $this->sanitizeString($_POST['contactNo']),
                    "birthdate" => ucwords($this->sanitizeString($_POST['birthdate']))
                    //"username" => strtoupper($projectDesc[0]).strtolower(substr($projectDesc, 1, strlen($projectDesc))), //first letter first word lang ang capital
                ],
                'notRequired' => [
                    "middleName" => ucwords($this->sanitizeString($_POST['middleName']))
                ]
            ];

            $result = json_decode($this->userService->updateUser($inputs), true);
            $url = "Location: ".SITE_URL.US."profile/index/".$inputs['required']['id'];

            if ($result['statusCode'] != 200) {
                $url .= "?error=".$result['message'];
            }

            header($url);
        } else {
            $this->goToLanding();
        }
    }

    // View change pass
    public function password()
    {
        $this->view("profile", "changepass", ['id' => $_SESSION['accID']]);
    }

    // Change pass
    public function changePass()
    {
        if (isset($_POST['changePass'])) {
            unset($_POST['changePass']);

            $result = json_decode($this->userService->changePassword($_POST), true);
            $url = "Location: ".SITE_URL.US."profile/password";

            if ($result['statusCode'] == 200) {
                $url .= "?success=password changed";
            } else {
                $url .= "?error=".$result['message'];
            }

            header($url);
        } else {
            $this->goToLanding();
        }
    }



    //     if($this->emptyInput(['inputs'])) {
    //         // Error Handling
    //         // Code here
    //         echo "<br>Please fill all required user inputs.";
    //         return;
    //    }

    //     echo "Modifying user profile";

    //     echo $_SESSION["accID"];
    //     $this->getModel();
    //     echo "<br>";
    //     echo "<pre>";
        
        // var_dump($this->getModel()->getUserAccount($_SESSION["accID"]));

        // CREATE AN ACCOUNT TO EXPERIMENT TO (SIGN UP)

        // Get registration id from account data

        // Createa register object and set properties to registration info

        // Set the changed input to register property

        // Update the register info in the db
    
        //echo "<br>";
        // var_dump($inputs);

        // Project
        // $profiles = $this->createEntity("User");
        // $profiles->setUser(
        //     $inputs['id'], $inputs['firstName'] $inputs['middleName'], $inputs['lastName'], $inputs['email'], 
        //     $inputs['address'], $inputs['contactNo'], $inputs['birthdate'], $inputs['log_id']
        // );


        
            // $result = 
            //     $this->getModel()->updateProfile();
      
        // Model update profile

        // Error handling ng model

    //}

    public function profilesChangePass() {
        if (isset($_POST['changePassword'])) {

            $inputs = [
                "currentPass" => $this->sanitizeString($_POST['currentPass']),
                "newPass" => $this->sanitizeString($_POST['newPass']), 
                "confirmNew" => $this->sanitizeString($_POST['confirmNew'])
            ];
        }

        if($this->emptyInput(['inputs'])) {
            // Error Handling
            // Code here
            echo "<br>Please fill all required user inputs.";
            return;
        }
    }
}