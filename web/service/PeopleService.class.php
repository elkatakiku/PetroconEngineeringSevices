<?php

namespace Service;

use Core\Service;
use Includes\Mail;
use Model\Invitation;
use Repository\PeopleRepository;
use Repository\ProjectRepository;
use Repository\UserRepository;

class PeopleService extends Service {

    private PeopleRepository $peopleRepository;

    public function __construct() {
        $this->peopleRepository = new PeopleRepository;
    }

    public function remove(string $form)
    {
        parse_str($form, $input);
        
        if (!$this->emptyInput($input)) {
            $cleanId = $this->sanitizeString($input['id']);
            $result['statusCode'] = $this->peopleRepository->remove($cleanId) ? 200 : 500;
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function list(string $projectId)
    {
        $cleanId = $this->sanitizeString($projectId);
        $response['data'] = [];

        if ($cleanId) {
            if ($people = $this->peopleRepository->getPeople($cleanId)) {
                $response['data'] = $people;
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    // || Invitations
    public function invitationList(string $projectId)
    {
        $cleanId = $this->sanitizeString($projectId);
        $response['data'] = [];

        if ($cleanId) 
        {
            if ($people = $this->peopleRepository->getInvitations($cleanId)) {
                $response['data'] = $people;
                $response['statusCode'] = 200;
            } 
            else {
                $response['statusCode'] = 500;
            }
        } 
        else {
            $response['statusCode'] = 400;
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function invite(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'name' => $this->sanitizeString($raw['name']),
            'type' =>  $this->sanitizeString($raw['type']),
            'email' => filter_var($raw['email'], FILTER_SANITIZE_EMAIL),
            'projId' => $this->sanitizeString($raw['projId']),
        ];

        if (!$this->emptyInput($input))
        {
            $username = bin2hex(random_bytes(4));
            $password = bin2hex(random_bytes(4));

            if ($input['name']) {
                $username = explode(',', $input['name'])[0].'_'.bin2hex(random_bytes(2));
            }

            // Creates invitation object
            $invitation  = new Invitation;
            $invitation ->create(
                $input['name'],
                $input['email'],
                bin2hex(random_bytes(32)),
                $input['projId'],
                $input['type'],
                $username,
                $password
            );

            //  Send invitation email
            Mail::sendMail(
                'Welcome to Petrocon Engineering Services',         // Subject
                Mail::invitation($invitation),     // Body
                $invitation->getEmail()          // Address / To
            );

            if ($this->peopleRepository->createInvitation($invitation)) {
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
            $response['message'] = "Fill all the required inputs.";
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

    public function getInvitation(string $code) {
        $cleanCode = $this->sanitizeString($code);
        $response['data'] = [];

        if ($cleanCode && ($people = $this->peopleRepository->getInvitationByCode($cleanCode)))
        {
            $TWO_DAYS = 172800;
            $sent_at = strtotime($people[0]['created_at']);

            $response['expired'] = time() > ($sent_at + $TWO_DAYS);

            if ($response['expired']) {
                $response['statusCode'] = 400;
            } else {
                $response['data'] = $people[0];
                $response['statusCode'] = 200;
            }
        }
        else
        {
            $response['statusCode'] = 500;
        }

        return $response;
    }

    public function removeInvitation(string $form)
    {
        parse_str($form, $input);

         if (!$this->emptyInput($input))
         {
             if ($invitation = $this->peopleRepository->getInvitationById($input['id']))
             {
                $response['statusCode'] = $this->peopleRepository->removeInvitation($invitation[0]['id']) ? 200 : 500;
             }

         }
         else
         {
             echo "Empty";
             $response['statusCode'] = 400;
             $response['message'] = "Fill all the required inputs.";
         }

         return json_encode($response, JSON_NUMERIC_CHECK);
    }

//    Processes the invitation
    public function runInvitation(string $code): array
    {
        $cleanCode = $this->sanitizeString($code);
        $response['data'] = [];

        if ($cleanCode && ($invitation = $this->peopleRepository->getInvitationByCode($cleanCode)))
        {
            $invitation = $invitation[0];

            $TWO_DAYS = 172800;
            $sent_at = strtotime($invitation['created_at']);

            $response['data']['expired'] = time() > ($sent_at + $TWO_DAYS);

            if (!$response['data']['expired'])
            {
                // Create account
                $userService = new UserService;
                $account = $userService->createAccount($invitation);

                // Add to project team
                $projectService = new ProjectRepository;
                $projectService->joinProject($invitation['proj_id'], $account);

                //  Mark invitation used
                $this->peopleRepository->invitationUsed($invitation['id']);

                //  Return data
                $response['data']['invitation'] = $invitation;
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 400;
            }
        }
        else
        {
            $response['statusCode'] = 500;
        }

        return $response;
    }

    public function validateEmail(string $input)
    {
        $userRepository = new UserRepository();
        $email = filter_var($input, FILTER_SANITIZE_EMAIL);
        $result['data'] = false;

        if (!$this->peopleRepository->validateEmail($email)) {
            $result['message'] = 'Invitation is already sent.';
        } else if ($userRepository->validateEmail($email)) {
            $result['message'] = 'Email is already taken.';
        } else {
            $result['data'] = true;
        }
        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    //    User
    public function joinedProjects($accountId) {
        $cleanId = $this->sanitizeString($accountId);
        $response['data'] = [];

        if ($cleanId)
        {
            if ($projects = $this->peopleRepository->getProjects($cleanId))
            {
                $response['data'] = $projects;
                $response['statusCode'] = 200;
            }
            else
            {
                $response['statusCode'] = 500;
            }
        }
        else
        {
            $response['statusCode'] = 400;
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }

//    Employees
    public function searchEmployees(string $form) {
        parse_str($form, $raw);
        $input = ['searchStr' => $this->sanitizeString($raw['search'])];
        $response['data'] = [];

        if (!$this->emptyInput($input))
        {
            if ($employeeList = $this->peopleRepository->searchEmployees($input['searchStr']))
            {
                $response['data'] = $employeeList;
                $response['statusCode'] = 200;
            }
            else
            {
                $response['statusCode'] = 500;
            }
        }
        else
        {
            $response['statusCode'] = 400;
        }

        return json_encode($response, JSON_NUMERIC_CHECK);
    }
}