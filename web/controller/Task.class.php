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
        // echo __METHOD__;
        // echo "<br>";
        // echo "<br>";
        if (isset($_POST['form'])) {
            // var_dump($_POST['form']);
            echo $this->taskService->createTask($_POST['form']);
        }
    }

    public function update() {
        // echo __METHOD__;
        // echo "<br>";
        // echo "<br>";

        if (isset($_POST['form']) && isset($_POST['deleted'])) {
            // echo "<pre>";
            // echo "<br>";
            // echo $_POST['form'];
            // echo "<br>";
            // echo $_POST['deleted'];
            echo $this->taskService->updateTask($_POST['form'], $_POST['deleted']);
        }
    }

    public function remove() {
        // echo __METHOD__;
        // echo "<br>";
        // echo "<br>";
        if (isset($_POST['form'])) {
            // echo "<pre>";
            // echo "<br>";
            // echo $_POST['form'];
            echo $this->taskService->removeTask($_POST['form']);
        }
    }

    public function list() {
        if (isset($_GET['projId'])) {
            echo $this->taskService->getAllTasks($_GET['projId']);
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

}