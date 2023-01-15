<?php

namespace Controller;
use \Core\Controller as MainController;
use Service\ProjectService;

class Dashboard extends MainController {

    public function __construct() {
        parent::__construct();
        $this->setPage(1);

        if (!isset($_SESSION['accID'])) {
            $this->goToLogin();
        }
    }

    public function index() 
    {
        $projectService = new ProjectService;
        $this->view("home", "dashboard", [
            'count' => $projectService->getProjectCount(), 
            'chart' => json_decode($projectService->getProjectsCountByYear(date('Y')), true)['data']
        ]);
    }

    public function projectsCountByYear(string $year)
    {
        if ($year) {
            $projectService = new ProjectService;
            echo $projectService->getProjectsCountByYear($year);
        } else {
            header("Location: ".SITE_URL."/dashboard");
            exit();
        }
    }
}