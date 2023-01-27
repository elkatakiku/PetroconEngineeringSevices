// || Gantt Chart
let ganttChart = $('.gantt-chart');
let ganttReload;
let chartTooltipShown = false;
let tooltip;
let showHelp = false;

function loadGanttChart() {
    console.log("Load gantt chart");
    let chartX = ganttChart.scrollLeft();
    let chartY = ganttChart.scrollTop();
    $.get(
        Settings.base_url + "/task/chart",
        {projId : projectId},
        function (data) {
            console.log(data);

            let response = JSON.parse(data);

            resetGanttChart();
            let rowHead = '250px';
            let startDate = new Date(response.data.start).getDate();
            let monthStart = 1;

            console.log(response.data);

            //  Completion Date
            $('.start-date').text(new Date(response.data.start).toLocaleString('default', {dateStyle : "medium"}));
            $('.end-date').text(new Date(response.data.end).toLocaleString('default', {dateStyle : "medium"}));
            $('.completion-days').text(response.data.total_days + ' days');

            // Chart Header
            for (let i = 0; i < response.data.header[0].length; i++) {
                const days = response.data.header[1][i];

                console.log(days);

                // Months
                let monthGrid = $('<span class="chart-month">' + (new Date(response.data.header[2][i], response.data.header[0][i], 0)).toLocaleString("default", { month: 'long', year : "numeric" }) + '</span>');
                monthGrid.css('grid-column', monthStart + ' / span ' + days);
                $('.chart-months').append(monthGrid);

                // Days
                for (let j = 1; j <= days; j++) {
                    $('.chart-days').append('<span>' + startDate++ + '</span>');
                }

                startDate = 1;
                monthStart += days;
            }

            // Content
            if (response.data.hasOwnProperty('content'))
            {
                let progress = 0;
                response.data.content.forEach(task =>
                {
                    let taskBar = generateGanttRow(task);
                    let bars = taskBar.find('.chart-row-bars');
                    progress += task.progress;

                    let bar = $('<li>' +
                        '<span class="progress-percent">'+task.progress+'%</span>' +
                        '</li>');

                    if (task.stopped === 1) {
                        bar
                            .addClass('stopped')
                            .css('--percent', task.progress + '%')
                            .find('.progress-percent')
                            .html('<span class="material-icons help-icon">help</span>');
                    }

                    bar.css({
                        'grid-column' : task.grid + ' / span ' + task.span,
                        'background-image' : 'linear-gradient(to right, var(--palette1), var(--palette1) '+task.progress+'%, #6fcbe0 0, #6fcbe0)'
                    });

                    bars.append(bar);

                    bar.on('mouseenter', (e) =>
                    {
                        tooltip = chartTooltipShown ? $('.custom_tooltip') : createTooltip(task);

                        let element = $(e.target);
                        let top = e.target.getBoundingClientRect().top;

                        const showToolTip = (left) => {
                            if (!chartTooltipShown) {
                                $('body').append(tooltip);
                            }
                            tooltip.css({
                                top : (top - tooltip[0].scrollHeight) - 5,
                                left : left - ((tooltip[0].scrollWidth)/2)
                            });

                            chartTooltipShown = true;
                        }

                        element.on('mousemove', (e) =>
                        {
                            showToolTip(e.clientX);
                            chartTooltipShown = true;
                        });
                    });

                    bar.on('mouseleave', (e) =>
                    {
                        chartTooltipShown = false;
                        let element = $(e.target);
                        tooltip.remove();
                        element.off('mousemove');
                    });

                    if (task.stopped === 1)
                    {
                        bar.find('.progress-percent').on('mouseenter', (e) =>
                        {
                            let element = $(e.target);
                            let top = e.target.getBoundingClientRect().top;
                            let left = e.target.getBoundingClientRect().left;

                            showHelp = true;

                            element.css('cursor', 'progress');

                            $.get(
                                Settings.base_url + "/task/stoppage",
                                {taskId : task.id},
                                function (data) {
                                    console.log('Stoppage');
                                    console.log(data);

                                    let response = JSON.parse(data);
                                    console.log(response);
                                    if (response.statusCode === 200 && showHelp) {
                                        tooltip = chartTooltipShown ? $('.custom_tooltip') : createTooltip(response.data, true);

                                        if (!chartTooltipShown) {
                                            $('body').append(tooltip);
                                        }

                                        tooltip.css({
                                            top: (top - tooltip[0].scrollHeight) - 5,
                                            left : left + ((element.width() - tooltip[0].scrollWidth)/2),
                                        });

                                        chartTooltipShown = true;
                                    }

                                    element.css('cursor', 'pointer');
                                }
                            );

                            e.stopPropagation();
                        });

                        bar.find('.progress-percent').on('mouseleave', (e) =>
                        {
                            chartTooltipShown = false;
                            showHelp = false;
                            let element = $(e.target);
                            tooltip.remove();
                            element.off('mousemove');
                            e.stopPropagation();
                        });
                    }

                    $('.chart-body').append(taskBar);

                    $('.progress-percent').each((index, element) => {
                        let percent = $(element);
                        percent.css('right', '-' + (percent.width() + 5) + 'px');
                    });
                });

                //  Completion bar
                const NUM_OF_TASKS = response.data.content.length;
                progress = (progress / (100 * NUM_OF_TASKS)) * 100;

                $('.completion-bar').css('background-image', 'linear-gradient(to right, var(--primary), var(--primary) '+progress+'%, transparent 0, #d2d2d2)');
                $('.completion-percent').text(progress.toFixed(2) + '%');
            }

            // Chart grid settings
            $('.chart-months, .chart-days, .gantt-chart .chart-row-bars').css(
                'grid-template-columns', 'repeat(' + response.data.grid + ', minmax(var(--chart-grid-width), 1fr))'
            );

            let chartLines = $('.chart-lines');
            chartLines.css(
                'grid-template-columns', rowHead + ' repeat(' + response.data.grid + ', 1fr)'
            );

            // Chart lines
            let day = new Date(response.data.start).getDay() - 1;

            for (let j = 0; j < response.data.grid; j++) {
                let line = $('<span></span>');

                if (day === 0) {line.addClass('sunday');}
                chartLines.append(line);

                day++;
                if (day === 7) {day = 0;}
            }

            $('.chart-lines span').first().addClass('chart-row-item');

            // Sets scroll position to last scrolls' positions :>
            ganttChart.scrollLeft(chartX);
            ganttChart.scrollTop(chartY);

            ganttChart.trigger('custom:ready');
        }
    ).then(function()
        {   // on completion, restart
            console.log("Reload ganttchart");
            ganttReload = setTimeout(loadGanttChart, 5000);
        }
    );
}

function resetGanttChart() {
    $('.chart-months, .chart-days, .gantt-chart .chart-row-bars').css('grid-template-columns', '');
    $('.chart-months').empty();
    $('.chart-days').empty();
    $('.chart-lines').empty();
    $('.chart-body')
        .empty()
        .append('<div class="chart-lines"></div>');
}

loadGanttChart();

function createTooltip(task, help = false)
{
    let end = (task.end === "0000-00-00") ? '-' : (new Date(task.end).toLocaleString('default', {dateStyle : "medium"}));
    let tooltip = $(
        '<div class="custom_tooltip">' +
        '<div class="linear">' +
        '<h5 class="tip-title">'+task.description+'</h5>' +
        '</div>' +
        '<p class="tip-date">' +
        'Start: '+(new Date(task.start).toLocaleString('default', {dateStyle : "medium"}))+' <br>' +
        'End: '+end+' </p>' +
        '</div>');

    if (task.stopped === 1 || help) {
        tooltip
            .addClass('stopped');
        if (help) {
            tooltip
                .find('.linear')
                .prepend('<span class="material-icons help-icon">help</span>');
        }
    }

    return tooltip;

}

function generateGanttRow(task = null)
{
    let row = $(
        '<div class="chart-row">' +
        '<div class="chart-row-item task-name">' +
        '<strong class="task-number"></strong>' +
        '</div>' +
        '<ul class="chart-row-bars"></ul>' +
        '</div>'
    );

    if (task != null) {
        row.find('.task-number').text(parseFloat(task.order_no));
        row.find('.task-name').text(task.description);
    }

    return row;
}

