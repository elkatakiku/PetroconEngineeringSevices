<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Faker\Factory;
use Repository\ProjectRepository;
use Repository\TaskRepository;
use Service\TaskService;

//require_once 'vendor/autoload.php';

class Task extends MainController
{

    // Service
    private $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService;
    }

    public function index()
    {
        $this->goToLogin();
    }

//    Load
    public function taskPopup()
    {
        if (isset($_POST['projId']) && $data = $this->taskService->initializePopup($_POST['projId'])) {
            $this->load('popup/task', $data);
        } else {
            $this->load('popup/error');
        }
    }

    public function progressPopup()
    {
        if (isset($_POST['task']) && isset($_POST['id']) && isset($_POST['progress'])) {
            $this->load('popup/progress', $_POST);
        } else {
            $this->load('popup/error');
        }
    }

    public function haltPopup()
    {
        if (isset($_POST['task']) && isset($_POST['id'])) {
            $this->load('popup/halt', $_POST);
        } else {
            $this->load('popup/error');
        }
    }

    public function resumePopup()
    {
        if (isset($_POST['task']) && isset($_POST['id'])) {
            $this->load('popup/resume', $_POST);
        } else {
            $this->load('popup/error');
        }
    }

//    New
    public function new()
    {
        if (isset($_POST['form'])) {
            echo $this->taskService->createTask($_POST['form']);
        }
    }

//    Update
    public function update()
    {
        if (isset($_POST['form'])) {
            echo $this->taskService->updateTask($_POST['form']);
        }
    }

//    Progress
    public function updateProgress()
    {
        if (isset($_POST['form'])) {
            echo $this->taskService->updateProgress($_POST['form']);
        }
    }

//    DEBUG: progress
    public function progress($id)
    {
        $this->taskService->progress($id);
    }

//    Halt
    public function haltTask()
    {
        if (isset($_POST['form'])) {
            echo $this->taskService->haltTask($_POST['form']);
        }
    }

    //    Resume
    public function resumeTask()
    {
        if (isset($_POST['form'])) {
            echo $this->taskService->resumeTask($_POST['form']);
        }
    }

    public function remove()
    {
        if (isset($_POST['form'])) {
            echo $this->taskService->removeTask($_POST['form']);
        }
    }

    public function list()
    {
        if (isset($_GET['projId'])) {
            echo $this->taskService->getTasks($_GET['projId']);
        }
    }

    public function count()
    {
        if (isset($_GET['projId'])) {
            echo $this->taskService->getTaskCount($_GET['projId']);
        }
    }

    public function chart()
    {
        if (isset($_GET['projId'])) {
            echo $this->taskService->getTasksDetails($_GET['projId']);
        }
    }

//    DEBUG: Chart
    public function charts($proj)
    {
        echo '<pre>';
        var_dump(json_decode($this->taskService->getTasksDetails($proj), true));
    }

//    Stoppage
    public function stoppage()
    {
        if (isset($_GET['taskId'])) {
            echo $this->taskService->getStoppage($_GET['taskId']);
        }
    }

    public function generate()
    {
        echo 'Generate';
        $faker = Factory::create();

        $projectRepo = new ProjectRepository();

        $projects = $projectRepo->getProjects('all');

        $taskRepo = new TaskRepository();

        $now = getdate();

        echo $now['year'] . '-' . $now['mon'] . '-' . ($now['mday'] - rand(1, 20));

        foreach ($projects as $project) {
            echo '<br> <br>';
            var_dump($project);

            echo '<br> <br>';
            $date = date_create($project['start']);
            echo var_dump($date);



            for ($i = 0; $i < 5; $i++) {
                echo '<br> <br>';
                echo "Creating task";
//                echo $project['id'];
//                echo $taskRepo->taskCount($project['id']);
//                echo $faker->words(rand(1, 3), true);

//                echo '<br> <br>';
                date_modify($date, '+'.rand(1, 5).' days');
//                echo var_dump($date);

                $task = new \Model\Task();

                $task->create(
                    $project['id'],
                    $taskRepo->taskCount($project['id']) + 1,
                    ucwords($faker->words(rand(1, 3), true)),
                    date_format($date,"Y-m-d"),
                    $now['year'] . '-' . $now['mon'] . '-' . ($now['mday'] - rand(1, 20)),
                );

                echo "Task created";

                var_dump($task);

                echo 'Generate stuff';

                $taskRepo->setTask($task);

            }

        }
    }

}