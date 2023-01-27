<main class="content">
    <!-- <pre>
        <?php //var_dump($data) ?>
    </pre> -->

    <!-- Header -->
    <div class="page-header">
        <span>
        <a id="backBtn" href="<?= SITE_URL ?>/project" class="linear">
            <span class="material-icons">
                arrow_back
            </span>
            <small>Go back</small>
        </a>
        <h1 class="page-title">New project</h1>
        </span>
    </div>

    <!-- Gantt Chart -->
    <section id="projectGanttChart" class="main-content chart-container">

        <style>
            .page-header .page-title {
                font-size: 16px;
            }

            #projectGanttChart {
                background-color: transparent;
                border-radius: 0;
                box-shadow: none;
            }

            .gantt-chart {
                background-color: white;
            }
        </style>

        <div class="completion-graph">
            <span class="completion-date">
                <h5>Completion Date</h5>
                <p style="font-size: 10px"><span class="start-date"></span> - <span class="end-date"></span></p>
            </span>
            <span class="completion-bar">
                <small class="completion-percent">0%</small>
            </span>
            <span class="completion-days"></span>
        </div>

        <div class="gantt-chart">
            <div class="chart">
                <div class="chart-row chart-header">
                    <div class="chart-row-item" id="timelineToggler">
                        Task name
                    </div>
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
    </section>

</main>

<script>
    //let projectId = '<?//= $data['project']['id'] ?>//';
    let projectId = 'PTRCN-PRJCT-63bc1cdd12b27';
</script>