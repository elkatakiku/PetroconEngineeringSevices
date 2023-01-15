<main class="content">
    <!-- <pre>
        <?php var_dump($data) ?>
    </pre> -->
    <!-- Header -->
    <div class="page-header">
        <div class="project-info">
            <div>
                <h1 class="page-title"><?= $data['project']['description'] ?></h1>
                <small><?= $data['project']['location'] ?></small>
            </div>
        </div>
        <button id="projectInfoToggller" type="button" class="btn icon-btn align-self-start" data-toggle="slide" data-target="#projectInfo">
            <span class="material-icons-outlined">info</span>
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

                    <input type="hidden" name="id" value="<?= $data['project']['id'] ?>">

                    <h3 class="detail-header">Project</h3>

                    <div class="linear">
        
                        <div class="form-input-group">
                            <label for="">Purchase Order #</label>
                            <input type="text" name="purchaseOrd" value="<?= $data['project']['purchase_ord'] ?>" readonly>
                        </div>
        
                        <div class="form-input-group">
                            <label for="">Date of Award</label>
                            <input type="date" name="awardDate" value="<?= $data['project']['award_date'] ?>" readonly>
                        </div>

                    </div>

                    <div class="form-input-group">
                        <label for="">Work Description</label>
                        <textarea name="description" rows="1" readonly><?= $data['project']['description'] ?></textarea>
                    </div>

                    <div class="form-input-group">
                        <label for="">Building no.</label>
                        <input type="text" name="buildingNo" value="<?= $data['project']['building_number'] ?>" readonly>
                    </div>

                    <div class="form-input-group">
                        <label for="">Location</label>
                        <input type="text" name="location" value="<?= $data['project']['location'] ?>" readonly>
                    </div>         
                    

                    <h3 class="detail-header">Client</h3>

                    <div class="form-input-group">
                        <label for="">Company</label>
                        <input type="text" name="company" value="<?= $data['project']['company'] ?>" readonly>
                    </div>

                    <div class="form-input-group">
                        <label for="">Representative</label>
                        <input type="text" name="representative" value="<?= $data['project']['comp_representative'] ?>" readonly>
                    </div>

                    <div class="form-input-group">
                        <label for="">Contact</label>
                        <input type="tel" name="contact" value="<?= $data['project']['comp_contact'] ?>" readonly>
                    </div>



                </form>
            </div>

            <div class="slide-footer">
                <button class="btn sm-btn <?= $data['project']['done'] == 1 ? 'outline-action' : 'success' ?>-btn done-btn" data-toggle="popup" data-target="#markDone">
                    <?= $data['project']['done'] == 1 ? 'Unmark as done' : 'Mark as done' ?>
                </button>
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
                <button class="link-btn" data-toggle="custom-tab" data-target="#projectResources">Resources</button>
            </li>
            <li class="nav-tab-item">
                <button class="link-btn" data-toggle="custom-tab" data-target="#projectPeople">People</button>
            </li>
            <li class="nav-tab-item">
                <button class="link-btn" data-toggle="custom-tab" data-target="#projectPayment">Payment</button>
            </li>
        </ul>

    <?php
    if ($data['project']['done'] == 1) { ?>
            <!-- <div>
                <a class="btn action-btn" data-toggle="custom-tab" href="invoice-admin.html">Invoice</a>
                <a class="btn action-btn" data-toggle="custom-tab" href="turnover-admin.html">Turn Over</a> 
            </div> -->
        <div class="projectDone">
            <a class="btn sm-btn action-btn" href="invoice-admin.html">Invoice</a>
            <a class="btn sm-btn action-btn" href="turnover-admin.html">Turn Over</a>
        </div>

        <div class="projectDone dropdown">
            <button class="btn sm-btn action-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                Print
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="invoice-admin.html">Invoice</a>
                <a class="dropdown-item" href="turnover-admin.html">Turn Over</a>
            </div>
        </div>
    <?php } ?>  
    </nav>

    <div class="custom-tab-container">

        <style>
            .timeline {
                display: grid;
                grid-auto-rows: auto 1fr;
                /* gap: 10px; */
                margin-left: -100%;
                width: 100%;
                /* overflow-y: auto; */
            }

            .chart-container {  
                visibility: hidden;
                width: 100%;
                overflow: hidden;
            }

            #tasksTable thead {
                position: sticky;
                top: 0;
            }

            td .form-input-group {
                margin: 0;
            }

            .timeline header, .timeline footer {
                padding: 1rem 20px;
            }

            #projectGanttChart .spinner {
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                color: var(--palette1);
                position: absolute;
                top: 0;
                left: 0;
            }

            .main-content header h5 {
                font-size: 1rem;
            }
        </style>

        <!-- Gantt Chart -->
        <section id="projectGanttChart" class="main-content custom-tab-content show">
            <div class="slider">
                <div class="timeline">
                    <header class="linear">
                        <!-- <h5>Tasks</h5> -->
                        
                        <button id="addTask" data-target="#newTask" type="button" class="btn action-btn sm-btn">
                            <i class="fa fa-plus btn-icon" aria-hidden="true"></i>
                            Add a task
                        </button>

                        <button class="btn icon-btn ml-auto back-btn" type="button">
                            <span class="material-icons">navigate_before</span>
                        </button>
                    </header>

                    <div class="mesa-container" id="timelineTable">
                        <table class="mesa" id="tasksTable">
                            <thead class="mesa-head">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col" class="taskCell">Task</th>
                                    <th scope="col">Plan Start</th>
                                    <th scope="col">Plan Due</th>
                                    <th scope="col" class="action-cell">
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <!-- <div class="mesa-container">
                        <table class="mesa" id="tasksTable">
                            <thead class="mesa-head">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col" class="taskCell">Task</th>
                                    <th scope="col">Activities</th>
                                    <th scope="col" class="action-cell">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="col"></th>
                                <td scope="col" class="taskCell">Task</td>
                                <td scope="col">
                                    <div class="linear">
                                        <span style="width: 100px; height: 50px; background-color: red;">
                                        </span>
                                    </div>
                                </td>
                                <td scope="col" class="action-cell"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                </div>

                <div class="chart-container active">
                    <div class="gantt-chart">
                        <div class="chart">
                            <div class="chart-row chart-header">
                                <div class="chart-row-item" id="timelineToggler">
                                    <button type="button" class="btn icon-btn">
                                        <span class="material-icons">edit_note</span>
                                    </button>
                                    Tasks
                                </div>
                                <div>
                                    <div class="chart-months">
                                        <!-- <span class="startMonth">December</span> -->
                                        <span class="chart-month"><?= date('F') ?></span>
                                    </div>
                                    <div class="chart-days">
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <!-- <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span>
                                        <span>##</span> -->
                                    </div>
                                </div>
                            </div>

                            <div class="chart-body">
                                <div class="chart-lines"> 
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <!-- <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span> -->
                                </div>

                                <!-- <div class="chart-row">
                                    <div class="chart-row-item">
                                        <strong>1</strong>
                                        Procurement
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-one"></li>
                                    </ul>
                                </div>

                                <div class="chart-row">
                                    <div class="chart-row-item">
                                        <strong>2</strong>
                                        Tool Box Meeting
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-two-a"></li>
                                        <li class="actual chart-li-two-b"></li>          
                                    </ul>
                                </div>

                                <div class="chart-row">
                                    <div class="chart-row-item">
                                        <strong>3</strong>
                                        Actual visit at site for measurement
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-three"></li>
                                    </ul>
                                </div>

                                <div class="chart-row">
                                    <div class="chart-row-item">
                                        <strong>4</strong>
                                        Mobilization
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-four"></li>
                                    </ul>
                                </div>

                                <div class="chart-row">
                                    <div class="chart-row-item">
                                        <strong>5</strong>
                                        Repainting of pipe
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-five"></li>
                                    </ul>
                                </div>

                                <div class="chart-row">
                                    <div class="chart-row-item">
                                        <strong>6</strong>
                                        Relocation of 2" Distribution line from Handyman's area (removal and Reinstall with 55 meter located at Upper ground)
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-six"></li>
                                    </ul>
                                </div>
                                
                                <div class="chart-row">
                                    <div class="chart-row-item">
                                        <strong>7</strong>
                                        Modification of 2" B.I. pipe (step-up for x 600mm 10meter long) due to modification of wall from concrete to glass wall at Second floor.
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-seven-t1"></li>
                                    </ul>

                                    <div class="chart-row-item">
                                        <strong></strong>
                                        Modification of 2" Distribution pipe line second floor due to aircon   ducting conflict with 15 meter long.
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-seven-t2"></li>
                                    </ul>
                                </div>

                                <div class="chart-row">
                                    <div class="chart-row-item">
                                        <strong>8</strong>
                                        Additional stub-out for 6 tenants and additional pipe line for 12- tenats  from existing stub-outs to meter location inside the tenant area.
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-8-t1"></li>
                                    </ul>

                                    <div class="chart-row-item">
                                        <strong></strong>
                                        Leak Test and commissioning  at 2F, UGF, LGF
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="plan chart-li-8-t2"></li>
                                    </ul>

                                    <div class="chart-row-item">
                                        <strong></strong>
                                        Additional 2-1/2"  LPG mainline and stubouts for Vikings, Tongyang and 3 tenants
                                    </div>
                                    <ul class="chart-row-bars">
                                        <li class="yellow-bar chart-li-8-t3"></li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    
                    <span class="expanding-btn">
                        <button class="btn action-btn icon-btn" data-toggle="popup" data-target="#viewLegends">
                            <span class="material-icons">legend_toggle</span>
                        </button>
                    </span>
                    
                    <!-- View Legends Popup -->
                    <div id="viewLegends" class="popup popup-contained" tabindex="-1" aria-hidden="true">
                        <div class="pcontainer popup-sm" data-right="15" data-bottom="35">
                            <div class="pcontent">
                                <div class="pheader">
                                    <h2 class="ptitle">Legends</h2>
                                    <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                                        <span class="material-icons">close</span>
                                    </button>
                                </div>
                    
                                <div class="pbody">
                                    <div class="legends-container">

                                        <!-- <div class="task-legend">
                                            <span class="leg-color" data-color="#026aa7"></span>
                                            <span class="leg-title">Plan</span>
                                            <button class="btn icon-btn leg-edit" data-toggle="legend" data-target="legendId">
                                                <span class="material-icons">edit</span>
                                            </button>
                                        </div>

                                        <div class="task-legend">
                                            <span class="leg-color" data-color="#5aac44"></span>
                                            <span class="leg-title">Actual</span>
                                            <button class="btn icon-btn leg-edit" data-toggle="legend" data-target="legendId">
                                                <span class="material-icons">edit</span>
                                            </button>
                                        </div>

                                        <div class="task-legend">
                                            <span class="leg-color" data-color="#f5dd29"></span>
                                            <span class="leg-title">Sample</span>
                                            <button class="btn icon-btn leg-edit" data-toggle="legend" data-target="legendID">
                                                <span class="material-icons">edit</span>
                                            </button>
                                        </div> -->

                                    </div>
                                    <button class="btn light-btn btn-block slim-btn" data-toggle="legend">
                                        <span class="material-icons btn-icon">label</span>
                                        Create legend
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="spinner">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Resources -->
        <section id="projectResources" class="main-content custom-tab-content">

            <!-- <div class="linear-container">
                <form action="" class="linear" id="itemForm">
                    <div class="form-group basis-12">
                        <label for="">Item name</label>
                        <input type="text" class="form-control" name="">
                    </div>

                    <div class="form-group basis-4">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" name="" min=0 oninput="validity.valid||(value='');">
                    </div>
                    
                    <div class="form-group basis-4 flex-shrink-0">
                        <label for="">Price per item (PHP)</label>
                        <input type="number" class="form-control" name="" min=0 oninput="validity.valid||(value='');">
                    </div>

                    <div class="form-group basis-4">
                        <label for="">Total Amount</label>
                        <input type="number" class="form-control" name="" readonly>
                    </div>

                    <div class="form-group basis-8">
                        <label for="">Note</label>
                        <textarea class="form-control"></textarea>
                    </div>

                    <button class="basis-2  btn block-btn action-btn">Add</button>
                </form>
            </div> -->

            <!-- <header class="linear"> -->
                <!-- <h5>Materials used</h5> -->
                <button id="addResource" type="button" class="btn action-btn sm-btn float-right">
                    <i class="fa fa-plus btn-icon" aria-hidden="true"></i>
                    Add material
                </button>
            <!-- </header> -->


            <!-- Resources Table -->
            <div class="mesa-container">
                <table class="mesa" id="resourceTable">
                    <thead class="mesa-head">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" class="tname"><strong>Item Name</strong></th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price per item (PHP)</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Notes</th>
                            <th scope="col" class="table-action-col"></th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td><strong>Patatas</strong></td>
                            <td>8</td>
                            <td>300</td>
                            <td>2,400</td>
                            <td>Mahal lods</td>
                            <td class="action-cell">
                                <div class="action-cell-content">
                                    <button class="dots-menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <span class="row-action-btns">
                                        <button class="btn icon-btn"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td><strong>Patatas</strong></td>
                            <td>8</td>
                            <td>300</td>
                            <td>2,400</td>
                            <td>Mahal lods</td>
                            <td class="action-cell">
                                <div class="action-cell-content">
                                    <button class="dots-menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <span class="row-action-btns">
                                        <button class="btn icon-btn"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td><strong>Patatas</strong></td>
                            <td>8</td>
                            <td>300</td>
                            <td>2,400</td>
                            <td>Mahal lods</td>
                            <td class="action-cell">
                                <div class="action-cell-content">
                                    <button class="dots-menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <span class="row-action-btns">
                                        <button class="btn icon-btn"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td><strong>Patatas</strong></td>
                            <td>8</td>
                            <td>300</td>
                            <td>2,400</td>
                            <td>Mahal lods</td>
                            <td class="action-cell">
                                <div class="action-cell-content">
                                    <button class="dots-menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <span class="row-action-btns">
                                        <button class="btn icon-btn"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">1</th>
                            <td><strong>Patatas</strong></td>
                            <td>8</td>
                            <td>300</td>
                            <td>2,400</td>
                            <td>Mahal lods</td>
                            <td class="action-cell">
                                <div class="action-cell-content">
                                    <button class="dots-menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <span class="row-action-btns">
                                        <button class="btn icon-btn"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody> -->
                </table>
            </div>
        </section>
        
        <!-- People -->
        <section id="projectPeople" class="main-content custom-tab-content">


            <div class="linear justify-content-end">
                <button class="btn outline-action-btn">Choose from team</button>
                or
                <a href="<?= SITE_URL.'/project/invitation/'.$data['project']['id'] ?>">
                    <button class="btn action-btn">Invite people</button>
                </a>
                <!-- <a href="<?= SITE_URL.'/project/invitation/'.$data['project']['id'] ?>">
                    <button class="btn btn-sm link-btn">
                        Pending invitations
                    </button>
                </a> -->
                <!-- <a class="" href="../admin/generateslip.html">
                    <button class="btn btn-sm action-btn" type="button" data-toggle="popup" aria-expanded="false">
                        Generate Slip
                    </button>
                </a> -->
                <!-- <div class="dropdown ml-auto"> -->
                    
                    <!-- <button class="btn btn-sm dropdown-toggle action-btn" type="button" data-toggle="dropdown" aria-expanded="false">
                        Add people
                    </button> -->

                    <!-- <div class="dropdown-menu dropdown-menu-lg-right"> -->
                        <!-- <button class="dropdown-item" type="button" data-toggle="popup" data-target="#InvitePeople" aria-expanded="false">
                        Invite
                        </button>
                        <button class="dropdown-item" type="button" data-toggle="popup" data-target="#ChooseFromTeam" aria-expanded="false">
                            Choose from team
                        </button>    -->
                    <!-- </div> -->
                <!-- </div> -->
            </div>
            <!-- <div class="linear"> -->
                <!-- <form action="" class=""> -->
                <!-- <div class="input-container">
                    <input type="text" placeholder="Enter an email address or number of a person you want to invite.">
                    <div class="input-append">
                        <button type="button" class="btn action-btn slim-btn">Invite person</button>
                    </div>
                </div>

                <span class="align-self-center">or</span>

                <button class="btn action-btn slim-btn  ">Choose from Team</button> -->
                <!-- </form> -->
            <!-- </div> -->

            <!-- People Table -->
            <div class="mesa-container">
                <table class="mesa" id="peopleTable">
                    <thead class="mesa-head">
                        <tr>
                            <th scope="col" class="tname"><strong>Name</strong></th>
                            <th scope="col">Email</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Priviledge</th>
                            <th scope="col" class="table-action-col"></th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <tr>
                            <td><strong>Eli Lamzon</strong></td>
                            <td>elilamzon@email.com</td>
                            <td>09xxxxxxxxx</td>
                            <td>Admin</td>
                            <td>Remove</td>
                        </tr>
                        <tr>

                            <td><strong>Effer Adaza</strong></td>
                            <td>EfferAdaza@email.com</td>
                            <td>09xxxxxxxxx</td>
                            <td>Admin</td>
                            <td>Remove</td>
                        </tr>
                        <tr>
                            <td><strong>Yva Magno</strong></td>
                            <td>YvaMagno@email.com</td>
                            <td>09xxxxxxxxx</td>
                            <td>Admin</td>
                            <td>Remove</td>
                        </tr>
                        <tr>
                            <td><strong>Gale Fernandez</strong></td>
                            <td>GaleFernandez@email.com</td>
                            <td>09xxxxxxxxx</td>
                            <td>Admin</td>
                            <td>Remove</td>
                        </tr>
                    </tbody> -->
                </table>
            </div>
        </section>

        <!-- Payment -->
        <section id="projectPayment" class="main-content custom-tab-content">

            <button id="addPayment" type="button" class="btn action-btn sm-btn float-right">
                <i class="fa fa-plus btn-icon" aria-hidden="true"></i>
                Add payment
            </button>

            <!-- Payment Table -->
            <div class="mesa-container">
                <table class="mesa" id="paymentTable">
                    <thead class="mesa-head">
                        <tr>
                            <th></th>
                            <th scope="col" class="tname"><strong>Description</strong></th>
                            <th scope="col">Payment</th>
                            <th scope="col">Date</th>
                            <th scope="col">
                                <!-- <div> -->
                                <!-- <div class="action-cell-content">
                                    <span class="row-action-btns">
                                        <button class="btn">
                                        <span class="material-icons">
                                                edit
                                            </span>
                                        </button>
                                        <button class="btn">
                                            <span class="material-icons">
                                                delete
                                            </span>
                                        </button>
                                    </span>
                                </div> -->
                            </th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <tr>
                            <td><strong>Tank Requalification Fire Protection System</strong><br>
                                <small>Phoenix</small>
                            </td>
                            <td>PHP 12,000</td>
                            <td>dd/mm/YYYY</td>
                            <td>Remove</td>
                        </tr>
                        <tr>
                            <td><strong>Centralized LPG Pipeline Installation</strong><br>
                                <small>Phoenix</small>
                            </td>
                            <td>PHP 12,000</td>
                            <td>dd/mm/YYYY</td>
                            <td>Remove</td>
                        </tr>
                        <tr>
                            <td><strong></strong><br>
                                <small>Phoenix</small>
                            </td>
                            <td>PHP 12,000</td>
                            <td>dd/mm/YYYY</td>
                            <td>Remove</td>
                        </tr>
                        <tr>
                            <td><strong></strong><br>
                                <small>Phoenix</small>
                            </td>
                            <td>PHP 12,000</td>
                            <td>dd/mm/YYYY</td>
                            <td>Remove</td>
                        </tr>
                        <tr>
                            <td><strong></strong><br>
                                <small>Phoenix</small>
                            </td>
                            <td>PHP 12,000</td>
                            <td>dd/mm/YYYY</td>
                            <td>Remove</td>
                        </tr>
                        <tr>
                            <td><strong></strong><br>
                                <small>Phoenix</small>
                            </td>
                            <td>PHP 12,000</td>
                            <td>dd/mm/YYYY</td>
                            <td>Remove</td>
                        </tr>
                    </tbody> -->
                </table>
            </div>
        </section>

    </div>

    <style>
        .toast-container {
            position: absolute;
            bottom: 0;
            right: 0;
            height: 100%;

            background-color: red;

            z-index: 2500;
        }

        .toast {
            opacity: 1;
        }
    </style>

    <!-- Toasts -->
    <!-- <div class="toast-container">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="..." class="rounded mr-2" alt="...">
                <strong class="mr-auto">Bootstrap</strong>
                <small class="text-muted">just now</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                See? Just like this.
            </div>
        </div>

        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="..." class="rounded mr-2" alt="...">
                <strong class="mr-auto">Bootstrap</strong>
                <small class="text-muted">2 seconds ago</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Heads up, toasts will stack automatically
            </div>
        </div>
    </div> -->
</main>

<style>
    #taskPopup .pcontent {
        flex-direction: row;
    }

    .pmain {
        flex-basis: 65%;
        padding: 1rem;

        background-color: #f4f4f4;
    }

    .pmain .pheader {
        border: none;
        padding: 0;
        margin-bottom: 1rem;
    }

    .pmain .pfooter {
        padding: 0;
        margin-top: 1rem;
        padding-top: 1rem;
    }

    .pmain .pheader .close-btn {
        top: 0;
        right: 0;
    }

    .pmain h5 {
        font-size: 14px;
        color: #172b4d;
    }

    .pmain textarea, .pmain input {
        padding: 5px 10px;
    }

    .pside {
        flex-basis: 35%;

        display: flex;
        flex-direction: column;

        box-shadow: -1px 0 10px rgba(0, 0, 0, 0.15);
        position: relative;
    }

    @media (max-width: 992px) {
        #taskPopup .pcontent {
            flex-direction: column;
        }

        #sideCollapse {
            height: 0;
        }

        .pmain {
            background-color: white;
        }
    }

    @media (min-width: 992px) {
        #activityCollapse {
            display: none;
        }

        #sideCollapse {
            height: 100%;
        }
    }
        
    #activityCollapse {
        position: absolute;
        top: -20px;
        left: 50%;
        z-index: 2005;
        transform: translateX(-50%);
        background: #ffffff;
        border-radius: 500px;
        padding: 5px;
        box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.15);
    }

    #sideCollapse {
        overflow: hidden;
    }
</style>

<!-- Task -->
<div class="popup" id="taskPopup" tabindex="-1" aria-hidden="true">
    <div class="pcontainer popup-lg">
        <div class="pcontent">
            <div class="pmain">

                <header class="pheader">
                    <h2 class="ptitle">Task 1</h2>
                    <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                        <span class="material-icons">close</span>
                    </button>
                </header>

                <!-- Alert -->
                <div class="alert alert-danger mb-0" role="alert">
                    A simple danger alert—check it out!
                </div>
                
                <form id="taskForm">
                    <input type="hidden" name="id" value="PTRCN-TSK-63b3fe4123497">
                    <input type="hidden" name="order" value="1">

                    <h5>Description</h5> 
                    <div class="form-input-group">
                        <textarea class="form-control" name="taskDesc" rows="1" placeholder="Type the task description here" style="min-height: 1rem; height: 34px; overflow-y: hidden;"></textarea>
                    </div>
                    
                    <h5>Activity</h5>

                    <!-- <div id="taskActivities">
                        <div class="form-input-group task-activity" id="PTRCN-TSKBR-63b3fe413440f" style="border-color: rgba(2, 106, 167, 0.4); box-shadow: rgba(2, 106, 167, 0.4) 0px 1px 5px;"><span class="linear-label"><label for="" style="color: rgb(2, 82, 129);">Plan</label><button type="button" class="icon-btn close-btn" data-dismiss="activity" aria-label="Close">
                            <span class="material-icons">
                            close

                        </span>
                    </button>
                    </span>
                        <input type="hidden" name="legendId" value="PTRCN-LGND-63b3fe007bff8" style="border-bottom-color: rgb(2, 82, 129);">
                        <div class="tb-date">
                            <input type="date" name="start" value="2023-01-03" style="border-bottom-color: rgb(2, 82, 129);">
                        -
                        <input type="date" name="end" value="2023-01-06" style="border-bottom-color: rgb(2, 82, 129);">
                    </div>
                    </div>
                    </div> -->

                    <div id="taskActivities">
                        <!-- <div class="form-input-group task-activity" id="PTRCN-TSKBR-63b3fe413440f" style="border-color: rgba(2, 106, 167, 0.4); box-shadow: rgba(2, 106, 167, 0.4) 0px 1px 5px;">
                            <span class="linear-label">
                                <label for="" style="color: rgb(2, 82, 129);">Plan</label>
                                <button type="button" class="icon-btn close-btn" data-dismiss="activity" aria-label="Close">
                                    <span class="material-icons"> close </span>
                                </button>
                            </span>
                            <input type="hidden" name="legendId" value="PTRCN-LGND-63b3fe007bff8" style="border-bottom-color: rgb(2, 82, 129);">
                            <div class="tb-date">
                                <input type="date" name="start" value="2023-01-03" style="border-bottom-color: rgb(2, 82, 129);"> - <input type="date" name="end" value="2023-01-06" style="border-bottom-color: rgb(2, 82, 129);">
                            </div>
                        </div> -->
                    </div>

                    <div id="newActivities"></div>

                    <div id="samp"></div>
                </form>

                <!-- <div class="form-input-group task-activity">
                    <span class="linear-label">
                        <label for="">Plan</label>
                        <button type="button" class="icon-btn close-btn" data-dismiss="activity" aria-label="Close">
                            <span class="material-icons">close</span>
                        </button>
                    </span>
                    <div class="tb-date">
                        <input type="date" name="planStart" id="" value="2023-01-07">
                        -
                        <input type="date" name="planEnd" id="" value="2023-01-07">
                    </div>
                </div>

                <div class="form-input-group task-activity">
                    <label for="">Actual</label>
                    <div class="tb-date">
                        <input type="date" name="" id="">
                        -
                        <input type="date" name="" id="">
                    </div>
                </div> -->
            </div>

            <div class="pside">
                <button class="btn icon-btn" id="activityCollapse" data-target="#sideCollapse">
                    <span class="material-icons" title="Add activity">
                        keyboard_double_arrow_up
                    </span>
                </button>

                <div id="sideCollapse">
                    <div class="pheader">
                        <h2 class="ptitle">Activities</h2>
                        <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                            <span class="material-icons">close</span>
                        </button>
                    </div>

                    <div class="pbody">
                        <i class="fa fa-search" aria-hidden="true"></i>

                        <div id="legends" class="legends-container"><div class="task-legend"><span class="leg-color" data-color="#026aa7" style="background-color: rgb(2, 106, 167);"></span><span class="leg-title" style="background-color: rgb(2, 106, 167);">Plan</span><button class="btn icon-btn leg-edit" data-toggle="legend" data-target="PTRCN-LGND-63b3fe007bff8"><span class="material-icons">edit</span></button></div><div class="task-legend"><span class="leg-color" data-color="#5aac44" style="background-color: rgb(90, 172, 68);"></span><span class="leg-title" style="background-color: rgb(90, 172, 68);">Actual</span><button class="btn icon-btn leg-edit" data-toggle="legend" data-target="PTRCN-LGND-63b3fe007bffc"><span class="material-icons">edit</span></button></div><div class="task-legend"><span class="leg-color" data-color="#ff8ed4" style="background-color: rgb(255, 142, 212);"></span><span class="leg-title" style="background-color: rgb(255, 142, 212);">Penk</span><button class="btn icon-btn leg-edit" data-toggle="legend" data-target="PTRCN-LGND-63b7a3a59a0f9"><span class="material-icons">edit</span></button></div></div>

                        <button class="btn light-btn btn-block slim-btn" data-toggle="legend">
                            Create legend
                        </button>
                    </div>

                </div>

                <div class="pfooter">
                    <button type="submit" form="taskForm" class="btn action-btn">Save</button>
                    <button type="button" class="btn danger-btn delete-btn">
                        Delete
                    </button>
                    <button type="button" class="btn neutral-outline-btn" data-dismiss="popup">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mark as done -->
<div class="popup popup-center popup-prompt" id="markDone" tabindex="-1" aria-hidden="true">
    <div class="pcontainer popup-sucess popup-sm">
        <div class="pcontent">
            <div class="pheader">
                <h2 class="ptitle"><?= $data['project']['done'] == 1 ? 'Unmark as done' : 'Mark as done' ?></h2>
                <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <div class="pbody">
                <form id="doneForm" action="<?= SITE_URL ?>/project/mark" method="POST">
                    <input type="hidden" name="id" value="<?= $data['project']['id'] ?>">
                    <input type="hidden" name="done" value="<?= $data['project']['done'] == 0 ? 1 : 0 ?>">
                </form>
                <?= $data['project']['done'] == 1 ? 'Unmark' : 'Mark' ?> this project done?
            </div>

            <div class="pfooter">
                <button type="submit" name="doneSubmit" form="doneForm" class="btn success-btn">Confirm</button>
                <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Resource -->
<div class="popup" id="resourcePopup" tabindex="-1" aria-hidden="true">
    <div class="pcontainer">
        <div class="pcontent">
            <div class="pheader">
                <h2 class="ptitle">Add Material</h2>
                <button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">
                    <span class="material-icons">close</span>
                </button>
            </div>

            <div class="linear-container pbody">

                <!-- Alert -->
                <div class="alert alert-danger mb-0" role="alert"></div>

                <!-- Content -->
                <form action="" class="linear" id="itemForm">
                    <div class="form-group basis-12">
                        <label for="">Item name</label>
                        <input type="text" class="form-control" name="item">
                    </div>

                    <div class="form-group basis-4">
                        <label for="">Price per item (PHP)</label>
                        <input type="number" class="form-control" name="price" step="any" min=0 oninput="validity.valid||(value='');">
                    </div>
                    
                    <div class="form-group basis-4">
                        <label for="">Quantity</label>
                        <input type="number" class="form-control" name="quantity" min=0 oninput="validity.valid||(value='');">
                    </div>

                    <div class="form-group basis-4">
                        <label for="">Total Amount</label>
                        <input type="number" class="form-control" name="total" readonly min=0 oninput="validity.valid||(value='');">
                    </div>

                    <div class="form-group">
                        <label for="">Note</label>
                        <textarea class="form-control" name="notes" rows="1"></textarea>
                    </div>

                    <input type="hidden" name="id">
                    <input type="hidden" name="projId" value="<?= $data['project']['id'] ?>">
                </form>
            </div>

            <div class="pfooter">
                <button type="submit" form="itemForm" class="btn action-btn">Save</button>
                <button type="button" class="btn danger-btn delete-btn">
                    Delete
                </button>
                <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!--POPUP INVITE PEOPLE-->
<div class="popup popup-center" id="InvitePeople" tabindex="-1" aria-hidden="true">
    <div class="pcontainer">
        <div class="pcontent">
            <div class="pheader">
                <i class="fa-solid fa-envelope-open-text"></i>
                <h2 class="ptitle">Invite People</h2>
                <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="pbody">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="" id="" placeholder="Type the name here">
                </div>
                <div class="form-group">
                    <label for="">Email / Phone</label>
                        <div class="input-container">
                            <input type="text" placeholder="Enter an email address or phone number.">
                            <div class="input-append">  
                                <button type="button" class="btn action-btn slim-btn">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>                     
                </div>
                <div class="form-group">
                    
                    <label for="">Selected Person</label>
                    
                        <div class="selected">
                            <p>Add a person to the list</p>
                        </div> 
                </div>
            </div>

            <div class="pfooter">
                <button type="button" class="btn action-btn">Send Invitation</button>
                <button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!--PENDING INVI-->
<div class="popup popup-center" id="Pending" tabindex="-1" aria-hidden="true">
    <div class="pcontainer">
        <div class="pcontent">
            <div class="pheader">
                <h2 class="ptitle">Pending Invitation</h2>
                <button type="button" class="close-btn" data-dismiss="popup" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="pbody">
                <div class="form-group"> 
                    <label for="">Invitations</label>
                    <div class="selected" style="overflow: auto;max-height: 250px;">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th scope="row"></th>
                                    <td>vana</td>
                                    <td>09152934627</td>
                                    <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                                </tr>
                                
                                <tr>
                                    <th scope="row"></th>
                                    <td>vana</td>
                                    <td>09152934627</td>
                                    <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                                </tr>
                                
                                <tr>
                                    <th scope="row"></th>
                                    <td>vana</td>
                                    <td>09152934627</td>
                                    <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                                </tr>
                                
                                <tr>
                                <th scope="row"></th>
                                <td>vana</td>
                                <td>09152934627</td>
                                <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                                </tr>
                                
                                <tr>
                                <th scope="row"></th>
                                <td>effer</td>
                                <td>09152934627</td>
                                <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                                </tr>
                                
                                <tr>
                                <th scope="row"></th>
                                <td>elkatakiki</td>
                                <td>elimarimae@emailcom</td>
                                <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                                </tr>
                                
                                <tr>
                                <th scope="row"></th>
                                <td>kath</td>
                                <td>09152934627</td>
                                <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="pfooter">
                <button type="button" class="btn action-btn" data-dismiss="popup">Okay</button>
            </div>
        </div>
    </div>
</div>

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
                        <input type="number" class="form-control" name="amount" min=0 oninput="validity.valid||(value='');">
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