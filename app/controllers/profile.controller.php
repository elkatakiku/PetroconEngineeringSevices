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

    public function profiles() {
        echo $_POST ["fullname"]; 
        echo "<br>";
        echo $_POST ["position"];
        echo "<br>";
        echo $_POST ["username"];
        echo "<br>";
        echo $_POST ["email"];
        echo "<br>";
    }

    public function profileschangepass() {
        echo "Haha";
    }
}