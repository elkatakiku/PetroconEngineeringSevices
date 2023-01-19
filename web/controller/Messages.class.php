<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Service\MessageService;
use Service\PaymentService;

class Messages extends MainController {

    // Service
    private $messageService;
    
    public function __construct() {
        parent::__construct();
        $this->setPage('#messagesMenu');

        $this->messageService = new MessageService;

        if (!isset($_SESSION['accID'])) {
            $this->goToLogin();
        }
    }

    public function index()
    {
        $this->view("message", "message");
    }

    public function send()
    {
        if (isset($_POST['form'])) {
            echo $this->messageService->new($_POST['form']);
        }
    }

    public function update()
    {
        if (isset($_POST['form'])) {
            echo $this->messageService->update($_POST['form']);
        }
    }

    public function remove()
    {
        if (isset($_POST['form'])) {
            echo $this->messageService->remove($_POST['form']);
        }
    }

    public function list($id = null)
    {
        if (isset($_GET['projId'])) {
            echo $this->messageService->list($_GET['projId']);
        } else {   
            echo $this->messageService->list($id);
        }
    }
}