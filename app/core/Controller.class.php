<?php

namespace Core;

class Controller {

    const AUTH = "auth";
    const CLIENT = "client";
    const ADMIN = "admin";
    
    private $type;
    private $pageNumber;

    private $isLogin;

    protected function __construct() {
        if (isset($_SESSION["accID"])) {
            $this->isLogin = true;
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
        require_once 'app/view/structure/header.php';
        require_once 'app/view/' . $viewFolder .DS. $view .'.php';
        require_once 'app/view/structure/footer.php';
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