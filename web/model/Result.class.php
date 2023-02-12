<?php

declare(strict_types = 1);
namespace Model;

class Result {

    private $status;
    private $message;

    public function __construct() {
        $this->status = true;
    }

    public function setStatus(bool $status) {
        if (!$status) {
            $this->message = "An error occured. Please try again later.";
        }
        $this->status = $status;
    }

    public function isSuccess() {
        return $this->status;
    }

    public function setMessage(string $message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }
}