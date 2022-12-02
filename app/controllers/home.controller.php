<?php

class Home extends Controller {
    
    public function index($name = '') {
        // echo "home/index <br>";

        // $user = $this->model("User");
        // $user->name = $name;

        // echo $user->name;
        $this->view("home/index", ['name' => "eli"]);
    }

    public function login() {
        echo "home/login<br>";
        echo "display login here";
    }

    public function post() {
        echo $_POST['samp'];
    }
}