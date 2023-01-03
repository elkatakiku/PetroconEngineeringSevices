<?php

namespace Service;

// Repository

use Model\Legend;
use Model\Project;
use Repository\ProjectRepository;

// Models


class ProjectService {

    private $projectRepository;

    public function __construct() {
        $this->projectRepository = new ProjectRepository;
    }

    // Gets project list
    public function getProjectList($filter) {
        
        if (!$filter || $filter == "all") {
            $filter = '';
        }

        $projects = $this->projectRepository->getProjects($filter);
        if ($projects) {
            $result['statusCode'] = 200;
            $result['data'] = $projects;
        } else {
            $result['statusCode'] = 500;
            $result['message'] = 'An error occured';
        }
    
        return $result;
    }

    public function getProjectDetails($id) {
        return $this->projectRepository->getProject($id);
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
}