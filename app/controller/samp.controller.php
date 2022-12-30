<?php

class SampController extends Controller {

    public function __construct() {
        $this->setModel(Model::SAMP);
    }

    public function sampf() {
        $this->view("samp", "sampf");
    }

    public function post() {

        if (isset($_POST['submitSamp'])) {
            echo $_POST['sampi'];

            // $this->getModel()->
        }
        echo "POST";
    }
}