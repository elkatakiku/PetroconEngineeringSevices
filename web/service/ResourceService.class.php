<?php

namespace Service;

use Core\Service;
use Model\Resource;
use Repository\ResourceRepository;


class ResourceService extends Service {

    private ResourceRepository $resourceRepository;

    public function __construct() {
        $this->resourceRepository = new ResourceRepository;
    }

//    Create
    public function recordResource(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'projectId' => $this->sanitizeString($raw['projectId']),
            'item' => $this->sanitizeString($raw['item']),
            'quantity' => filter_var($raw['quantity'], FILTER_SANITIZE_NUMBER_INT),
            'price' => filter_var($raw['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ),
        ];

        if (!$this->emptyInput($input))
        {
            // Creates resource object
            $resource = new Resource;
            $resource->create(
                $input['item'],
                $input['quantity'],
                $input['price'],
                $this->sanitizeString($raw['notes']),
                $input['projectId']
            );

            if ($this->resourceRepository->create($resource)) {
                $result['statusCode'] = 200;
                $result['message'] = 'Resource added successfully.';
            } else {
                $result['statusCode'] = 500;
                $response['message'] = "An error occurred. Please try again.";
            }
        } else {
            $result['statusCode'] = 400;
            $result['message'] = "Fill all the required inputs.";
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

//    Update
    public function update(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'id' => $this->sanitizeString($raw['id']),
            'item' => $this->sanitizeString($raw['item']),
            'quantity' => filter_var($raw['quantity'], FILTER_SANITIZE_NUMBER_INT),
            'price' => filter_var($raw['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ),
        ];

        if (!$this->emptyInput($input))
        {
            $input['total'] = $input['price'] * $input['quantity'];
            $input['notes'] = $this->sanitizeString($raw['notes']);

            $this->resourceRepository->update($input);
            $result['statusCode'] = 200;
            $result['message'] = 'Updated successfully.';
        } else {
            $result['statusCode'] = 400;
            $result['message'] = "Fill all the required inputs.";
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function updateNotes(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'id' => $this->sanitizeString($raw['id']),
            'notes' => $this->sanitizeString($raw['notes'])
        ];

        if (!$this->emptyInput($input)) {
            $this->resourceRepository->updateNotes($input);
            $result['statusCode'] = 200;
            $result['message'] = 'Notes updated successfully.';
        } else {
            $result['statusCode'] = 400;
            $result['message'] = 'Please fill all the required inputs.';
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

//    Delete
    public function remove(string $form)
    {
        parse_str($form, $input);
        
        if (!$this->emptyInput($input)) {
            $cleanId = $this->sanitizeString($input['id']);
            if ($this->resourceRepository->remove($cleanId)) {
                $result['statusCode'] = 200;
                $result['message'] = 'Item removed successfully.';
            } else {
                $result['statusCode'] = 500;
                $result['message'] = "An error occurred. Please try again.";
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

//    Read
    public function list(string $projectId)
    {
        $cleanId = $this->sanitizeString($projectId);
        $response['data'] = [];

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

        return json_encode($response, JSON_NUMERIC_CHECK);
    }
}