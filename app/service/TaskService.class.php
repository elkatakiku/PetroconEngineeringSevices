<?php

namespace Service;

// Core
use Core\Service;
use DateTime;
// Repository
use Repository\TaskRepository;
// Models
use Model\Task;
use Repository\ActivityRepository;


class TaskService extends Service{

    private $taskRepository;

    public function __construct() {
        $this->taskRepository = new TaskRepository;
    }

    // Creates a task
    public function createTask($request) {
        // echo "<br>";
        // echo "<br>";
        // echo "<pre>";

        // echo __METHOD__;
        // echo "<br>";

        $input = $this->parseInput($request);
        // var_dump($input);
        unset($input['id']);
        unset($input['oldActivities']);
        // var_dump($input);

        // Validates input
        if(!$this->emptyInput($input))
        {
            $task = new Task;
            $task->create(
                $input['description'], 
                $this->taskRepository->taskCount($input['projId']) + 1,
                $input['projId']
            );

            // Result validation
            if ($this->taskRepository->setTask($task)) {
                $activityService = new ActivityService;
                $activityService->createActivities(
                    $task->getId(), 
                    $input['newActivities']
                );

                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
                $result['message'] = 'An error occured. Please try again later.';

            }
        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result);
    }

    // Updates a task
    public function updateTask($request, $deleted) {

        $input = $this->parseInput($request, true);
        $deletedActivity = json_decode($deleted);

        // echo "<br>";
        // var_dump($input);
        // echo "<br>";
        // var_dump($deletedActivity);

        $hasNewActs = true;

        if (!$input['newActivities']) {
            unset($input['newActivities']);
            $hasNewActs = false;
        }

        // Validates input
        if(!$this->emptyInput($input))
        {                
            // Updates task description
            $this->taskRepository->updateTask($input['id'], $input['description']);
            
            $activityService = new ActivityService;

            // Updates old activities
            $activityService->updateActivities(
                $input['oldActivities'], 
                $deletedActivity
            );

            $result['statusCode'] =  200;

            if ($hasNewActs) 
            {   // Creates activities
                if(!$activityService->createActivities($input['id'], $input['newActivities'])) 
                {   // Result validation
                    $result['statusCode'] = 500;
                }
            }

        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result);
    }

    // Removes a task
    public function removeTask($request) {
        // echo "<br>";
        // echo "<br>";
        // echo __METHOD__;
        // echo "<br>";
        // echo "<br>";
        parse_str($request, $input);

        // var_dump($input);
        
        if (!$this->emptyInput($input)) {
            $cleanId = $this->sanitizeString($input['id']);
            $result['statusCode'] = $this->taskRepository->deleteTask($cleanId) ? 200 : 500;
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result);
    }

    // Gets all tasks of a project
    public function getAllTasks($request) {
        $cleanId = $this->sanitizeString($request);

        if ($cleanId) {
            if ($tasks = $this->taskRepository->getActiveTasks($cleanId)) {
                $result['data'] = $tasks;
                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result);
    }

    public function getTasksDetails(string $projectId)
    {
        $cleanId = $this->sanitizeString($projectId);

        if ($cleanId) {

            if ($tasks = $this->taskRepository->getActiveTasks($cleanId)) {

                $startDates = [];
                $endDates = [];


                $activityRepository = new ActivityRepository;
                $activities = [];

                for ($i=0; $i < count($tasks); $i++) 
                {
                    $tasks[$i]['activity'] = $activityRepository->getActiveActivities($tasks[$i]['id']);

                    $activities = array_merge($activities, $tasks[$i]['activity']);
                }
                

                foreach ($activities as $activity) {
                    $startDates[] = $activity['start'];
                    $endDates[] = $activity['end'];
                }

                $startDates = array_map('strtotime', $startDates);
                $endDates = array_map('strtotime', $endDates);

                // Project start
                $startDate = date('Y-m-j', (min($startDates)));
                // Project end
                $endDate = date('Y-m-j', (max($endDates)));

                $dStart = new DateTime($startDate);
                $dEnd  = new DateTime($endDate);
                $dDiff = $dStart->diff($dEnd);

                $numDays = ((int) $dDiff->format('%r%a')) + 1;
                $header = $this->getDates($startDates, $endDates);


                // var_dump($tasks);

                // echo "Start diff";
                for ($i=0; $i < count($tasks); $i++) { 
                    for ($j=0; $j < count($tasks[$i]['activity']); $j++) { 
                        
                        // var_dump($tasks[$i]['activity'][$j]['start']);
                        // var_dump($tasks[$i]['activity'][$j]['end']);
                        $actStart = new DateTime($tasks[$i]['activity'][$j]['start']);
                        $startDiff = $dStart->diff($actStart);

                        $actEnd = new DateTime($tasks[$i]['activity'][$j]['end']);
                        $span = $actStart->diff($actEnd);

                        $tasks[$i]['activity'][$j]['grid'] = ((int) $startDiff->format('%r%a')) + 1;
                        $tasks[$i]['activity'][$j]['span'] = (int) $span->format('%r%a') + 1;
                    }
                }

                // var_dump($tasks);

                // var_dump($endDates);
                // var_dump($activities);

                // echo "End";
                // var_dump(end($tasks)['activity']);

                $result['data']['content'] = $tasks;
                $result['data']['header'] = $header;
                $result['data']['start'] = $startDate;
                $result['data']['end'] = $endDate;
                $result['data']['total_days'] = $numDays;

                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result);
    }

    private function getDates(array $startDates, array $endDates) {
        $months = [[], [], []];
        
        for ($i=0; $i < count($startDates); $i++) { 
            $start = date("n", $startDates[$i]);
            $end = date("n", $endDates[$i]);
            if (!in_array($start, $months[0])) {
                $months[0][] = $start;
                $months[2][] = date("Y", $startDates[$i]);
            } else if(!in_array($end, $months[0])) {
                $months[0][] = $end;
                $months[2][] = date("Y", $endDates[$i]);
            } 
            // else {
            //     var_dump("Nandun na");
            // }
        }

        
        $months[1][] = date('t', min($startDates)) - (date('j', min($startDates)) - 1);
        
        // echo "Looping";
        
        // var_dump((count($months[0])-1));
        
        for ($i=1; $i < (count($months[0])-1); $i++) { 
            // echo "Days in month";
            $months[1][] = cal_days_in_month(CAL_GREGORIAN, $months[0][$i], $months[2][$i]);
        }

        $months[1][] = (int)date('j', max($endDates));

        // var_dump($months);
        // echo "End get months";

        return $months;
    }

    // Gets all tasks of a project
    public function getTasksPlan($request) {
        $cleanId = $this->sanitizeString($request);

        if ($cleanId) {
            if ($tasks = $this->taskRepository->getPlans($cleanId)) {
                $result['data'] = $tasks;
                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result);
    }

    // Gets task count of a project
    public function getTaskCount($request) {
        $cleanId = $this->sanitizeString($request);
        if ($cleanId) {
            if (($taskCount = $this->taskRepository->taskCount($cleanId)) >= 0) {
                $result['data'] = $taskCount;
                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result);
    }

    // Converts json string activities to arrays
    private function parseInput($request, $hasOldActs = false) {
        // Converts json string to an associative array
        $input = json_decode($request, true);

        // Converts activities' json string to associative array
        for ($i=0; $i < count($input['newActivities']); $i++) {
            $jsonString = $input['newActivities'][$i];
            $input['newActivities'][$i] = json_decode($jsonString, true);
        }

        if ($hasOldActs) {
            for ($i=0; $i < count($input['oldActivities']); $i++) {
                $jsonString = $input['oldActivities'][$i];
                $input['oldActivities'][$i] = json_decode($jsonString, true);
            }
        }

        // var_dump($input);

        return $input;
    }

}