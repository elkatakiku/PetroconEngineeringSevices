<?php

class AuthController extends Controller {
    private $action;

    public function __construct() {
        $this->setType(Controller::AUTH);
    }

    public function index() {
        $this->view("auth/login");
        // header('Location: '.SITE_URL.US.'auth'.US.'login');
    }

    public function login() {
        // View
        $this->view("auth/login");
    }

    public function loginUser() {
        // Control inputs

        // Model
        $user = $this->model("Auth"); // Sample model

        // If success
        header('Location: '.SITE_URL.US.'dashboard');
        // $this->view("dashboard/dashboard");
    }

    public function signup() {
        $this->action = "signup";
        $this->view("auth/login");
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