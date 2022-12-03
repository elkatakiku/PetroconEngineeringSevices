            <div class="col-lg-7 col-md-6 col-12">
                <div class="container">
                    <span class="inline-block row brand">
                        <img src="../images/petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
                        <span class="brand-name">Petrocon Engineering Services</span>
                    </span>
                </div>
                <header class="login-header-content">
                    <h1>Petrocon Engineering <br> Services can help.</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </header>
            </div>
            
            <div class="col-lg-5 col-md-6 col-12">
                <form class="form-login" action="loginUser" method="post">

                    <header class="text-center mb-5">
                        <h2>Login</h2>
                        <p class="lead">Lorem ipsum dolor sit amet.</p>
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

                    <button type="submit" name="" id="" class="btn btn-lg btn-block primary-btn">Login</button>

                    <div class="container">
                        <div class="row justify-content-between login-options">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue">
                                    Remember me
                                </label>
                            </div>
                            <!-- <a href="">Forgot Password?</a> -->
                            <button type="button" class="btn btn-link" data-toggle="popup" data-target="#popupforgotPass">Forgot Password?</button>
                        </div>
                    </div>

                    <button type="button" id="createAccountBtn" class="btn outline-primary-btn btn-lg btn-block" data-toggle="popup" data-target="#popupsignUp">Create an account</button>
                </form>
            </div>
        </div>
    </div>  
</div>

<!-- SIGNUP -->
<div class="container-fluid">
    <div class="popup fade" id="popupsignUp" tabindex="-1" aria-hidden="true">
        <div class="pcontainer">
            <div class="pcontent">
                <div class="pheader">
                    <div class="linear-center-h">
                        <!-- Can add icon here -->
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <h2 class="ptitle">Sign Up</h2>
                    </div>
                    <button type="button" class="close-btn" data-dismiss="popupsignUp" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="pbody pad-6">
                    <form action="table.html" class="slide-wrapper">
                        <div id="firstFormSlide">
                            <div class="container">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Last Name</label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Enter last name">
                                        </div>
                                        <div class="form-group">
                                            <label for="">First Name</label>
                                            <input type="text" class="form-control top" name="" id="" aria-describedby="helpId" placeholder="Enter first name">    
                                        </div>
                                        <div class="form-group">
                                            <label for="">Middle Name</label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Enter middle name">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Contact Number</label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Enter contact number">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Birthdate</label>
                                            <input type="date" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Enter birthdate">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" class="form-control top" name="" id="" aria-describedby="helpId" placeholder="Enter email">    
                                        </div>
                                        <div class="form-group">
                                            <label for="">Username</label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Enter username">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Enter password">
                                        </div>
                                    </div>
                                </div>
                            </div>       
                        </div>
                    </form>
                </div>

                <div class="pfooter pad-6">
                    <button type="button" class="btn action-btn">Sign up</button>
                    <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORGOT PASS -->
<div class="container-fluid">
    <div class="popup fade" id="popupforgotPass" tabindex="-1" aria-hidden="true">
        <div class="pcontainer">
            <div class="pcontent">
                <div class="pheader">
                    <div class="linear-center-h">
                        <!-- Can add icon here -->
                        <h2 class="ptitle">Forgot Password?</h2>
                    </div>
                    <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="pbody pad-6">
                    <form action="table.html" class="slide-wrapper">
                        <div id="firstFormSlide">
                            <div class="container">
                                <div class="row">
                                    <div class="col-7 col-8 col-12">
                                        <div class="form-group">
                                            <label for="">Enter your email address below and we'll send you further instructions on how to reset your password.</label>
                                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Enter email address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> 

                <div class="pfooter pad-6">
                    <button type="button" class="btn action-btn">Sign up</button>
                    <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
                </div>
                </div>
            </div>
    </div>
</div>

