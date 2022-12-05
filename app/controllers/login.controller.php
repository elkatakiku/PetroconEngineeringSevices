<?php

class LoginController extends Controller {

    private $username;
    private $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;

        $this->setModel(Model::AUTH);
    }

    public function loginUser() {
        if ($this->emptyInput()) {
            // echo "<br>Please fill all required inputs.";
            return -101;
        }

        if(!$this->getModel()->getUser($this->username, $this->password)) {
            // echo '<hr>';
            // echo "Error".__METHOD__;
            return -1;
        }

        // echo "returning 1 from " . __METHOD__;

        return 1;
    }

    private function emptyInput() {
        return  !$this->username || !$this->password;
    }
    
}