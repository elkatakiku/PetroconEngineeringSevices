<!doctype html>
<html lang="en">
  <head>
    <!-- Change the 'Page' to current page  -->
    <title>Petrocon</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- External CSS -->
    <link rel="stylesheet" href="<?=STYLES_PATH?>styles.css">
    <link rel="stylesheet" href="<?=STYLES_PATH?>popup.css">
    <link rel="stylesheet" href="<?=STYLES_PATH?>navbar.css">
    <link rel="stylesheet" href="<?=STYLES_PATH?>sidebar.css">
    <?php 
      if ($this->getType() == Core\Controller::CLIENT && isset($_SESSION['accID'])) {
        echo '<link rel="stylesheet" href="'.STYLES_PATH.'index.css">';
      }
    ?>
    <link rel="stylesheet" href="<?=STYLES_PATH.$view?>.css">    
  </head>

  <body class="body-wrapper" <?php 
        // Moodify if is client and logged in
        if ($this->getType() == Core\Controller::CLIENT) {
          echo 'data-spy="scroll" data-target="#topbar" data-offset="500"';
        }
      ?>
    >

  <?php
  // var_dump($this->getType());
  switch ($this->getType()) {

    case Core\Controller::AUTH: ?>
      <?php break;


    case Core\Controller::CLIENT: ?>
    
    <!-- Navbar -->
    <nav id="topbar" class="navbar fixed-top navbar-expand-lg navbar-<?= !isset($_SESSION['accID']) ? 'dark" data-user="home"' : 'light" data-user="client"' ?>">
      <a class="navbar-brand brand" href="#">
        <img src="<?=IMAGES_PATH?>petrocon-icon-2.png" class="d-inline-block align-top brand-icon" alt="Petrocon Logo">
        <span class="brand-name">Petrocon Engineering Services</span>
      </a>
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#header">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#whyUs">Services</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="#aboutUs">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#projects">Projects</a>
          </li>

          <?php if (!isset($_SESSION['accID'])) { ?>
            <li class="nav-item">
                <a class="nav-link" href="#contactUs">Contact</a>
              </li>
            <li class="nav-item">
              <a class="btn light-btn" href="#footer">Login</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= SITE_URL.US.'app/profile/'.$_SESSION['accID'] ?>">
                  <!-- <span id="user-display" class="material-icons">account_circle</span> -->
                  Profile
              </a>
            </li>
            <li class="nav-item">
              <a class="btn action-btn" href="<?= SITE_URL.US.'auth/logout' ?>">
                  Logout
              </a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </nav>

      <?php break;


    case Core\Controller::ADMIN: ?>
      
    <nav id="topbar"  class="navbar navbar-expand-md navbar-light">
      <button id="sidebarCollapseToggler" type="button" class="btn icon-btn">
          <span class="material-icons">menu</span>
      </button>
      <a class="flex-grow-1" href="<?= SITE_URL.US.'dashboard' ?>"><strong>Petrocon</strong><small> : Admin</small></a>
      <span class="material-icons">circle_notifications</span>
      <p class="user-name">Eli Lamzon</p>
      
      <span id="user-display" class="material-icons">account_circle</span>
    </nav>

    <div class="wrapper">
      <div id="sidebar">
        <nav>
          <ul class="list-unstyled components">
            <li class="">
              <a class="d-flex align-content-start" href="<?= SITE_URL.US.'dashboard' ?>">
                <span class="material-icons">dashboard</span>
                <div class="collapsible">
                  <span>Dashboard</span>
                </div> 
                <span class="sr-only">(current)</span>
              </a>
            </li>

            <li class="item-dropdown">
              <div class="dropdown-tile">
                <a class="d-flex align-content-start" data-toggle="collapse" href="#projectsCollapse" aria-expanded="false" aria-controls="contentId"> 
                  <span class="material-icons">handyman</span>
                  <div class="collapsible">
                    <span>
                      Projects
                      <span class="material-icons">arrow_drop_down</span>
                    </span>
                  </div>
                </a>
              </div>
              <ul class="collapse list-unstyled sub-menu" id="projectsCollapse">
                <li class="">
                  <a class="" href="<?= SITE_URL.US.'project#all' ?>">All</a>
                </li>
                <li class="">
                  <a class="" href="<?= SITE_URL.US.'project#done' ?>">Done</a>
                </li>
                <li class="">
                  <a class="" href="<?= SITE_URL.US.'project#ongoing' ?>">Ongoing</a>
                </li>
                <!-- <li class="">
                  <a class="" href="<?= SITE_URL.US.'project#pending' ?>">Pending</a>
                </li> -->
              </ul>
            </li>

            <li class="">
              <a class="d-flex align-content-start" href="<?= SITE_URL.US.'messages' ?>">
                <span class="material-icons">chat_bubble</span>
                <div class="collapsible">
                  <span>Messages</span>
                </div>
              </a>
            </li>

            <!-- <li class="item-dropdown">
              <div class="dropdown-tile">
                <a class="d-flex align-content-start" data-toggle="collapse" href="#teamCollapse" aria-expanded="false" aria-controls="contentId"> 
                  <span class="material-icons">workspaces</span>
                  <div class="collapsible">
                    <span>
                      Team
                      <span class="material-icons">arrow_drop_down</span>
                    </span>
                  </div>
                </a>
              </div>
              <ul class="collapse list-unstyled sub-menu" id="teamCollapse">
                <li class="">
                  <a class="" href="< SITE_URL.US.'team/employees' ?>">Employees</a>
                </li>
                <li class="">
                  <a class="" href="?= SITE_URL.US.'team/workers' ?>">Workers</a>
                </li>
              </ul>
            </li> -->

            <li class="item-dropdown">
              <div class="dropdown-tile">
                <a class="d-flex align-content-start" data-toggle="collapse" href="#teamCollapse" aria-expanded="false" aria-controls="contentId"> 
                  <span class="material-icons">workspaces</span>
                  <div class="collapsible">
                    <span>
                      Users
                      <span class="material-icons">arrow_drop_down</span>
                    </span>
                  </div>
                </a>
              </div>
              <ul class="collapse list-unstyled sub-menu" id="teamCollapse">
                <li class="">
                  <a class="" href="<?= SITE_URL.US.'user/employees' ?>">Employees</a>
                </li>
                <li class="">
                  <a class="" href="<?= SITE_URL.US.'user/workers' ?>">Workers</a>
                </li>
                <li class="active">
                  <a class="" href="<?= SITE_URL.US.'user/clients' ?>">Clients</a>
                </li>
              </ul>
            </li> 

            
            <!-- <li class="">
              <a class="d-flex align-content-start" href="?= SITE_URL.US.'users' ?>">
                <span class="material-icons">people</span>
                <div class="collapsible">
                  <span>Users</span>
                </div>
              </a>
            </li> -->

            <li class="">
              <a class="d-flex align-content-start" href="<?= SITE_URL.US.'users' ?>">
              <i class="fa-sharp fa-solid fa-credit-card"></i>
                <div class="collapsible">
                  <span>Payment</span>
                </div>
              </a>
            </li>

            <li class="">
              <a class="d-flex align-content-start" href="<?= SITE_URL.US.'users' ?>">
              <i class="fa-sharp fa-solid fa-file-invoice"></i>
                <div class="collapsible">
                  <span>Invoice</span>
                </div>
              </a>
            </li>
  
            <hr>
  
            <li class="">
              <a class="d-flex align-content-start" href="<?= SITE_URL.US.'app/profile/'.$_SESSION['accID'] ?>">
                <span class="material-icons">person</span>
                <div class="collapsible">
                  <span>Profile</span>
                </div>
                <span class="sr-only">(current)</span>
              </a>
            </li>
            
            <li class="">
              <a class="d-flex align-content-start" href="<?= SITE_URL.US.'auth/logout' ?>">
                <span class="material-icons">logout</span>
                <div class="collapsible">
                  <span>Logout</span>
                </div>
              </a>
            </li>
          </ul>
        </nav>
      </div>

      <?php break;
  }
  ?>
