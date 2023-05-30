<?php

namespace Service;

use Core\Service;
use DateTime;
use Exception;
use Model\Stopage;
use Model\Task;
use Repository\ProjectRepository;
use Repository\TaskRepository;


class TaskService extends Service{

    private TaskRepository $taskRepository;

    public function __construct() {
        $this->taskRepository = new TaskRepository;
    }

    // Creates a task
    public function createTask(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'projectId' => $this->sanitizeString($raw['projectId']),
            'description' =>  $this->sanitizeString($raw['description']),
            'start' => $this->sanitizeString($raw['start']),
            'end' => $this->sanitizeString($raw['end'])
        ];

        if(!$this->emptyInput($input))
        {
            $task = new Task;
            $task->create(
                $input['projectId'],
                $this->taskRepository->taskCount($input['projectId']) + 1,
                $input['description'],
                $input['start'],
                $input['end']
            );

            // Result validation
            if ($this->taskRepository->setTask($task))
            {
                $result['statusCode'] = 200;
                $result['message'] = 'Task created successfully.';
            } else {
                $result['statusCode'] = 500;
                $result['message'] = 'An error occurred.';
            }
        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    // Updates a task
    public function updateTask(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'id' => $this->sanitizeString($raw['id']),
            'description' =>  $this->sanitizeString($raw['description']),
            'start' => $this->sanitizeString($raw['start']),
            'end' => $this->sanitizeString($raw['end'])
        ];

        if(!$this->emptyInput($input))
        {
            $this->taskRepository->updateTask($input);
            $result['statusCode'] = 200;
            $result['message'] = 'Updated successfully.';
        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function updateProgress(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'id' => $this->sanitizeString($raw['id']),
            'progress' => filter_var($raw['progress'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100]])
        ];

        if (!$this->emptyInput($input)) {
            $this->taskRepository->updateProgress($input);
            $result['message'] = 'Progress update: '.$input['progress'].'%.';

//          Gets project id through task
            if ($task = $this->taskRepository->getTask($input['id']))
            {
//                Gets projects total progress
                $progress = $this->taskRepository->getProgress($task[0]['proj_id'])[0];

//                Update projects status based on project progress percentage
                $projectRepo = new ProjectRepository();
                if ((($progress['progress'] / (100 * $progress['count'])) * 100) == 100)
                {
                    $projectRepo->markAsDone($task[0]['proj_id'], 1);
                } else {
                    $projectRepo->markAsDone($task[0]['proj_id'], 0);
                }
            }

            $result['statusCode'] = 200;
        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function haltTask(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'id' => $this->sanitizeString($raw['id']),
            'reason' => $this->sanitizeString($raw['reason'])
        ];

        if (!$this->emptyInput($input))
        {
            $stoppage = new Stopage();
            $stoppage->create(
                $input['id'],
                $input['reason']
            );

            if ($end = $this->sanitizeString($raw['end'])) {
                $stoppage->setEnd($end);
            }

            $this->taskRepository->createStoppage($stoppage);
            $this->taskRepository->haltTask($input['id'], true);

            $result['statusCode'] = 200;
            $result['message'] = 'Task operation halted.';
        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function resumeTask(string $form)
    {
        parse_str($form, $raw);
        $input = [
            'id' => $this->sanitizeString($raw['id'])
        ];

        if (!$this->emptyInput($input) && $stoppge = $this->taskRepository->getTaskStoppage($input['id'])) {
            $this->taskRepository->haltTask($input['id'], false);
            $this->taskRepository->endStoppage($stoppge[0]['id'], date('Y-m-d H:i:s'));

            $result['statusCode'] = 200;
            $result['message'] = 'Task operation resumed.';
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    // Removes a task
    public function removeTask(string $request)
    {
        parse_str($request, $raw);
        $input = ['id' => $this->sanitizeString($raw['id'])];

        if (!$this->emptyInput($input)) {
            $cleanId = $this->sanitizeString($input['id']);
            if ($this->taskRepository->removeTask($cleanId)) {
                $result['statusCode'] = 200;
                $result['message'] = 'Task removed successfully.';
            } else {
                $result['statusCode'] = 500;
                $result['message'] = "An error occurred. Please try again.";
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    // Gets all tasks of a project
    public function getTasks($request) {
        $cleanId = $this->sanitizeString($request);
        $result['data'] = [];

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

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
     * @throws Exception
     */
    public function getTasksDetails(string $projectId) {
        $cleanId = $this->sanitizeString($projectId);

        if ($cleanId) 
        {
            $projectRepository = new ProjectRepository();
            if ($completionDate = $projectRepository->getCompletionDate($cleanId))
            {
                // Gets start date and end date of the project
                $startDate = $completionDate[0]['start'];
                $endDate = $completionDate[0]['end'];

                $dStart = new DateTime($startDate);
                $dEnd  = new DateTime($endDate);
                $dDiff = $dStart->diff($dEnd);

                // Number of days
                $days = ((int) $dDiff->format('%r%a')) + 1;
                // Chart header settings
                $months = ($dDiff->y * 12) + $dDiff->m;

//                var_dump($days);

                if ($tasks = $this->taskRepository->getActiveTasks($cleanId))
                {
                    //  Sets grid and span of task
                    for ($i=0; $i < count($tasks); $i++) {

                        //  Sets starting grid of task
                        $start = new DateTime($tasks[$i]['start']);
                        $startDiff = $dStart->diff($start);
                        $tasks[$i]['grid'] = ((int) $startDiff->format('%r%a')) + 1;

                        //  Sets ending grid/span of task
                        $end = new DateTime($tasks[$i]['end']);
                        $span = $start->diff($end);
                        $tasks[$i]['span'] = (int) $span->format('%r%a') + 1;
                    }

                    $result['data']['content'] = $tasks;

                    $result['statusCode'] = 200;
                }

                $result['data']['extra'] = [$startDate, $endDate, $projectId];
                $result['data']['month'] = $months;
                $result['data']['start'] = $startDate;
                $result['data']['end'] = $endDate;
                $result['data']['total_days'] = $days;
                $result['data']['grid'] = $days + 3;

            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
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

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

//    Stoppage
    public function getStoppage(string $taskId)
    {
        $cleanId = $this->sanitizeString($taskId);
        $result['data'] = [];

        if ($cleanId) {
            if ($stoppage = $this->taskRepository->getStoppage($cleanId)) {
                $result['data'] = $stoppage[0];
                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

//    Project Details
    public function initializePopup(string $projectId): array
    {
        $cleanId = $this->sanitizeString($projectId);
        $project = [];

        $projectRepo = new ProjectRepository();
        if ($cleanId && $completion = $projectRepo->getCompletionDate($projectId)) {
            $project['count'] = (int) $this->taskRepository->taskCount($projectId) + 1;
            $project['id'] = $projectId;
            $project['completion'] = $completion[0];
        }

        return $project;
    }

}