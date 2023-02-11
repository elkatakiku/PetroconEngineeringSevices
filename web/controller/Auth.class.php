<?php

namespace Controller;

use Core\Controller as MainController;
use Service\PeopleService;


class Auth extends MainController {

    const LOGIN = "login";
    const SIGNUP = "signup";
    const RESET = "reset";

    private $userService;

    public function __construct() {
        $this->setType(MainController::AUTH);
        $this->userService = new \Service\UserService();

        // if (!isset($_SESSION['accID'])) {
        //     $this->goToLogin();
        // }
    }

    public function index() {
        $this->goToLogin();
    }

//    public function signup()
//    {
//        $this->view("auth", "signup");
//    }

    // Forgot pass
    public function forgotpass() {
        $this->view("auth", "forgot-pass");
    }

    public function sendReset() {
        if (isset($_POST['forgotSubmit'])) {
            $result = json_decode($this->userService->forgotPassword($_POST['email']), true);
            if ($result['statusCode'] == 200) {
                header("Location: ".SITE_URL."/auth/forgotpass?success=sent");
            } else {
                header("Location: ".SITE_URL."/auth/forgotpass?error=".$result['message']);
            }
        }
    }

    // Reset
    public function reset($resetId)
    {
        if (!$this->userService->isResetUsed($resetId) || isset($_GET['success']) || isset($_GET['?error'])) {
            $this->view("auth", "reset", ['resetId' => $resetId]);
        } else {
            $this->goToLogin();
        }
    }

    public function resetPassword()
    {
        if (isset($_POST['resetSubmit'])) {
            $result = json_decode($this->userService->resetPassword($_POST), true);
            if ($result['statusCode'] == 200) {
                 header("Location: ".SITE_URL."/auth/reset/".$result['resetId']."?success=changed");
            } else {
                 header("Location: ".SITE_URL."/auth/reset/".$result['resetId']."?error=".$result['message']);
            }
        }
    }


    public function verify($regId) {
        if ($regId) {
            // $user = json_decode($this->userService->getUserRegister($regId), true);
            // $this->userService->sendVerification($regId);
            if ($user = json_decode($this->userService->getUserRegister($regId), true)) {
                // var_dump($user);
                $this->view("auth", "verify", $user['data']);
            }
        }
    }

    public function activate()
    {
        if (isset($_SESSION['accID'])) {
            if ($this->userService->sendVerification()) {
                // Show instruction
                header('Location: ' .SITE_URL.'/auth/verify/'.$_SESSION['accRegister']);
                exit();
                return;
            } else {
                echo "Error";
            }
        } else {
            $this->goToLogin();
        }
    }

    public function logout() {
        session_unset();
        session_destroy();

        header("Location: ".SITE_URL);
    }

    //  Invitation
    public function invitation(string $code)
    {
        if ($code) {
            $peopleService = new PeopleService();
            $invitation = $peopleService->runInvitation($code);

            $data = ['expired' => ($invitation['data'] ? $invitation['data']['expired'] : true)];

            if ($invitation['statusCode'] == 200) {
                $data['invitation'] = $invitation['data']['invitation'];
            }

            $this->view('auth', 'invitation', $data);

//            TODO : Check if the invitation expired
//            TODO : Create account if not expired
//            TODO : Show message or go back to login when expired?
        } else {
            $this->goToLogin();
        }

    }
}