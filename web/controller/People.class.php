<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Service\PeopleService;

class People extends MainController {

    // Service
    private $peopleService;

    
    public function __construct() {
        $this->peopleService = new PeopleService;
    }

    public function new()
    {
        if (isset($_POST['form'])) {
            echo $this->peopleService->new($_POST['form']);
        }
    }

    public function update()
    {
        if (isset($_POST['form'])) {
            echo $this->peopleService->update($_POST['form']);
        }
    }

    public function remove()
    {
        if (isset($_POST['form'])) {
            echo $this->peopleService->remove($_POST['form']);
        }
    }

    public function list()
    {
        if (isset($_GET['projId'])) {
            echo $this->peopleService->list($_GET['projId']);
        }
    }

    // || Invitations
    public function invitations()
    {
        if (isset($_GET['projId'])) {
            echo $this->peopleService->invitationList($_GET['projId']);
        }
    }

    public function invite()
    {
        if (isset($_POST['form'])) {
            echo $this->peopleService->invite($_POST['form']);
        }
    }

    public function removeInvitation()
    {
        if (isset($_POST['form'])) {
            echo $this->peopleService->removeInvitation($_POST['form']);
        }
    }

    //  User
    public function joinedProjects() {
        if ($_GET['accountId']) {
            echo $this->peopleService->joinedProjects($_GET['accountId']);
        }
    }

//    Employees
    public function searchEmployees() {
        if ($_GET['form']) {
            echo $this->peopleService->searchEmployees($_GET['form']);
        }
    }
}
