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

    public function samp() {
        echo __METHOD__;
        echo "<pre>";
        $filterStatus = $_POST['filterStatus'];
        parse_str($filterStatus, $filter_data);
        // foreach ($status as $key => $value) {
        //     echo "{$key} => {$value} ";
        //     if (!$value) {
        //         echo "Value is empty";
        //         unset($status[$key]);
        //     }
        // }

        $filter = $filter_data['status'];

        if (!$filter_data['status'] || $filter_data['status'] == "all") {
            unset($filter_data['status']);
            $filter = '';
        }

        
        print_r($filter_data);
        $this->getModel()->getProjects($filter);
    }

    // || Projects
    // Get the projects
    public function projects() {
        parse_str($_POST['filterStatus'], $filter_data);

        $filter = $filter_data['status'];

        if (!$filter_data['status'] || $filter_data['status'] == "all") {
            unset($filter_data['status']);
            $filter = '';
        }

        $projects = $this->getModel()->getProjects($filter);
        if ($projects != -1) {
            $json_data['data'] = $projects;
            $json_data['statusCode'] = 200;
        } else {
            $json_data['statusCode'] = 400;
        }
        
        echo json_encode($json_data);
    }

    // Gets a project
    public function project($projectId) {
        
        $cleanId = $this->sanitizeString($projectId);
        if (!$cleanId) {
            header("Location: ".SITE_URL.US."projects");
            exit();
        }
        
        // Get project
        $project = $this->getModel()->getProject($cleanId);

        
        $status = "";
        $isPaid = true;
        // echo "Project view";
        $this->view("project", "project", $project);
    }

    // Creates a project
    public function new() {
        // echo __METHOD__;
        if (!isset($_POST['createProject'])) {
            $this->view("project", "new-project");
            return;
        }

        // echo "<pre>";
        
        // echo "Post";

        $projectDesc = $this->sanitizeString($_POST['prjDescription']);

        $inputs = [
            "project" => [
                "prjPurchaseOrd" => ucwords($this->sanitizeString($_POST['prjPurchaseOrd'])),
                "prjAwardDate" => ucwords($this->sanitizeString($_POST['prjAwardDate'])),
                "prjDescription" => strtoupper($projectDesc[0]).strtolower(substr($projectDesc, 1, strlen($projectDesc))),
                "prjLocation" => ucwords($this->sanitizeString($_POST['prjLocation'])),
                "prjBuildingNo" => ucwords($this->sanitizeString($_POST['prjBuildingNo']))
            ],
            "client" => [
                "cmpnyName" => ucwords($this->sanitizeString($_POST['cmpnyName'])),
                "cmpnyRepresentative" => ucwords($this->sanitizeString($_POST['cmpnyRepresentative'])),
                "cmpnyContact" => $this->sanitizeString($_POST['cmpnyContact'])
            ]
        ];

        // var_dump($inputs);

        // echo "<br>Project Details<br>";
        // var_dump($inputs);

        $result = $this->createProject($inputs);

        if (!$result) {
            echo "Redirect with error";
            return;
        }

        // Project creation success
        header("Location: ".SITE_URL."/projects/project/".$result);
        exit();
    }

    private function createProject($inputs) {
        echo __METHOD__;
        // echo "<br>Project Details<br>";
        // var_dump($this->getModel());
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

        // Project
        $project = $this->createEntity("Project");
        $project->createProject(
            $inputs['project']['prjDescription'], $inputs['project']['prjLocation'], $inputs['project']['prjBuildingNo'], $inputs['project']['prjPurchaseOrd'], $inputs['project']['prjAwardDate'], 
            $inputs['client']['cmpnyName'], $inputs['client']['cmpnyRepresentative'], $inputs['client']['cmpnyContact']
        );

        // Legend: Plan
        $planLegend = $this->createEntity("Legend");
        $planLegend->createLegend(
            Legend::PLAN,
            "plan",
            $project->getId()
        );

        // Legend: Actual
        $actualLegend = $this->createEntity("Legend");
        $actualLegend->createLegend(
            Legend::ACTUAL,
            "actual",
            $project->getId()
        );

        echo "Passing to model project object";

        // var_dump($this->getModel());

        echo '<pre>';

        $result = 
            $this->getModel()->setProject($project) && 
            $this->getModel()->setLegend($planLegend) &&
            $this->getModel()->setLegend($actualLegend) &&
            $this->getModel()->setProjectPlan($project->getId(), $planLegend->getId());

        if (!$result) {
            echo "<h1>ERROR! Error occured creating project.</h1>"; 
           return false;
        }

        return $project->getId();
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
            header("Location: ".SITE_URL.US."projects");
            exit();
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
            $activities = $this->getModel()->getTaskActivities($_GET['taskId']);
            if ($activities != -1) {
                $json_data['data'] = $activities;
                $json_data['statusCode'] = 200;
            } else {
                $json_data['statusCode'] = 500;
            }
        } else {
            $json_data['message'] = "No task id found";
            $json_data['statusCode'] = 404;
        }

        echo json_encode($json_data);
    }

    // Gets tasks' count
    public function taskCount() {
        if (isset($_POST['projId'])) {
            $taskCount = $this->getModel()->getTasksCount($this->sanitizeString($_POST['projId']));
            if ($taskCount >= 0) {
                $json_data['data'] = $taskCount;
                $json_data['statusCode'] = 200;
            } else {
                $json_data['statusCode'] = 500;
            }
        }
        else {
            $json_data['statusCode'] = 400;
        }

        echo json_encode($json_data);
    }

    // || Timeline
    public function timeline($projectId) {
        $tasks = $this->getModel()->getTimeline($projectId);
        if ($tasks != -1) {
            $json_data['data'] = $tasks;
            $json_data['statusCode'] = 200;
        } else {
            $json_data['statusCode'] = 400;
        }
        
        echo json_encode($json_data);
    }

    // || Legend
    public function legends() {
        if (isset($_GET['id'])) {
            $legends = $this->getModel()->getLegends($_GET['id']);
            if ($legends != -1) {
                $json_data['data'] = $legends;
                $json_data['statusCode'] = 200;
            } else {
                $json_data['statusCode'] = 500;
            }
        } else {
            $json_data['message'] = "No project id found";
            $json_data['statusCode'] = 404;
        }

        echo json_encode($json_data);
    }

    public function newLegend() {

        if (isset($_POST['projId']) && isset($_POST['form'])) {
            $projectId = $this->sanitizeString($_POST['projId']);
            parse_str($_POST['form'], $form);

            if (!$this->emptyInput($form) && $projectId) {
                $legend = $this->createEntity("Legend");
                $legend->createLegend(
                    $form['color'],
                    $form['title'],
                    $projectId
                );
    
                if ($this->getModel()->setLegend($legend)) {
                    $json_data['statusCode'] = 200;
                } else {
                    $json_data['statusCode'] = 500;
                }
            } else {
                $json_data['message'] = "Fill all the required inputs.";
                $json_data['statusCode'] = 400;
            }

        } else {
            $json_data['message'] = "No project id or form found";
            $json_data['statusCode'] = 404;
        }

        echo json_encode($json_data);
    }
}