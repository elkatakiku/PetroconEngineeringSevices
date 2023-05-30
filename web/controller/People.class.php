<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Service\PeopleService;

class People extends MainController {

    // Service
    private PeopleService $peopleService;

    
    public function __construct() {
        $this->peopleService = new PeopleService;
    }

//    Load
    public function teamPopup() {
        if (isset($_POST['projId'])) {
            $this->load('popup/jointeam', $_POST);
        } else {
            $this->load('popup/error');
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

    public function validateInvitationEmail() {
        if (isset($_GET['input'])) {
            echo $this->peopleService->validateInvitationEmail($_GET['input']);
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

//    Add to team
    public function searchPeople() {
        if ($_GET['searchStr']) {
            echo $this->peopleService->searchPeople($_GET['searchStr']);
        }
    }

    public function addToTeam()
    {
//        echo  __METHOD__;
//        var_dump($_POST);
        if (isset($_POST['projId']) && isset($_POST['email'])) {
//            echo 'Add to team';
            echo $this->peopleService->addToTeam($_POST);
        }
    }
}
