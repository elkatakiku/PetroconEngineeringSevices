<main id="dashboard" class="content" data-fill="true">
    <div class="db-content">
        <div class="page-header">
            <h1 class="page-title">Dashboard</h1>
        </div>

        <div class="ov-card-container">
            <div class="custom-card">
                <div class="overview-card">
                    <div class="ov-info">
                        <h3 class="ov-title">
                            <?=
                            (isset($data['count']['0']['count']) ? $data['count']['0']['count'] : 0) +
                            (isset($data['count']['1']['count']) ? $data['count']['1']['count'] : 0)
                            ?>
                        </h3>
                        <p class="ov-desc">Total projects</p>
                    </div>
                    <i class="fa fa-info-circle ov-icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="custom-card">
                <div class="overview-card">
                    <div class="ov-info">
                        <h3 class="ov-title"><?= (isset($data['count']['1']['count']) ? $data['count']['1']['count'] : 0) ?></h3>
                        <p class="ov-desc">Finished projects</p>
                    </div>
                    <i class="fa fa-info-circle ov-icon" aria-hidden="true"></i>
                </div>
            </div>

            <div class="custom-card">
                <div class="overview-card">
                    <div class="ov-info">
                        <h3 class="ov-title"><?= (isset($data['count']['0']['count']) ? $data['count']['0']['count'] : 0) ?></h3>
                        <p class="ov-desc">Ongoing projects</p>
                    </div>
                    <i class="fa fa-info-circle ov-icon" aria-hidden="true"></i>
                </div>
            </div>
        </div>

        <div>
            <canvas id="myChart"></canvas>
        </div>

    </div>
</main>