<div class="cover-page">
    <div class="brand">
        <img src="<?= IMAGES_PATH ?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container-fluid p-0">
        <form class="form-login" action="<?= SITE_URL ?>/login/run" method="post">

            <header class="login-header">
                <h2>Login</h2>
            </header>

            <div class="form-group">
                <label for="">Username</label>
                <input type="text" class="form-control" name="usernameInput" id="" aria-describedby="helpId"
                       placeholder="Username" required>
            </div>

            <div class="form-group">
                <label for="">Password</label>
                <input type="password" class="form-control" name="passwordInput" id="" placeholder="Password" required>
            </div>

            <button type="submit" name="loginSubmit" id="" class="btn btn-block primary-btn">Login</button>

            <div class="linear-center mt-3">
                <a href="<?= SITE_URL . '/auth/forgotpass' ?>">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>