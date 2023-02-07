<?php

namespace Controller;

use \Core\Controller as MainController;
use Model\Account;
use Service\PeopleService;
use Service\ProjectService;
use Service\UserService;

class Project extends MainController {

    // Service
    private $projectService;

    public function __construct() {
        parent::__construct();
        $this->setPage('#projectsMenu');

        $this->projectService = new ProjectService;

        if (!isset($_SESSION['accID'])) {
            $this->goToLogin();
        }
    }

    public function index() {
        header("Location: ".SITE_URL."/project/list");
        exit();
    }

    public function list()
    {
        $this->view("project", "project-list");
    }

    // || Projects
    // Gets the projects
    public function getList() {
        if (isset($_POST['form'])) {
            echo $this->projectService->getProjectList($_POST['form']);
        }
    }

    public function gets($status) {
        var_dump($_SESSION['accID']);
        $this->projectService->getProjectList('status='.$status);
    }

    // Gets a project
    public function details($projectId) {
        $project = json_decode($this->projectService->getProjectDetails($projectId), true);

        if ($project['statusCode'] == 200) {
            $this->view("project", "project", ['project' => $project['data']]);
        } else {
            $this->goToIndex();
        }
    }

    // Gets project info
    public function get() {
        if (isset($_GET['projId'])) {
            echo $this->projectService->getProjectDetails($_GET['projId']);
        }
    }

    // New-project view
    public function new() {
        $this->view(
            "project",
            "new-project"
//            ['companyList' => $this->projectService->getCompanyList(), 'clientList' => $this->projectService->getClientList()]
        );
    }

    // Creates new project
    public function newProject() {
        if (isset($_POST['form'])) {
            echo $this->projectService->createProject($_POST['form']);
        }
    }

//    DEBUG: Completion date
    public function completiondate($projectId) {
//        $this->projectService->completionDate($projectId);
    }

    public function update() {
        if (isset($_POST['form'])) {
            echo $this->projectService->update($_POST['form']);
        }
    }

    public function mark() {
        if (isset($_POST['doneSubmit'])) {
            if($this->projectService->mark($_POST['id'], $_POST['done'])) {
                header("Location: ".SITE_URL."/project/details/".$_POST['id']);
                exit();
            }
        }

        $this->goToIndex();
    }

    public function remove() {
        if (isset($_POST['form'])) {
            echo $this->projectService->remove($_POST['form']);
        }
    }

    public function invitation(string $projectId)
    {
        $project = json_decode($this->projectService->getProjectDetails($projectId), true);

        if ($project['statusCode'] == 200) 
        {
            $userService = new UserService();
            $this->view(
                "project",
                "invitations",
                ['project' => $project['data'], 'accountTypes' => $userService->getAccountTypes()]
            );
        } 
        else 
        {
            $this->goToIndex();
        }
    }

    private function goToIndex() {
        header("Location: ".SITE_URL."/project");
        exit();
    }

//    Views
    public function completion()
    {
        if (isset($_GET['project']) && isset($_GET['task'])) {
            $this->view(
                "project",
                "completion"
            );
        }

        var_dump($_GET);
    }
}