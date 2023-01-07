<?php

namespace Service;

use Core\Service;
use Model\Resource;
use Repository\ResourceRepository;


class ResourceService extends Service {

    private $resourceRepository;

    public function __construct() {
        $this->resourceRepository = new ResourceRepository;
    }

    public function new(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'required' => [
                'item' => $this->sanitizeString($raw['item']),
                'quantity' => filter_var($raw['quantity'], FILTER_SANITIZE_NUMBER_INT),
                'price' => filter_var($raw['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ),
                'total' => filter_var($raw['total'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'projId' => $this->sanitizeString($raw['projId'])
            ],
            
            'notRequired' => [
                'note' => $this->sanitizeString($raw['note']),
            ]
        ];

        if (!$this->emptyInput($input['required'])) 
        {
            // Creates resource object
            $resource = new Resource;
            $resource->create(
                $input['required']['item'],
                $input['required']['quantity'],
                $input['required']['price'],
                $input['required']['total'],
                $input['notRequired']['note'],
                $input['required']['projId'],
            );

            if ($this->resourceRepository->create($resource)) {
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

    public function list(string $projectId)
    {
        $cleanId = $this->sanitizeString($projectId);

        if ($cleanId) {
            if ($resources = $this->resourceRepository->getActiveResources($cleanId)) {
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
}