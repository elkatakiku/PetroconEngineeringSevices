<main class="content">
    <!-- Header -->
    <div class="page-header">
        <span>                
        <a id="backBtn" href="<?= SITE_URL ?>/project" class="link-btn">
            <span class="material-icons">
                arrow_back
            </span>
            <small>Go back</small>
        </a>
        <h1 class="page-title">New project</h1>
        </span>
    </div>

    <form id="newProject" class="main-content">
        <!-- Alert -->
        <div class="alert alert-danger" role="alert"></div>

        <!-- Content -->
        <div class="linear-container">
            <div class="linear">
                <div class="project-form basis-lg-8">
                    <h5 class="form-header">Project</h5>

                    <div class="linear flex-md-nowrap flex-wrap" data-gap="5">
                      <div class="form-group basis-12 basis-md-6">
                        <label for="">Purchase order no.</label>
                        <input type="text" class="form-control" name="purchaseOrd" id="" aria-describedby="helpId" placeholder="Type the purchase order number here" required>
                      </div>

                      <div class="form-group basis-12 basis-md-6">
                        <label for="">Date of award</label>
                        <input type="date" class="form-control" name="awardDate" id="" aria-describedby="helpId" required>
                      </div>
                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control" name="description" id="" rows="1"  placeholder="Type the project description here"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Location</label>
                        <input type="text" class="form-control" name="location" id="" aria-describedby="helpId" placeholder="Type the location here" required>
                    </div>

                    <div class="form-group">
                        <label for="">Building no.</label>
                        <input type="text" class="form-control" name="buildingNo" id="" aria-describedby="helpId" placeholder="Type the building number here" required>
                    </div>

<!--                    <div class="form-group">-->
<!--                        <label for="" class="basis-12">Completion Date</label>-->
<!--                        <div class="linear flex-md-nowrap flex-wrap">-->
<!--                            <span class="flex-grow-1">-->
<!--                                <input type="date" class="form-control" required >-->
<!--                            </span>-->
<!--                            <span>-->
<!--                                --->
<!--                            </span>-->
<!--                            <span class="flex-grow-1">-->
<!--                                <input type="date" class="form-control" required>-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>

                <div class="client-form basis-lg-4">
                    <h5 class="form-header">Client</h5>

                    <style>
                        [list]::-webkit-calendar-picker-indicator {
                            display:none !important;
                        }
                    </style>

                    <div class="form-group">
                        <label for="">Company name</label>
                        <input type="text" class="form-control" name="cmpnyName" aria-describedby="helpId" placeholder="Type the company name here" required>
<!--                        <datalist id="companyList">-->
<!--                            --><?php //foreach ($data['companyList'] as $company) { ?>
<!--                                <option value="--><?//= $company['name'] ?><!--" data-company="--><?//= $company['id'] ?><!--"></option>-->
<!--                            --><?php //} ?>
<!--                        </datalist>-->
                    </div>

                    <div class="form-group">
                        <label for="">Representative</label>
                        <input type="text" class="form-control" name="cmpnyRepresentative" aria-describedby="helpId" placeholder="Type the representative's name here" required>
<!--                        <datalist id="clientList">-->
<!--                            --><?php //foreach ($data['clientList'] as $client) { ?>
<!--                                <option value="--><?//= $client['name'] ?><!--" data-client="--><?//= $client['id'] ?><!--"></option>-->
<!--                            --><?php //} ?>
<!--                        </datalist>-->
                    </div>

                    <div class="form-group">
                        <label for="">Contact number</label>
                        <input type="text" class="form-control" name="cmpnyContact" id="" aria-describedby="helpId" placeholder="Type the contact number here" required>
                    </div>

<!--                    <div class="form-group">-->
<!--                        <label for="">Email</label>-->
<!--                        <input type="email" class="form-control" name="cmpnyEmail" id="" aria-describedby="helpId" placeholder="Type the email here" required>-->
<!--                    </div>-->
                </div>

                <style>
                    .project-actions .btn {
                        min-width: 100px;
                        padding: 5px 25px;
                    }
                </style>

                <div class="project-actions basis-12 mb-1">
                    <h5 class="form-header">Others</h5>
                    <div class="linear">
                        <button class="btn primary-btn">Completion Date</button>
<!--                        <button class="btn primary-btn">Tasks</button>-->
                    </div>
                </div>
            </div>

        </div>
    </form>

    <div class="page-footer">
        <button class="btn action-btn" type="submit" form="newProject" name="createProject">Create</button>
        <a href="<?= SITE_URL.'/project/list#all' ?>"><button type="button" class="btn outline-action-btn">Cancel</button></a>
    </div>
</main>

