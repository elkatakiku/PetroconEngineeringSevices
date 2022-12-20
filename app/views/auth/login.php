<div class="cover-background" data-image="header-image.jpg">
    <div class="cover-page">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-6 col-12">
                <div class="brand">
                    <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
                    <span class="brand-name">Petrocon Engineering <br> Services</span>
                </div>
                <header class="login-header-content">
                    <h1>Petrocon Engineering <br> Services can help.</h1>
                    <p class="subtitle">
                        Accident precaution is our intention, 
                        <br>
                        For every project, we provide quality construction.
                    </p>
                </header>
            </div>
            
            <div class="col-lg-5 col-md-6 col-12">
                <form class="form-login" action="<?= SITE_URL ?>/auth/login" method="post">

                    <header class="login-header">
                        <h2>Login</h2>
                        <p class="subtitle">New to this site? Click create an account button below and sign up!</p>
                    </header>

                    <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Username">
                    <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                    </div>

                    
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="" id="" placeholder="Password">
                    </div>

                    <button type="submit" name="loginSubmit" id="" class="btn btn-block primary-btn">Login</button>

                    <div class="login-options">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue">
                                Remember me
                            </label>
                        </div>
                        <!-- <a href="">Forgot Password?</a> -->
                        <button type="button" class="btn btn-link" data-toggle="popup" data-target="#popupforgotPass">Forgot Password?</button>
                    </div>

                    <button type="button" id="createAccountBtn" class="btn outline-primary-btn btn-block" data-toggle="popup" data-target="#popupLargeId">Create an account</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SIGNUP -->
<div class="popup fade" id="popupsignUp" tabindex="-1" aria-hidden="true">
    <div class="pcontainer">
        <div class="pcontent">
            <div class="pheader">
                <div class="linear-center">
                    <!-- Can add icon here -->
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <h2 class="ptitle">Sign Up</h2>
                </div>
                <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="pbody pad-6">
                <form id="signupForm" action="<?= SITE_URL ?>/auth/signup" method="post">
                    <!-- Alert -->
                    <div class="alert alert-danger" role="alert">
                        A simple danger alert—check it out!
                    </div>

                    <!-- Form Inputs -->
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" name="lNameInput" id="lastName" aria-describedby="helpId" placeholder="Enter last name">
                                </div>
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control top" name="fNameInput" id="firstName" aria-describedby="helpId" placeholder="Enter first name">    
                                </div>

                                <div class="form-group">
                                    <label for="middleName">Middle Name</label>
                                    <input type="text" class="form-control" name="mNameInput" id="middleName" aria-describedby="helpId" placeholder="Enter middle name">
                                </div>

                                <div class="form-group">
                                    <label for="contactNumber">Contact Number</label>
                                  <input type="number" pattern="/d" class="form-control" name="contactInput" id="contactNumber" aria-describedby="helpId" placeholder="Enter contact number">
                                  <small id="helpId" class="form-text text-muted">Ex: 09123456789</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="birthdate">Birthdate</label>
                                    <input type="date" class="form-control" name="dobInput" id="birthdate" aria-describedby="helpId" placeholder="Enter birthdate" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control top" name="emailInput" id="email" aria-describedby="helpId" placeholder="Enter email">    
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="usernameInput" id="username" aria-describedby="helpId" placeholder="Enter username">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="passwordInput" id="password" aria-describedby="helpId" placeholder="Enter password">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password Repeat</label>
                                    <input type="password" class="form-control" name="passwordRepeatInput" id="password" aria-describedby="helpId" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                    </div>       
                </form>
            </div>

            <div class="pfooter pad-6">
            <button type="submit" form="signupForm" name="signupSubmit" class="btn action-btn">Sign up</button>
            <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- FORGOT PASS -->
<div class="popup fade" id="popupforgotPass" tabindex="-1" aria-hidden="true">
    <div class="pcontainer">
        <div class="pcontent">
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
        </div>
    </div>
</div>