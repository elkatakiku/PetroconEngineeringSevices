<main class="content">
    <!-- Header -->
    <div class="page-header pb-1">
        <div class="project-info">
            <div>
                <h1 class="page-title" style="font-size: 16px;"><?= $data['project']['description'] ?></h1>
                <small><?= $data['project']['location'] ?></small>
            </div>
        </div>
        <button id="projectInfoToggller" type="button" class="btn icon-btn align-self-start p-0" data-toggle="slide"
                data-target="#projectInfo">
            <span class="material-icons-outlined" style="font-size: 20px">info</span>
        </button>
    </div>

    <!-- Project Info -->
    <div class="slide slide-fixed" id="projectInfo" data-side="right">
        <div class="slide-content">
            <div class="slide-header">
                <div>
                    <button class="btn icon-btn" data-dismiss="slide">
                        <span class="material-icons">navigate_next</span>
                    </button>

                    <button
                            type="button"
                            class="link-btn"
                            data-toggle="form"
                            data-action="cancel"
                            form="projectDetailForm"
                    >
                        Cancel
                    </button>
                </div>

                <h2 class="slide-title">Details</h2>

                <button
                        type="button"
                        class="link-btn"
                        form="projectDetailForm"
                        data-toggle="form"
                        data-action="edit"
                >
                    Edit
                </button>
            </div>

            <div class="slide-body">
                <form id="projectDetailForm">
                    <!-- Alert -->
                    <div class="alert alert-danger mb-2" role="alert"></div>

                    <input type="hidden" name="id" value="<?= $data['project']['id'] ?>" required>

                    <h3 class="detail-header">Project</h3>

                    <div class="linear">

                        <div class="form-input-group">
                            <label for="">Purchase Order #</label>
                            <input type="text" name="purchaseOrd" value="<?= $data['project']['purchase_ord'] ?>"
                                   required readonly>
                        </div>

                        <div class="form-input-group">
                            <label for="">Date of Award</label>
                            <input type="date" name="awardDate" value="<?= $data['project']['award_date'] ?>" required
                                   readonly>
                        </div>

                    </div>

                    <div class="form-input-group">
                        <label for="">Work Description</label>
                        <textarea name="description" rows="1" required
                                  readonly><?= $data['project']['description'] ?></textarea>
                    </div>

                    <div class="form-input-group">
                        <label for="">Building no.</label>
                        <input type="text" name="buildingNo" value="<?= $data['project']['building_number'] ?>" required
                               readonly>
                    </div>

                    <div class="form-input-group">
                        <label for="">Location</label>
                        <input type="text" name="location" value="<?= $data['project']['location'] ?>" required
                               readonly>
                    </div>


                    <h3 class="detail-header">Client</h3>

                    <div class="form-input-group">
                        <label for="">Company</label>
                        <input type="text" name="company" value="<?= $data['project']['company'] ?>" required readonly>
                    </div>

                    <div class="form-input-group">
                        <label for="">Representative</label>
                        <input type="text" name="representative" value="<?= $data['project']['comp_representative'] ?>"
                               required readonly>
                    </div>

                    <div class="form-input-group">
                        <label for="">Contact</label>
                        <input type="tel" name="contact" value="<?= $data['project']['comp_contact'] ?>" required
                               readonly>
                    </div>
                </form>
            </div>

            <div class="slide-footer">
                <button type="button" class="btn sm-btn danger-btn delete-btn">
                    Remove project
                </button>
            </div>
        </div>
    </div>

    <nav class="nav-tab-container border-bottom">
        <ul class="nav-tab">
            <li class="nav-tab-item active">
                <button class="link-btn" data-toggle="custom-tab" data-target="#projectGanttChart">Gantt Chart</button>
            </li>
            <li class="nav-tab-item">
                <button class="link-btn" data-toggle="custom-tab" data-target="#projectTasks">Tasks</button>
            </li>
            <li class="nav-tab-item">
                <button class="link-btn" data-toggle="custom-tab" data-target="#projectResources">Resources</button>
            </li>
            <li class="nav-tab-item">
                <button class="link-btn" data-toggle="custom-tab" data-target="#projectPeople">People</button>
            </li>
            <li class="nav-tab-item">
                <button class="link-btn" data-toggle="custom-tab" data-target="#projectPayment">Payment</button>
            </li>
        </ul>
    </nav>

    <div class="custom-tab-container">

        <!-- Gantt Chart -->
        <section id="projectGanttChart" class="main-content custom-tab-content chart-container show">

            <div class="completion-graph">
                <span class="completion-date">
                    <h5>Completion Date</h5>
                    <p style="font-size: 10px"><span
                                class="start-date"><?= date('M. d, Y', strtotime($data["project"]['start'])) ?></span> - <span
                                class="end-date"><?= date('M. d, Y', strtotime($data["project"]['end'])) ?></span></p>
                </span>
                <span class="completion-bar">
                    <small class="completion-percent">0%</small>
                </span>
                <span class="completion-days"></span>
            </div>

            <div class="gantt-chart">
                <div class="chart">
                    <div class="chart-row chart-header">
                        <div class="chart-row-item">Task name</div>
                        <div>
                            <div class="chart-months">
                                <span class="chart-month"><?= date('F') ?></span>
                            </div>
                            <div class="chart-days"></div>
                        </div>
                    </div>

                    <div class="chart-body">
                        <div class="chart-lines"></div>
                    </div>
                </div>
            </div>

            <div class="spinner">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </section>

        <!-- Tasks -->
        <section id="projectTasks" class="main-content custom-tab-content">

            <?php if ($data['accountType'] != Core\Controller::CLIENT) { ?>
                <button id="addTask" type="button" class="btn action-btn sm-btn float-right">
                    <i class="fa fa-plus btn-icon" aria-hidden="true"></i>
                    Add task
                </button>
            <?php } ?>

            <div class="mesa-container" id="timelineTable">
                <table class="mesa" id="taskTable">
                    <thead class="mesa-head">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="tname" style="width: 80%;"><strong>Task</strong></th>
                        <th scope="col">Progress</th>
                        <th scope="col">Last Updated</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </section>

        <!-- Resources -->
        <section id="projectResources" class="main-content custom-tab-content">

            <?php if ($data['accountType'] != Core\Controller::CLIENT) { ?>
                <button id="addResource" type="button" class="btn action-btn sm-btn float-right">
                    <i class="fa fa-plus btn-icon" aria-hidden="true"></i>
                    Add material
                </button>
            <?php } ?>

            <!-- Resources Table -->
            <div class="mesa-container">
                <table class="mesa" id="resourceTable">
                    <thead class="mesa-head">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="tname"><strong>Item</strong></th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price per item (PHP)</th>
                        <th scope="col">Total Amount</th>
                        <!--                            <th scope="col">Notes</th>-->
                        <th scope="col" class="table-action-col">Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </section>

        <!-- People -->
        <section id="projectPeople" class="main-content custom-tab-content">

            <?php if ($data['accountType'] == Core\Controller::ADMIN) { ?>
                <div class="linear">
                    <form class="input-container">
                        <input type="text" id="employeeSearch" name="search" list="employeesList"
                               placeholder="Enter email address of employee" required>
                        <datalist id="employeesList"></datalist>
                        <div class="input-append">
                            <button type="submit" class="btn action-btn px-4 sm-btn">Choose from team</button>
                        </div>
                    </form>
                    or
                    <a href="<?= SITE_URL . '/project/invitation/' . $data['project']['id'] ?>" class="flex-shrink-0">
                        <button class="btn action-btn sm-btn">Invite people</button>
                    </a>
                </div>
            <?php } ?>

            <!-- People Table -->
            <div class="mesa-container">
                <table class="mesa mesa-hover" id="peopleTable">
                    <thead class="mesa-head">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="tname"><strong>Name</strong></th>
                        <th scope="col">Email</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </section>

        <!-- Payment -->
        <section id="projectPayment" class="main-content custom-tab-content">

            <?php if ($data['accountType'] == Core\Controller::ADMIN) { ?>
                <button id="addPayment" type="button" class="btn action-btn sm-btn float-right">
                    <i class="fa fa-plus btn-icon" aria-hidden="true"></i>
                    Add payment
                </button>
            <?php } ?>

            <!-- Payment Table -->
            <div class="mesa-container">
                <table class="mesa mesa-hover" id="paymentTable">
                    <thead class="mesa-head">
                    <tr>
                        <th></th>
                        <th scope="col" class="tname"><strong>Description</strong></th>
                        <th scope="col">Payment</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </section>

    </div>
</main>

<div class="popup popup-center" id="popupContainer"></div>

<!--POPUP INVITE PEOPLE-->
<!--<div class="popup popup-center" id="InvitePeople" tabindex="-1" aria-hidden="true">-->
<!--    <div class="pcontainer">-->
<!--        <div class="pcontent">-->
<!--            <div class="pheader">-->
<!--                <i class="fa-solid fa-envelope-open-text"></i>-->
<!--                <h2 class="ptitle">Invite People</h2>-->
<!--                <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!---->
<!--            <div class="pbody">-->
<!--                <div class="form-group">-->
<!--                    <label for="">Name</label>-->
<!--                    <input type="text" class="form-control" name="" id="" placeholder="Type the name here">-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label for="">Email / Phone</label>-->
<!--                        <div class="input-container">-->
<!--                            <input type="text" placeholder="Enter an email address or phone number.">-->
<!--                            <div class="input-append">  -->
<!--                                <button type="button" class="btn action-btn slim-btn">-->
<!--                                    <i class="fa-solid fa-plus"></i>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>                     -->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    -->
<!--                    <label for="">Selected Person</label>-->
<!--                    -->
<!--                        <div class="selected">-->
<!--                            <p>Add a person to the list</p>-->
<!--                        </div> -->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="pfooter">-->
<!--                <button type="button" class="btn action-btn">Send Invitation</button>-->
<!--                <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!-- Payment -->
<div class="popup" id="paymentPopup" tabindex="-1" aria-hidden="true">
    <div class="pcontainer">
        <div class="pcontent">
            <div class="pheader">
                <h2 class="ptitle">Add Payment</h2>
                <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <div class="linear-container pbody">

                <!-- Alert -->
                <div class="alert alert-danger mb-0" role="alert"></div>

                <!-- Content -->
                <form id="paymentForm">
                    <input type="hidden" name="id">

                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" class="form-control" name="date">
                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <input type="text" class="form-control" name="description">
                    </div>

                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="number" class="form-control" name="amount" min=0
                               oninput="validity.valid||(value='');">
                    </div>

                </form>
            </div>

            <div class="pfooter">
                <button type="submit" form="paymentForm" class="btn action-btn">Create</button>
                <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    let projectId = '<?= $data['project']['id'] ?>';
</script>