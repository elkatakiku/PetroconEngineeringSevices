<?php

class HomeController extends Controller {

    public function __construct() {
        $this->setType(Controller::CLIENT);
        $this->setPage(1);
    }
    
    public function index($name = '') {
        // $user = $this->model("User");
        // $user->name = $name;

        // echo $user->name;
        $this->view("home/index", ['name' => "eli"]);
    }

    public function login() {
        // bring to bottom of landing page
        // header('Location: '.SITE_URL.US.'auth'.US.'login');
    }

    public function post() {
        // echo $_POST['samp'];
    }
}