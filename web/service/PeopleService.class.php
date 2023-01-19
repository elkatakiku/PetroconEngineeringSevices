<?php

namespace Service;

use Core\Service;
use Includes\Mail;
use Model\Invitation;
use Model\Resource;
use Repository\PeopleRepository;
use Repository\ProjectRepository;
use Repository\UserRepository;

class PeopleService extends Service {

    private $peopleRepository;

    public function __construct() {
        $this->peopleRepository = new PeopleRepository;
    }

    public function new(string $form)
    {
        $input = $this->getInputs($form);
        unset($input['id']);

        if (!$this->emptyInput($input)) 
        {
            $input['total'] = $input['price'] * $input['quantity'];

            // Creates resource object
            $resource = new Resource;
            $resource->create(
                $input['item'],
                $input['quantity'],
                $input['price'],
                $input['total'],
                $input['notRequired']['notes'],
                $input['projId'],
            );

            if ($this->peopleRepository->create($resource)) {
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
            $response['message'] = "Fill all the required inputs.";
        }

        return json_encode($response);
    }

    public function update(string $form)
    {
        $input = $this->getInputs($form);

        if (!$this->emptyInput($input)) 
        {
            $input['total'] = $input['price'] * $input['quantity'];

            $this->peopleRepository->update(array_merge($input, $input['notRequired']));
            $response['statusCode'] = 200;
        } else {
            $response['statusCode'] = 400;
            $response['message'] = "Fill all the required inputs.";
        }

        return json_encode($response);
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

        return json_encode($result);
    }

    public function list(string $projectId)
    {
//        echo __METHOD__;
        $cleanId = $this->sanitizeString($projectId);
        $response['data'] = [];

        if ($cleanId) {
            if ($people = $this->peopleRepository->getPeople($cleanId)) {
//                var_dump($people);
                $response['data'] = $people;
                $response['statusCode'] = 200;
            } else {
                $response['statusCode'] = 500;
            }
        } else {
            $response['statusCode'] = 400;
        }

        return json_encode($response);
    }

    public function getInputs(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'required' => [
                'id' => $this->sanitizeString($raw['id']),
                'item' => $this->sanitizeString($raw['item']),
                'quantity' => filter_var($raw['quantity'], FILTER_SANITIZE_NUMBER_INT),
                'price' => filter_var($raw['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ),
                'projId' => $this->sanitizeString($raw['projId'])
            ],
            
            'notRequired' => [
                'notes' => (!$this->sanitizeString($raw['notes']) ? '' : $this->sanitizeString($raw['notes'])),
            ]
        ];

        return $input;
    }

    // || Invitations
    public function invitationList(string $projectId)
    {
        $cleanId = $this->sanitizeString($projectId);
        $response['data'] = [];

        if ($cleanId) 
        {
            if ($people = $this->peopleRepository->getInvitations($cleanId))
            {
                $response['data'] = $people;
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

        return json_encode($response);
    }

    public function invite(string $form)
    {
        parse_str($form, $input);

        if (!$this->emptyInput($input)) 
        {
            $username = bin2hex(random_bytes(4));
            $password = bin2hex(random_bytes(4));

            if ($input['name']) {
                $username = explode(' ', $input['name'])[0].'_'.bin2hex(random_bytes(2));
            }

            // Creates invitation object
            $invitation  = new Invitation;
            $invitation ->create(
                $input['name'],
                $input['email'],
                bin2hex(random_bytes(32)),
                $input['projId'],
                $username,
                $password
            );

//            // Create account
//            $userService = new UserService;
//            $account = $userService->createAccount($input['email'], $input['name']);
//
//            // Add to project team
//            $projectService = new ProjectRepository;
//            $projectService->joinProject($input['projId'], $account);

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

        return json_encode($response);
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
//             TODO : Remove login
//             TODO : Remove to project team
//             Account is not created when the invitation is not accepted
//             Accepting the invitation will remove the person in the pending invitation list

             if ($invitation = $this->peopleRepository->getInvitationById($input['id'])) {
                 var_dump($invitation);
                 $userRepository = new UserRepository();
//                 $userRepository->removeUser();
                $response['statusCode'] = $this->peopleRepository->removeInvitation($invitation[0]['id']) ? 200 : 500;
             }

         }
         else
         {
             echo "Empty";
             $response['statusCode'] = 400;
             $response['message'] = "Fill all the required inputs.";
         }

         return json_encode($response);
    }

    public function runInvitation(string $code): array
    {
        $cleanCode = $this->sanitizeString($code);
        $response['data'] = [];


        if ($cleanCode && ($invitation = $this->peopleRepository->getInvitationByCode($cleanCode)))
        {
            $TWO_DAYS = 172800;
            $sent_at = strtotime($invitation[0]['created_at']);

            $response['data']['expired'] = time() > ($sent_at + $TWO_DAYS);

            if (!$response['data']['expired'])
            {
                // Create account
                $userService = new UserService;
                $account = $userService->createAccount($invitation[0]);

                // Add to project team
                $projectService = new ProjectRepository;
                $projectService->joinProject($invitation[0]['proj_id'], $account);

                //  Mark invitation used
                $this->peopleRepository->invitationUsed($invitation[0]['id']);

                //  Return data
                $response['data']['invitation'] = $invitation[0];
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

        return json_encode($response);
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

        return json_encode($response);
    }
}