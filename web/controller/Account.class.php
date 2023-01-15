<?php

namespace Controller;

use \Core\Controller as MainController;
use Service\UserService;

class Account extends MainController {

    // Service
    private $userService;
    private $user;

    public function __construct() {
        parent::__construct();
        $this->setPage(7);
        
        $this->userService = new UserService;

        if (!isset($_SESSION['accID'])) {
            $this->goToLogin();
        }
    }

    public function index() {
        // $user = json_decode($this->userService->getUser($_SESSION['accID']), true);

        // if ($user['statusCode'] == 200) {
            $this->view("account", "profile");
        // } else {
            // $this->goToLogin();
            // header('Location: ' .SITE_URL.'/auth/logout');
            // exit();
        // }
    }

    // Employee positions list
    public function positions()
    {
        echo $this->userService->getEmployeePositions();
    }

    public function changepass()
    {
        $this->view("account", "changepass");
    }

    // public function new() {

    //     if (isset($_POST['projId']) && isset($_POST['form'])) {
    //         echo $this->userService->new($_POST['projId'], $_POST['form']);
    //     } 
    // }

    // }
    
    // public function update() {
    //     if (isset($_POST['id']) && isset($_POST['form'])) {
    //         echo $this->accountService->update($_POST['id'], $_POST['form']);
    //     }
    // }

    // public function remove() {
    //     if (isset($_POST['id'])) {
    //         echo $this->accountService->remove($_POST['id']);
    //     }
    // }

    // public function list() {
    //     if (isset($_GET['id'])) {
    //         echo $this->accountService->getList($_GET['id']);
    //     } 
    // }

}