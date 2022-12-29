<?php

class ProfileController extends Controller {

    public function __construct() {
        $this->setModel(Model::PROFILE);
        $this->setType(Controller::ADMIN);
        $this->setPage(5);
    }

    public function index() {
        // echo "Working";
        $this->view("profile", "profile");
    }

    //Modify Profile
    public function profiles() {
        if (isset($_POST['modifyProfile'])) {

            $inputs = [
                "firstName" => ucwords($this->sanitizeString($_POST['firstName'])), //every first letter of words is capital
                "middleName" => ucwords($this->sanitizeString($_POST['middleName'])),
                "lastName" => ucwords($this->sanitizeString($_POST['lastName'])),
                "email" => $this->sanitizeString($_POST['email']), //all lower case/upper case
                "address" => ucwords($this->sanitizeString($_POST['address'])),
                "contactNo" => $this->sanitizeString($_POST['contactNo']),
                "birthdate" => ucwords($this->sanitizeString($_POST['birthdate']))

                //"username" => strtoupper($projectDesc[0]).strtolower(substr($projectDesc, 1, strlen($projectDesc))), //first letter first word lang ang capital
            ];
        }

        if($this->emptyInput(['inputs'])) {
            // Error Handling
            // Code here
            echo "<br>Please fill all required user inputs.";
            return;
        }
        echo "Modifying user profile";

        echo $_SESSION["accID"];
        echo "<br>";
        echo "<br>";
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

    }

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
        echo "Modifying user password";

            // Project
            $profiles = $this->createEntity("User");
            $profiles->setUser(
                $inputs['currentPass'], $inputs['newPass'], $inputs['confirmNew']
            );

            // $result = 
            //     $this->getModel()->updateProfile();
            
        // Model update profile

        // Error handling ng model

        }
    }