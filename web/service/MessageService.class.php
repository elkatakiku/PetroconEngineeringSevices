<?php

namespace Service;

use Core\Service;
use Model\Payment;
use Repository\PaymentRepository;


class MessageService extends Service {

    private $paymentRepository;

    public function __construct() {
        $this->paymentRepository = new PaymentRepository;
    }

    public function new(string $form)
    {
        parse_str($form, $input);
        unset($input['id']);

        if (!$this->emptyInput($input)) 
        {
            // Creates resource object
            $payment = new Payment;
            $payment->create(
                $input['description'],
                $input['amount'],
                $input['date'],
                $input['projId'],
            );

            if ($this->paymentRepository->create($payment)) {
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
       parse_str($form, $input);

        if (!$this->emptyInput($input)) 
        {
            $this->paymentRepository->update($input);
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
            $result['statusCode'] = $this->paymentRepository->remove($cleanId) ? 200 : 500;
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
            if ($payment = $this->paymentRepository->getAll($cleanId)) {
                $response['data'] = $payment;
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