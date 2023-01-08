<div class="cover-page">
    <div class="brand container">
        <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container">
        <form id="signupForm" action="<?= SITE_URL ?>/signup/run" method="post">

            <header class="my-4 text-center">
                <h2>Signup</h2>
            </header>

            <button type="button" data-slider="#signupSlider" data-action="prev" class="linear link-btn mb-2">
                <span class="material-icons">
                    arrow_back
                </span>
                <small>Go back</small>
            </button>
            
            <?php $this->displayResult($_GET, 'Signed up successfully'); ?>
            
            <div class="slider" id="signupSlider">
                <div class="active">
                    <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" class="form-control" name="lNameInput" id="lastName" aria-describedby="helpId" placeholder="Enter last name">
                    </div>
                
                    <div class="form-group">
                        <label for="">First Name</label>
                        <input type="text" class="form-control top" name="fNameInput" id="firstName" aria-describedby="helpId" placeholder="Enter first name">    
                    </div>

                    <div class="form-group">
                        <label for="">Middle Name</label>
                        <input type="text" class="form-control top" name="mNameInput" id="firstName" aria-describedby="helpId" placeholder="Enter first name">    
                    </div>
                    
                    <div class="form-group">
                        <label for="">Contact Number</label>
                        <input type="number" pattern="/d" class="form-control" name="contactInput" id="contactNumber" aria-describedby="helpId" placeholder="Enter contact number">
                        <small id="helpId" class="form-text text-muted">Ex: 09123456789</small>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" rows="2" class="form-control"  name="message" placeholder="Enter address" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Birthdate</label>
                        <input type="date" class="form-control" name="dobInput" id="birthdate" aria-describedby="helpId" placeholder="Enter birthdate" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" class="form-control top" name="emailInput" id="email" aria-describedby="helpId" placeholder="Enter email">
                    </div>
                
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="usernameInput" id="username" aria-describedby="helpId" placeholder="Enter username">
            
                    </div>
                    
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="passwordInput" id="password" aria-describedby="helpId" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                        <label for="">Retype Password</label>
                        <input type="password" class="form-control" name="passwordRepeatInput" id="password" aria-describedby="helpId" placeholder="Enter password">
                    </div>
                </div>
            </div>

            <button 
                data-slider="#signupSlider" 
                data-action="next" 
                type="button" name="signupSubmit" 
                class="btn btn-block primary-btn mt-2 mb-4" 
                form="signupForm"
            >Continue</button>

            <p class="text-center">Already have an account? <a href="<?= SITE_URL ?>/login">Login here</a></p>
        </form>
    </div>
</div>
