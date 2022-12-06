<?php

class ProjectsController extends Controller {

    public function __construct() {
        $this->setType(Controller::ADMIN);
        $this->setPage(2);
    }

    public function index() {
        $this->view("project/project-list");
    }

    // Remove default param
    public function project($projectId = "") { 
        // echo "Project view";
        $this->view("project/project");
    }
}