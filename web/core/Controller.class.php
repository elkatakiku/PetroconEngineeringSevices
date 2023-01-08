<?php

namespace Core;

use Model\Account;

class Controller {

    const AUTH = "auth";
    const CLIENT = "client";
    const ADMIN = "admin";
    const WORKER = "worker";
    
    private string $type;
    private int $pageNumber;

    private $isLogin;

    protected function __construct() {
        if (isset($_SESSION["accID"])) {
            $this->isLogin = true;
            switch ($_SESSION["accType"]) {
                case Account::CLIENT_TYPE:
                    $this->setType(Controller::CLIENT);
                    break;
                case Account::ADMIN_TYPE:
                    $this->setType(Controller::ADMIN);
                    break;
                case Account::WORKER_TYPE:
                case Account::EMPLOYEE_TYPE:
                    $this->setType(Controller::WORKER);
                    break;
            }
        }
    }

    protected function goToLanding() {
        header("Location: ".SITE_URL);
        exit();
    }

    protected function isLogin() {
        return $this->isLogin;
    }

    public function view($viewFolder, $view, $data = []) {
        require_once 'web/view/structure/header.php';
        require_once 'web/view/' . $viewFolder .DS. $view .'.php';
        require_once 'web/view/structure/footer.php';
    }

    protected function getType() {
        return $this->type;
    }

    protected function setType($type) {
        $this->type = $type;
    }

    protected function setPage($pageNumber) {
        $this->pageNumber = $pageNumber - 1;
    }

    protected function getPageNumber() {
        return $this->pageNumber;
    }

    protected function getPage() {
        $pages = [
            Controller::CLIENT => ["home"],
            Controller::ADMIN => ["dashboard", "projects", "messages", "team", "users", "profile"]
        ];

        return $pages[$this->type][$this->pageNumber];
    }

    public function displayResult(array $get, string $successMsg)
    {
        if (isset($get['error'])) { 
            echo '<div class="alert alert-danger show" role="alert">'.$get['error'].'</div>';
        } else if (isset($get['success'])) { 
            echo '<div class="alert alert-success show" role="alert">'.$successMsg.'</div>';
        }
    }

    protected function sanitizeString($string) {
        return trim(htmlspecialchars(strip_tags($string)));
    }

    // Validate Inputs
    protected function emptyInput($inputs) {
        foreach ($inputs as $key => $value) {
            if (is_array($value)) {
                if($this->emptyInput($value)) {
                    return true;
                }
            }
            if (!$value) {
                return true;
            }
        }

        return false;
    }
}