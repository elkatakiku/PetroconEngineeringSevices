<?php

use Model\Account;

?>
<main class="content">
    <!-- Header -->
    <div class="page-header">
        <span>                
            <a id="backBtn" href="<?= SITE_URL ?>/user/list#all" class="link-btn">
                <span class="material-icons">
                    arrow_back
                </span>
                <small>Go back</small>
            </a>
            <h1 class="page-title">New user</h1>
        </span>
    </div>

    <form class="main-content" id="signupForm" action="<?= SITE_URL ?>/signup/run" method="post">

        <!-- Alert -->
        <div class="alert alert-danger" role="alert"></div>

        <!-- Content -->
        <div class="linear-container">
            <div class="linear">
                <div class="personal-form basis-lg-8">
                    <h5 class="form-header">Personal</h5>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastName" aria-describedby="helpId"
                               placeholder="Enter last name" required>
                    </div>

                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control top" name="firstname" id="firstName"
                               aria-describedby="helpId" placeholder="Enter first name" required>
                    </div>

                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control top" name="middlename" id="middlename"
                               aria-describedby="helpId" placeholder="Enter first name">
                    </div>

                    <div class="form-group">
                        <label for="">Contact Number</label>
                        <input type="number" pattern="/d" class="form-control" name="contact" id="contactNumber"
                               aria-describedby="helpId" placeholder="Enter contact number" required>
                        <small id="helpId" class="form-text text-muted">Ex: 09123456789</small>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" rows="2" class="form-control" name="address"
                                  placeholder="Enter address" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Birthdate</label>
                        <input type="date" class="form-control" name="dob" id="birthdate" aria-describedby="helpId"
                               placeholder="Enter birthdate" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="">Email</label>
                        <span class="loading-input">
                            <input type="email" class="form-control top" data-validate="userEmail" name="email"
                                   id="email" aria-describedby="helpId" placeholder="Enter email" required>
                            <div class="loading" style="display: none;">
                                <div class="spinner-grow spinner-grow-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </span>
                        <small id="helpId" class="form-text text-danger"></small>
                    </div>
                </div>

                <div class="account-form basis-lg-4">
                    <h5 class="form-header">Account</h5>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" id="type" required>
                            <option selected value="<?= Account::CLIENT_TYPE ?>">Client</option>
                            <option value="<?= Account::EMPLOYEE_TYPE ?>">Employee</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Username</label>
                        <span class="loading-input">
                            <input type="text" class="form-control" name="username" id="username"
                                   aria-describedby="helpId" placeholder="Enter username" required>
                            <div class="loading" style="display: none;">
                                <div class="spinner-grow spinner-grow-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </span>
                        <small id="helpId" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control top" name="password" data-validate="password"
                               id="password" aria-describedby="helpId" placeholder="Enter password" required>
                        <input type="password" class="form-control bottom" name="passwordRepeat"
                               data-validate="passwordRepeat" id="password" aria-describedby="helpId"
                               placeholder="Confirm password" required>
                        <small id="helpId" class="form-text text-danger"></small>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="page-footer">
        <button class="btn action-btn" type="submit" form="signupForm" name="createUser">Create</button>
        <a href="<?= SITE_URL . '/user/list#all' ?>">
            <button type="button" class="btn outline-action-btn">Cancel</button>
        </a>
    </div>
</main>

<script>
    let types = {
        'employee': '<?= Account::EMPLOYEE_TYPE ?>',
        'client': '<?= Account::CLIENT_TYPE ?>'
    };
</script>