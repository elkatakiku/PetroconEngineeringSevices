<!-- <div class="pcontent">
    <div class="pheader">
        <div class="linear-center">
            <h2 class="ptitle">Forgot Password?</h2>
        </div>
        <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="pbody pad-6">
        <form id="resetForm" action="<?= SITE_URL ?>/auth/reset" method="post">
            <div class="form-group">
                <label for="">Enter your email address below and we'll send you further instructions on how to reset your password.</label>
                <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Enter email address">
            </div>
        </form>
    </div> 

    <div class="pfooter pad-6">
        <button type="submit" form="resetForm" class="btn action-btn">Sign up</button>
        <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
    </div>
    </div>
</div> -->

<!-- <div class="cover-page">
    <div class="brand">
        <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container-fluid p-0">
        <form class="form-login" action="<?= SITE_URL ?>/login/run" method="post">

            <header class="login-header">
                <h2>Login</h2>
            </header>

            <div class="form-group">
            <label for="">Username</label>
            <input type="text" class="form-control" name="usernameInput" id="" aria-describedby="helpId" placeholder="Username">
            </div>

            
            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="passwordInput" id="" placeholder="Password">
            </div>

            <button type="submit" name="loginSubmit" id="" class="btn btn-block primary-btn">Login</button>

            <div class="login-options">
                <label class="remember">
                    <input type="checkbox" class="" name="" id="" value="checkedValue">
                    Remember me
                </label>
                <a href="<?= SITE_URL.'/auth/reset' ?>">Forgot Password?</a>
            </div>
        </form>
    </div>

</div> -->

<div class="cover-page">
    <div class="brand container">
        <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container">
        <form class="cover-form p-4" action="<?= SITE_URL.'/auth/sendReset' ?>" method="POST">

            <header class="mb-4">
                <h5>Forgot Password?</h5>
            </header>

            <?= $this->displayResult($_GET, 'Email sent successfully.') ?>

            <!-- Alert -->
            <div class="alert alert-danger" role="alert"></div>

            <div class="form-group">
                <label for="">Enter your email address below and we'll send you instructions on how to reset your password.</label>
                <input type="text" class="form-control" name="email" id="" aria-describedby="helpId" placeholder="Enter email address">
            </div>
            
            <button type="submit" name="forgotSubmit" class="btn btn-block primary-btn mt-4 mb-2">Send</button>
            <a href="<?= SITE_URL ?>" class="btn btn-block link-btn">Back to login</a>
        </form>
    </div>
</div>