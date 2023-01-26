<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Service\TaskService;

class Task extends MainController {

    // Service
    private $taskService;

    public function __construct() {
        $this->taskService = new TaskService;
    }

    public function index() {
        $this->goToLogin();
    }

    public function new() {
        if (isset($_POST['form'])) {
            echo $this->taskService->createTask($_POST['form']);
        }
    }

    public function update() {
        if (isset($_POST['form'])) {
            echo $this->taskService->updateTask($_POST['form']);
        }
    }

    public function remove() {
        if (isset($_POST['form'])) {
            echo $this->taskService->removeTask($_POST['form']);
        }
    }

    public function list() {
        if (isset($_GET['projId'])) {
            echo $this->taskService->getTasks($_GET['projId']);
        }
    }

    public function count() {
        // echo __METHOD__;
        // echo "<br>";
        // echo "<br>";
        // echo "Hello";
        // echo "<pre>";
        if (isset($_GET['projId'])) {
            echo $this->taskService->getTaskCount($_GET['projId']);
        }
    }

    public function plans() {
        if (isset($_GET['projId'])) {
            echo $this->taskService->getTasksPlan($_GET['projId']);
        }
    }

    public function chart() {
        if (isset($_GET['projId'])) {
            echo $this->taskService->getTasksDetails($_GET['projId']);
        }
    }

//    DEBUG: Chart
    public function charts($proj) {
        echo '<pre>';
        echo $this->taskService->getTasksDetails($proj);
    }

//    Stoppage
    public function stoppage() {
        if (isset($_GET['taskId'])) {
            echo $this->taskService->getStoppage($_GET['taskId']);
        }
    }

}