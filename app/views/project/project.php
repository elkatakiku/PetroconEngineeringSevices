<main class="content">
    <!-- Header -->
    <div class="page-header">
        <div class="project-info">
            <div>
                <h1 class="page-title">Installation of extension of main LPG pipeline and additional food tenant at LGF and Relocation of main pipeline at UGF and extension of stub outs at 2F and UGF.</h1>
                <small>Robinson Palace, Antipolo City</small>
            </div>
        </div>
        <button type="button" class="btn icon-btn align-self-start" data-toggle="slide" data-target="#projectInfo">
        <span class="material-icons-outlined">info</span>
        </button>
    </div>

    <!-- Project Info -->
    <div class="slide slide-fixed" id="projectInfo" data-side="right">
        <div class="slide-content">
            <div class="slide-header">
                <button class="btn icon-btn" data-dismiss="slide">
                    <span class="material-icons">navigate_next</span>
                </button>
                <h2 class="slide-title">Details</h2>
                <div>
                    <button class="btn link-btn show" data-toggle="form" data-action="edit" data-target="#projectDetailForm">
                        Edit
                    </button>
                    <button class="btn link-btn" type="submit" form="#projectDetailForm" data-toggle="form" data-action="submit" id="projectDetailSubmit" data-target="#projectDetailForm">
                        Done
                    </button>
                </div>
            </div>

            <div class="slide-body">
                <form action="" id="projectDetailForm">

                <h3 class="detail-header">General</h3>

                <div class="form-input-group display">
                    <label for="">Name of Client</label>
                    <p>Yvana Eunice Magno</p>
                    <input type="text" value="Yvana Eunice Magno" autofocus>
                </div>

                <div class="form-input-group display">
                    <label for="">Building no.</label>
                    <p>Building 1, 2, 3</p>
                    <input type="text" value="Building 1, 2, 3">
                </div>

                <div class="form-input-group display">
                    <label for="">Work Description</label>
                    <p>Conduct preventive maintenance for Gasline from Manifold to distribution line up to burnes equipment.</p>
                    <textarea name="" id="">Conduct preventive maintenance for Gasline from Manifold to distribution line up to burnes equipment.</textarea>
                </div>

                <h3 class="detail-header">Project</h3>

                <div class="linear">
                
                    <div class="form-input-group display">
                        <label for="">Purchase Order #</label>
                        <p>20221526</p>
                        <input type="number" value="20221526">
                    </div>

                    <div class="form-input-group display">
                        <label for="">Date of Award</label>
                        <p>11/26/2022</p>
                        <input type="date" value="11/26/2022">
                    </div>
                    
                </div>

                <div class="form-input-group display">
                    <label for="">Location</label>
                    <p>Rosario, Batangas</p>
                    <input type="text" value="Rosario, Batangas">
                </div>

                </form>
            </div>

            <div class="slide-footer">
                footer
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
        </ul>

        <div>
            <button class="btn action-btn">Invoice</button>
            <button class="btn action-btn">Turn Over</button>
        </div>

    </nav>

    <div class="slide-container">
        <div class="custom-tab-container">
            <!-- Timeline Slide -->
            <div class="slide" id="timelineSlide" data-side="left">
                <div class="slide-content">
                    <div class="mesa-container">
                    <table class="mesa">
                        <thead class="mesa-header">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="taskCell">Task</th>
                                <th scope="col">Start</th>
                                <th scope="col">Due</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="action-cell">
                                    <button class="btn icon-btn" data-dismiss="slide">
                                    <span class="material-icons">navigate_before</span>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td class="taskCell">Procurement</td>
                                <td>dd/mm/YYYY</td>
                                <td>dd/mm/YYYY</td>
                                <td>Done</td>
                                <td class="action-cell">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                </td>
                            </tr>
                    
                            <tr>
                                <th scope="row">2</th>
                                <td class="taskCell">Tool Box Meeting</td>
                                <td>dd/mm/YYYY</td>
                                <td>dd/mm/YYYY</td>
                                <td>Done</td>
                                <td class="action-cell">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                </td>
                            </tr>
                    
                            <tr>
                                <th scope="row">3</th>
                                <td class="taskCell">Actual visit at site for measurementActual visit at site for measurementActual visit at site for measurementActual visit at site for measurement</td>
                                <td>dd/mm/YYYY</td>
                                <td>dd/mm/YYYY</td>
                                <td>Done</td>
                                <td class="action-cell">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            <style>

                .chart-container {
                    display: grid;
                    padding: 0 !important;
                }

                .gantt-chart {  
                    position: relative;
                    overflow: auto;
                }

                .gantt-chart .chart { 
                    display: grid;  

                }

                :root {
                    --chart-row-head: 250px;
                    --chart-grid-width: 30px;
                    --week-days: 7;
                    --chart-header-bg: var(--palette1);
                }

                .chart-header {
                    background-color:  var(--chart-header-bg) !important;
                    color:  white;
                }

                .chart-body {
                    position: relative;
                    background-color: white;
                }

                .gantt-chart .chart-row {  
                    display: grid; 
                    grid-template-columns: var(--chart-row-head) 1fr; 
                    /* background-color: #DCDCDC; */
                }

                /* .chart-row:nth-child(even) {
                    background-color: #EEF4ED !important;
                } */

                /* Grid width */
                .chart-lines {
                    display: grid;
                    grid-template-columns: var(--chart-row-head) repeat(50, 1fr) !important;
                }

                .chart-months, .chart-days,
                .gantt-chart .chart-row-bars { 
                    display: grid;
                    grid-template-columns: repeat(50, minmax(var(--chart-grid-width), 1fr)); 
                }

                /* Grid Components */
                #timelineToggler {
                    padding: 0;
                    background-color:  var(--chart-header-bg);
                    border-right: none;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    color: white;
                    font-size: 1rem;
                    text-align: center;
                    position: relative;
                }

                #timelineToggler .btn {
                    position: absolute;
                    left: 10px;
                    height: 100%;
                    color: white;
                }

                #timelineToggler .btn .material-icons {
                    align-self: center;
                }

                .chart-months {
                    text-transform: uppercase;
                    font-weight: 500;
                    border-bottom: 1px solid white;
                }

                .startMonth, .month31, .month30 {
                    border-left: 1px solid white;
                    padding: 5px 0;
                }

                .startMonth {
                    grid-column: 1 / span 22;
                    justify-self: center;
                    align-self: stretch;
                    width: 100%;
                    text-align: center;
                }

                .month31 {
                    grid-column: 1 / span 31;
                }

                .month30 {
                    grid-column: 1 / span 30;
                }

                .gantt-chart .chart-days {
                    padding: 2px 0;
                    border-left: 1px solid white;
                }

                .gantt-chart .chart-days > span {
                    font-size: .75rem;  
                    display: block;
                    text-align: center;
                    align-self: center;  
                }

                .gantt-chart .chart-lines { 
                    display: grid; 
                    position: absolute;  
                    height: 100%;
                    width: 100%; 
                    background-color: transparent;
                }

                .gantt-chart .chart-lines > span {  
                    display: block;  
                    border-right: 1px solid rgba(13, 13, 13, 0.4);
                }

                .gantt-chart .chart-days > span, 
                .gantt-chart .chart-lines > span {
                    min-width: var(--chart-grid-width);
                }

                .gantt-chart .chart-lines > span:nth-child(3),
                .gantt-chart .chart-lines > span:nth-child(10),
                .gantt-chart .chart-lines > span:nth-child(17) {
                    background-color: rgb(255, 70, 70);
                    position: relative;
                    z-index: 50;
                }

                .gantt-chart .chart-row-item { 
                    align-self: stretch;
                    display: grid;
                    grid-template-columns: minmax(5px, auto) 1fr;
                    gap: 10px;
                    padding: 10px;
                    min-height: 20px;
                    background-color: white;
                    font-size: .75rem;
                    color: var(--primary-text);
                    border-right: 1px solid black;
                    border-bottom: 1px solid var(--border-rgba-color);

                    position: sticky;
                    left: 0;
                    z-index: 60;
                }

                .gantt-chart .chart-row-bars { 
                    list-style: none; 
                    padding: 10px 0;
                    margin: 0;  
                    grid-gap: 10px 0;
                    border-bottom: 1px solid var(--border-rgba-color);
                }
                
                .gantt-chart li {  
                    min-width: 30px;
                    min-height: 30px;
                    max-height: 30px;
                    cursor: pointer;
                    overflow: hidden;

                    position: relative;
                    z-index: 40;
                }
                
                .gantt-chart li.plan {
                    background-color: var(--palette1) !important;
                }

                .gantt-chart li.actual {
                    background-color: green !important;
                }
                
                .gantt-chart li.yellow-bar {
                    background-color: yellow !important;
                }

                

                /* .gantt-chart li.actual {
                    background-color: yellow !important;
                } */

                .gantt-chart ul .chart-li-one { 
                    grid-column: 1 / span 1;  
                    /* background-color: #588BAE; */
                }

                .chart-li-two-a {
                    grid-column: 1 / span 1;  
                }

                ul .chart-li-two-b {
                    grid-column: 1 / span 1;  
                    /* background-color:#4682B4; */
                } 

                ul .chart-li-three {
                    grid-column: 1 / span 1; 
                    /* background-color:#57A0D3; */
                }

                ul .chart-li-four {
                    grid-column: 3 / span 1; 
                    /* background-color:#0E4D92; */
                }

                ul .chart-li-five {
                    grid-column: 3 / span 4; 
                    /* background-color:#4F97A3; */
                }

                ul .chart-li-six {
                    grid-column: 3 / span 13; 
                    /* background-color:#73C2FB; */
                }

                ul .chart-li-seven-t1 {
                    grid-column: 3 / span 13; 
                }

                ul .chart-li-seven-t2 {
                    grid-column: 3 / span 9; 
                    /* background-color:#0080FF; */
                }

                .chart-li-8-t1 {
                    grid-column: 3 / span 13; 
                }

                .chart-li-8-t2 {
                    grid-column: 13 / span 3; 
                }

                .chart-li-8-t3 {
                    grid-column: 17 / span 3; 
                }
            </style>

             <!-- Gantt Chart -->
            <div id="projectGanttChart" class="custom-tab-content show chart-container">
                <div class="gantt-chart">                        
                    <div class="chart">
                        <div class="chart-row chart-header">
                            <div class="chart-row-item" id="timelineToggler">
                                <button type="button" class="btn icon-btn" data-toggle="slide" data-target="#timelineSlide">
                                    <span class="material-icons">edit_note</span>
                                </button>
                                Tasks
                            </div>
                            <div>
                                <div class="chart-months">
                                    <span class="startMonth">December</span>
                                    <!-- <span class="month30">January</span> -->
                                </div>
                                <div class="chart-days">
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
                                    <span>##</span>
                                    <span>##</span>
                                    <span>##</span>
                                    <span>##</span>
                                    <span>##</span>
                                </div>
                            </div>
                        </div>

                        <div class="chart-body">
                            <div class="chart-lines"> 
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
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="chart-row">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resources -->
            <div id="projectResources" class="custom-tab-content">

                <!-- Resources Table -->
                <div class="mesa-container">                
                    <table class="mesa">
                        <thead class="mesa-head">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="tname"><strong>Item Name</strong></th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price per item (PHP)</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Notes</th>
                                <th scope="col" class="table-action-col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td><strong>Patatas</strong></td>
                                <td>8</td>
                                <td>300</td>
                                <td>2,400</td>
                                <td>Mahal lods</td>
                                <td>
                                    <div>
                                        <i class="fa fa-trash" aria-hidden="true"></i>        
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
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
                                <td>
                                    <div>
                                        <i class="fa fa-trash" aria-hidden="true"></i>        
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
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
                                <td>
                                    <div>
                                        <i class="fa fa-trash" aria-hidden="true"></i>        
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
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
                                <td>
                                    <div>
                                        <i class="fa fa-trash" aria-hidden="true"></i>        
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
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
                                <td>
                                    <div>
                                        <i class="fa fa-trash" aria-hidden="true"></i>        
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn action-btn slim-btn align-self-start">
                    <i class="fa fa-plus btn-icon" aria-hidden="true"></i>
                    Add resource
                </button>
            </div>

            <!-- People -->
            <div id="projectPeople" class="custom-tab-content">
                <div class="linear">
                    <!-- <form action="" class=""> -->
                        <div class="input-container">
                        <input type="text" placeholder="Enter an email address or number of a person you want to invite.">
                        <div class="input-append">
                            <button type="button" class="btn action-btn slim-btn">Invite person</button>
                        </div>
                        </div>

                        <span class="align-self-center">or</span>

                        <button class="btn action-btn slim-btn  ">Choose from Team</button>
                    <!-- </form> -->
                </div>

                <!-- People Table -->
                <div class="mesa-container">
                    <table class="mesa">
                        <thead class="mesa-head">
                            <tr>
                                <th scope="col" class="tname"><strong>Name</strong></th>
                                <th scope="col">Email</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Priviledge</th>
                                <th scope="col" class="table-action-col"></th>
                            </tr>
                        </thead>
                        <tbody>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>