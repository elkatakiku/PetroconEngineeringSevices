<?php

namespace Core;

use Model\Account;
use Repository\UserRepository;
use User;

class Controller {

    const AUTH = "auth";
    const CLIENT = "client";
    const ADMIN = "admin";
    const EMPLOYEE = "employee";
    
    private string $type;
    private string $pageId;
    private  $user;

    private $isLogin;

    protected function __construct() {
        if (isset($_SESSION["accID"])) {
            $this->isLogin = true;

            $this->user = (new UserRepository())->getUserByRegister($_SESSION["accRegister"]);

            switch ($_SESSION["accType"]) {
                case Account::CLIENT_TYPE:
                    $this->setType(Controller::CLIENT);
                    break;
                case Account::ADMIN_TYPE:
                    $this->setType(Controller::ADMIN);
                    break;
                case Account::WORKER_TYPE:
                case Account::EMPLOYEE_TYPE:
                    $this->setType(Controller::EMPLOYEE);
                    break;
            }
        }
    }

    protected function goToLogin() {
        header("Location: ".SITE_URL);
        exit();
    }

    protected function getUser() {
        return $this->user;
    }

    protected function isLogin() {
        return $this->isLogin;
    }

    public function view($viewFolder, $view, $data = []) {
        if ($this->isLogin()) 
        {
            $data['user'] = $this->user;
            $data['pageId'] = $this->pageId;
            $data['fullname'] = ucwords(
                $this->user['lastname']).", ".
                ucwords($this->user['firstname'])." ".
                (!$this->user['middlename'] ? ' ' : ucwords(substr($this->user['middlename'], 0, 1))."."
            );
        }

        $data['accountType'] = $this->type;

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

    protected function setPage($pageId) {
//        $this->pageNumber = $pageNumber - 1;
        $this->pageId = $pageId;
    }

    protected function getPage() {
        return $this->pageId;
    }

    public function displayResult(array $get, string $successMsg)
    {
        if (isset($get['error'])) { 
            echo '<div class="alert alert-danger show" role="alert">'.$get['error'].'</div>';
        } else if (isset($get['success'])) { 
            echo '<div class="alert alert-success show" role="alert">'.$successMsg.'</div>';
        }
    }

    public function mergeName($lastname, $firstname, $middlename)
    {
        $middleInitial = !$middlename ? '' : (ucwords(substr($middlename, 0, 1)).".");
        return ucwords($lastname).", ".ucwords($firstname)." ".$middleInitial;
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