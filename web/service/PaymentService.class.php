<?php

namespace Service;

use Core\Service;
use Model\Payment;
use Repository\PaymentRepository;


class PaymentService extends Service {

    private PaymentRepository $paymentRepository;

    public function __construct() {
        $this->paymentRepository = new PaymentRepository;
    }

    public function new(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'projectId' => $this->sanitizeString($raw['projectId']),
            'description' => $this->sanitizeString($raw['description']),
            'amount' => filter_var($raw['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ),
            'date' => $this->sanitizeString($raw['date'])
        ];

        if (!$this->emptyInput($input)) 
        {
            // Creates resource object
            $payment = new Payment;
            $payment->create(
                $input['description'],
                $input['amount'],
                $input['date'],
                $input['projectId'],
            );

            if ($this->paymentRepository->create($payment)) {
                $result['statusCode'] = 200;
                $result['message'] = 'Payment added successfully.';
            } else {
                $result['statusCode'] = 500;
                $result['message'] = "An error occurred. Please try again.";
            }
        } else {
            $result['statusCode'] = 400;
            $result['message'] = "Fill all the required inputs.";
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function update(string $form)
    {
        parse_str($form, $raw);

        $input = [
            'id' => $this->sanitizeString($raw['id']),
            'description' => $this->sanitizeString($raw['description']),
            'amount' => filter_var($raw['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ),
            'sent_at' => $this->sanitizeString($raw['date'])
        ];

        if (!$this->emptyInput($input)) 
        {
            $this->paymentRepository->update($input);
            $result['statusCode'] = 200;
            $result['message'] = 'Updated successfully.';
        } else {
            $result['statusCode'] = 400;
            $result['message'] = "Fill all the required inputs.";
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function remove(string $form)
    {
        parse_str($form, $input);

        if (!$this->emptyInput($input)) {
            $cleanId = $this->sanitizeString($input['id']);
            if ($this->paymentRepository->remove($cleanId)) {
                $result['statusCode'] = 200;
                $result['message'] = 'Payment removed successfully.';
            } else {
                $result['statusCode'] = 500;
                $result['message'] = "An error occurred. Please try again.";
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function list(string $projectId)
    {
        $cleanId = $this->sanitizeString($projectId);
        $result['data'] = [];

        if ($cleanId) {
            if ($payment = $this->paymentRepository->getAll($cleanId)) {
                $result['data'] = $payment;
                $result['statusCode'] = 200;
            } else {
                $result['statusCode'] = 500;
            }
        } else {
            $result['statusCode'] = 400;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }
}