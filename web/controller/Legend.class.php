<?php

namespace Controller;

use \Core\Controller as MainController;
use Service\LegendService;

class Legend extends MainController {

    // Service
    private $legendService;

    public function __construct() {
        $this->legendService = new LegendService;
    }

    public function index() {
        $this->goToLanding();
    }

    public function new() {

        if (isset($_POST['projId']) && isset($_POST['form'])) {
            echo $this->legendService->new($_POST['projId'], $_POST['form']);
        } 

    }
    
    public function update() {
        if (isset($_POST['id']) && isset($_POST['form'])) {
            echo $this->legendService->update($_POST['id'], $_POST['form']);
        }
    }

    public function remove() {
        if (isset($_POST['id'])) {
            echo $this->legendService->remove($_POST['id']);
        }
    }

    public function list() {
        if (isset($_GET['id'])) {
            echo $this->legendService->getList($_GET['id']);
        } 
    }

}