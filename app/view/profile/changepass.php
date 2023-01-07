<main class="content">
    <!-- Header -->
    <div class="page-header">
        <span>                
            <a id="backBtn" href="<?= SITE_URL.US.'user/profile/'.$_SESSION['accID'] ?>" class="linear">
                <span class="material-icons">
                    arrow_back
                </span>
                <small>Go back</small>
            </a>
        </span>
    </div>

    <form id="changePassForm" action="<?= SITE_URL.US.'profile/changePass'?>" method="POST" class="main-content">
    <?php if (isset($_GET['error'])) { ?>  
          <!-- Alert -->
          <div class="alert alert-danger show" role="alert"><?= $_GET['error'] ?></div>
    <?php } else if (isset($_GET['success'])) { ?>  
          <!-- Alert -->
          <div class="alert alert-success show" role="alert">Password changed successfully</div>
    <?php } ?>

        <!-- Content -->
        <h5 class="form-header">Reset password</h5>

        <input type="hidden" name="id" value="<?= $data['id'] ?>">

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
        <button class="btn action-btn" type="submit" form="changePassForm" name="changePass">Update</button>
        <a href="projects.html"><button type="button" class="btn outline-action-btn">Cancel</button></a>
    </div>            
</main>