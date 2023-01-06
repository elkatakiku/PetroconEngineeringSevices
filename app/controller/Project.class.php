<?php


namespace Controller;

// Core
use \Core\Controller as MainController;

// Model
use \Model\Account as AccountModel;
use Model\Result;
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

    // public function samp() {
    //     echo __METHOD__;
    //     echo "<pre>";
    //     $filterStatus = $_POST['filterStatus'];
    //     parse_str($filterStatus, $form);
    //     // foreach ($status as $key => $value) {
    //     //     echo "{$key} => {$value} ";
    //     //     if (!$value) {
    //     //         echo "Value is empty";
    //     //         unset($status[$key]);
    //     //     }
    //     // }

    //     $filter = $form['status'];

    //     if (!$form['status'] || $form['status'] == "all") {
    //         unset($form['status']);
    //         $filter = '';
    //     }

        
    //     print_r($form);
    //     $this->getModel()->getProjects($filter);
    // }

    // || Projects
    // Get the projects
    public function list() {

        if (isset($_POST['form'])) {
            parse_str($_POST['form'], $form);

            $json_data = $this->projectService->getProjectList($form['status']);
        }
        
        $json_data['statusCode'] = 200;
        echo json_encode($json_data);
    }

    // Gets a project
    public function details($projectId) {
        
        $cleanId = $this->sanitizeString($projectId);
        if (!$cleanId) {
            $this->goToIndex();
            return;
        }

        // Get project
        $project = $this->projectService->getProjectDetails($cleanId);

        // View
        if ($project) {
            $this->view("project", "project", $project);
        } else {
            $this->goToIndex();
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

    // || Task
    // Get the tasks of a project
    public function tasks($projectId) {
        $tasks = $this->getModel()->getTasks($projectId);
        if ($tasks != -1) {
            $json_data['data'] = $tasks;
            $json_data['statusCode'] = 200;
        } else {
            $json_data['statusCode'] = 400;
        }
        
        echo json_encode($json_data);
    }

    // Creates a task
    public function newTask() {
        // WIP : Validation might trigger error
        if (isset($_POST['projId']) && isset($_POST['form'])) {
            $projectId = $_POST['projId'];
            parse_str($_POST['form'], $form);
        }

        $cleanId = $this->sanitizeString($projectId);

        if (!$cleanId) {
            $this->goToIndex();
            return;
        }

        $inputs = [
            'taskDesc' => $this->sanitizeString($form['taskDesc']),
            'planStart' => $this->sanitizeString($form['planStart']),
            'planEnd' => $this->sanitizeString($form['planEnd'])
        ];

        if(!$this->emptyInput($inputs)) {
            $taskCount = $this->getModel()->getTasksCount($cleanId);

            $task = $this->createEntity('Task');
            $task->createTask(
                $inputs['taskDesc'],
                ++$taskCount,
                $cleanId
            );
    
            $planId = $this->getModel()->getPlanId($cleanId);
    
            $planTask = $this->createEntity('TaskBar');
            $planTask->createTaskBar(
                $task->getId(),
                $planId,
                $inputs['planStart'],
                $inputs['planEnd']
            );

            if ($this->getModel()->setTask($task) && $this->getModel()->setTaskBar($planTask)) {
                $json_data['statusCode'] = 200;
            } else {
                $json_data['statusCode'] = 500;
                $json_data['message'] = 'An error occurred. Please try again.';
            }

        } else {
            // Error Handling
            $json_data['statusCode'] = 400;
            $json_data['message'] = 'Fill all required project inputs.';
        }

        echo json_encode($json_data);
    }

    // Gets activities of a task
    public function taskActivities() {

        if (isset($_GET['taskId'])) {
            $cleanId = $this->sanitizeString($_GET['taskId']);
            echo json_encode($this->projectService->getTaskActivities($cleanId));
        }
        // } else {
        //     $json_data['message'] = "No task id found";
        //     $json_data['statusCode'] = 404;
        // }

        // echo json_encode($json_data);
    }

    // Gets tasks' count
    public function taskCount() {
        if (isset($_POST['projId'])) {
            echo json_encode($this->projectService->taskCount($this->sanitizeString($_POST['projId'])));
        }
        // else {
        //     $json_data['statusCode'] = 400;
        // }

        // echo json_encode($json_data);
    }

    // || Timeline
    public function timeline($projectId) {
        $cleanId = $this->sanitizeString($projectId);
        echo json_encode($this->projectService->getTimeline($cleanId));
    }

    // || Legend
    public function legends() {
        if (isset($_GET['id'])) {
            $cleanId = $this->sanitizeString($_GET['id']);
            echo json_encode($this->projectService->getLegends($cleanId));
            // if ($legends != -1) {
            //     $json_data['data'] = $legends;
            //     $json_data['statusCode'] = 200;
            // } else {
            //     $json_data['statusCode'] = 500;
            // }
        } 
        // else {
        //     $json_data['message'] = "No project id found";
        //     $json_data['statusCode'] = 404;
        // }

        // echo json_encode($json_data);
    }

    public function newLegend() {

        if (isset($_POST['projId']) && isset($_POST['form'])) {
            $cleanId = $this->sanitizeString($_POST['projId']);
            parse_str($_POST['form'], $form);

            if (!$this->emptyInput($form) && $cleanId) {
                $json_data = $this->projectService->createLegend($cleanId, $form);
            } else {
                $json_data['message'] = "Fill all the required inputs.";
                $json_data['statusCode'] = 400;
            }
        } 
        // else {
        //     $json_data['message'] = "No project id or form found";
        //     $json_data['statusCode'] = 404;
        // }

        echo json_encode($json_data);
    }

    private function goToIndex() {
        header("Location: ".SITE_URL.US."project");
        exit();
    }
}