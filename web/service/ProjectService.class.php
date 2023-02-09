<?php

namespace Service;

// Repository

use Core\Service;
use Model\Account;
use Model\Legend;
use Model\Project;
use Repository\ProjectRepository;
use Repository\TaskRepository;

class ProjectService extends Service{ 

    private $projectRepository;

    public function __construct() {
        $this->projectRepository = new ProjectRepository;
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

    public function getProjectList($form)
    {
        parse_str($form, $input);
        $response['data'] = [];

        if (!$this->emptyInput($input))
        {
            $status = $input['status'];

            if ($status == "done") {
                $status = 1;
            } else if ($status == "ongoing") {
                $status = 0;
            }

//        Gets respective projects list
            if ($_SESSION['accType'] == Account::ADMIN_TYPE) {
                $projects = $this->projectRepository->getProjects($status);
            } else {
                $projects = $this->projectRepository->getJoinedProjects($_SESSION['accID'], $status);
            }

//        Gets projects completion date progress
            $taskRepository = new TaskRepository();
            foreach ($projects as $project)
            {
                $progress = $taskRepository->getProgress($project['id'])[0];

                if ($progress && $progress['count'] > 0) {
                    $percent = number_format((($progress['progress'] / (100 * $progress['count'])) * 100), 2, '.', '') . '%';
                } else {
                    $percent = "-";
                }

                $projectInfo['id'] = $project['id'];
                $projectInfo['description'] = $project['description'];
                $projectInfo['location'] = $project['location'];
                $projectInfo['company'] = $project['company'];
                $projectInfo['progress'] = $percent;
                $projectInfo['completion'] = date(" M. d, Y", strtotime($project['start'])) . ' - ' . date(" M. d, Y", strtotime($project['end']));

                $response['data'][] = $projectInfo;
            }

        }  else {
            $response['statusCode'] = 400;
            $response['message'] = "Fill all the required inputs.";
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

//    DEBUG: Completion date
    public function completionDate(string $projectid) {
//        echo '<pre>';
//        var_dump($date = $this->projectRepository->getCompletionDate($projectid)[0]);
//        $dStart = new \DateTime($date['start']);
//        $dEnd  = new \DateTime($date['end']);
//        $dDiff = $dStart->diff($dEnd);
//
//        $months = ($dDiff->y * 12) + $dDiff->m;
//        var_dump($months);

        $dStart = new \DateTime();
//        $dEnd  = new \DateTime(date("Y-m-t"));
//        $dDiff = $dStart->diff($dEnd);

        echo '<pre>';

//        TODO: Get current date
//        get the days of cd
        var_dump((int) $dStart->format('t'));
        $daysInMonth = (int) $dStart->format('t');
        var_dump($diff = ($daysInMonth - (int) $dStart->format('j')) + 1);
        if ($diff < $daysInMonth) {
            var_dump(30 - $diff);
            $dStart->modify('+ '.(30 - $diff).' day');
            var_dump($dStart);
        }

//        subtract to 30 days
//        Get date for next month with the subtracted days

        // Default tasks time
        $tasks = [time(), strtotime(date("Y-m-t"))];

        // Default Project start
        $startDate = date('Y-m-j', (min($tasks)));
        // Default Project end
        $endDate = date('Y-m-j', (max($tasks)));

        // Default number of days
        $days =  date('t');

        // Default number of months
        $months = 1;

//        echo $dDiff->format('%r%a') + 1;
    }

    public function getProjectDetails(string $id) {
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
                "buildingNo" => ucwords($this->sanitizeString($raw['buildingNo'])),
                "start" => $this->sanitizeString($raw['start']),
                "end" => $this->sanitizeString($raw['end'])
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
                $input['project']['purchaseOrd'], $input['project']['awardDate'], $input['project']['start'], $input['project']['end'],
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

    public function update($form) {
        parse_str($form, $input);

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