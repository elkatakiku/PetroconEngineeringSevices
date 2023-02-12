<main class="content">
    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Projects</h1>

        <?php if ($data['accountType'] == Core\Controller::ADMIN) { ?>

            <!-- New Projects -->
            <a href="<?= SITE_URL ?>/project/new">
                <button type="button" class="btn sm-btn action-btn">
                    Create Project
                </button>
            </a>

        <?php } ?>

    </div>

    <!-- Navigation Tab -->
    <nav class="nav-tab-container">
        <form id="filterTable" action="" class="filter-tab">
      <span class="filter-tab-item active">
        <label for="allStat">All</label>
        <input id="allStat" class="link-btn" type="radio" name="status" value="all" checked>
      </span>
            <span class="filter-tab-item">
        <label for="doneStat">Done</label>
        <input id="doneStat" class="link-btn" type="radio" name="status" value="done">
      </span>
            <span class="filter-tab-item">
        <label for="ongoingStat">Ongoing</label>
        <input id="ongoingStat" class="link-btn" type="radio" name="status" value="ongoing">
      </span>
        </form>

        <!-- Search -->
        <div>
            <div class="search-form">
                <div class="input-container">
                    <div class="input-prepend">
                        <i class="fa fa-search icon" aria-hidden="true"></i>
                    </div>
                    <input type="text" id="searchProject" placeholder="Search Project">
                </div>
            </div>
        </div>
    </nav>

    <!-- Project Table -->
    <div class="main-content pt-0">
        <table class="mesa mesa-hover" id="projectsTable">
            <thead class="mesa-head">
            <tr>
                <th scope="col"></th>
                <th scope="col" class="tname projectName"><strong>Project</strong></th>
                <th scope="col">Progress</th>
                <th scope="col">Completion Date</th>
            </tr>
            </thead>
        </table>
    </div>
</main>