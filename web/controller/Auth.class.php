<?php

namespace Controller;

use Core\Controller as MainController;
use Service\PeopleService;
use Service\UserService;


class Auth extends MainController
{
    private UserService $userService;

    public function __construct() {
        $this->setType(MainController::AUTH);
        $this->userService = new UserService();
    }

    public function index() {
        $this->goToLogin();
    }

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
            if ($user = json_decode($this->userService->getUserRegister($regId), true)) {
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
        } else {
            $this->goToLogin();
        }

    }
}