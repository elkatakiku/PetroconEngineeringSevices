<?php

namespace Service;

use Core\Service;
use Model\TaskBar;
use Repository\ActivityRepository;

class ActivityService extends Service{
    
    private $activityRepository;

    public function __construct() {
        $this->activityRepository = new ActivityRepository;
    }

    public function getActiveActivities($request) {
        $cleanId = $this->sanitizeString($request);

        if ($cleanId) {
            if ($activities = $this->activityRepository->getActiveActivities($cleanId)) {
                $result['data'] = $activities;
                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    // Creates multiple activities
    public function createActivities($taskId, $input) {

        $activities = [];

        // Iterate through input and create taskbar model objects
        foreach($input as $activity) {
            $taskBar = new TaskBar;
            $taskBar->create(
                $taskId, 
                $activity['legendId'], 
                $activity['start'], 
                $activity['end']
            );
            $activities[] = $taskBar;
        }

        return $this->activityRepository->setActivities($activities);
    }

    // Updates multiple activities
    public function updateActivities($input, $deleted) {

        $activities = [];
        

        // Iterate through input and create taskbar model objects
        foreach($input as $activity) 
        {
            $taskBar = [
                $activity['id'],
                $activity['start'], 
                $activity['end'],
                !in_array($activity['id'], $deleted)
            ];

            $activities[] = $taskBar;
        }

        return $this->activityRepository->updateActivities($activities);
    }


}