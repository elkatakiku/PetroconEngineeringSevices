<main class="content">
    <!-- Header -->
    <div class="page-header">
        <span>                
            <a id="backBtn" href="<?= SITE_URL.'/account/profile' ?>" class="linear">
                <span class="material-icons">
                    arrow_back
                </span>
                <small>Go back</small>
            </a>
        </span>
    </div>

    <form id="changePassForm" action="<?= SITE_URL.'/user/changePass'?>" method="POST" class="main-content">
    
        <!-- Content -->
        <h5 class="form-header">Reset password</h5>
        
        <?= $this->displayResult($_GET, 'Password changed successfully.') ?>

        <input type="hidden" name="id" value="<?= $data['user']['log_id'] ?>">

        <div class="form-group">
            <label for="old">Current password</label>
            <input type="password" class="form-control" name="oldPass" id="old" placeholder="Type the old password here">
        </div>

        <div class="form-group">
            <label for="new">New password</label>
            <input type="password" class="form-control" name="newPass" id="new"  placeholder="Type the new password here">
        </div>

        <div class="form-group">
            <label for="new2">Confirm new password</label>
            <input type="password" class="form-control" name="newPassRepeat" id="new2" placeholder="Confirm new password here">
        </div>
    </form>

    <div class="page-footer">
        <button class="btn action-btn" type="submit" form="changePassForm" name="changePassSubmit">Update</button>
        <a href="<?= SITE_URL.'/account' ?>"><button type="button" class="btn outline-action-btn">Cancel</button></a>
    </div>            
</main>