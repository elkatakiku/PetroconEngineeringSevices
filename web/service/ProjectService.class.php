<?php

namespace Service;

// Repository

use Core\Service;
use Model\Account;
use Model\Legend;
use Model\Project;
use Repository\PeopleRepository;
use Repository\ProjectRepository;
use Repository\TaskRepository;

// Models


class ProjectService extends Service{ 

    private $projectRepository;
    private string $accountId;

    public function __construct() {
        $this->projectRepository = new ProjectRepository;

        $this->accountId = $_SESSION["accType"] != Account::ADMIN_TYPE ? $_SESSION["accID"] : '';
    }

    public function getProjectCount()
    {
        return $this->projectRepository->getAllProjectCount();
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
    
        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    // Gets project list
//    public function getProjectList($form) {
//        parse_str($form, $input);
//        $response['data'] = [];
//
//        if (!$this->emptyInput($input))
//        {
//            if ($input['status'] == "done") {
//                $input['status'] = 1;
//            } else if ($input['status'] == "ongoing") {
//                $input['status'] = 0;
//            }
//
//            if ($projects = $this->projectRepository->getProjects($input['status'])) {
//                $response['data'] = $projects;
//                $response['statusCode'] = 200;
//            } else {
//                $response['statusCode'] = 500;
//                $response['message'] = 'An error occurred';
//            }
//        } else {
//            $response['statusCode'] = 400;
//        }
//
//        return json_encode($response);
//    }

    public function getProjectList($form)
    {
        parse_str($form, $input);
        $response['data'] = [];

        if (!$this->emptyInput($input)) {
            $status = $input['status'];

            if ($status == "done") {
                $status = 1;
            } else if ($status == "ongoing") {
                $status = 0;
            }

            $projects = [];

    //        Gets respective projects list
            if ($_SESSION['accType'] == Account::ADMIN_TYPE) {
                $projects = $this->projectRepository->getProjects($status);
            } else {
                $projects = $this->projectRepository->getJoinedProjects($_SESSION['accID'], $status);
            }

    //        Gets projects completion date progress
            $taskRepository = new TaskRepository();
            foreach ($projects as $project) {
                $progress = $taskRepository->getProgress($project['id'])[0];
                $completionDate = '-';

                if ($progress && $progress['count'] > 0) {
                    $percent = number_format(
                        (($progress['progress'] / (100 * $progress['count'])) * 100),
                        2,
                        '.',
                        ''
                    );

                    $completion = $taskRepository->getCompletionDate($project['id'])[0];
                    $completionDate = date(" M. d, Y", strtotime($completion['start'])) . ' - ' . date(" M. d, Y", strtotime($completion['end']));
                } else {
                    $percent = 0;
                }

                $projectInfo['id'] = $project['id'];
                $projectInfo['description'] = $project['description'];
                $projectInfo['location'] = $project['location'];
                $projectInfo['company'] = $project['company'];
                $projectInfo['progress'] = $percent . '%';
                $projectInfo['completion'] = $completionDate;

                $response['data'][] = $projectInfo;
            }

        }  else {
            $response['statusCode'] = 400;
            $response['message'] = "Fill all the required inputs.";
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
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

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function createProject(string $form)
    {
        parse_str($form, $raw);

        $projectDesc = $this->sanitizeString($raw['description']);

        $input = [
            "project" => [
                "purchaseOrd" => ucwords($this->sanitizeString($raw['purchaseOrd'])),
                "awardDate" => ucwords($this->sanitizeString($raw['awardDate'])),
                "description" => $projectDesc ? strtoupper($projectDesc[0]).strtolower(substr($projectDesc, 1, strlen($projectDesc))) : '',
                "location" => ucwords($this->sanitizeString($raw['location'])),
                "buildingNo" => ucwords($this->sanitizeString($raw['buildingNo']))
            ],
            "client" => [
                "company" => ucwords($this->sanitizeString($raw['cmpnyName'])),
                "representative" => ucwords($this->sanitizeString($raw['cmpnyRepresentative'])),
                "contact" => $this->sanitizeString($raw['cmpnyContact'])
            ]
        ];

        if(!$this->emptyInput($input['project']) && !$this->emptyInput($input['client']))
        {
            // Project
            $project = new Project();
            $project->create(
                $input['project']['description'], $input['project']['location'], $input['project']['buildingNo'],
                $input['project']['purchaseOrd'], $input['project']['awardDate'],
                $input['client']['company'], $input['client']['representative'], $input['client']['contact']
            );

            $result['statusCode'] = $this->projectRepository->setProject($project) ? 200 : 500;
            $result['data'] = $project->getId();

        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
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

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function mark($id, $status) {
        if ($id && ($status == 1 || $status == 0)) {
            $this->projectRepository->markAsDone($id, $status);
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

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function joinProject(string $projId, string $regId)
    {
        if ($projId && $regId && $this->projectRepository->getProject($projId)) {   
            return $this->projectRepository->joinProject($projId, $regId);
        }
    }

    //    Company List
    public function getCompanyList() {
        return $this->projectRepository->getCompanyList();
    }

    //    Company List
    public function getClientList() {
        return $this->projectRepository->getClientList();
    }
}