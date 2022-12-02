<?php

class Auth extends Controller {
    public function login() {
         echo "auth/login <br>";

         $this->view("auth/login");
    }
}