<?php

namespace Controller;
use \Core\Controller as MainController;

class Home extends MainController {

    public function __construct() {
        $this->setType(MainController::CLIENT);
        $this->setPage(1);
    }
    
    public function index($name = '') {
        // $user = $this->model("User");
        // $user->name = $name;

        // echo $user->name;
        if (!isset($_SESSION['accID'])) {
            $this->view("home", "index");
        } else {
            // header("Location: ".SITE_URL.US."app/home");
            header("Location: ".SITE_URL.US."app");
        }
    }

    public function login() {
        // bring to bottom of landing page
        // header('Location: '.SITE_URL.US.'auth'.US.'login');
    }

    public function post() {
        // echo $_POST['samp'];
    }

    function send_mail(){
		// if(isset($_POST['send']))
        // {
		$to_email= "lamzonelizer1@gmail.com";
		$subject="subject";
		$message= "Sample message.";
			
		$to = $to_email;
        $subject = $subject;
        $txt = $message;
        $headers = "From: admin@gmail.com" . "\r\n" .
        "CC: anymail@example.com";
		mail($to,$subject,$txt,$headers);
		// }
        // $this->view->render('hello/send_mail');
	}
}