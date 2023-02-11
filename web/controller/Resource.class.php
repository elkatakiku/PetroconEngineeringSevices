<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Service\ResourceService;

class Resource extends MainController {

    // Service
    private $resourceService;

    
    public function __construct() {
        $this->resourceService = new ResourceService;
    }

//    Load
    public function resourcePopup() {
        if (isset($_POST['projId'])) {
            $this->load('popup/resource', $_POST);
        } else {
            $this->load('popup/error');
        }
    }

    public function notesPopup() {
        if (isset($_POST['resource']) && isset($_POST['id']) && isset($_POST['notes'])) {
            $this->load('popup/notes', $_POST);
        } else {
            $this->load('popup/error');
        }
    }

//    Create
    public function new()
    {
        if (isset($_POST['form'])) {
            echo $this->resourceService->recordResource($_POST['form']);
        }
    }

//    Update
    public function update()
    {
        if (isset($_POST['form'])) {
            echo $this->resourceService->update($_POST['form']);
        }
    }

//    Notes
    public function updateNotes() {
        if (isset($_POST['form'])) {
            echo $this->resourceService->updateNotes($_POST['form']);
        }
    }


    public function remove()
    {
        if (isset($_POST['form'])) {
            echo $this->resourceService->remove($_POST['form']);
        }
    }

    public function list()
    {
        if (isset($_GET['projId'])) {
            echo $this->resourceService->list($_GET['projId']);
        }
    }
}