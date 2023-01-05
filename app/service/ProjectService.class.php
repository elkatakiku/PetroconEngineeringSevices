<?php

namespace Service;

// Repository

use Core\Service;
use Model\Legend;
use Model\Project;
use Repository\ProjectRepository;

// Models


class ProjectService extends Service{ 

    private $projectRepository;

    public function __construct() {
        $this->projectRepository = new ProjectRepository;
    }

    // Gets project list
    public function getProjectList($form) {
        parse_str($form, $input);

        if (!$this->emptyInput($input)) {
            
            if (!$input['status'] || $input['status'] == "all") {
                $input['status'] = '';
            }

            if ($projects = $this->projectRepository->getProjects($input['status'])) {
                $response['statusCode'] = 200;
                $response['data'] = $projects;
            } else {
                $response['statusCode'] = 500;
                $response['message'] = 'An error occured';
            }
        } else {
            $response['statusCode'] = 500;
        }
    
        return json_encode($response);
    }

    public function getProjectDetails($id) {
        $cleanId = $this->sanitizeString($id);

        // var_dump($cleanId);

        if ($cleanId) {
            // Gets the project details and returns view
            if ($project = $this->projectRepository->getProject($id)) {
                $response['data'] = $project;
                $response['statusCode'] = 200;
             } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }

        // var_dump($response);

        return json_encode($response);
        // return $this->projectRepository->getProject($id);
    }

    public function createProject($input) {
        // Project
        $project = new Project;
        $project->create(
            $input['project']['prjDescription'], $input['project']['prjLocation'], $input['project']['prjBuildingNo'], $input['project']['prjPurchaseOrd'], $input['project']['prjAwardDate'], 
            $input['client']['cmpnyName'], $input['client']['cmpnyRepresentative'], $input['client']['cmpnyContact']
        );

        // Legend: Plan
        $planLegend = new Legend;
        $planLegend->create(
            Legend::PLAN,
            "plan",
            $project->getId()
        );

        // Legend: Actual
        $actualLegend = new Legend;
        $actualLegend->create(
            Legend::ACTUAL,
            "actual",
            $project->getId()
        );

        $result = 
            $this->projectRepository->setProject($project) && 
            $this->projectRepository->setLegend($planLegend) &&
            $this->projectRepository->setLegend($actualLegend) &&
            $this->projectRepository->setProjectPlan($project->getId(), $planLegend->getId());

        if (!$result) {
            return false;
        }

        return $project->getId();
    }

    public function getTimeline(string $id) {
        $tasks = $this->projectRepository->getTimeline($id);
        if ($tasks != -1) {
            $result['data'] = $tasks;
            $result['statusCode'] = 200;
        } else {
            $result['statusCode'] = 400;
        }

        return $result;
    }

    public function getTaskActivities($id) {
        $activities = $this->projectRepository->getTaskActivities($id);
        if ($activities != -1) {
            $result['data'] = $activities;
            $result['statusCode'] = 200;
        } else {
            $result['statusCode'] = 500;
        }

        return $result;
    }

    public function getLegends($id) {
        $legends = $this->projectRepository->getLegends($id);
        if ($legends != -1) {
            $result['data'] = $legends;
            $result['statusCode'] = 200;
        } else {
            $result['statusCode'] = 500;
        }

        return $result;
    }

    public function createLegend($id, $input) {

        $legend = new Legend();
        $legend->create(
            $input['color'],
            $input['title'],
            $id
        );

        if ($this->projectRepository->setLegend($legend)) {
            $result['statusCode'] = 200;
        } else {
            $result['statusCode'] = 500;
        }

        return $result;
    }

    public function taskCount($id) {
        if (($taskCount = $this->projectRepository->getTasksCount($id)) >= 0) {
            $result['data'] = $taskCount;
            $result['statusCode'] = 200;
        } else {
            $result['statusCode'] = 500;
        }

        return $result;
    }

    public function update($form) {
        parse_str($form, $input);

        // var_dump($input);

        if (!$this->emptyInput($input)) {
            $this->projectRepository->update($input);
            $response['statusCode'] = 200;
        } else {
            $response['statusCode'] = 400;
            $response['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($response);
    }

    public function mark($id, $status) {
        // parse_str($form, $input);
        echo "<br>";
        // var_dump(empty($status));
        var_dump(!empty($id));
        var_dump(($status == 1 || $status == 0));

        if ($id && ($status == 1 || $status == 0)) {
            $this->projectRepository->mark($id, $status);
            // $response['statusCode'] = 200;
            echo "Updated";
            $response = true;
        } else {
            echo "No status";
            $response = false;
            // $response['statusCode'] = 400;
        }

        return $response;
    }

    public function remove($form) {
        parse_str($form, $input);

        // var_dump($input);
        
        if (!$this->emptyInput($input)) {
            $cleanId = $this->sanitizeString($input['id']);
            $result['statusCode'] = $this->projectRepository->delete($cleanId) ? 200 : 500;
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result);
    }
}