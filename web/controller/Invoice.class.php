<?php

namespace Controller;

use \Core\Controller as MainController;
use Service\LegendService;

class Invoice extends MainController {

    // Service
    private $invoiceService;

    public function __construct() {
        parent::__construct();
        $this->setPage(5);

        if (!isset($_SESSION['accID'])) {
            $this->goToLogin();
        }
    }

    public function index() {
        $this->view("invoice", "invoice-list");
    }

    public function new() {

        if (isset($_POST['projId']) && isset($_POST['form'])) {
            echo $this->invoiceService->new($_POST['projId'], $_POST['form']);
        } 

    }
    
    public function update() {
        if (isset($_POST['id']) && isset($_POST['form'])) {
            echo $this->invoiceService->update($_POST['id'], $_POST['form']);
        }
    }

    public function remove() {
        if (isset($_POST['id'])) {
            echo $this->invoiceService->remove($_POST['id']);
        }
    }

    public function list() {
        if (isset($_GET['id'])) {
            echo $this->invoiceService->getList($_GET['id']);
        } 
    }

}