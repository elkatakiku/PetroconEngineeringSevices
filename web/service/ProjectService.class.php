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

    public function getProjectCount()
    {
        return $this->projectRepository->getProjectCount();
    }

    public function getProjectsCountByYear(string $year)
    {
        // echo "<pre>";
        $cleanString = $this->sanitizeString($year);
        $response['data'] = [];

        if ($cleanString) {
            $data['years'] = $this->projectRepository->getYears();
            $data['projectsInYear'] = $this->projectRepository->projectsInYear($year);
            $response['data'] = $data;
            $response['statusCode'] = 200;
        } 
        else 
        {
            $response['statusCode'] = 400;
        }
    
        return json_encode($response);
    }

    // Gets project list
    public function getProjectList($form) {
        parse_str($form, $input);
        $response['data'] = [];

        if (!$this->emptyInput($input)) 
        {            
            if ($input['status'] == "done") {
                $input['status'] = 1;
            } else if ($input['status'] == "ongoing") {
                $input['status'] = 0;
            }

            if ($projects = $this->projectRepository->getProjects($input['status'])) {
                $response['data'] = $projects;
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 500;
                $response['message'] = 'An error occured';
            }
        } else {
            $response['statusCode'] = 400;
        }
    
        return json_encode($response);
    }

    public function getProjectDetails($id) {
        $cleanId = $this->sanitizeString($id);
        $response['data'] = [];

        if ($cleanId) {
            // Gets the project details and returns view
            if ($project = $this->projectRepository->getProject($id)) {
                $response['data'] = $project[0];
                $response['statusCode'] = 200;
             } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }

        return json_encode($response);
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
        if ($id && ($status == 1 || $status == 0)) {
            $this->projectRepository->mark($id, $status);
            $response = true;
        } else {
            $response = false;
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

    public function joinProject(string $projId, string $regId)
    {
        if ($projId && $regId && $this->projectRepository->getProject($projId)) {   
            return $this->projectRepository->joinProject($projId, $regId);
        }
    }
}