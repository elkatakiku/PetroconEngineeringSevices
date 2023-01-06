<?php

namespace Controller;

// Core
use \Core\Controller as MainController;
use Service\ActivityService;

class Activity extends MainController {

    // Service
    private $activityService;

    public function __construct() {
        $this->activityService = new ActivityService;
    }

    public function index() {
        $this->goToLanding();
    }

    // Gets activities of a task
    public function list() {

        if (isset($_GET['taskId'])) {
            $cleanId = $this->sanitizeString($_GET['taskId']);
            echo $this->activityService->getActiveActivities($cleanId);
        }
    }
}