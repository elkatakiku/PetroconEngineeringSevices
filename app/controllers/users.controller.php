<?php

class UsersController extends Controller {

    public function __construct() {
        // $this->setModel(Model::USERS);
        $this->setType(Controller::ADMIN);
        $this->setPage(4);
    }

    public function index() {
        return $this->view("users", "users-list");
    }

    public function user($id = null) {
        echo "WAW";
    }

}