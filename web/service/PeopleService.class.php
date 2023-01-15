<?php

namespace Service;

use Core\Service;
use Includes\Mail;
use Model\Invitation;
use Model\Resource;
use Repository\PeopleRepository;
use Repository\ProjectRepository;

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
        $cleanId = $this->sanitizeString($projectId);
        $response['data'] = [];

        if ($cleanId) {
            if ($resources = $this->peopleRepository->getPeople($cleanId)) {
                $response['data'] = $resources;
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
            if ($resources = $this->peopleRepository->getInvitations($cleanId)) 
            {
                $response['data'] = $resources;
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
        {   // Creates resource object
            $invitation  = new Invitation;
            $invitation ->create(
                $input['name'],
                $input['email'],
                bin2hex(random_bytes(32)),
                $input['projId'],
            );

            // Create account
            $userService = new UserService;
            $account = $userService->createAccount($input['email'], $input['name']);

            // Add to project team
            $projectService = new ProjectRepository;
            $projectService->joinProject($input['projId'], $account);

            Mail::sendMail(
                'Project Invitation',         // Subject
                Mail::invitation($input['name'], $input['projId']),     // Body
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

    public function removeInvitation(string $invitationId)
    {
        // if (!empty($invitationId)) 
        // {   // Creates resource object
        //     $invitation  = new Invitation;
        //     $invitation ->create(
        //         $input['name'],
        //         $input['email'],
        //         bin2hex(random_bytes(32)),
        //         $input['projId'],
        //     );

        //     // Create account
        //     $userService = new UserService;
        //     $account = $userService->createAccount($input['email'], $input['name']);

        //     // Add to project team
        //     $projectService = new ProjectRepository;
        //     $projectService->joinProject($input['projId'], $account);

        //     Mail::sendMail(
        //         'Project Invitation',         // Subject
        //         Mail::invitation($input['name'], $input['projId']),     // Body
        //         $invitation->getEmail()          // Address / To
        //     );

        //     if ($this->peopleRepository->createInvitation($invitation)) {
        //         $response['statusCode'] = 200;
        //     } else {
        //         $response['statusCode'] = 500;
        //     }
        // } else {
        //     $response['statusCode'] = 400;
        //     $response['message'] = "Fill all the required inputs.";
        // }

        // return json_encode($response);
    }
}