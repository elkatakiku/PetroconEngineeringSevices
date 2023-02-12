<div class="cover-page">
    <div class="brand container">
        <img src="<?= IMAGES_PATH ?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container">
        <form class="cover-form p-4" action="<?= SITE_URL . '/auth/sendReset' ?>" method="POST">

            <header class="mb-4">
                <h5>Forgot Password?</h5>
            </header>

            <?= $this->displayResult($_GET, 'Email sent successfully.') ?>

            <div class="form-group">
                <label for="">Enter your email address below, and we'll send you instructions on how to reset your
                    password.</label>
                <input type="email" class="form-control" name="email" aria-describedby="helpId"
                       placeholder="Enter email address" required>
            </div>

            <button type="submit" name="forgotSubmit" class="btn btn-block primary-btn mt-4 mb-2">Send</button>
            <a href="<?= SITE_URL ?>" class="btn btn-block link-btn">Back to login</a>
        </form>
    </div>
</div>