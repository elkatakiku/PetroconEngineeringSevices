<div class="cover-page">
    <div class="brand container">
        <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="brand-icon" alt="Petrocon logo">
        <span class="brand-name">Petrocon Engineering <br> Services</span>
    </div>

    <div class="linear-center container">
        <form id="signupForm">

            <header class="mb-4 text-center">
                <h2>Sign Up</h2>
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
                    <div class="linear-md">
                        <div class="form-group">
                            <label for="">Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastName" aria-describedby="helpId" placeholder="Enter last name" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="">First Name</label>
                            <input type="text" class="form-control" name="firstname" id="firstName" aria-describedby="helpId" placeholder="Enter first name" required>
                        </div>
    
                        <div class="form-group">
                            <label for="">Middle Name</label>
                            <input type="text" class="form-control" name="middlename" id="firstName" aria-describedby="helpId" placeholder="Enter middle name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Birthdate</label>
                        <input type="date" class="form-control" name="dob" id="birthdate" aria-describedby="helpId" placeholder="Enter birthdate" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Contact Number</label>
                        <input type="number" pattern="/d" class="form-control" name="contact" id="contactNumber" aria-describedby="helpId" placeholder="Enter contact number" required>
                        <small id="helpId" class="form-text text-muted">Ex: 09123456789</small>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" rows="2" class="form-control"  name="address" placeholder="Enter address" required></textarea>
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control top" name="email" id="email" data-validate="userEmail" aria-describedby="helpId" placeholder="Enter email" required>
                    </div>
                
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="username" id="username" aria-describedby="helpId" placeholder="Enter username" required>
            
                    </div>
                    
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control top" name="password" data-validate="password" id="password" aria-describedby="helpId" placeholder="Enter password" required>
                        <input type="password" class="form-control bottom" name="passwordRepeat" data-validate="passwordRepeat" id="password" aria-describedby="helpId" placeholder="Confirm password" required>
                        <small id="helpId" class="form-text text-danger"></small>
                    </div>
                </div>
            </div>

            <button 
                data-slider="#signupSlider" 
                data-action="next" 
                type="button"
                class="btn btn-block primary-btn mt-2 mb-4"
                form="signupForm"
                name="signupSubmit" 
            >Continue</button>
<!-- 
            <button
                type="submit" name="signupSubmit" 
                class="btn btn-block primary-btn mt-2 mb-4" 
                form="signupForm"
                style="display: none;">
                Submit
            </button> -->
        </form>
    </div>
</div>
