<?php

namespace Service;

// Core
use Core\Service;
// Repository
use Repository\TaskRepository;
// Models
use Model\Legend;
use Model\Project;
use Model\Task;
use Repository\ProjectRepository;


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