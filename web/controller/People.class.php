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
}
