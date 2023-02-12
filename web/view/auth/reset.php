<div class="cover-page">
    <div class="brand container">
        <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container">
        <form class="cover-form p-4" action="<?= SITE_URL.'/auth/resetPassword' ?>" method="POST">

            <header class="mb-4">
                <h5>Reset Password</h5>
            </header>

            <?= $this->displayResult($_GET, 'Password changed successfully.') ?>

            <?php if (!isset($_GET['success'])) { ?>

            <input type="hidden" name="id" value="<?= $data['resetId'] ?>" required>
            
            <div class="form-group">
                <label for="">New password</label>
                <input type="password" class="form-control" name="password" data-validate="password" required>
            </div>

            <div class="form-group">
                <label for="">Retype new password</label>
                <input type="password" class="form-control" name="passwordRepeat" data-validate="passwordRepeat" required>
            </div>
            
            <button type="submit" name="resetSubmit" class="btn btn-block primary-btn mt-4 mb-2">Submit</button>
            <?php } ?>

            <a href="<?= SITE_URL ?>" class="btn btn-block <?php echo isset($_GET['success']) ? 'action-btn' : 'link-btn' ;  ?>">Go to login</a>
        </form>
    </div>
</div>