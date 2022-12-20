<main class="content">
    <!-- Header -->
    <div class="page-header">
        <span>                
        <a id="backBtn" href="projects.html" class="link-btn">
            <span class="material-icons">
            arrow_back
            </span>
            <small>Go back</small>
        </a>
        <h1 class="page-title">New project</h1>
        </span>
    </div>

    <form id="newProject" action="<?= SITE_URL ?>/projects/new" method="POST" class="main-content">
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
                        <label for="">Project name</label>
                        <input type="text" class="form-control" name="prjName" id="" aria-describedby="helpId" placeholder="Type the project name here">
                    </div>

                    <div class="form-group">
                        <label for="">Location</label>
                        <input type="text" class="form-control" name="prjLocation" id="" aria-describedby="helpId" placeholder="Type the location here">
                    </div>

                    <div class="form-group">
                        <label for="">Building no.</label>
                        <input type="text" class="form-control" name="prjBuildingNo" id="" aria-describedby="helpId" placeholder="Type the building number here">
                    </div>
        
                    <div class="form-group">
                        <div class="linear-label">
                            <label for="">Working days</label>
                            <small># d</small>
                        </div>
                        <div class="input-options scroll-x">
                            <label for="mon" class="option-box">
                                Mon
                                <input type="checkbox" name="prjWorkDay[]" id="mon" value="1">
                            </label>
                            <label for="tue" class="option-box">
                                Tue
                                <input type="checkbox" name="prjWorkDay[]" id="tue" value="2">
                            </label>
                            <label for="wed" class="option-box">
                                Wed
                                <input type="checkbox" name="prjWorkDay[]" id="wed" value="3">
                            </label>
                            <label for="thu" class="option-box">
                                Thu
                                <input type="checkbox" name="prjWorkDay[]" id="thu" value="4">
                            </label>
                            <label for="fri" class="option-box">
                                Fri
                                <input type="checkbox" name="prjWorkDay[]" id="fri" value="5">
                            </label>
                            <label for="sat" class="option-box">
                                Sat
                                <input type="checkbox" name="prjWorkDay[]" id="sat" value="6">
                            </label>
                            <label for="sun" class="option-box">
                                Sun
                                <input type="checkbox" name="prjWorkDay[]" id="sun" value="7">
                            </label>
                        </div>
                    </div>
        
                    <div class="form-group">
                        <div class="linear-label">
                            <label for="">Working hours</label>
                            <small># h</small>
                        </div>
                        <div class="input-options scroll-x">
                            <label for="morn" class="option-box">
                                09:00 - 12:00
                                <input type="checkbox" name="prjWorkHour[]" value="1" id="morn">
                            </label>
                            <label for="aft" class="option-box">
                                14:00 - 18:00
                                <input type="checkbox" name="prjWorkHour[]" value="2" id="aft">
                            </label>
                        </div>
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