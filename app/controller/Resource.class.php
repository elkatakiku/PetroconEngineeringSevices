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

    public function new()
    {
        if (isset($_POST['form'])) {
            echo $this->resourceService->new($_POST['form']);
        }
    }

    public function update()
    {
        if (isset($_POST['form'])) {
            echo $this->resourceService->new($_POST['form']);
        }
    }

    public function list()
    {
        if (isset($_GET['projId'])) {
            echo $this->resourceService->list($_GET['projId']);
        }
    }
}