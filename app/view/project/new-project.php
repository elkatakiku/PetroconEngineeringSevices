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
        <div class="alert alert-danger" role="alert">
            A simple danger alert—check it out!
        </div>

        <!-- Content -->
        <div class="linear-container">
            <div class="linear">
                <div class="project-form basis-lg-8" data-basis="">
                    <h5 class="form-header">Project</h5>

                    <div class="linear">
                        <div class="basis-sm-6">
                          <div class="form-group">
                            <label for="">Purchase order no.</label>
                            <input type="text" class="form-control" name="prjPurchaseOrd" id="" aria-describedby="helpId" placeholder="Type the purchase order number here">
                          </div>
                        </div>

                        <div class="basis-sm-6">
                          <div class="form-group">
                            <label for="">Date of award</label>
                            <input type="date" class="form-control" name="prjAwardDate" id="" aria-describedby="helpId">
                          </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control" name="prjDescription" id="" rows="1"  placeholder="Type the project name here"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Location</label>
                        <input type="text" class="form-control" name="prjLocation" id="" aria-describedby="helpId" placeholder="Type the location here">
                    </div>

                    <div class="form-group">
                        <label for="">Building no.</label>
                        <input type="text" class="form-control" name="prjBuildingNo" id="" aria-describedby="helpId" placeholder="Type the building number here">
                    </div>
                </div>

                <div class="client-form basis-lg-4">
                    <h5 class="form-header">Client</h5>

                    <div class="form-group">
                        <label for="">Company name</label>
                        <input type="text" class="form-control" name="cmpnyName" id="" aria-describedby="helpId" placeholder="Type the company name here">
                    </div>

                    <div class="form-group">
                        <label for="">Representative</label>
                        <input type="text" class="form-control" name="cmpnyRepresentative" id="" aria-describedby="helpId" placeholder="Type the representative's name here">
                    </div>

                    <div class="form-group">
                        <label for="">Contact number</label>
                        <input type="text" class="form-control" name="cmpnyContact" id="" aria-describedby="helpId" placeholder="Type the contact number here">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="page-footer">
        <button class="btn action-btn" type="submit" form="newProject" name="createProject">Create</button>
        <a href="projects.html"><button type="button" class="btn outline-action-btn">Cancel</button></a>
    </div>            
</main>