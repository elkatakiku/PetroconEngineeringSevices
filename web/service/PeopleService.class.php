<?php

namespace Service;

use Core\Service;
use Model\Resource;
use Repository\PeopleRepository;


class PeopleService extends Service {

    private $peopleRepository;

    public function __construct() {
        $this->peopleRepository = new PeopleRepository;
    }

    public function new(string $form)
    {
        $input = $this->getInputs($form);
        unset($input['required']['id']);

        if (!$this->emptyInput($input['required'])) 
        {
            $input['required']['total'] = $input['required']['price'] * $input['required']['quantity'];

            // Creates resource object
            $resource = new Resource;
            $resource->create(
                $input['required']['item'],
                $input['required']['quantity'],
                $input['required']['price'],
                $input['required']['total'],
                $input['notRequired']['notes'],
                $input['required']['projId'],
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

        if (!$this->emptyInput($input['required'])) 
        {
            $input['required']['total'] = $input['required']['price'] * $input['required']['quantity'];

            $this->peopleRepository->update(array_merge($input['required'], $input['notRequired']));
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
}