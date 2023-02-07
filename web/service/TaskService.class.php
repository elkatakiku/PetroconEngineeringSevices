<?php

namespace Service;

// Core
use Core\Service;
use DateTime;
// Repository
use Model\Stopage;
use Repository\ProjectRepository;
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

//            // Result validation
            $result['statusCode'] = $this->taskRepository->setTask($task) ? 200 : 500;
        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function createTask1(string $request)
    {
        parse_str($request, $raw);

        $input = [
            'task' => [
                'projectId' => $this->sanitizeString($raw['projectId']),
                'description' =>  $this->sanitizeString($raw['description']),
                'start' => $this->sanitizeString($raw['start']),
                'end' => $this->sanitizeString($raw['end']),
                'progress' => filter_var($raw['progress'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100]])
            ],
            'halt' => [
                'haltReason' => $this->sanitizeString($raw['haltReason']),
                'haltStart' => $this->sanitizeString($raw['haltStart'])
            ]
        ];

        $isHalted = isset($raw['isHalted']) && filter_var($raw['isHalted'],FILTER_VALIDATE_BOOLEAN);

        // Validates input
        // Stops process if task is halted and halt information are incomplete
        if(!$this->emptyInput($input['task']) && (!$isHalted || ($isHalted && !$this->emptyInput($input['halt']))))
        {
            $task = new Task;
            $task->create(
                $input['task']['projectId'],
                $this->taskRepository->taskCount($input['task']['projectId']) + 1,
                $input['task']['description'],
                $input['task']['start'],
                $input['task']['end'],
                $input['task']['progress'],
            );

            $task->setStopped($isHalted);

//            // Result validation
            if ($this->taskRepository->setTask($task))
            {
//                Checks if halted and creates log
                if ($isHalted) {
                    $haltEnd = $this->sanitizeString($raw['haltEnd']);
                    $this->createStoppage($task->getId(), $input['halt'], $haltEnd);
                }

                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
                $result['message'] = 'An error occured. Please try again later.';
            }
        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    // Updates a task
    public function updateTask(string $request)
    {
        parse_str($request, $raw);

        $input = [
            'task' => [
                'id' => $this->sanitizeString($raw['id']),
                'projectId' => $this->sanitizeString($raw['projectId']),
                'description' =>  $this->sanitizeString($raw['description']),
                'start' => $this->sanitizeString($raw['start']),
                'end' => $this->sanitizeString($raw['end']),
                'progress' => filter_var($raw['progress'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100]])
            ],
            'halt' => [
                'haltReason' => $this->sanitizeString($raw['haltReason']),
                'haltStart' => $this->sanitizeString($raw['haltStart'])
            ]
        ];

        $isHalted = isset($raw['isHalted']) && filter_var($raw['isHalted'],FILTER_VALIDATE_BOOLEAN);

        // Validates input
        // Stops process if task is halted and halt information are incomplete
        if(!$this->emptyInput($input['task']) && (!$isHalted || ($isHalted && !$this->emptyInput($input['halt']))))
        {
            // Result validation
            $this->taskRepository->updateTask($input['task'], $isHalted);

//            Checks project progress
            $COMPLETE = 100;
            $progress = $this->taskRepository->getProgress($input['task']['projectId'])[0];
            $projectDone = ((($progress['progress'] / (100 * $progress['count'])) * 100) == $COMPLETE);

            $projectRepository = new ProjectRepository();

            if ($projectDone) {
                $projectRepository->markAsDone($input['task']['projectId'], 1);
            } else {
                $projectRepository->markAsDone($input['task']['projectId'], 0);
            }


//          Checks if halted and creates log
            $haltId = $this->sanitizeString($raw['haltId']);

            if ($isHalted) {
                $haltEnd = $this->sanitizeString($raw['haltEnd']);
                if ($haltId) {
                    $this->taskRepository->updateStoppage($haltId, $input['halt'], $haltEnd);
                } else {
                    $this->createStoppage($input['task']['id'], $input['halt'], $haltEnd);
                }
            } else {
                if ($haltId) {
                    $this->taskRepository->updateStoppage($haltId, $input['halt'], date('Y-m-d'));
                }
            }

            $result['statusCode'] = 200;
            $result['done'] = $projectDone;
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
//            TODO: Create stoppage
            $stoppage = new Stopage();
            $stoppage->create(
                $input['id'],
                $input['reason']
            );

            if ($end = $this->sanitizeString($raw['end'])) {
                $stoppage->setEnd($end);
            }

            $this->taskRepository->createStoppage($stoppage);

//            TODO: Halt task
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
        $input = [
            'id' => $this->sanitizeString($raw['id'])
        ];

        if (!$this->emptyInput($input)) {
            $cleanId = $this->sanitizeString($input['id']);
            $result['statusCode'] = $this->taskRepository->removeTask($cleanId) ? 200 : 500;
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
//                var_dump($tasks);
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

    public function getTasksDetails(string $projectId) {
        $cleanId = $this->sanitizeString($projectId);

//        TODO: Get current date
//        get the days of cd
//        subtract to 30 days
//        Get date for next month with the subtracted days

        // Default tasks time
//        $tasks = [time(), strtotime(date("Y-m-t"))];

//        $dStart = new DateTime();
//
//        // Default Project start
//        $startDate = $dStart->format('Y-m-j');
//
//        // Default Project end
//        $endDate = $dStart->format('Y-m-t');
//
//        $daysInMonth = (int) $dStart->format('t');
//        $diff = ($daysInMonth - (int) $dStart->format('j')) + 1;

//        if ($diff < $daysInMonth)
//        {
////            New end date
//            $dStart->modify('+ '.(30 - $diff).' day');
//            $endDate = $dStart->format('Y-m-j');
//        }
//
//        // Default number of days
//        $days =  date('t');
//
//        // Default number of months
//        $months = 1;
        
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

                if ($tasks = $this->taskRepository->getActiveTasks($cleanId))
                {
    //                Resets dates
//                    $startDates = [];
//                    $endDates = [];

    //                Gets start and ends dates of tasks
//                    for ($i = 0; $i < count($tasks); $i++) {
//                        $startDates[] = $tasks[$i]['start'];
//                        $endDates[] = $tasks[$i]['end'];
//                    }

                    //  Converts dates to timestamp for easy arrangement
//                    $startDates = array_map('strtotime', $startDates);
//                    $endDates = array_map('strtotime', $endDates);

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

            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        $result['data']['month'] = $months;
        $result['data']['start'] = $startDate;
        $result['data']['end'] = $endDate;
        $result['data']['total_days'] = $days;
        $result['data']['grid'] = $days + 3;

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

//    private function getDates(array $startDates, array $endDates) {
//        $months = [[], [], []];
//
////        Months and years
//        for ($i=0; $i < count($startDates); $i++)
//        {
//            $start = date("n", $startDates[$i]);
//            $end = date("n", $endDates[$i]);
//            if (!in_array($start, $months[0]))
//            {
//                $months[0][] = $start;
//                $months[2][] = date("Y", $startDates[$i]);
//            } else if(!in_array($end, $months[0]))
//            {
//                $months[0][] = $end;
//                $months[2][] = date("Y", $endDates[$i]);
//            }
//        }
//
//        // echo "Date T";
//        // var_dump(date('t', min($startDates)));
//        // echo "Date J";
//        // var_dump(date('j', min($startDates)));
//        // echo "Diff";
//        // var_dump(date('j', min($startDates)));
//
//        $EXTRA_SPACE = 3;
//
//        if (count($months[0]) > 1)
//        {
//            $months[1][] = date('t', min($startDates)) - (date('j', min($startDates)) - 1);
//
//            for ($i=1; $i < (count($months[0])-1); $i++) {
//                $months[1][] = cal_days_in_month(CAL_GREGORIAN, $months[0][$i], $months[2][$i]);
//            }
//
//            $months[1][] = ((int) date('j', max($endDates))) + $EXTRA_SPACE;
//        }
//        else if (count($months[0]) === 1)
//        {
//            $dStart = new DateTime();
//            $dStart->setTimestamp(min($startDates));
//            $dEnd  = new DateTime();
//            $dEnd->setTimestamp(max($endDates));
//            $dDiff = $dStart->diff($dEnd);
//
//            $months[1][] = ((int) $dDiff->format('%r%a')) + $EXTRA_SPACE;
//        }
//
//        return $months;
//    }

    // Gets all tasks of a project
    public function getTasksPlan($request) {
        $cleanId = $this->sanitizeString($request);
        $result['data'] = [];
        
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

//    Stoppage
    public function getStoppage(string $taskId)
    {
        $cleanId = $this->sanitizeString($taskId);
        $response['data'] = [];

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

    public function createStoppage(string $taskId, array $halt, $end) {
        $stoppage = new Stopage();
        $stoppage->create(
            $taskId,
            $halt['haltReason'],
            $halt['haltStart'],
            $end
        );

        $this->taskRepository->createStoppage($stoppage);
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