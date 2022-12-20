<?php

class ProjectsController extends Controller {

    public function __construct() {
        $this->setModel(Model::PROJECT);
        $this->setType(Controller::ADMIN);
        $this->setPage(2);
    }

    public function index() {
        $this->view("project", "project-list");
    }

    // Remove default param
    public function project($projectId = "") {
        
        $cleanId = $this->sanitizeString($projectId);
        // if (!$cleanId) {
        //     header("Location: ".SITE_URL.US."projects");
        // }
        
        // Get project
        $this->getModel()->setProjectId($cleanId);
        $this->getModel()->getProject();

        
        $status = "";
        $isPaid = true;
        // echo "Project view";
        // $this->view("project/project", ["status" => $status, "isPaid" => $isPaid]);
    }

    public function new() {
        if (!isset($_POST['createProject'])) {
            $this->view("project", "new-project");
            return;
        }

        echo "<pre>";
        
        echo "Post";

        $projWork = array(
            'prjWorkDay' => array(
                'filter'    => FILTER_VALIDATE_INT,
                'flags'     => FILTER_REQUIRE_ARRAY, 
                'options'   => array('min_range' => 1, 'max_range' => 7)
            ), 
            'prjWorkHour' => array(
                'filter'    => FILTER_VALIDATE_INT,
                'flags'     => FILTER_REQUIRE_ARRAY, 
                'options'   => array('min_range' => 1, 'max_range' => 2)
            )
        );

        $inputs = [
            "project" => [
                // Project
                "prjPurchaseOrd" => ucwords($this->sanitizeString($_POST['prjPurchaseOrd'])),
                "prjAwardDate" => ucwords($this->sanitizeString($_POST['prjAwardDate'])),
                "prjName" => ucwords($this->sanitizeString($_POST['prjName'])),
                "prjLocation" => ucwords($this->sanitizeString($_POST['prjLocation'])),
                "prjBuildingNo" => ucwords($this->sanitizeString($_POST['prjBuildingNo'])), 
                "prjWork" => filter_input_array(INPUT_POST, $projWork)
            ],
            "client" => [
                // Client
                "cmpnyName" => ucwords($this->sanitizeString($_POST['cmpnyName'])),
                "cmpnyRepresentative" => ucwords($this->sanitizeString($_POST['cmpnyRepresentative'])),
                "cmpnyContact" => $this->sanitizeString($_POST['cmpnyContact'])
            ]
        ];

        var_dump($inputs);

        echo "<br>Project Details<br>";
        var_dump($inputs);

        $this->createProject($inputs);

    }

    private function createProject($inputs) {
        echo __METHOD__;
        echo "<br>Project Details<br>";
        var_dump($this->getModel());
        // Validate inputs
        if($this->emptyInput($inputs['project'])) {
            // Error Handling
            // Code here
            echo "<br>Please fill all required project inputs.";
            return;
        }

        if($this->emptyInput($inputs['client'])) {
            // Error Handling
            // Code here
            echo "<br>Please fill all required client inputs.";
            return;
        }

        echo "Creating project object";

        $project = $this->createEntity("Project");
        $project->createProject(
            $inputs['project']['prjName'], $inputs['project']['prjLocation'], $inputs['project']['prjBuildingNo'], $inputs['project']['prjPurchaseOrd'], $inputs['project']['prjAwardDate'], 
            $inputs['client']['cmpnyName'], $inputs['client']['cmpnyRepresentative'], $inputs['client']['cmpnyContact']
        );

        echo "Passing to model project object";

        var_dump($this->getModel());

        $this->getModel()->setProject(
            $project->getId(),
            $project->getName(),
            $project->getLocation(),
            $project->getBuildingNumber(),
            $project->getPurchaseOrder(),
            $project->getAwardDate(),
            $project->getStatus(),
            $project->getActive(),
            $project->getCompany(),
            $project->getCompRepresentative(),
            $project->getCompContact()
        );
    }

    public function task($projectId = "") {

    }
}