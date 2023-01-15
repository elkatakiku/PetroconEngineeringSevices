<div class="cover-page">
    <div class="brand container">
        <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container">
        <form class="cover-form p-4" id="verifyForm" action="<?= SITE_URL.'/user/verify' ?>" method="post">

            <header class="mb-4">
                <h5>Verify your account</h5>
            </header>
            
            <p>To access other features of the web application, you will need to active your account by verifying your email address.</p>
            <p>We've sent a link to your email address, <?= $data['email'] ?>.</p>
            <p>Sign in to your email and follow the instructions given to activate your account.</p>

            <a href="<?= SITE_URL.'dashboard' ?>" class="btn btn-block primary-btn mt-4 mb-2">Contiue to home</a>
        </form>
    </div>
</div>