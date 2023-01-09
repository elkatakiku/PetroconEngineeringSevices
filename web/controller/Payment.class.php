<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Service\PaymentService;

class Payment extends MainController {

    // Service
    private $paymentService;

    
    public function __construct() {
        $this->paymentService = new PaymentService;
    }

    public function new()
    {
        if (isset($_POST['form'])) {
            echo $this->paymentService->new($_POST['form']);
        }
    }

    public function update()
    {
        if (isset($_POST['form'])) {
            echo $this->paymentService->update($_POST['form']);
        }
    }

    public function remove()
    {
        if (isset($_POST['form'])) {
            echo $this->paymentService->remove($_POST['form']);
        }
    }

    public function list($id = null)
    {
        if (isset($_GET['projId'])) {
            echo $this->paymentService->list($_GET['projId']);
        } else {   
            echo $this->paymentService->list($id);
        }
    }
}