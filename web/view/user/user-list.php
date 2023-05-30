<main class="content">
    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Users</h1>

        <!-- New users -->
        <a href="<?= SITE_URL ?>/user/new">
            <button type="button" class="btn sm-btn action-btn">
                Create User
            </button>
        </a>
    </div>

    <!-- Navigation Tab -->
    <nav class="nav-tab-container">
        <form id="filterTable" action="" class="filter-tab">
            <div class="filter-tab-item active">
                <label for="allStat">All</label>
                <input id="allStat" class="link-btn" type="radio" name="type" value="all" checked>
            </div>
            <?php
            foreach ($data['acctTypes'] as $acctType) { ?>
                <div class="filter-tab-item">
                    <label for="<?= $acctType['name'] ?>"><?= ucwords($acctType['name']) . 's' ?></label>
                    <input id="<?= $acctType['name'] ?>" class="link-btn" type="radio" name="type"
                           value="<?= $acctType['id'] ?>">
                </div>
            <?php } ?>
        </form>

        <!-- Search -->
        <div>
            <div class="search-form">
                <div class="input-container">
                    <div class="input-prepend">
                        <i class="fa fa-search icon" aria-hidden="true"></i>
                    </div>
                    <input type="text" name="" id="searchUser" placeholder="Search user">
                </div>
            </div>
        </div>
    </nav>

    <style>

        .main-content {
            padding-top: 0;
        }
    </style>

    <!-- Users Table -->
    <div class="main-content">
        <table class="mesa mesa-hover" id="usersTable">
            <thead class="mesa-head">
            <tr>
                <th scope="col"></th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col"></th>
            </tr>
            </thead>
        </table>
    </div>
</main>