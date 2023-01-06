<?php

namespace Controller;

use \Core\Controller as MainController;
use Service\ProjectService;

class Project extends MainController {

    // Service
    private $projectService;

    public function __construct() {
        $this->setType(MainController::ADMIN);
        $this->setPage(2);

        $this->projectService = new ProjectService;
    }

    public function index() {
        $this->view("project", "project-list");
    }

    // || Projects
    // Gets the projects
    public function list() {
        if (isset($_POST['form'])) {
            echo $this->projectService->getProjectList($_POST['form']);
        }
    }

    // Gets a project
    public function details($projectId) {
        $project = json_decode($this->projectService->getProjectDetails($projectId), true);

        if ($project['statusCode'] == 200) {
            $this->view("project", "project", $project['data']);
            return;
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
        $this->view("project", "new-project");
    }

    // Creates new project
    public function newProject() {
        if (isset($_POST['form'])) {
            parse_str($_POST['form'], $form);

            $projectDesc = $this->sanitizeString($form['prjDescription']);

            if ($projectDesc) {
            
                $input = [
                    "project" => [
                        "prjPurchaseOrd" => ucwords($this->sanitizeString($form['prjPurchaseOrd'])),
                        "prjAwardDate" => ucwords($this->sanitizeString($form['prjAwardDate'])),
                        "prjDescription" => strtoupper($projectDesc[0]).strtolower(substr($projectDesc, 1, strlen($projectDesc))),
                        "prjLocation" => ucwords($this->sanitizeString($form['prjLocation'])),
                        "prjBuildingNo" => ucwords($this->sanitizeString($form['prjBuildingNo']))
                    ],
                    "client" => [
                        "cmpnyName" => ucwords($this->sanitizeString($form['cmpnyName'])),
                        "cmpnyRepresentative" => ucwords($this->sanitizeString($form['cmpnyRepresentative'])),
                        "cmpnyContact" => $this->sanitizeString($form['cmpnyContact'])
                    ]
                ];

                if(!$this->emptyInput($input['project']) && !$this->emptyInput($input['client'])) {

                    $newProject = $this->projectService->createProject($input);

                    if ($newProject) {
                        $json_data['statusCode'] = 200;
                        $json_data['data'] = ['id' => $newProject];
                        echo json_encode($json_data);
                        return;
                    }

                    $json_data['statusCode'] = 500;
                    $json_data['message'] = 'An error occured. Please try again later.';
                    echo json_encode($json_data);
                    return;
                }
            }

        }

        $json_data['statusCode'] = 400;
        $json_data['message'] = 'Please fill all required inputs.';
        echo json_encode($json_data);
    }

    public function update() {
        if (isset($_POST['form'])) {
            echo $this->projectService->update($_POST['form']);
        }
    }

    public function mark() {
        if (isset($_POST['doneSubmit'])) {
            if($this->projectService->mark($_POST['id'], $_POST['done'])) {
                header("Location: ".SITE_URL.US."project/details/".$_POST['id']);
                exit();
                return;
            }
        }

        $this->goToIndex();
    }

    public function remove() {
        if (isset($_POST['form'])) {
            // echo "<pre>";
            // echo "<br>";
            // echo $_POST['form'];
            echo $this->projectService->remove($_POST['form']);
        }
    }

    // || Timeline
    public function timeline($projectId) {
        $cleanId = $this->sanitizeString($projectId);
        echo json_encode($this->projectService->getTimeline($cleanId));
    }

    private function goToIndex() {
        header("Location: ".SITE_URL.US."project");
        exit();
    }
}