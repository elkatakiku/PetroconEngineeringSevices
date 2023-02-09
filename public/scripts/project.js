// Local
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';
import * as Popup from '/PetroconEngineeringServices/public/scripts/module/popup.js';

// Server
// import * as Utils from '/public/scripts/module/utils.js';
// import * as Popup from '/public/scripts/module/popup.js';

const HTML_BODY = $('body');
const WINDOW = $(window);

// || Slide
function slideAutoHeight() {
    let topbarHeight = $("#topbar")[0].scrollHeight;
    let top = (topbarHeight - $(this).scrollTop() <= 0) ? 0 : topbarHeight - $(this).scrollTop();
    $(".slide.slide-fixed")
        .css("top", (top <= 0 ? 0 : top))
        .find(".slide-content")
            .css("height", 'calc(100vh - ' + top + 'px)');
}

slideAutoHeight();

// || Window
$(window).on('scroll',function(){
    console.log("Scroll");
    slideAutoHeight();
});

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

    const getMonth = function (year, month) {
        return new Date(year, month + 1, 0);
    }

    const createMonth = function (month, {grid, span}) {
        let monthGrid = $('<span class="chart-month">' + month.toLocaleString("default", { month: 'long', year : "numeric" }) + '</span>');
        monthGrid.css('grid-column', grid + ' / span ' + (span));
        return monthGrid;
    }


    $.get(
        Settings.base_url + "/task/chart",
        {projId : projectId},
        function (data) {
            // console.log(data);

            let response = JSON.parse(data);
              
            resetGanttChart();

            let rowHead = '250px';
            let startDate = new Date(response.data.start);
            // let startDate = new Date(response.data.start).getDate();
            // let monthStart = 1;

            console.log(response.data);

            //  Completion Date
            // $('.start-date').text(new Date(response.data.start).toLocaleString('default', {dateStyle : "medium"}));
            // $('.end-date').text(new Date(response.data.end).toLocaleString('default', {dateStyle : "medium"}));
            $('.completion-days').text(response.data.total_days + ' days');

            //  TODO: Months is based on the number of days
            //  TODO: Get the month of the start date
            //  TODO: Start the header with the start date
            //  TODO: Compare if the current date is the end date of a month
            //  TODO: Resets counter

            // Chart Header
            const HTML_DAYS = $('.chart-days');
            const HTML_MONTHS = $('.chart-months');

            let monthCounter = startDate.getMonth();
            let daysCounter = startDate.getDate();
            let monthLastDate =  getMonth(startDate.getFullYear(), monthCounter);

            //  Add first month
            console.log(monthLastDate)
            HTML_MONTHS.append(createMonth(monthLastDate, {grid : 1, span : monthLastDate.getDate() - daysCounter + 1}));

            for (let i = 0; i < response.data.grid; i++)
            {   //  Adds every other months
                HTML_DAYS.append('<span>' + daysCounter + '</span>');

                if (monthLastDate.getDate() === daysCounter)
                {   // Resets gantt chart date

                    monthLastDate = getMonth(startDate.getFullYear(), ++monthCounter);
                    HTML_MONTHS.append(createMonth(monthLastDate, {grid : i + 2, span : monthLastDate.getDate()}));

                    daysCounter = 1;
                }
                else
                {   // Increment days of gantt chart
                    daysCounter++;
                }
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

                        //  Show tooltip of bar/task on hover
                        bar.on('mouseenter', (e) =>
                        {
                            tooltip = chartTooltipShown ? $('.custom_tooltip') : createTooltip(task);

                            let element = $(e.target);
                            let top = e.target.getBoundingClientRect().top;

                            const showToolTip = (left) => {
                                if (!chartTooltipShown) {
                                    HTML_BODY.append(tooltip);
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
                                                HTML_BODY.append(tooltip);
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
            // ganttReload = setTimeout(loadGanttChart, 5000);
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

ganttChart.on('custom:ready', (e) =>
{
    $('#projectGanttChart .spinner').hide();
    $('.chart-container').css('visibility', 'visible');
});

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


// || Project info
let projectInfo = $('#projectDetailForm');
let infoInterval;

// Gets project info from the server
function loadProjectInfo() {  
    console.log("Load project info");
    $.get(
        Settings.base_url + "/project/get",
        {projId : projectId},
        function (data) {
            let response = JSON.parse(data);

            if (response.hasOwnProperty('data'))
            {
                let project = response.data;
                projectInfo.find('[name="id"]').val(project.id);
                projectInfo.find('[name="purchaseOrd"]').val(project.purchase_ord);
                projectInfo.find('[name="awardDate"]').val(project.award_date);
                projectInfo.find('[name="description"]').val(project.description);
                projectInfo.find('[name="buildingNo"]').val(project.building_number);
                projectInfo.find('[name="location"]').val(project.location);
                projectInfo.find('[name="company"]').val(project.company);
                projectInfo.find('[name="representative"]').val(project.comp_representative);
                projectInfo.find('[name="contact"]').val(project.comp_contact);
            }
        }
    ).then(function()
        {   // on completion, restart
            console.log("Reload info");
            ganttReload = setTimeout(loadProjectInfo, 5000);
        }
    );
}

// Project info toggle actions
$('#projectInfoToggller').on('click', (e) => {
    console.log("Info clicked");

    // infoInterval = setInterval(() => {
    //     loadProjectInfo();
    // }, 5000);

    // Removes refresh when editing
    projectInfo.on('custom:edit', (e) => {
        console.log("Edit event");
        // clearInterval(infoInterval);
    });

    $('#projectInfo').find('button[data-dismiss="slide"]').on('click', (e) =>
    {
        // clearInterval(infoInterval);
    });

    // Reapply refresh when done editing
    projectInfo.on('custom:readOnly', (e) =>
    {
        console.log("Read only");
        infoInterval = setInterval(() => {
            loadProjectInfo();
        }, 5000);
    });
});

// Project details actions
projectInfo.on('submit', (e) => {
    e.preventDefault();
    console.log("Submit project");

    $.post(
        Settings.base_url + "/project/update",
        {form : function () {return $(e.target).serialize();}},
        function (response, textStatus, jqXHR) {
            console.log("Project Update Response");
            console.log(response);
            let data = JSON.parse(response);
            if (data.statusCode !== 200)
            {
                // Shows alert on fail
                $(e.target).find('.alert-danger')
                    .addClass('show')
                    .text(data.message);
            } else {
                $(e.target).parents('.slide-content').find('button[data-toggle="form"][data-action="submit"]').trigger('click');
            }
        }
    );
});

// Delete task actions
$('#projectInfo').find('.delete-btn').on('click', () => {
    console.log("Delete project");
    deleteProject(projectId);
});

function deleteProject(projId) {  
    console.log("Delete popup");
    let deletePopup = Popup.generateDeletePopup('project');

    deletePopup.find('input[name="id"]').val(projId);
    deletePopup.find('#deleteForm').submit((e) => {
        e.preventDefault();
        console.log("Submit delete");

        $.post(
            Settings.base_url + "/project/remove",
            {form : function () {return $(e.target).serialize();}},
            function (data, textStatus) {
                console.log("Response delete");
                console.log(data);
                let jsonData = JSON.parse(data);
                if (jsonData.statusCode === 200)
                {   // Dismiss delete popup and redirect to projects list on success
                    console.log("Success delete");
                    deletePopup.find('button[data-dismiss]').trigger('click');

                    window.location.href =  Settings.base_url + '/project/list#all';
                }
            }
        );
    });

    Popup.show(deletePopup);
}

// Slide form buttons
$('.slide button[data-toggle="form"]').on('click', (e) => {
    let btn = $(e.target);
    if (btn.data('action') === 'edit') {
        console.log("Edit");

        let form = $("#" + btn.attr("form"));
    
        form.find("textarea, input").removeAttr("readonly");
    
        btn.attr("type", "button");
        btn.text("Done");
        btn.data("action", "submit");

        btn.parents('.slide-header').find('button[data-dismiss="slide"]').hide();
        btn.parents('.slide-header').find('button[data-toggle="form"][data-action="cancel"]').show();

        form.trigger('custom:edit');
    }
    else if (btn.data('action') === 'submit') {
        console.log("Submit");
        let form = $("#" + btn.attr("form"));

        form.find('.alert-danger').hide();
        form.find("textarea, input").attr("readonly", true);
        
        btn.attr("type", "submit");
        btn.text("Edit");
        btn.data("action", "edit");

        btn.parents('.slide-header').find('button[data-dismiss="slide"]').show();
        btn.parents('.slide-header').find('button[data-action="cancel"]').hide();

        form.trigger('custom:readOnly');
    }
    else if (btn.data('action') === 'cancel') {
        console.log("Cancel");
        let form = $("#" + btn.attr("form"));

        form.find('.alert-danger').hide();
        form.find("textarea, input").attr("readonly", true);

        let editBtn =  btn.parents('.slide-header').find('button[data-action="edit"]');

        editBtn.text("Edit");
        editBtn.data("action", "edit");
        editBtn.attr("type", "button");

        btn.hide();
        btn.parents('.slide-header').find('button[data-dismiss="slide"]').show();

        form.trigger('custom:readOnly');
    }
});

// || NAV TABS
let reloadTimeout;
// Nav tab datatables
function reloadDatatable(timeout, datatable) {
    clearTimeout(timeout);
    reloadTimeout = null;
    datatable.ajax.reload(null, false);
}

let taskTable = $('#taskTable');

let datatableSettings = {
    taskTable : {
        'dom' : 't',
        'autoWidth': false,
        'lengthChange': false,
        'sort' : false,
        'paging' : false,

        "ajax" : {
            url : Settings.base_url + "/task/list",
            type : 'GET',
            data : {projId : projectId},
            'complete' : function (data) {
                console.log("Complete");
                reloadTimeout = setTimeout(() => {
                    console.log("Reload");
                    if (DataTable.isDataTable(taskTable)) {
                        taskTable.dataTable().api().ajax.reload(null, false)
                    }
                }, 5000);

                taskTable.trigger('custom:reload');
            }
        },

        'language' : {
            'paginate' : {
                'previous' : '<',
                    'next' : '>'
            }
        },

        "columns" : [
            {'defaultContent' : ''},
            {'data' : 'description'},
            {
                'data' : 'stopped',
                'render' : function (data, type, row) {
                    return data === 0 ? (row.progress + '%') : '<span class="danger-text" style="font-weight: bold;">Paused</span>';
                }
            },
            {'data' : 'last_update'},
            {
                'defaultContent' : '',
                'render' : function (data, type, row) {
                    return  '<div class="action-cell-content">' +
                                // '<button class="btn action-btn sm-btn edit-btn">Edit</button>' +
                        ((row.stopped === 0) ?
                                ('<button class="btn attention-btn sm-btn progress-btn">Progress</button>' +
                                    '<button class="btn danger-btn sm-btn halt-btn">Halt</button>')
                        :
                                '<button class="btn success-btn sm-btn resume-btn">Resume</button>') +
                                '<div class="dots-menu flex-grow-1">' +
                                    '<button type="button" class="dots-menu-btn">' +
                                        '<i class="fa-solid fa-ellipsis-vertical"></i>' +
                                    '</button>' +
                                '</div>' +
                            '</div>';
                }
            }
        ],

        "columnDefs" : [
            {
                targets: 0,
                searchable: false,
                orderable: false
            },
            {
                "targets": 1,
                "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).addClass('taskCell');
                }
            },
            {
                "targets": 4,
                "createdCell": function (td, cellData, rowData, rowIndex, colIndex)
                {
                    console.log(rowData);

                    taskTable.find('tbody tr').eq(rowIndex).css('background-color', '#ffdddd');

                    let cell = $(td);
                    let thisDatatable = taskTable.dataTable().api();
                    // cell.find('.edit-btn').on('click', (e) =>
                    // {
                    //     let popup = $('#taskPopup');
                    //
                    //     Popup.initialize(popup);
                    //
                    //     popup.find('.ptitle').text('Task ' + parseFloat(rowData.order_no));
                    //     popup.find('[name="id"]').val(rowData.id);
                    //     popup.find('[name="order"]').val(parseFloat(rowData.order_no));
                    //     popup.find('[name="description"]').val(rowData.description);
                    //     popup.find('[name="start"]').val(rowData.start);
                    //     popup.find('[name="end"]').val(rowData.end);
                    //     popup.find('[name="progress"]').val(rowData.progress);
                    //
                    //     // Gets and displays stoppage information
                    //     if (rowData.stopped === 1)
                    //     {
                    //         popup.addClass('popup-delete');
                    //         $.get(
                    //             Settings.base_url + "/task/stoppage",
                    //             {taskId : rowData.id},
                    //             function (data) {
                    //                 console.log('Stoppage');
                    //                 console.log(data);
                    //
                    //                 let response = JSON.parse(data);
                    //                 if (response.statusCode === 200) {
                    //                     popup.find('[name="haltId"]').val(response.data.id);
                    //                     popup.find('[name="haltReason"]').val(response.data.description);
                    //                     popup.find('[name="haltStart"]').val(response.data.start);
                    //                     popup.find('[name="haltEnd"]').val(response.data.end);
                    //                 }
                    //             }
                    //         );
                    //
                    //         popup.find('[name="isHalted"]').prop('checked', rowData.stopped === 1)
                    //             .trigger('change');
                    //     }
                    //
                    //     popup.on('custom:dismissPopup', (e) => {
                    //         popup.removeClass('popup-delete');
                    //         popup.find('.ptitle-icon').remove();
                    //         popup.find('.delete-btn').off();
                    //         popup.find('[name="haltId"]').val('');
                    //     });
                    //
                    //     // Submit action
                    //     popup.find('form').on('submit', (event) =>
                    //     {
                    //         let form = $(event.target);
                    //         event.preventDefault();
                    //
                    //         $.post(
                    //             Settings.base_url + "/task/update",
                    //             {form : form.serialize()},
                    //             function (data) {
                    //                 console.log("Edit Response");
                    //                 console.log(data);
                    //                 let response = JSON.parse(data);
                    //
                    //                 if (response.statusCode === 200)
                    //                 {
                    //                     let turnover = '<a id="turnover" class="btn sm-btn action-btn" href="'+Settings.base_url+'/document/turnover/'+projectId+'">Turn Over</a>';
                    //                     $('#turnover').remove();
                    //
                    //                     if (response.done) {
                    //                         $('.nav-tab-container').append(turnover);
                    //                     }
                    //
                    //                     // Dismiss legend's form and reload legends list on success
                    //                     popup.find('button[data-dismiss]').trigger('click');
                    //
                    //                     // Reload tasks
                    //                     reloadDatatable(reloadTimeout, thisDatatable);
                    //                 }
                    //                 else
                    //                 {   // Shows alert on fail
                    //                     popup.find('.alert-danger')
                    //                         .addClass('show')
                    //                         .text(response.message);
                    //                 }
                    //
                    //                 form.trigger('custom:submitted');
                    //             }
                    //         );
                    //
                    //         Utils.toggleForm(form, true);
                    //     });
                    //
                    //     // Delete task actions
                    //     popup.find('.delete-btn').on('click',() =>
                    //     {
                    //         Popup.promptDelete('task', rowData.id, (deletePopup) => {
                    //             $.post(
                    //                 Settings.base_url + "/task/remove",
                    //                 {form : function () {return deletePopup.find('form').serialize();}},
                    //                 function (data) {
                    //                     console.log("Response delete");
                    //                     console.log(data);
                    //                     let jsonData = JSON.parse(data);
                    //                     if (jsonData.statusCode === 200)
                    //                     {   // Dismiss delete popup and reload legends list on success
                    //                         deletePopup.find('button[data-dismiss]').trigger('click');
                    //
                    //                         deletePopup.on('custom:dismissPopup', (e) => {
                    //                             popup.find('button[data-dismiss]').trigger('click');
                    //                         });
                    //
                    //                         // Reload tasks
                    //                         reloadDatatable(reloadTimeout, thisDatatable);
                    //                     }
                    //                 }
                    //             );
                    //         }, true);
                    //     });
                    //
                    //     // Finally, shows popup
                    //     Popup.show(popup);
                    // });

                    cell.find('.halt-btn').on('click', (e) =>
                    {
                        showHaltPopup(rowData);
                    });

                    cell.find('.progress-btn').on('click', (e) =>
                    {
                        showProgressPopup(rowData);
                    });

                    cell.find('.resume-btn').on('click', (e) =>
                    {
                        showResumePopup(rowData);
                    })

                    cell.find('.dots-menu-btn').on('click', (e) =>
                    {
                        showRowMenu(e, rowData);
                    });

                }
            }
        ],

        order: [
            [1, 'asc']
        ],

        //     // Sets click functionality of rows
        //     $(this).find('tbody').on('click', 'tr', (e) =>
        //     {
        //
        //         console.log("TR CLICKED");
        //
        //         let dt = this.api();
        //         let row = $(e.target).parents('tr');
        //         let rowData = dt.row(row).data();
        //         // let rowDisplay = dt.cells( row, '' ).render( 'display' );
        //
        //         let popup = buildResourcePopup();
        //         popup.find('.pfooter .btn.delete-btn').show();
        //
        //         popup.find('[name="id"]').val(rowData.id);
        //         popup.find('[name="item"]').val(rowData.item);
        //         popup.find('[name="quantity"]').val(rowData.quantity);
        //         popup.find('[name="price"]').val(rowData.price);
        //         popup.find('[name="total"]').val(rowData.total);
        //         popup.find('[name="notes"]').val(rowData.notes);
        //
        //         // Delete task actions
        //         popup.find('.delete-btn').click(() => {
        //             console.log("DELETE CLICKED");
        //             Popup.promptDelete('resource', rowData.id, (deletePopup) => {
        //                 $.post(
        //                     Settings.base_url + "/resource/remove",
        //                     {form : function () {return deletePopup.find('#deleteForm').serialize();}},
        //                     function (data, textStatus) {
        //                         console.log("Response delete");
        //                         console.log(data);
        //                         let jsonData = JSON.parse(data);
        //                         if (jsonData.statusCode == 200)
        //                         {   // Dismiss delete popup and reload legends list on success
        //                             deletePopup.find('button[data-dismiss]').trigger('click');
        //
        //                             deletePopup.on('custom:dismissPopup', (e) => {
        //                                 popup.find('button[data-dismiss]').trigger('click');
        //                             });
        //
        //                             // Reload tasks
        //                             dt.ajax.reload(null, false);
        //                         }
        //                     }
        //                 );
        //             }, true);
        //         });
        //
        //         // Submit action
        //         popup.find('#itemForm').submit((e) => {
        //             e.preventDefault();
        //
        //             $.post(
        //                 Settings.base_url + "/resource/update",
        //                 {form : getFormData(e.target)},
        //                 function (data, textStatus) {
        //                     console.log(data);
        //                     console.log("Edit Response");
        //                     let response = JSON.parse(data);
        //                     console.log(response);
        //
        //                     if (response.statusCode == 200)
        //                     {   // Dismiss legend's form and reload legends list on success
        //                         popup.find('button[data-dismiss]').trigger('click');
        //
        //                         // Reload resources
        //                         $("#resourceTable").dataTable().api().ajax.reload(null, false);
        //                     }
        //                     else
        //                     {   // Shows alert on fail
        //                         popup.find('.alert-danger')
        //                             .addClass('show')
        //                             .text(response.message);
        //                     }
        //                 }
        //             );
        //         });
        //
        //         // Finally shows popup
        //         Popup.show(popup);
        //     });
        // }
    },
    resourceTable : {
        'dom' : 't',
        'autoWidth': false,
        'lengthChange': false,
        'sort' : false,
        'paging' : false,
    
        "ajax" : {
            url : Settings.base_url + "/resource/list",
            type : 'GET',
            data : {projId : projectId},
            'complete' : function (data) {
                console.log("Complete");
                let table = $('#resourceTable');
                reloadTimeout = setTimeout(() => {
                    console.log("Reload");
                    table.dataTable().api().ajax.reload(null, false)
                }, 5000);

                table.trigger('custom:reload');
            }
        },
    
        'language' : {
            'paginate' : {
                'previous' : '<',
                'next' : '>'
            }
        },
    
        'columnDefs' : [
            {
                targets: 0,
                searchable: false,
                orderable: false
            },
        ],
    
        "columns" : [
            {'defaultContent' : ''},
            {'data' : 'item'}, 
            {'data' : 'quantity'},
            {'data' : 'price'},
            {'data' : 'total'},
            {'data' : 'notes'},
            {'defaultContent' : ''}
        ],
    
        order: [
            [1, 'asc']
        ],
    
        // "columnDefs" : [
        //     {
        //         "targets": 1,
        //         "createdCell": function (td, cellData, rowData, row, col) {
        //             // console.log("TD");
        //             // console.log(td);
        //             // console.log("Cell data");
        //             // console.log(cellData);
        //             $(td).addClass('taskCell');
        //         }
        //     }
        // ],
        
        initComplete : function () {
            // Sets click functionality of rows   
            $(this).find('tbody').on('click', 'tr', (e) => {
    
                console.log("TR CLICKED");
    
                let dt = this.api();
                let row = $(e.target).parents('tr');
                let rowData = dt.row(row).data();
                // let rowDisplay = dt.cells( row, '' ).render( 'display' );    
                
                let popup = buildResourcePopup();
                popup.find('.pfooter .btn.delete-btn').show();

                popup.find('[name="id"]').val(rowData.id);
                popup.find('[name="item"]').val(rowData.item);
                popup.find('[name="quantity"]').val(rowData.quantity);
                popup.find('[name="price"]').val(rowData.price);
                popup.find('[name="total"]').val(rowData.total);
                popup.find('[name="notes"]').val(rowData.notes);
                
                // Delete task actions
                popup.find('.delete-btn').click(() => {
                    console.log("DELETE CLICKED");
                    Popup.promptDelete('resource', rowData.id, (deletePopup) => {
                        $.post(
                            Settings.base_url + "/resource/remove",
                            {form : function () {return deletePopup.find('#deleteForm').serialize();}},
                            function (data, textStatus) {
                                console.log("Response delete");
                                console.log(data);
                                let jsonData = JSON.parse(data);
                                if (jsonData.statusCode == 200) 
                                {   // Dismiss delete popup and reload legends list on success
                                    deletePopup.find('button[data-dismiss]').trigger('click');

                                    deletePopup.on('custom:dismissPopup', (e) => {
                                        popup.find('button[data-dismiss]').trigger('click');
                                    });
                                
                                    // Reload tasks
                                    dt.ajax.reload(null, false);
                                }
                            }
                        );
                    }, true);
                });
    
                // Submit action 
                popup.find('#itemForm').submit((e) => {
                    e.preventDefault();
    
                    $.post(
                        Settings.base_url + "/resource/update",
                        {form : getFormData(e.target)},
                        function (data, textStatus) {
                            console.log(data);
                            console.log("Edit Response");
                            let response = JSON.parse(data);
                            console.log(response);

                            if (response.statusCode === 200)
                            {   // Dismiss legend's form and reload legends list on success
                                popup.find('button[data-dismiss]').trigger('click');

                                // Reload resources
                                $("#resourceTable").dataTable().api().ajax.reload(null, false);
                            }
                            else
                            {   // Shows alert on fail
                                popup.find('.alert-danger')
                                    .addClass('show')
                                    .text(response.message);
                            }
                        }
                    );
                });

                // Finally shows popup
                Popup.show(popup);
            });
        }
    },
    peopleTable : {
        'dom' : 't',
        'autoWidth': false,
        'lengthChange': false,
        'sort' : false,
        'paging' : false,
    
        "ajax" : {
            url : Settings.base_url + "/people/list",
            type : 'GET',
            data : {projId : projectId},
            'complete' : function (data) {
                console.log("Complete");
                let table = $('#peopleTable');
                reloadTimeout = setTimeout(() => {
                    console.log("Reload");
                    table.dataTable().api().ajax.reload(null, false)
                }, 5000);

                table.trigger('custom:reload');
            }
        },
    
        'language' : {
            'paginate' : {
                'previous' : '<',
                'next' : '>'
            }
        },
    
        'columnDefs' : [
            {
                targets: 0,
                searchable: false,
                orderable: false
            },
        ],
    
        "columns" : [
            {'defaultContent' : ''},
            {
                'defaultContent' : '',
                'render' : function (data, type, row) {
                    console.log(row);
                    let middlename = row.middlename.trim().length > 0 ? (row.middlename.trim() + '.') : '';
                    return row.lastname + ', ' + row.firstname + middlename;
                }
            },
            {'data' : 'email'},
            {
                'data' : 'contact_number',
                'render' : function (data, type, row) {
                    return data.trim().length === 0 ? 'N/A' : data;
                }
            },
            {'defaultContent' : ''}
        ],
    
        order: [
            [1, 'asc']
        ],
        
        initComplete : function () {
            // Sets click functionality of rows   
            $(this).find('tbody').on('click', 'tr', (e) => {
    
                console.log("TR CLICKED");
    
                let dt = this.api();
                let row = $(e.target).parents('tr');
                let rowData = dt.row(row).data();
                // let rowDisplay = dt.cells( row, '' ).render( 'display' );    
                
                let popup = buildResourcePopup();
                popup.find('.pfooter .btn.delete-btn').show();

                // popup.find('[name="id"]').val(rowData.id);
                // popup.find('[name="item"]').val(rowData.item);
                // popup.find('[name="quantity"]').val(rowData.quantity);
                // popup.find('[name="price"]').val(rowData.price);
                // popup.find('[name="total"]').val(rowData.total);
                // popup.find('[name="notes"]').val(rowData.notes);
                
                // Delete task actions
                // popup.find('.delete-btn').click(() => {
                //     console.log("DELETE CLICKED");
                //     Popup.promptDelete('resource', rowData.id, (deletePopup) => {
                //         $.post(
                //             Settings.base_url + "/resource/remove",
                //             {form : function () {return deletePopup.find('#deleteForm').serialize();}},
                //             function (data, textStatus) {
                //                 console.log("Response delete");
                //                 console.log(data);
                //                 let jsonData = JSON.parse(data);
                //                 if (jsonData.statusCode == 200) 
                //                 {   // Dismiss delete popup and reload legends list on success
                //                     deletePopup.find('button[data-dismiss]').trigger('click');

                //                     deletePopup.on('custom:dismissPopup', (e) => {
                //                         popup.find('button[data-dismiss]').trigger('click');
                //                     });
                                
                //                     // Reload tasks
                //                     dt.ajax.reload(null, false);
                //                 }
                //             }
                //         );
                //     }, true);
                // });
    
                // Submit action 
                // popup.find('#itemForm').submit((e) => {
                //     e.preventDefault();
    
                //     $.post(
                //         Settings.base_url + "/resource/update",
                //         {form : function () {return $(e.target).serialize();}},
                //         function (data, textStatus) {
                //             console.log(data);
                //             console.log("Edit Response");
                //             let response = JSON.parse(data);
                //             console.log(response);

                //             if (response.statusCode == 200) 
                //             {   // Dismiss legend's form and reload legends list on success
                //                 popup.find('button[data-dismiss]').trigger('click');

                //                 // Reload resources
                //                 $("#resourceTable").dataTable().api().ajax.reload(null, false);
                //             }
                //             else
                //             {   // Shows alert on fail
                //                 popup.find('.alert-danger')
                //                     .addClass('show')
                //                     .text(response.message);
                //             }
                //         }
                //     );
                // });

                // Finally shows popup
                // Popup.show(popup);
            });
        }
    },
    paymentTable : {
        'dom' : 't',
        'autoWidth': false,
        'lengthChange': false,
        'sort' : false,
        'paging' : false,
    
        "ajax" : {
            url : Settings.base_url + "/payment/list",
            type : 'GET',
            data : {projId : projectId},
            'complete' : function (data) {
                console.log("Complete");
                let table = $('#paymentTable');
                reloadTimeout = setTimeout(() => {
                    console.log("Reload");
                    table.dataTable().api().ajax.reload(null, false)
                }, 5000);

                table.trigger('custom:reload');
            }
        },
    
        "columns" : [
            {'defaultContent' : ''},
            {
                'data' : 'description'
                // 'render' : function (data, type, row) {
                //     return data + '<br>' + row.company; }
            }, 
            {'data' : 'amount'},
            {
                'data' : 'sent_at',
                'render' : function (data, type, row) {  
                    let date = new Date(data);
                    // return date.toLocaleString("default", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    return date.toDateString();
                }
            },
            {
                'defaultContent' : '',
                'render' : function (data, type, row) { 
                    return '<div class="action-cell-content">' +
                                '<span class="row-action-btns">' +
                                    '<button class="btn icon-btn edit-btn">' +
                                        '<span class="material-icons">' +
                                            'edit' +
                                        '</span>' +
                                    '</button>' +
                                    '<button class="btn icon-btn delete-btn">' +
                                        '<span class="material-icons">' +
                                            'delete' +
                                        '</span>' +
                                    '</button>' +
                                '</span>' +
                            '</div>'; 
                    }
            }
        ],

        "columnDefs" : [
            {
                "targets": 4,
                "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
                    // console.log("TD");
                    // console.log(td);
                    // console.log("Cell data");
                    // console.log(cellData);
                    // $(td).addClass('taskCell');
                    $(td).find('.edit-btn').on('click', (e) => {
                        console.log("Edit payment");
                        console.log(rowIndex);
                        console.log(colIndex);
                        console.log(cellData);
                        console.log(rowData);
                        console.log(rowData.id);

                        // let dt = this.api();
                        // let row = $(e.target).parents('tr');
                        // let rowData = dt.row(row).data();
                        // let rowDisplay = dt.cells( row, '' ).render( 'display' );    
                        
                        let popup = buildPaymentPopup();

                        popup.find('[name="date"]').val(rowData.id);
                        popup.find('[name="description"]').val(rowData.description);
                        popup.find('[name="amount"]').val(rowData.amount);
                        popup.find('[type="submit"]').text('Save');

                        // Submit action 
                        popup.find('#paymentForm').on('submit', (event) => {
                            event.preventDefault();
                            disableInputs(event.target);

                            $.post(
                                Settings.base_url + "/payment/update",
                                {form : getFormData(e.target)},
                                function (data, textStatus) {
                                    console.log(data);
                                    console.log("Edit Response");
                                    let response = JSON.parse(data);
                                    console.log(response);

                                    if (response.statusCode === 200)
                                    {   // Dismiss legend's form and reload legends list on success
                                        popup.find('button[data-dismiss]').trigger('click');

                                        // Reload resources
                                        $("#paymentTable").dataTable().api().ajax.reload(null, false);
                                    }
                                    else
                                    {   // Shows alert on fail
                                        popup.find('.alert-danger')
                                            .addClass('show')
                                            .text(response.message);
                                    }

                                    $(e.target).trigger('custom:formSubmitted');
                                }
                            );
                        });

                        // Finally shows popup
                        Popup.show(popup);
                    });

                    $(td).find('.delete-btn').on('click', (e) => {
                        console.log("Delete payment");
                        Popup.promptDelete('payment', rowData.id, (deletePopup) => {
                            $.post(
                                Settings.base_url + "/payment/remove",
                                {form : function () {return deletePopup.find('#deleteForm').serialize();}},
                                function (data, textStatus) {
                                    console.log("Response delete");
                                    console.log(data);
                                    let jsonData = JSON.parse(data);
                                    if (jsonData.statusCode === 200)
                                    {   // Dismiss delete popup and reload legends list on success
                                        deletePopup.find('button[data-dismiss]').trigger('click');

                                        deletePopup.on('custom:dismissPopup', (e) => {
                                            popupContainer.find('button[data-dismiss]').trigger('click');
                                        });
                                    
                                        // Reload tasks
                                        this.api().ajax.reload(null, false);
                                    }
                                }
                            );
                        }, true);
                    });
                }
            }
        ],

        order: [
            [1, 'asc']
        ],
        
        initComplete : function () {
            // Sets click functionality of rows   
            // $(this).find('tbody').on('click', 'tr', (e) => {
    
            //     console.log("TR CLICKED");
    
            //     let dt = this.api();
            //     let row = $(e.target).parents('tr');
            //     let rowData = dt.row(row).data();
            //     // let rowDisplay = dt.cells( row, '' ).render( 'display' );    
                
            //     // let popup = buildResourcePopup();
            //     // popup.find('.pfooter .btn.delete-btn').show();

            //     // popup.find('[name="id"]').val(rowData.id);
            //     // popup.find('[name="item"]').val(rowData.item);
            //     // popup.find('[name="quantity"]').val(rowData.quantity);
            //     // popup.find('[name="price"]').val(rowData.price);
            //     // popup.find('[name="total"]').val(rowData.total);
            //     // popup.find('[name="notes"]').val(rowData.notes);
                
            //     // Delete task actions
            //     // popup.find('.delete-btn').click(() => {
            //     //     console.log("DELETE CLICKED");
            //     //     Popup.promptDelete('resource', rowData.id, (deletePopup) => {
            //     //         $.post(
            //     //             Settings.base_url + "/resource/remove",
            //     //             {form : function () {return deletePopup.find('#deleteForm').serialize();}},
            //     //             function (data, textStatus) {
            //     //                 console.log("Response delete");
            //     //                 console.log(data);
            //     //                 let jsonData = JSON.parse(data);
            //     //                 if (jsonData.statusCode == 200) 
            //     //                 {   // Dismiss delete popup and reload legends list on success
            //     //                     deletePopup.find('button[data-dismiss]').trigger('click');

            //     //                     deletePopup.on('custom:dismissPopup', (e) => {
            //     //                         popup.find('button[data-dismiss]').trigger('click');
            //     //                     });
                                
            //     //                     // Reload tasks
            //     //                     dt.ajax.reload(null, false);
            //     //                 }
            //     //             }
            //     //         );
            //     //     }, true);
            //     // });
    
            //     // Submit action 
            //     // popup.find('#itemForm').submit((e) => {
            //     //     e.preventDefault();
    
            //     //     $.post(
            //     //         Settings.base_url + "/resource/update",
            //     //         {form : function () {return $(e.target).serialize();}},
            //     //         function (data, textStatus) {
            //     //             console.log(data);
            //     //             console.log("Edit Response");
            //     //             let response = JSON.parse(data);
            //     //             console.log(response);

            //     //             if (response.statusCode == 200) 
            //     //             {   // Dismiss legend's form and reload legends list on success
            //     //                 popup.find('button[data-dismiss]').trigger('click');

            //     //                 // Reload resources
            //     //                 $("#resourceTable").dataTable().api().ajax.reload(null, false);
            //     //             }
            //     //             else
            //     //             {   // Shows alert on fail
            //     //                 popup.find('.alert-danger')
            //     //                     .addClass('show')
            //     //                     .text(response.message);
            //     //             }
            //     //         }
            //     //     );
            //     // });

            //     // Finally shows popup
            //     // Popup.show(popup);
            // });
        }
    }
};

// When navigation tab change actions
$('.nav-tab').on('custom:tabChange', (e, tab, target) =>
{
    console.log("Tab changed");

    resetGanttChart();

    let table = $(target).find('table');
    console.log(table);
    
    if (target !== '#projectGanttChart' && !DataTable.isDataTable(table))
    {
        console.log(ganttReload);
        if (ganttReload !== null) {
            clearTimeout(ganttReload);
            ganttReload = null;
        }

        // Initializes resource table's datatable
        let datatable = table.DataTable(datatableSettings[table.attr('id')]);

        if (Settings.type === 'PTRCN-TYPE-18c19c59') {
            datatable.column( table.find('thead tr th').length - 1 ).visible( false );
        }

        // Incrementing number of table rows
        datatable.on('order.dt search.dt', function () {
            let i = 1;
            datatable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();

        // On datatable destroy actions
        datatable.on( 'destroy.dt', function ( e, settings )
        {
            console.log("Datable destroy");
            $(this).find('tbody').off( 'click', 'tr' );
            datatable.off( 'destroy.dt');
        });

        // On tab hide actions
        $(target).on('custom:hide', (e) =>
        {
            console.log("Hiding");
            datatable.destroy();
            clearTimeout(reloadTimeout);
            $(target).off('custom:hide')
        });
    } else if (target === '#projectGanttChart') {
        clearTimeout(reloadTimeout);
        loadGanttChart();
    }
});

// || TASK


// Resource
function buildResourcePopup() {
    console.log("Build resource popup");
    let popup = $('#resourcePopup');

    // Preps resource form
    resetResourcePopup(popup);

    // Computes total
    popup.find('[name="quantity"], [name="price"]').on('input', (e) => {
        popup.find('[name="total"]').val(popup.find('[name="price"]').val() * popup.find('[name="quantity"]').val());
    });
    
    // On dismiss listener
    popup.on('custom:dismissPopup', (e) => {
        console.log("Project Resource Popup dismissed");

        // Removes events of resource popup
        popup.find('#itemForm').off('submit');
        popup.find('[name="quantity"], [name="price"]').off('keyup');
        popup.find('.delete-btn').off();

        resetResourcePopup(popup);
    });

    Popup.initialize(popup);

    return popup;
}

function resetResourcePopup(popup) {  
    popup.find('[name="item"]').val('');
    popup.find('[name="quantity"]').val('');
    popup.find('[name="price"]').val('');
    popup.find('[name="total"]').val('');
    popup.find('[name="notes"]').val('');
    popup.find('[name="id"]').val('');
}

$('#addResource').on('click', (e) => {
    console.log("Add resource");
    let popup = buildResourcePopup();
    
    popup.find('#itemForm').on('submit', (e) =>
    {
        e.preventDefault();
        console.log("Submit resource");

        $.post(
            Settings.base_url + "/resource/new",
            {form : getFormData(e.target)},
            function (data, textStatus) {
                console.log(data);
                console.log("Add Response");
                let response = JSON.parse(data);
                console.log(response);

                if (response.statusCode === 200)
                {   // Dismiss legend's form and reload legends list on success
                    popup.find('button[data-dismiss]').trigger('click');

                    // Reload resources
                    reloadDatatable(reloadTimeout, $('#resourceTable').dataTable().api());
                }
                else
                {   // Shows alert on fail
                    popup.find('.alert-danger')
                        .addClass('show')
                        .text(response.message);
                }
            }
        );
    });

    popup.find('.pfooter .btn.delete-btn').hide();
    Popup.show(popup);
});


// Payment
function buildPaymentPopup() {  
    console.log("Build payment popup");
    let popup = $('#paymentPopup');

    // Preps payment form
    // Popup.reset(popup);
    
    // On dismiss listener
    popup.on('custom:dismissPopup', (e) => {
        console.log("Project payment popup dismissed");

        // Removes events of resource popup
        popup.find('#paymentForm').off('submit');
        popup.find('.delete-btn').off();
    });

    Popup.initialize(popup);

    return popup;
}

$('#addPayment').on('click', (e) => {
    console.log("Add payment");
    let popup = buildPaymentPopup();

    popup.find('[type="submit"]').text('Create');
    
    popup.find('#paymentForm').on('submit', (e) =>
    {
        e.preventDefault();
        console.log("Submit payment");

        $.post(
            Settings.base_url + "/payment/new",
            {form : getFormData(e.target)},
            function (data, textStatus) {
                console.log(data);
                console.log("Add Response");
                let response = JSON.parse(data);
                console.log(response);

                if (response.statusCode === 200)
                {   // Dismiss legend's form and reload legends list on success
                    popup.find('button[data-dismiss]').trigger('click');

                    // Reload resources
                    reloadDatatable(reloadTimeout, $('#paymentTable').dataTable().api());
                }
                else
                {   // Shows alert on fail
                    popup.find('.alert-danger')
                        .addClass('show')
                        .text(response.message);
                }
            }
        );
    });

    popup.find('.pfooter .btn.delete-btn').hide();
    Popup.show(popup);
})

function getFormData(form) {  
    console.log("get form data");
    console.log(projectId);
    return $(form).serialize() + "&projId=" + projectId;
}

function disableInputs(form) { 
    $(form).find('input, textarea').each((index, element) => {
        console.log(element);
        $(element).prop('disabled', true);
    });

    $('button[form="' + $(form).attr('id') + '"]').prop('disabled', true);
}

//  Choose from team
$('#employeeSearch').on('input', (e) => {
    console.log("Focus");
    $.get(
        Settings.base_url + "/people/searchEmployees",
        {form : getFormData(e.target)},
        function (data, textStatus) {
            let response = JSON.parse(data);
            console.log(response);

            let datalist = $('#employeesList');
            datalist.empty();

            if (response.statusCode === 200)
            {
                for (let i = 0; i < response.data.length; i++)
                {
                    console.log(response.data);
                    let user = response.data[i];
                    // let middleInitial = (user.middlename.trim().length > 0) ? user.middlename.charAt(0) + '.' : '';
                    // let name = user.lastname + ', ' + user.firstname + ' ' + middleInitial;
                    let option = '<option value="'+ user.email +'">';
                    console.log(option);
                    datalist.append(option);
                }
            }
        }
    );
});


let popupContainer = $('#popupContainer');

//  Task
$('#addTask').on('click', (e) => {
    popupContainer.load(
        Settings.base_url + "/task/taskPopup",
        {projId : projectId},
        function ()
        {
            Popup.initialize(popupContainer, true);
            initializeDateDuration(popupContainer);

            // Displays task form
            Popup.show(popupContainer);

            // Task submit action
            popupContainer.find('form')
                .on('submit',(e) =>
                {
                    e.preventDefault();
                    console.log("Submit form");
                    let form = $(e.target);

                    $.post(
                        Settings.base_url + "/task/new",
                        {form : form.serialize()},
                        function (data) {crudResponse(data, form, taskTable);}
                    );

                    Utils.toggleForm(form, true);
                })
                .on('custom:submitted', (e) =>
                {
                    Utils.toggleForm($(e.target), false);
                });
        }
    );
});

function showHaltPopup(task)
{
    popupContainer.load(
        Settings.base_url + "/task/haltPopup",
        {task : task.description, id : task.id},
        function ()
        {
            Popup.initialize(popupContainer, true);
            Popup.show(popupContainer);

            // Task submit action
            popupContainer.find('form')
                .on('submit',(e) =>
                {
                    e.preventDefault();
                    console.log("Submit form");
                    let form = $(e.target);

                    $.post(
                        Settings.base_url + "/task/haltTask",
                        {form : form.serialize()},
                        function (data) {crudResponse(data, form, taskTable, {'title' : task.description});}
                    );

                    Utils.toggleForm(form, true);
                })
                .on('custom:submitted', (e) =>
                {
                    Utils.toggleForm($(e.target), false);
                });

            popupContainer.on('custom:dismissPopup', (e) =>
            {
                popupContainer.removeClass('popup-delete');
                popupContainer.off();
            });
        }
    );
}

function showProgressPopup(task)
{
    popupContainer.load(
        Settings.base_url + "/task/progressPopup",
        {task : task.description, id : task.id, progress : task.progress},
        function () {
            Popup.initialize(popupContainer, true);
            Popup.show(popupContainer);

            // Task submit action
            popupContainer.find('form')
                .on('submit',(e) =>
                {
                    e.preventDefault();
                    let form = $(e.target);

                    $.post(
                        Settings.base_url + "/task/updateProgress",
                        {form : form.serialize()},
                        function (data)
                        {
                            crudResponse(data, form, taskTable, {'title' : task.description});

                            // console.log(data);
                            // let response = JSON.parse(data);
                            //
                            // if (response.statusCode === 200)
                            // {   // Dismiss legend's form and reload legends list on success
                            //     popupContainer.find('button[data-dismiss]').trigger('click');
                            //
                            //     // Reload tasks
                            //     reloadDatatable(reloadTimeout, taskTable.dataTable().api());
                            //
                            //     //  Show feedback
                            //     Popup.feedback({
                            //         'feedback' : 'success',
                            //         'title' : task.description,
                            //         'message' : response.message
                            //     });
                            // }
                            // else
                            // {   // Shows alert on fail
                            //     popupContainer.find('.alert-danger')
                            //         .addClass('show')
                            //         .text(response.message);
                            // }
                            //
                            // form.trigger('custom:submitted');
                        }
                    );

                    Utils.toggleForm(form, true);
                })
                .on('custom:submitted', (e) =>
                {
                    Utils.toggleForm($(e.target), false);
                });

            popupContainer.on('custom:dismissPopup', (e) =>
            {
                popupContainer.removeClass('popup-sucess');
                popupContainer.off();
            });
        }
    );
}

function showResumePopup(task)
{
    popupContainer.load(
        Settings.base_url + "/task/resumePopup",
        {task : task.description, id : task.id},
        function ()
        {
            Popup.initialize(popupContainer, true);
            Popup.show(popupContainer);

            // Task submit action
            popupContainer.find('form')
                .on('submit',(e) =>
                {
                    e.preventDefault();
                    let form = $(e.target);

                    console.log(form);

                    $.post(
                        Settings.base_url + "/task/resumeTask",
                        {form : form.serialize()},
                        function (data)
                        {
                            crudResponse(data, form, taskTable, {'title' : task.description});
                            // console.log(data);
                            // let response = JSON.parse(data);
                            //
                            // if (response.statusCode === 200)
                            // {   // Dismiss legend's form and reload legends list on success
                            //     popupContainer.find('button[data-dismiss]').trigger('click');
                            //
                            //     // Reload tasks
                            //     reloadDatatable(reloadTimeout, taskTable.dataTable().api());
                            //
                            //     //  Show feedback
                            //     Popup.feedback({
                            //         'feedback' : 'success',
                            //         'title' : task.description,
                            //         'message' : response.message
                            //     });
                            // }
                            // else
                            // {   // Shows alert on fail
                            //     popupContainer.find('.alert-danger')
                            //         .addClass('show')
                            //         .text(response.message);
                            // }
                            //
                            // form.trigger('custom:submitted');
                        }
                    );

                    Utils.toggleForm(form, true);
                })
                .on('custom:submitted', (e) =>
                {
                    Utils.toggleForm($(e.target), false);
                });

            popupContainer.on('custom:dismissPopup', (e) =>
            {
                popupContainer.removeClass('popup-sucess');
                popupContainer.off();
            });
        }
    );
}

// Row Menu
function renderRowMenu(id)
{
    return $('<ul class="dots-menu-popup" data-target="'+id+'">' +
                '<li id="editRow">Edit</li>' +
                '<li id="removeRow">Remove</li>' +
            '</ul>');
}

// Shows Menu
function showRowMenu(e, task)
{
    e.preventDefault();
    let menuBtn = $(e.target);
    let activeMenu = $(".dots-menu-popup");

    //  Closes opened menu when other menu clicked
    if (activeMenu.length > 0) {
        console.log("Menu is open");
        activeMenu.remove();
        activeMenu.off('custom:windowResize');
    }

    //  Closes menu manually
    if (activeMenu.data('target') !== task.id)
    {
        let menuPopup = renderRowMenu(task.id);
        HTML_BODY.append(menuPopup);

        const positionMenu = function () {
            menuPopup.css({
                top : menuBtn.offset().top,
                left : menuBtn.offset().left - menuPopup.width()
            });
        }

        positionMenu();
        menuPopup.on('custom:windowResize', positionMenu);

        //  Edit row
        menuPopup.find("#editRow").on('click', (e) =>
        {
            popupContainer.load(
                Settings.base_url + "/task/taskPopup",
                {projId : projectId},
                function ()
                {
                    Popup.initialize(popupContainer, true);

                    //  Sets input dates min and max
                    initializeDateDuration(popupContainer);

                    popupContainer.find('.ptitle').text('Task ' + task.order_no);
                    popupContainer.find('input[name="id" ]').val(task.id);
                    popupContainer.find('textarea[name="description" ]').val(task.description);
                    popupContainer.find('input[name="start" ]').val(task.start).trigger('change');
                    popupContainer.find('input[name="end" ]').val(task.end).trigger('change');

                    // Displays task form
                    Popup.show(popupContainer);

                    // Task submit action
                    popupContainer.find('form')
                        .on('submit',(e) =>
                        {
                            e.preventDefault();
                            let form = $(e.target);

                            $.post(
                                Settings.base_url + "/task/update",
                                {form : form.serialize()},
                                function (data)
                                {
                                    crudResponse(data, form, taskTable, {
                                            'feedback' : 'success',
                                            'title' : 'Task ' + task.order_no
                                    });
                                    // console.log(data);
                                    // let response = JSON.parse(data);
                                    //
                                    // if (response.statusCode === 200)
                                    // {   // Dismiss legend's form and reload legends list on success
                                    //     popupContainer.find('button[data-dismiss]').trigger('click');
                                    //
                                    //     // Reload tasks
                                    //     reloadDatatable(reloadTimeout, taskTable.dataTable().api());
                                    //
                                    //     //  Show feedback
                                    //     Popup.feedback({
                                    //         'feedback' : 'success',
                                    //         'title' : 'Task ' + task.order_no,
                                    //         'message' : response.message
                                    //     });
                                    // }
                                    // else
                                    // {   // Shows alert on fail
                                    //     popupContainer.find('.alert-danger')
                                    //         .addClass('show')
                                    //         .text(response.message);
                                    // }
                                    //
                                    // form.trigger('custom:submitted');
                                }
                            );

                            Utils.toggleForm(form, true);
                        })
                        .on('custom:submitted', (e) =>
                        {
                            Utils.toggleForm($(e.target), false);
                        });
                }
            );
        });

        //  Remove row
        menuPopup.find("#removeRow").on('click', (e) => {
            Popup.promptDelete('task', task.id, (deletePopup) => {
                $.post(
                    Settings.base_url + "/task/remove",
                    {form : function () {return deletePopup.find('#deleteForm').serialize();}},
                    function (data)
                    {
                        console.log(data);
                        let response = JSON.parse(data);

                        if (response.statusCode === 200)
                        {   // Dismiss delete popup and reload legends list on success
                            deletePopup.find('button[data-dismiss]').trigger('click');

                            deletePopup.on('custom:dismissPopup', (e) => {
                                popup.find('button[data-dismiss]').trigger('click');
                            });

                            // Reload tasks
                            reloadDatatable(reloadTimeout, taskTable.dataTable().api());

                            //  Show feedback
                            Popup.feedback({
                                'feedback' : 'success',
                                'title' : 'Task ' + task.description,
                                'message' : response.message
                            });
                        }
                    }
                );
            }, true);
        });
    }

    e.stopPropagation();
}

function initializeDateDuration(popupContainer)
{
    let start = popupContainer.find('input[name="start"]');
    let end = popupContainer.find('input[name="end"]');

    let min = start.attr('min');
    let max = start.attr('max');

    start.on('change', (e) => {
        if (!e.target.value) {
            end.attr('min', min);
        } else {
            $('input[data-end="'+e.target.dataset.start+'"]').attr('min', e.target.value);
        }
    });

    end.on('change', (e) => {
        if (!e.target.value) {
            start.attr('max', max);
        } else {
            $('input[data-start="'+e.target.dataset.end+'"]').attr('max', e.target.value);
        }
    });
}

function crudResponse(data, form, table, successFeedback = {})
{
    console.log(data);
    let response = JSON.parse(data);

    if (response.statusCode === 200)
    {   // Dismiss popup and reloads table
        popupContainer.find('button[data-dismiss]').trigger('click');

        // Reload tasks
        reloadDatatable(reloadTimeout, table.dataTable().api());

        //  Show feedback
        successFeedback.feedback = 'success';
        if (!successFeedback.hasOwnProperty('message')) {
            successFeedback.message = response.message;
        }
        Popup.feedback(successFeedback);
    }
    else
    {   // Shows alert on fail
        popupContainer.find('.alert-danger')
            .addClass('show')
            .text(response.message);
    }

    form.trigger('custom:submitted');
}


WINDOW.on('resize', (e) =>
{
    console.log('Window resize');
    $(".dots-menu-popup").trigger('custom:windowResize');
});
