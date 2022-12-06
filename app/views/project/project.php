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

    <style>
        .gantt-chart {  
            /* max-width: 1200px;  */
            min-width: 650px;  
            margin: 0 auto; 
            padding: 50px;
        }
        .gantt-chart .chart { 
            display: grid;  
            border: 2px solid #000;  
            position: relative;  
            overflow: hidden; 
        } 
        .gantt-chart .chart-row {  
            display: grid; 
            grid-template-columns: 50px 1fr; 
            background-color: #DCDCDC;
        }

        .gantt-chart .chart-period { 
            color:  #fff;  
            background-color:  #708090 !important;  
            border-bottom: 2px solid #000;  
            grid-template-columns: 50px repeat(12, 1fr);
        }

        .gantt-chart .chart-period > span {
            text-align: center;  
            font-size: 13px;  
            align-self: center;  
            font-weight: bold;  
            padding: 15px 0;   
        }

        .gantt-chart .chart-lines { 
            position: absolute;  
            height: 100%;  
            width: 100%;  
            background-color: transparent;  
            grid-template-columns: 50px repeat(12, 1fr);}

        .gantt-chart .chart-lines > span {  
            display: block;  border-right: 1px solid rgba(0, 0, 0, 0.3);
        }

        .gantt-chart .chart-row-item { 
            background-color: #808080;  
            border: 1px solid #000;  
            border-top: 0;  border-left: 0;  
            padding: 20px 0;  font-size: 15px;  
            font-weight: bold;  
            text-align: center;
        }

        .gantt-chart .chart-row-bars { 
            list-style: none; 
            display: grid;  padding: 15px 0;  
            margin: 0;  
            grid-template-columns: repeat(12, 1fr); 
            grid-gap: 10px 0;  
            border-bottom: 1px solid #000;
        }
        .gantt-chart li {  
            font-weight: 450;  
            text-align: left;  
            font-size: 15px;  min-height: 15px;  
            background-color: #708090;  
            padding: 5px 15px;  color: #fff;  
            overflow: hidden;  
            position: relative;  
            cursor: pointer;  
            border-radius: 15px;
        } 
        
        .gantt-chart ul .chart-li-one { 
            grid-column: 1/2;  
            background-color: #588BAE;
        }

        ul .chart-li-two-b {
            grid-column: 2/4; 
            background-color:#4682B4;
        } 
        ul .chart-li-three {
            grid-column: 3/5; 
            background-color:#57A0D3;
        }
        ul .chart-li-four {
            grid-column: 3/9; 
            background-color:#0E4D92;
        }
        ul .chart-li-five {
            grid-column: 7/10; 
            background-color:#4F97A3;
        }
        ul .chart-li-six {
            grid-column: 10/12; 
            background-color:#73C2FB;
        }
        ul .chart-li-seven {
            grid-column: 12/12; 
            background-color:#0080FF;
        }

    </style>

    <div class="slide-container">
        <div class="custom-tab-container">
            <!-- Timeline Slide -->
            <div class="slide" id="timelineSlide" data-side="left">
                <div class="slide-content">
                    <div class="mesa-container">
                    <table class="mesa">
                        <thead class="mesa-header">
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

            <!-- Gantt Chart -->
            <div id="projectGanttChart" class="custom-tab-content show gantt-chart">
                <div class="chart">
                    <div class="chart-row chart-period">
                        <div class="chart-row-item"></div>
                        <span>January</span>
                        <span>February</span>
                        <span>March</span>
                        <span>April</span>
                        <span>May</span>
                        <span>June</span>
                        <span>July</span>
                        <span>August</span>
                        <span>September</span>
                        <span>October</span>
                        <span>November</span>
                        <span>December</span>
                    </div>

                    <div class="chart-row chart-lines"> 
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
                        <div class="chart-row-item">1</div>
                        <ul class="chart-row-bars">
                            <li class="chart-li-one">Planning</li>
                        </ul>
                    </div>
                    <div class="chart-row">
                        <div class="chart-row-item">2</div>
                        <ul class="chart-row-bars">
                            <li class="chart-li-two-a">Meeting</li>
                            <li class="chart-li-two-b">Analysis</li>          
                        </ul>
                    </div>
                    <div class="chart-row">
                        <div class="chart-row-item">3</div>
                        <ul class="chart-row-bars">
                            <li class="chart-li-three">Design</li>
                        </ul>
                    </div>
                    <div class="chart-row">
                        <div class="chart-row-item">4</div>
                        <ul class="chart-row-bars">
                            <li class="chart-li-four">Development</li>
                        </ul>
                    </div>
                    <div class="chart-row">
                        <div class="chart-row-item">5</div>
                        <ul class="chart-row-bars">
                            <li class="chart-li-five">Testing</li>
                        </ul>
                    </div>
                    <div class="chart-row">
                        <div class="chart-row-item">6</div>
                        <ul class="chart-row-bars">
                            <li class="chart-li-six">Maintenance</li>
                        </ul>
                    </div>
                    <div class="chart-row">
                        <div class="chart-row-item">7</div>
                        <ul class="chart-row-bars">
                            <li class="chart-li-seven">Meeting</li>
                        </ul>
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