<!doctype html>
<html lang="en">
<head>
    <title>Petrocon</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" href="<?= IMAGES_PATH ?>favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
          rel="stylesheet">

    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- External CSS -->
    <link rel="stylesheet" href="<?= STYLES_PATH ?>styles.css">
    <link rel="stylesheet" href="<?= STYLES_PATH ?>popup.css">
    <?php if ($data['accountType'] == Core\Controller::CLIENT && isset($_SESSION['accID'])) { ?>
        <link rel="stylesheet" href="<?= STYLES_PATH ?>index.css">
    <?php } ?>
    <link rel="stylesheet" href="<?= STYLES_PATH . $view ?>.css">
</head>

<body class="body-wrapper">
<?php if (isset($data['user'])) { ?>
<nav id="topbar" class="navbar navbar-expand-md navbar-light">
    <button id="sidebarCollapseToggler" type="button" class="btn icon-btn">
        <span class="material-icons">menu</span>
    </button>
    <a class="flex-grow-1" href="<?= SITE_URL . '/dashboard' ?>">
        <strong>Petrocon</strong>
        <?php if ($data['accountType'] == Core\Controller::ADMIN) { ?>
            <small> : Admin</small>
        <?php } ?>
    </a>
    <p class="user-name"><?= ucwords($data['user']['firstname']) . ' ' . ucwords($data['user']['lastname']) ?></p>

    <a href="<?= SITE_URL . '/account/profile' ?>"><span id="user-display" class="material-icons">account_circle</span></a>
</nav>
<div class="wrapper">
    <div id="sidebar">
        <nav>
            <ul class="list-unstyled components">
                <li id="dashboardMenu">
                    <a class="d-flex align-content-start" href="<?= SITE_URL . '/dashboard' ?>" title="Dashboard">
                        <span class="material-icons">dashboard</span>
                        <div class="collapsible">
                            <span>Dashboard</span>
                        </div>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li class="item-dropdown" id="projectsMenu">
                    <a class="d-flex align-content-start" href="<?= SITE_URL . '/project' ?>" title="Projects">
                        <span class="material-icons">construction</span>
                        <div class="collapsible">
                            <span>Projects</span>
                        </div>
                    </a>
                </li>

                <li id="dashboardMenu">
                    <a class="d-flex align-content-start" href="<?= SITE_URL . '/dashboard' ?>" title="Dashboard">
                        <span class="material-icons">engineering</span>
                        <div class="collapsible">
                            <span>Team</span>
                        </div>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php if ($data['accountType'] == Core\Controller::ADMIN) { ?>
                    <li class="item-dropdown" id="users">
                        <a class="d-flex align-content-start" href="<?= SITE_URL . '/user' ?>" title="Projects">
                            <span class="material-icons">people</span>
                            <div class="collapsible"><span>Users</span></div>
                        </a>
                    </li>
                <?php } ?>

                <hr>

                <li id="profileMenu">
                    <a class="d-flex align-content-start" href="<?= SITE_URL . '/account/profile' ?>" title="Profile">
                        <span class="material-icons">person</span>
                        <div class="collapsible">
                            <span>Profile</span>
                        </div>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                <li id="logout">
                    <a class="d-flex align-content-start" href="<?= SITE_URL . '/auth/logout' ?>" title="Logout">
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
