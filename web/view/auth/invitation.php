<div class="cover-page">
    <div class="brand container">
        <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container">
        <form class="cover-form p-4" id="verifyForm" action="<?= SITE_URL.'/user/verify' ?>" method="post">

<!--            --><?//= var_dump($data) ?>
            <?php if (!$data['expired']) { ?>
            <header class="mb-4">
                <h5>Welcome <?= strtoupper($data['invitation']['name']) ?>!</h5>
            </header>

            <p>Sign in with the login credentials below to access your account.</p>
            <p>After logging in for the first time, we recommend that you to: </p>
            <ul>
                <li>
                    change your username and password to something you can easily remember;
                </li>
                <li>
                    fill up your personal details.
                </li>
            </ul>

            <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="form-control" name="password" readonly value="<?= $data['invitation']['username'] ?>">
            </div>

            <div class="form-group">
                <label for="">Password</label>
                <input type="text" class="form-control" name="password" readonly value="<?=  $data['invitation']['password'] ?>">
            </div>

            <div class="alert alert-info show">
                This is your only way to access your account. <strong>Save your login credentials</strong> or change your username and password.
            </div>

            <a href="<?= SITE_URL ?>" target="_blank" class="btn btn-block primary-btn mt-4 mb-2">Login</a>
            <?php } else { ?>
                <header class="mb-4">
                    <h5>Invitation Feedback</h5>
                </header>

                <p>The invitation may have been canceled, used or does not exist.</p>
                <p>For more information, contact the admin.</p>

                <a href="<?= SITE_URL ?> " target="_blank" class="btn btn-block primary-btn mt-4 mb-2">Go to login</a>
            <?php } ?>
        </form>
    </div>
</div>