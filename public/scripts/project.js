// Modules
import * as Popup from '/PetroconEngineeringServices/public/scripts/module/popup.js';
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';

// ==========================================================================

// Collapse Task Legends Popup
$('#activityCollapse').click((e) => {
    let btn = $(e.target);

    resizeCollapse($(btn.data('target')).hasClass('active'), btn);
});

function resizeCollapse(isActive, btn = $('#activityCollapse')) {  
    if (!isActive) {
        $(btn.data('target')).addClass('active');
        btn.find('.material-icons').animate({
            'rotate' : '180deg'
        }, 150, 'swing');

        $($(btn.data('target'))).animate({
            'height' : '100%'
        }, 300, 'swing');
    } else {
        $(btn.data('target')).removeClass('active');
        btn.find('.material-icons').animate({
            'rotate' : '0deg'
        }, 150, 'swing');

        $($(btn.data('target'))).animate({
            'height' : 0
        }, 300, 'swing');
    }
}

// || Slide
function slideAutoHeight() {
    var topbarHeight = $("#topbar")[0].scrollHeight;
    let top = (topbarHeight - $(this).scrollTop() <= 0) ? 0 : topbarHeight - $(this).scrollTop();
    $(".slide.slide-fixed")
        .css("top", (top <= 0 ? 0 : top))
        .find(".slide-content")
            .css("height", 'calc(100vh - ' + top + 'px)');
}

slideAutoHeight();

// Ajax loader
function loadActivities(id, activities) { 
    console.log("Load activities");
    $.get(
        Settings.base_url + "/activity/list", 
        {taskId : id},
        function (data, status) {
            console.log("Activity response");
            console.log(data);
            activities.empty();
    
            let jsonResponse = JSON.parse(data);
            console.log(typeof jsonResponse);
            console.log(jsonResponse);

            if (jsonResponse.hasOwnProperty('data')) {
                for (let i = 0; i < jsonResponse.data.length; i++) {
                    const activity = jsonResponse.data[i];
                    const activityElement = generateTaskActivity(
                        {
                            id : activity.legendId,
                            title : activity.title,
                            color : activity.color
                        },
                        activity.start, 
                        activity.end,
                        activity.id
                    );
    
                    if ($.inArray(activity.id, deletedActivities) >= 0) {
                        activityElement.addClass('hide');
                    }
                    activities.append(activityElement);
                }
            }
        }
    );
}

function loadLegends(legends, activities = null) {
    legends.trigger('custom:reload');
    
    $.get(
        Settings.base_url + "/legend/list", 
        { id : projectId },
        function (response) {
            console.log("Legend response");
            // console.log(response);
            let jsonResponse = JSON.parse(response);
            if (jsonResponse.statusCode == 200 && jsonResponse.hasOwnProperty('data')) 
            {
                legends.empty();

                for (let i = 0; i < jsonResponse.data.length; i++) {
                    generateLegend(jsonResponse.data[i], legends, activities);
                }
            }
        }
    );
}

function generateLegend(legendData, legendsContainer, activities = null) {  
    const legendElement = $(
        '<div class="task-legend">' +
            '<span class="leg-color" data-color="' + legendData.color + '"></span>' +
            '<span class="leg-title">' + legendData.title + '</span>' +
            '<button class="btn icon-btn leg-edit" data-toggle="legend" data-target="' + legendData.id + '">' +
                '<span class="material-icons">edit</span>' +
            '</button>' +
        '</div>'
    );

    legendElement
        .find('.leg-color, .leg-title')
        .css('background-color', legendElement.find('.leg-color').data('color'))
        .on('click', (e) => {
            let date = new Date();
            let currentDate =   date.getFullYear() + '-' +
                                ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1) + '-' +
                                (date.getDay() < 10 ? '0' : '') + date.getDay();

            if (activities) {
                activities.append(generateTaskActivity(
                    legendData,
                    currentDate, 
                    currentDate,
                    '')
                );
            }
        });

    legendElement
        .find("button[data-toggle='legend']")
        .on('click', (e) => {
            buildLegendForm(legendData);
        });

    legendsContainer.append(legendElement);

    legendsContainer.on('custom:reload', (e) => {
        legendElement.find('.leg-color, .leg-title').off('click');
        legendElement.find('button[data-toggle="legend"]').off('click');
    });

    return legendElement;
}

// || Task
// Timeline datatable settings
let dtTable = {
    'dom' : '<"mesa-container"t>p',
    "autoWidth": false,
    "lengthChange": false,
    'paging' : false,
    'sort' : false,
    'searching' : false,
    'info' : false,

    "ajax" : {
        url : Settings.base_url + "/task/plans",
        type : 'GET',
        data : {projId : projectId}
        // ,
        // 'complete' : function (data) { 
        //     console.log(data);
        // }
    },
    "columns" : [
        {
            'data' : 'order_no',
            'render' : function (data, type, row) {  
                return parseFloat(data);
            }
        }, 
        {'data' : 'description'}, 
        {'data' : 'plan_start'},
        {'data' : 'plan_end'},
        {'defaultContent' : ''}
    ],

    "columnDefs" : [
        {
            "targets": 1,
            "createdCell": function (td, cellData, rowData, row, col) {
                // console.log("TD");
                // console.log(td);
                // console.log("Cell data");
                // console.log(cellData);
                $(td).addClass('taskCell');
            }
        }
    ],
    
    order: [
        [0, 'asc']
    ],

    initComplete : function () {
        // Sets click functionality of rows   
        $(this).find('tbody').on('click', 'tr', (e) => {

            console.log("TR CLICKED");

            let dt = this.api();

            let row = $(e.target).parents('tr');
            let rowData = dt.row(row).data();
            let rowDisplay = dt.cells( row, '' ).render( 'display' );    
            
            let popup = buildTaskPopup();
    
            popup.find('.pmain .ptitle').text('Task ' + rowDisplay[0]);
            popup.find('.pmain input[name="id"]').val(rowData.id);
            popup.find('.pmain input[name="order"]').val(rowDisplay[0]);
            popup.find('.pmain textarea[name="taskDesc"]').val(rowDisplay[1]);
    
            let activities = popup.find('#taskActivities');
            
            // Gets task activities
            loadActivities(rowData.id, activities);
            // Refreshes Activities
            let taskInterval = setInterval(() => {
                console.log("Activities reload");
                loadActivities(rowData.id, activities);
            }, 3000);
            
            // Delete task actions
            popup.find('.pfooter .btn.delete-btn').show();
            popup.find('.delete-btn').click(() => {
                console.log("DELETE CLICKED");
                console.log("Delete data");
                console.log(rowData);
                deleteTask(popup, rowData.id, dt);
            });

            // Task submit action 
            popup.find('#taskForm').submit((e) => {
                e.preventDefault();

                $.post(
                    Settings.base_url + "/task/update",
                    {
                        form : getTaskData($(e.target)),
                        deleted : JSON.stringify(deletedActivities)
                    },
                    function (response, status) {
                        console.log("Edit Response");
                        let data = JSON.parse(response);
                        if (data.statusCode == 200) 
                        {   // Dismiss legend's form and reload legends list on success
                            popup.find('button[data-dismiss]').trigger('click');

                            // Reload tasks
                            dt.ajax.reload(null, false);
                        }
                        else
                        {   // Shows alert on fail
                            popup.find('.alert-danger')
                                .addClass('show')
                                .text(data.message);
                        }

                        console.log("Response");
                });
            });
    
            // On dismiss listener
            popup.on('custom:dismissPopup', (e) => {
                console.log("Task edit dismissed");
                
                // Clears task reload interval
                clearInterval(taskInterval);
            });

            popup.find('.pfooter .btn.neutral-outline-btn').css('width', '100%');

            // Finally shows popup
            Popup.show(popup);
        });

        // Destroy initialization of datatable on dismiss
        $('.timeline').on('custom:timelineDismiss', (e) => {
            console.log("Timeline dismiss");
            this.api().destroy();
        });
    }
}

function deleteTask(taskPopup, taskId, table) {  
    console.log("Delete popup");
    let deletePopup = Popup.generateDeletePopup('task');

    deletePopup.find('input[name="id"]').val(taskId);
    deletePopup.find('#deleteForm').submit((e) => {
        e.preventDefault();
        console.log("Submit delete");

        $.post(
            Settings.base_url + "/task/remove",
            {form : function () {return $(e.target).serialize();}},
            function (data, textStatus) {
                console.log("Response delete");
                console.log(data);
                let jsonData = JSON.parse(data);
                if (jsonData.statusCode == 200) 
                {   // Dismiss delete popup and reload legends list on success
                    console.log("Success delete");
                    deletePopup.find('button[data-dismiss]').trigger('click');

                    deletePopup.on('custom:dismissPopup', (e) => {
                        console.log("TaskDelete dismiss");
                        taskPopup.find('button[data-dismiss]').trigger('click');
                    });
                

                    // Reload tasks
                    table.ajax.reload(null, false);
                }
            }
        );
    });

    Popup.show(deletePopup);
}

// Shows timeline
$('#timelineToggler button').click((e) => {
    clearInterval(ganttChartInterval);
    resetGanttChart();

    $('.timeline')
        .show()
        .animate({
            'margin-left' : '0'
        }, 300, "swing");

    // Initializes timeline table to datatable
    let table = $("#tasksTable").DataTable(dtTable);

    let tableInterval = setInterval(() => {
        console.log("Table interval");
        table.ajax.reload(null, false);
    }, 3000);


    $("#tasksTable").on( 'destroy.dt', function ( e, settings ) {
        console.log("Table Destroy");
        $(this).find('tbody').off( 'click', 'tr' );
        clearInterval(tableInterval);
    });
});

// Dismisses timeline
$('.timeline header .back-btn').click((e) => {
    buildGanttChart();

    $('.timeline').animate({
        'margin-left' : '-100%'
    }, 300, "swing", function () {  
        $('.timeline').hide();
        // $('.chart-container').show();
    });

    $('.timeline').trigger('custom:timelineDismiss');
});

function buildTaskPopup() {
    console.log("Build popup");
    let popup = $('#taskPopup');

    // Preps task form
    resetTaskPopup(popup);
    
    let newActivities = popup.find('#newActivities');
    let legends = popup.find('#legends');
    
    // Get project legends
    loadLegends(legends, newActivities);
    // Refresh legends
    let legendsInterval = setInterval(() => {
        console.log("Legends reload");
        loadLegends(legends, newActivities);
    }, 3000);
    

    // On dismiss listener
    popup.on('custom:dismissPopup', (e) => {
        console.log("Project Popup dismissed");
        
        // Removes legends reload interval
        clearInterval(legendsInterval);
        resetTaskPopup(popup);

        // Removes submit event of task form
        popup.find('#taskForm').off('submit');
    });

    popup.on('custom:legendReload', (e) => {
        console.log("Legends reloaded");
        loadLegends(legends, newActivities);
    });

    Popup.initialize(popup);

    return popup;
}

// Adds new task
$('#addTask').click((e) => {
    let popup = buildTaskPopup();

    console.log("Porject id " + projectId);
    
    $.get(
        Settings.base_url + "/task/count",
        { projId : projectId },
        function (data, textStatus) {
            let jsonData = JSON.parse(data);
            popup.find('.pmain .ptitle').text('Task ' + (jsonData.data + 1));
        }
    );

    // Displays task form
    popup.find('.pfooter .btn.delete-btn').hide();
    popup.find('.pfooter .btn.neutral-outline-btn').css('width', '');
    Popup.show(popup);

    // Task submit action
    popup.find('#taskForm').submit((e) => {
        e.preventDefault();
        console.log("Submit form");
        let form = $(e.target);
    
        $.post(
            Settings.base_url + "/task/new",
            {form : getTaskData(form)},
            function (data, textStatus) {
                console.log("Add Response");
                $('#samp').html(data);
                let response = JSON.parse(data);
                console.log(response);

                if (response.statusCode == 200) 
                {   // Dismiss legend's form and reload legends list on success
                    popup.find('button[data-dismiss]').trigger('click');

                    // Reload tasks
                    $("#tasksTable").dataTable().api().ajax.reload(null, false);
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
    
});

// Collects task's form data
function getTaskData(form) {

    let formData = {
        id : form.find('input[name="id"]').val(),
        projId : projectId,
        description : form.find('[name="taskDesc"]').val()
    };

    // Gets old activities data
    let oldActivities = [];

    form
        .find('#taskActivities')
        .children()
        .each((index, element) => {
            getActivityData(element, oldActivities);
        });

    formData['oldActivities'] = oldActivities;

    // Gets new activities data
    let newActivities = [];

    form
        .find('#newActivities')
        .children('div:not(.hide)')
        .each((index, element) => {
            getActivityData(element, newActivities, true);
        });
    
    formData['newActivities'] = newActivities;

    // Returs a json format form data
    return JSON.stringify(formData);
}

// Scrapes activity details to array
function getActivityData(element, actsArr, isNew = false) {  
    let activity = $(element);
    let actObj = {};

    console.log("Element");
    console.log(activity);
    if (!isNew) {
        actObj['id'] = activity.attr('id');
    }
    actObj['legendId'] = activity.find('[name="legendId"]').val();
    actObj['start'] = activity.find('[name="start"]').val();
    actObj['end'] = activity.find('[name="end"]').val();
    console.log(actObj);

    actsArr.push(JSON.stringify(actObj));
}

$('form[data-row] button[type="submit"]').click((e) => {
    e.preventDefault();
    $(e.target).parents('form[data-row]').submit();
});

// Task Activity
let deletedActivities = [];

// Resets task form
function resetTaskPopup(popup) {
    deletedActivities = [];
    popup.find('.pmain .ptitle').empty();
    popup.find('[name="taskDesc"]').val('');
    popup.find('#taskActivities').empty();
    popup.find('#newActivities').empty();
    popup.find('#legends').empty();
    
    popup.find('.alert-danger').removeClass('show');

    popup.find('.delete-btn').off('click');
}

// Generates task activity panel/element
function generateTaskActivity(legend, start, end, id = '') {  
    console.log("Generate Task activityi");
    let activityElement = $('<div class="form-input-group task-activity" id="' + id + '">' +
                                '<span class="linear-label">' +
                                    '<label for="">' + legend.title + '</label>' +
                                    '<button type="button" class="icon-btn close-btn" data-dismiss="activity" aria-label="Close">' +
                                        '<span class="material-icons">close</span>' +
                                    '</button>' +
                                '</span>' +
                                '<input type="hidden" name="legendId" value="' + legend.id + '">' +
                                '<div class="tb-date">' +
                                    '<input type="date" name="start" value="' + start + '">' +
                                    '-' +
                                    '<input type="date" name="end" value="' + end + '">' +
                                '</div>' +
                            '</div>');

    activityElement.find('.close-btn').click((e) => {
        if (id && ($.inArray(id, deletedActivities) <= -1)) {
            deletedActivities.push(id);
        }

        activityElement.addClass('hide');
        console.log("DEBUG: Deleted");
        console.log(deletedActivities);
    });

    activityElement.css({
        'border-color' : Utils.hexToRGB ( legend.color, 0.4 ),
        'box-shadow' : '0 1px 5px ' + Utils.hexToRGB ( legend.color, 0.4 )
    });

    activityElement.find('label').css('color', Utils.pSBC( -0.4, legend.color ));
    activityElement.find('input').css('border-bottom-color', Utils.pSBC( -0.4, legend.color ));

    return activityElement;
}

// || Gantt Chart 

// Even Rows Background
let chartRows = $(".chart-row");

if (chartRows.length > 0) {
    for (let i = 0; i < chartRows.length; i++) {
        if (i % 2===0) {
            if (i !== 0) {
                $(chartRows[i]).css("background-color", "#EEF4ED");
                $(chartRows[i]).find(".chart-row-item").css("background-color", "#EEF4ED");
            }
        }
    }
}

// || Legend

// Legends form
function generateLegendForm() {
    let legend = $(
        '<div class="popup show popup-center popup-legend" id="legendPopup" data-legend="" tabindex="-1" aria-hidden="true">' +
            '<div class="pcontainer popup-sm">' +
                '<div class="pcontent">' +
                    '<div class="pheader">' +
                        '<h2 class="ptitle">Legend</h2>' +
                        '<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">' +
                            '<span class="material-icons">close</span>' +
                        '</button>' +
                    '</div>' +
        
                    '<div class="pbody">' +

                        '<div class="alert alert-danger" role="alert">' +
                            'A simple danger alert—check it out!' +
                        '</div>' +

                        '<div class="legend-preview">' +
                            '<span></span>' +
                            '<span id="color-preview"></span>' +
                            '<span></span>' +
                        '</div>' +

                        '<form id="legendForm">' +
                            '<div class="form-group">' +
                            '<label for="">Title</label>' +
                            '<input type="text"' +
                                'class="form-control" name="title" aria-describedby="helpId" placeholder="">' +
                            '</div>' +

                            '<label for="">Select a color</label>' +
                            '<div class="color-selection">' +
                                '<label for="row1.1" class="option-box">' +
                                '<input type="radio" name="color" id="row1.1"  value="#7bc86c" checked>' +
                                '</label>' +
                                '<label for="row1.2" class="option-box">' +
                                '<input type="radio" name="color" id="row1.2"  value="#f5dd29">' +
                                '</label>' +
                                '<label for="row1.3" class="option-box">' +
                                '<input type="radio" name="color" id="row1.3"  value="#ffaf3f">' +
                                '</label>' +
                                '<label for="row1.4" class="option-box">' +
                                '<input type="radio" name="color" id="row1.4"  value="#ef7564">' +
                                '</label>' +
                                '<label for="row1.5" class="option-box">' +
                                '<input type="radio" name="color" id="row1.5"  value="#cd8de5">' +
                                '</label>' +

                                '<label for="row2.1" class="option-box">' +
                                    '<input type="radio" name="color" id="row2.1"  value="#5aac44">' +
                                '</label>' +
                                '<label for="row2.2" class="option-box">' +
                                    '<input type="radio" name="color" id="row2.2"  value="#e6c60d">' +
                                '</label>' +
                                '<label for="row2.3" class="option-box">' +
                                    '<input type="radio" name="color" id="row2.3"  value="#e79217">' +
                                '</label>' +
                                '<label for="row2.4" class="option-box">' +
                                    '<input type="radio" name="color" id="row2.4"  value="#cf513d">' +
                                '</label>' +
                                '<label for="row2.5" class="option-box">' +
                                    '<input type="radio" name="color" id="row2.5"  value="#a86cc1">' +
                                '</label>' +

                                '<label for="row3.1" class="option-box">' +
                                    '<input type="radio" name="color" id="row3.1"  value="#5ba4cf">' +
                                '</label>' +
                                '<label for="row3.2" class="option-box">' +
                                    '<input type="radio" name="color" id="row3.2"  value="#29cce5">' +
                                '</label>' +
                                '<label for="row3.3" class="option-box">' +
                                    '<input type="radio" name="color" id="row3.3"  value="#6deca9">' +
                                '</label>' +
                                '<label for="row3.4" class="option-box">' +
                                    '<input type="radio" name="color" id="row3.4"  value="#ff8ed4">' +
                                '</label>' +
                                '<label for="row3.5" class="option-box">' +
                                    '<input type="radio" name="color" id="row3.5"  value="#344563">' +
                                '</label>' +

                                '<label for="row4.1" class="option-box">' +
                                    '<input type="radio" name="color" id="row4.1"  value="#026aa7">' +
                                '</label>' +
                                '<label for="row4.2" class="option-box">' +
                                    '<input type="radio" name="color" id="row4.2"  value="#00aecc">' +
                                '</label>' +
                                '<label for="row4.3" class="option-box">' +
                                    '<input type="radio" name="color" id="row4.3"  value="#4ed583">' +
                                '</label>' +
                                '<label for="row4.4" class="option-box">' +
                                    '<input type="radio" name="color" id="row4.4"  value="#e568af">' +
                                '</label>' +
                                '<label for="row4.5" class="option-box">' +
                                    '<input type="radio" name="color" id="row4.5"  value="#091e42">' +
                                '</label>' +
                            '</div>' +
                        '</form>' +
                    '</div>' +
        
                    '<div class="pfooter">' +
                        '<button type="submit" form="legendForm" class="btn action-btn">Save</button>' +
                        '<button type="button" class="btn danger-btn" data-action="delete" data-toggle="popup" data-type="delete">' +
                            'Delete' +
                        '</button>' +
                        '<button type="button" class="btn neutral-outline-btn" data-dismiss="popup">Cancel</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>'
    );

    legend.find('.option-box').each((index, element) => {
        $(element).css('background-color', $(element).find('input').val());
        $(element).find('input').on('change', (e) => {
            console.log("Input change");
            if (e.target.checked) {
                legend.find('#color-preview').css('background-color', $(e.target).val());
            }
        });
    });

    Popup.initialize(legend);

    return legend;
}

function buildLegendForm(legend = null) {  
    // let btn = $(e.target);
    let legendForm = generateLegendForm();

    console.log("Legend form");

    if (legend != null) 
    {   // Generate a legend form to edit
        console.log("Edit legend");
        console.log(legend);
        legendForm
            .attr('id', legend.id)
            .attr('data-legend', 'edit')
            .find('[name="title"]').val(legend.title);
        legendForm
            .find('[type="radio"][value="' + legend.color + '"]')
            .prop('checked', true)
            .trigger('change');

        // Submit action
        legendForm.find('#legendForm').on('submit', (e) => {
            e.preventDefault();

            // Requests to update a legend
            $.post(
                // Url
                Settings.base_url + "/legend/update", 
                // Data
                {
                    id : legend.id,
                    form : function () {return $(e.target).serialize();}
                },
                // On success
                function (response, textStatus) {
                    console.log("Update legend");
                    let jsonResponse = JSON.parse(response);
                    dimissLegend(legendForm, jsonResponse);
                }
            );
        });

        legendForm.find(".pfooter .btn.danger-btn").on('click', (e) => {
            // Requests to remove a legend
            $.post(
                // Url
                Settings.base_url + "/legend/remove", 
                // Data
                { id : legend.id },
                // On success
                function (response, textStatus) {
                    console.log("Remove legend");
                    let jsonResponse = JSON.parse(response);
                    dimissLegend(legendForm, jsonResponse);
                }
            );
        });
    }
    else 
    {   // Prepare a legend form to create
        console.log("Create legend");
        legendForm.find(".ptitle").text("Create legend");
        legendForm.find(".pfooter .btn.danger-btn").remove();

        // Submit action
        legendForm.find('#legendForm').on('submit', (e) => {
            e.preventDefault();

            // Requests to create a new legend
            $.post(
                // Url
                Settings.base_url + "/legend/new", 
                // Data
                { 
                    projId : projectId,
                    form : function () {return $(e.target).serialize();}
                },
                // On success
                function (newLegendResponse, textStatus) {
                    let jsonResponse = JSON.parse(newLegendResponse);

                    dimissLegend(legendForm, jsonResponse);
                }
            );
        });
    }

    // On dismiss, removes listeners
    legendForm.on('custom:dismissPopup', (e) => {
        console.log("Legend dismiss");
        legendForm.find('#legendForm').off('submit');
        legendForm.find('input').off('change');
        legendForm.find(".pfooter .btn.danger-btn").off('click');
    });

    $('body').append(legendForm);
    Popup.show(legendForm);
}

function dimissLegend(legendForm, response) {
    if (response.statusCode == 200) 
    {   // Dismiss legend's form and reload legends list on success
        legendForm.find('button[data-dismiss]').trigger('click');
        loadLegends($('.show #legends'), $('.show #taskActivities'));
        $('#taskPopup').trigger('custom:legendReload');
    }
    else
    {   // Shows alert on fail
        legendForm.find('.alert-danger')
            .addClass('show')
            .text(response.message);
    }
}

// Shows legends form
$("button[data-toggle='legend']").on('click', (e) => {
    buildLegendForm();
});

// Closes Menu when clicked anywhere
$(document).click((e) => {
    if (!$(e.target).is(".dots-menu")) {
        console.log("Not menu");
        closeMenu();
    }

    console.log("INFO: Clicked element: ");
    console.log(e.target);
});

// || Task Menu Functions

// Task Row
function renderTask(taskID, taskNumber) {
    return  '<tr id="taskID">' +
                '<th scope="row">' + taskNumber + '</th>' +
                '<td class="taskCell">' +
                    '<div class="form-input-group">' +
                        '<textarea oninput="autoHeight(this)" name="" rows="1" readonly></textarea>' +
                    '</div>' +
                '</td>' +
                '<td>' +
                    '<div class="form-input-group">' +
                        '<input type="date" name="" readonly>' +
                    '</div>' +
                '</td>' +
                '<td>' +
                    '<div class="form-input-group">' +
                        '<input type="date" name="" readonly>' +
                    '</div>' +
                '</td>' +
                '<td class="action-cell">' +
                    '<div class="action-cell-content">' +
                        '<div class="dots-menu">' +
                            '<button type="button" class="dots-menu-btn"><i class="fa-solid fa-ellipsis-vertical"></i></button>' +
                        '</div>' +
                    '</div>' +
                '</td>' +
            '</tr>';
}

// Generates new row
function generateRow(taskID, taskNumber) {
    let newRow = $(renderTask(taskID, taskNumber));

    // Listeners
    newRow
        .on('click', openTask)
        .find(".dots-menu-btn").on('click', showRowMenu);

    newRow.find(".dots-menu-btn").trigger('click');
    console.log("addRow");
    console.log(newRow.find("#editRow").trigger('click'));

    return newRow;
}

// Row Actions
function renderRowActions(rowID) {
    return '<span class="row-action-btns">' +
                '<button class="btn icon-btn neutral-btn" type="button">' +
                    '<span class="material-icons">cancel</span>' +
                '</button>' +
                '<button class="btn icon-btn" name="editTask" type="submit" value="' + rowID + '">' +
                    '<span class="material-icons success-text">check_circle</span>' +
                '</button>' +
            '</span>';
}

// Row Menu
function renderRowMenu(formId, isEdit) {
    return '<ul class="dots-menu-popup">' + 
                (
                    isEdit ? 
                    '<li id="saveRow" data-form="#' + formId + '">Save</li>' + 
                    '<li id="cancelRow">Cancel</li>' 
                    :
                    '<li id="editRow">Edit</li>' +
                    '<li id="removeRow">Remove</li>'
                ) +
                '<hr>' + 
                '<li class="add-task" data-position="subtask">Add sub task</li>' + 
                '<li class="add-task" data-position="top">Add task before</li>' + 
                '<li class="add-task" data-position="bottom">Add task after</li>' + 
            '</ul>';
}

// Closes Menu
function closeMenu(menu = $("div.dots-menu.active")) {
    console.log(menu.find(".dots-menu-popup").remove());
    console.log(menu.removeClass("active"));
}

// Shows Menu
function showRowMenu(e) {
    console.log("Menu");
    e.preventDefault();
    let menuBtn = $(e.target);
    let reClicked = $(".dots-menu.active").is(menuBtn.parent());
    console.log(menuBtn);

    if ($(".dots-menu.active").length > 0) {
        console.log("Menu is open");
        closeMenu();
    }

    if (!reClicked) {
        console.log("Parent");
        menuBtn.parent().addClass("active");
        menuBtn.after(renderRowMenu(menuBtn.closest("form").attr("id"), menuBtn.closest("tr").hasClass("edit")));

        console.log("Active Menu");
        let menu = menuBtn.parent();
        console.log(menu);

        menu.find("#saveRow").on('click', saveTask);
        menu.find("#cancelRow").on('click', closeEdit);
        menu.find("#editRow").on('click', editTask);
        menu.find("#removeRow").on('click', removeTask);
        menu.find("#saveRow").on('click', saveTask);
        menu.find('li.add-task').on('click', addTask);
    }

    e.stopPropagation();
}

// Add task on row
function addTask(e) {
    console.log("Add Task");
    e.preventDefault();
    let position = $(e.target).data("position");

    switch(position) {
        case "top":
            console.log($(e.target).closest("tr").before(renderTask('taskID', "-1")));
            break;
        case "bottom":
            console.log($(e.target).closest("tr").after(renderTask('taskID', "+1")));
            break;
        case "subtask":
            console.log($(e.target).closest("tr").after(renderTask('taskID', "")));
            break;
    }

    closeMenu()
    e.stopPropagation();
}

// Edits task
function editTask(e) {
    e.preventDefault();

    console.log("Edit row");
  
    let row = $(e.target).closest("tr");
    row.addClass("edit");
    row.find("textarea, input")
        .removeAttr("readonly")
        .click((event) => {event.stopPropagation();});

    row.find(".action-cell-content").append(renderRowActions(row.attr("id")));
    row.find('.neutral-btn').on('click', closeEdit);
    
    closeMenu($(e.target).closest('div.dots-menu.active'));
    e.stopPropagation();
}

// Closes task editting
function closeEdit(e) {
    console.log("Close edit");
    console.log(e.target);
    $(e.target).closest("tr")
        .removeClass("edit")
        .find("textarea, input")
            .off('click')
            .attr("readonly", true)
            .removeClass("edit")
        .closest("tr").find(".row-action-btns")
            .remove();

    closeMenu();
    e.stopPropagation();
}

// Saves task
function saveTask(e) {
    console.log("Save task");
    console.log("Submit using ajax");
    console.log($($(e.target).data("form")).submit());
}

// Removes task
function removeTask(e) {
    console.log("Remove this element");
    $(e.target).closest("tr").remove();

    closeMenu();
    e.stopPropagation();
}

// Open Task Bar details
function openTask(e) {
    console.log("Clicked open task");
    let selectedRow = $(e.target).closest('tr');
    let taskBar = $("#taskBar");

    if(!selectedRow.hasClass("active")) {
        let hasActiveRow = selectedRow.siblings(".active");
        if (hasActiveRow) {
            console.log(hasActiveRow.removeClass("active"));
            console.log("A row is active");
        }

        if (taskBar.hasClass("hide")) {
            console.log("Taskbar is inactive");
            console.log(selectedRow.addClass("active"));
            taskBar.removeClass("hide");
        }

        console.log("Showing");
        // taskBar.load("data.txt", {
        //     firstName: "Eli",
        //     lastName: "Lamzon"
        // }, () => {
        //     console.log("Open Task/Row Clicked");
        // });
        console.log(selectedRow.addClass("active"));
        
    } else {
        console.log("Hiding");
        console.log(selectedRow.removeClass("active"));
        taskBar.addClass("hide");
    }
}


// || Listeners
$("#tasksTable tbody tr").on('click', openTask);
$(".dots-menu-btn").on('click', showRowMenu);

// Adds new subtask of last row
$('#addSubTask').on('click', (e) => {
    console.log("Add Subtask");
    $($(e.target).data('target')).append(generateRow("taskID", ""));
});


// || Window
// Scroll
$(window).scroll(function(){
    console.log("Scroll");
    // Slide fixed stuff
    slideAutoHeight();
});

$(window).on("resize", (e) => {
    if ($(this).width() >= 992) {
        resizeCollapse(false);
        $('#sideCollapse').css('height', ''); 
    }
});




// Gannt Chart
function loadGanttChart() {
    console.log("Load gantt chart");
    let ganttChart = $('.gantt-chart');
    let chartX = ganttChart.scrollLeft();
    let chartY = ganttChart.scrollTop();
    $.get(
        Settings.base_url + "/task/chart",
        {projId : projectId},
        function (data, textStatus) {
            resetGanttChart();

            let response = JSON.parse(data);
            let rowHead = '250px';
            let startDate = new Date(response.data.start).getDate();
            let monthStart = 1;

            // Chart Header
            for (let i = 0; i < response.data.header[0].length; i++) {
                const days = response.data.header[1][i];

                // Months
                let monthGrid = $('<span class="chart-month">' + (new Date(response.data.header[2][i], response.data.header[0][i], 0)).toLocaleString("default", { month: 'long' }) + '</span>');
                monthGrid.css('grid-column', monthStart + ' / span ' + days);
                $('.chart-months').append(monthGrid);
                
                // Days
                for (let j = 1; j <= days; j++) {
                    $('.chart-days').append('<span>' + startDate++ + '</span>');
                }
                
                startDate = 1;
                monthStart += days;

            }


            response.data.content.forEach(task => 
                {
                let taskBar = generateGanttRow(task);
                let bars = taskBar.find('.chart-row-bars');

                task.activity.forEach(activity => 
                    {   // Generates gantt charts bars
                    let bar = $('<li title="' + activity.title + '"></li>');

                    bar.css({
                        'grid-column' : activity.grid + ' / span ' + activity.span,
                        'background-color' : activity.color
                    });

                    bars.append(bar);
                });

                //     let end = new Date(activity.end);
                //     let start = new Date(activity.start);

                //     // Span of width of grid item
                //     let span = (end - start) / (1000*60*60*24) + 1;
                    

                //     if (projectStart === 0) {
                //         projectStart = start;
                //     }

                //     projectEnd = end;

                //     if ($.inArray(start.getMonth(), months[0]) < 0) {
                //         months[0].push(start.getMonth());
                //         months[1].push(start.getFullYear());
                //     } else {
                //         console.log("Nandun na start");
                //     }

                //     if ($.inArray(end.getMonth(), months[0]) < 0) {
                //         months[0].push(end.getMonth());
                //         months[1].push(end.getFullYear());
                //     } else {
                //         console.log("Nandun na end");
                //     }

                //     let grid = (start - projectStart) / (1000*60*60*24);

                //     lastGrid = (grid === 0) ? 1 : grid+1;

                //     let parsedDate = String(lastGrid) + ' / span ' + String(span > 0 ? span : 1);
                //     bar.css({
                //         'grid-column' : parsedDate,
                //         'background-color' : activity.color
                //     });

                //     bars.append(bar);
                // });

                $('.chart-body').append(taskBar);
                
            });

            $('.chart-months, .chart-days, .gantt-chart .chart-row-bars').css(
                'grid-template-columns', 'repeat(' + response.data.total_days + ', minmax(var(--chart-grid-width), 1fr))'
            );

            $('.chart-lines').css(
                'grid-template-columns', rowHead + ' repeat(' + response.data.total_days + ', 1fr)'
            );

            
            // Chart lines
            let day = new Date(response.data.start).getDay() - 1;
            
            for (let j = 0; j < response.data.total_days; j++) {
                let line = $('<span></span>');

                if (day === 0) {line.addClass('sunday');}
                $('.chart-lines').append(line);
                
                day++;
                if (day === 7) {day = 0;}
            }
            
            // Sets scroll position to last scrolls' positions :>
            ganttChart.scrollLeft(chartX);
            ganttChart.scrollTop(chartY);

            ganttChart.trigger('custom:ready');
        }
    );
}

function resetGanttChart() {  
    $('.chart-months, .chart-days, .gantt-chart .chart-row-bars').css('grid-template-columns', '');
    // $('.chart-lines').css('grid-template-columns', '');
    $('.chart-months').empty();
    $('.chart-days').empty();
    $('.chart-lines').empty();
    $('.chart-body')
        .empty()
        .append('<div class="chart-lines"></div>');
}

function buildGanttChart() {  
    loadGanttChart();
    loadLegends($('.legends-container'));

    ganttChartInterval = setInterval(() => {
        loadGanttChart();
        loadLegends($('.legends-container'));
    }, 5000);
}

let ganttChartInterval;

buildGanttChart();

// loadGanttChart();
// loadLegends($('.legends-container'));

// let ganttChartInterval = setInterval(() => {
//     loadGanttChart();
//     loadLegends($('.legends-container'));
// }, 5000);


//create the function getNumberOfDays with getDate() method
function getNumberOfDays (month, year) {
    return new Date(year, month + 1, 0).getDate();
}

$('.gantt-chart').on('custom:ready', (e) => {
    $('#projectGanttChart .spinner').hide();
    $('.chart-container').css('visibility', 'visible');
});

function generateGanttRow(task) {  
    // console.log(task.plan_start);
    // console.log(new Date(task.plan_end) - new Date(task.plan_start));
    // console.log((new Date(task.plan_end) - new Date(task.plan_start)) / (1000*60*60*24));
    // console.log((1000*60*60*24));
    return $(
        '<div class="chart-row">' +
            '<div class="chart-row-item task-name">' +
                '<strong class="task-number">' + parseFloat(task.order_no) + '</strong>' +
                task.description +
            '</div>' +
            '<ul class="chart-row-bars"></ul>' +
        '</div>'
    );
}


// || Project info
let infoInterval;

// Gets project info from the server
function loadProjectInfo() {  
    console.log("Load project info");
    $.get(
        Settings.base_url + "/project/get",
        {projId : projectId},
        function (data, textStatus) {
            console.log(data);
            let response = JSON.parse(data);

            if (response.hasOwnProperty('data')) {
                console.log(response.data);
                let project = response.data;
                let form = $('#projectDetailForm');
                form.find('[name="id"]').val(project.id);
                form.find('[name="purchaseOrd"]').val(project.purchase_ord);
                form.find('[name="awardDate"]').val(project.award_date);
                form.find('[name="description"]').val(project.name);
                form.find('[name="buildingNo"]').val(project.building_number);
                form.find('[name="location"]').val(project.location);
                form.find('[name="company"]').val(project.company);
                form.find('[name="representative"]').val(project.comp_representative);
                form.find('[name="contact"]').val(project.comp_contact);
            }
        }
    );
}

// Project info toggle actions
$('#projectInfoToggller').on('click', (e) => {
    console.log("Info clicked");

    infoInterval = setInterval(() => {
        loadProjectInfo();
    }, 5000);

    // Removes refresh when editing
    $('#projectDetailForm').on('custom:edit', (e) => {
        console.log("Edit event");
        clearInterval(infoInterval);
    });

    $('#projectInfo').find('button[data-dismiss="slide"]').on('click', (e) => {
        clearInterval(infoInterval);
    });

    // Reapply refresh when done editing
    $('#projectDetailForm').on('custom:readOnly', (e) => {
        console.log("Read only");
        infoInterval = setInterval(() => {
            loadProjectInfo();
        }, 5000);
    });
});

// Project details actions
$('#projectDetailForm').on('submit', (e) => {
    e.preventDefault();
    console.log("Submit project");

    $.post(
        Settings.base_url + "/project/update",
        {form : function () {return $(e.target).serialize();}},
        function (response, textStatus, jqXHR) {
            console.log("Project Update Response");
            console.log(response);
            let data = JSON.parse(response);
            if (data.statusCode != 200) 
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
$('#projectInfo').find('.delete-btn').click(() => {
    console.log("Delete project");
    // deleteTask(popup, rowData.id, dt);
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
                if (jsonData.statusCode == 200) 
                {   // Dismiss delete popup and redirect to projects list on success
                    console.log("Success delete");
                    deletePopup.find('button[data-dismiss]').trigger('click');

                    window.location.href =  Settings.base_url + '/project';
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



// Resource popup
// Timeline datatable settings
$('button[data-target="#projectResources"]').on('click', (e) => {
    console.log("Show resources");

    // Clears declared interval
    // clearInterval(ganttChartInterval);
    // resetGanttChart();

    // Initializes resource table's datatable
    // let resourceTable = $("#resourceTable").DataTable(resourceSettings);

    // let resourceInterval = setInterval(() => {
    //     console.log("Resource interval");
    //     resourceTable.ajax.reload(null, false);
    // }, 3000);


    // $("#resourceTable").on( 'destroy.dt', function ( e, settings ) {
    //     console.log("Resource Destroy");
    //     $(this).find('tbody').off( 'click', 'tr' );
    //     clearInterval(resourceInterval);
    // });
});

let datatableSettings = {
    resourceTable : {
        'dom' : '<"mesa-container"t><"linear"ip>',
        "autoWidth": false,
        "lengthChange": false,
        'paging' : true,
        'sort' : false,
    
        "ajax" : {
            url : Settings.base_url + "/resource/list",
            type : 'GET',
            data : {projId : projectId}
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
                        {form : function () {return $(e.target).serialize();}},
                        function (data, textStatus) {
                            console.log(data);
                            console.log("Edit Response");
                            let response = JSON.parse(data);
                            console.log(response);

                            if (response.statusCode == 200) 
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
    }
};

// When navigation tab change actions
$('.nav-tab').on('custom:tabChange', (e, tab, target) => {
    console.log("Tab changed");

    clearInterval(ganttChartInterval);
    resetGanttChart();
    
    if (target !== '#projectGanttChart') 
    {   
        let table; 
        // Clears gantt chart settings
        table = $(target).find('table');

        // Initializes resource table's datatable
        let datatable = table.DataTable(datatableSettings[table.attr('id')]);

        // Incrementing number of table rows
        datatable.on('order.dt search.dt', function () {
            let i = 1;
            datatable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                this.data(i++);
            });
        }).draw();

        let dtInterval = setInterval(() => {
            console.log("General datable interval");
            datatable.ajax.reload(null, false);
        }, 3000);

        // On datatable destoy actions
        datatable.on( 'destroy.dt', function ( e, settings ) {
            console.log("Datable destroy");
            $(this).find('tbody').off( 'click', 'tr' );
            clearInterval(dtInterval);
        });

        // On tab hide actions
        $(target).on('custom:hide', (e) => {
            console.log("Hiding");
            datatable.destroy();
        });
    } else {
        buildGanttChart();
    }
});

function buildResourcePopup() {
    console.log("Build resource popup");
    let popup = $('#resourcePopup');

    // Preps resource form
    resetResourcePopup(popup);

    // Computes total
    popup.find('[name="quantity"], [name="price"]').on('keyup', (e) => {
        console.log("Key press");
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
    
    popup.find('#itemForm').on('submit', (e) => {
        e.preventDefault();
        console.log("Submit resource");

        $.post(
            Settings.base_url + "/resource/new",
            {form : function () {return $(e.target).serialize();}},
            function (data, textStatus) {
                console.log(data);
                console.log("Add Response");
                let response = JSON.parse(data);
                console.log(response);

                if (response.statusCode == 200) 
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

    popup.find('.pfooter .btn.delete-btn').hide();
    Popup.show(popup);
});

