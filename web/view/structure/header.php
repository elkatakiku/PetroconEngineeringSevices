<!doctype html>
<html lang="en">
  <head>
    <!-- Change the 'Page' to current page  -->
    <title>Petrocon</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" href="<?= IMAGES_PATH.'favicon.ico' ?>">

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
      if ($data['accountType'] == Core\Controller::CLIENT && isset($_SESSION['accID'])) {
        echo '<link rel="stylesheet" href="'.STYLES_PATH.'index.css">';
      }
    ?>
    <link rel="stylesheet" href="<?=STYLES_PATH.$view?>.css">    
  </head>

  <body class="body-wrapper" <?php 
        // Moodify if is client and logged in
        if ($data['accountType'] == Core\Controller::CLIENT) {
          echo 'data-spy="scroll" data-target="#topbar" data-offset="500"';
        }
      ?>
    >

    <!-- <pre>
      <?= var_dump($data) ?>
    </pre> -->

  <?php
//  switch ($data['accountType'])
//  {
//    case Core\Controller::AUTH: ?>
    <?php //break;
//

//    case Core\Controller::CLIENT:
//      if (isset($data['acct']) && $data['acct']['activated'] === 0) { ?><!-- -->
<!--        <div class="alert alert-secondary show mb-0" role="alert">-->
<!--          <p class="mb-0">Verify email to access other features of the site. <a href="--><?//= SITE_URL.'/auth/activate' ?><!--">Verify now</a></p>-->
<!--        </div>-->
<!--      --><?php //}?>
<!---->
<!--    Navbar -->
<!--    <nav id="topbar" class="navbar fixed-top navbar-expand-lg navbar---><?//= !isset($_SESSION['accID']) ? 'dark" data-user="home"' : 'light" data-user="client"' ?><!--">-->
<!--      <a class="navbar-brand brand" href="--><?//= SITE_URL ?><!--">-->
<!--        <img src="--><?//=IMAGES_PATH?><!--petrocon-icon-2.png" class="d-inline-block align-top brand-icon" alt="Petrocon Logo">-->
<!--        <span class="brand-name">Petrocon Engineering Services</span>-->
<!--      </a>-->
<!--      -->
<!--      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">-->
<!--        <span class="navbar-toggler-icon"></span>-->
<!--      </button>-->
<!--    -->
<!--      <div class="collapse navbar-collapse" id="navbarSupportedContent">-->
<!--        <ul class="navbar-nav ml-auto" id="navItemBar">-->
<!--          <li class="nav-item">-->
<!--            <a class="nav-link" href="#header">Home</a>-->
<!--          </li>-->
<!--          <li class="nav-item">-->
<!--            <a class="nav-link" href="#whyUs">Services</a>-->
<!--          </li>-->
<!--          <li class="nav-item">-->
<!--            <a class="nav-link" href="#aboutUs">About</a>-->
<!--          </li>-->
<!--          <li class="nav-item">-->
<!--            <a class="nav-link" href="#projects">Projects</a>-->
<!--          </li>-->
<!---->
<!--          --><?php //if (!isset($_SESSION['accID'])) { ?>
<!--            <li class="nav-item">-->
<!--                <a class="nav-link" href="#contactUs">Contact</a>-->
<!--              </li>-->
<!--            <li class="nav-item">-->
<!--              <a class="btn light-btn" href="--><?//= SITE_URL.'/login' ?><!--">Login</a>-->
<!--            </li>-->
<!--          --><?php //} else { ?>
<!--            <li class="nav-item">-->
<!--              <a class="nav-link" href="--><?//= SITE_URL.'/account/profile' ?><!--">-->
<!--                  Profile-->
<!--              </a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--              <a class="btn action-btn" href="--><?//= SITE_URL.'/auth/logout' ?><!--">-->
<!--                  Logout-->
<!--              </a>-->
<!--            </li>-->
<!--          --><?php //} ?>
<!--        </ul>-->
<!--      </div>-->
<!--    </nav>-->
<!---->
<!--      --><?php //break;

//    case Core\Controller::ADMIN:

    if (isset($data['user'])) { ?>

        <nav id="topbar" class="navbar navbar-expand-md navbar-light">
          <button id="sidebarCollapseToggler" type="button" class="btn icon-btn">
              <span class="material-icons">menu</span>
          </button>
          <a class="flex-grow-1" href="<?= SITE_URL.'/dashboard' ?>">
              <strong>Petrocon</strong>
              <?php if ($data['accountType'] == Core\Controller::ADMIN) { ?>
              <small> : Admin</small>
              <?php } ?>
          </a>
<!--          <span class="material-icons">circle_notifications</span>-->
          <p class="user-name"><?= ucwords($data['user']['firstname']).' '.ucwords($data['user']['lastname']) ?></p>

          <a href="<?= SITE_URL.'/account/profile' ?>"><span id="user-display" class="material-icons">account_circle</span></a>
        </nav>

        <div class="wrapper">
          <div id="sidebar">
            <nav>
              <ul class="list-unstyled components">
                <li id="dashboardMenu">
                  <a class="d-flex align-content-start" href="<?= SITE_URL.'/dashboard' ?>" title="Dashboard">
                    <span class="material-icons" data-tooltip="Dashboard">dashboard</span>
                    <div class="collapsible">
                      <span>Dashboard</span>
                    </div>
                    <span class="sr-only">(current)</span>
                  </a>
                </li>

                <li class="item-dropdown" id="projectsMenu">
                  <div class="dropdown-tile">
                    <a class="d-flex align-content-start" data-toggle="collapse" href="#projectsCollapse" aria-expanded="false" aria-controls="contentId" title="Projects">
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
                    <li>
                      <a href="<?= SITE_URL.'/project/list#all' ?>">All</a>
                    </li>
                    <li>
                      <a href="<?= SITE_URL.'/project/list#done' ?>">Done</a>
                    </li>
                    <li>
                      <a href="<?= SITE_URL.'/project/list#ongoing' ?>">Ongoing</a>
                    </li>
                  </ul>
                </li>

<!--                <li id="messagesMenu">-->
<!--                  <a class="d-flex align-content-start" href="--><?//= SITE_URL.'/messages' ?><!--" title="Messages">-->
<!--                    <span class="material-icons">chat_bubble</span>-->
<!--                    <div class="collapsible">-->
<!--                      <span>Messages</span>-->
<!--                    </div>-->
<!--                  </a>-->
<!--                </li>-->

<!--                <li id="billsMenu">-->
<!--                  <a class="d-flex align-content-start" href="--><?//= SITE_URL.'/bill' ?><!--" title="Invoices">-->
<!--                  <span class="material-icons">-->
<!--                    receipt_long-->
<!--                  </span>-->
<!--                    <div class="collapsible">-->
<!--                      <span>Bills</span>-->
<!--                    </div>-->
<!--                  </a>-->
<!--                </li>-->

                  <?php if ($data['accountType'] == Core\Controller::ADMIN) { ?>
                    <li class="item-dropdown" id="users">
                      <div class="dropdown-tile">
                        <a class="d-flex align-content-start" data-toggle="collapse" href="#teamCollapse" aria-expanded="false" aria-controls="contentId" title="Users">
                          <span class="material-icons">people</span>
                          <div class="collapsible">
                            <span>
                              Users
                              <span class="material-icons">arrow_drop_down</span>
                            </span>
                          </div>
                        </a>
                      </div>
                      <ul class="collapse list-unstyled sub-menu" id="teamCollapse">
                        <li>
                          <a href="<?= SITE_URL.'/user/list#all' ?>">All</a>
                        </li>
                        <li>
                          <a href="<?= SITE_URL.'/user/list#employees' ?>">Employees</a>
                        </li>
                        <li>
                          <a href="<?= SITE_URL.'/user/list#clients' ?>">Clients</a>
                        </li>
                      </ul>
                    </li>
                  <?php } ?>

                <hr>

                <li id="profileMenu">
                  <a class="d-flex align-content-start" href="<?= SITE_URL.'/account/profile' ?>" title="Profile">
                    <span class="material-icons">person</span>
                    <div class="collapsible">
                      <span>Profile</span>
                    </div>
                    <span class="sr-only">(current)</span>
                  </a>
                </li>

                <li id="logout">
                  <a class="d-flex align-content-start" href="<?= SITE_URL.'/auth/logout' ?>"  title="Logout">
                    <span class="material-icons">logout</span>
                    <div class="collapsible">
                      <span>Logout</span>
                    </div>
                  </a>
                </li>
              </ul>
            </nav>
          </div>

    <?php } ?>
