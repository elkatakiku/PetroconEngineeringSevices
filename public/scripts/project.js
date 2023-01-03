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

function loadLegends(legends, activities) {
    legends.trigger('custom:reload');
    
    $.get(
        Settings.base_url + "/legend/list", 
        { id : projectId },
        function (response) {
            console.log("Legend response");
            console.log(response);
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

            activities.append(generateTaskActivity(
                legendData,
                currentDate, 
                currentDate,
                '')
            );
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
        url : Settings.base_url + "/task/list",
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
                        // console.log(response);
                        // $('#samp').html(response);
                        let data = JSON.parse(response);
                        // console.log(data);
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

            // Finally shows popup
            Popup.showPopup(popup);
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

    Popup.showPopup(deletePopup);
}

// Shows timeline
$('#timelineToggler button').click((e) => {
    $('.timeline').animate({
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
    $('.timeline').animate({
        'margin-left' : '-100%'
    }, 300, "swing");

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
    popup.find('.pfooter .btn.danger-btn').remove();
    Popup.showPopup(popup);

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

// New Row
$('form[data-row]').submit((e) => {
    e.preventDefault();

    $.post(
        // Url
        Settings.base_url + "/project/newTask", 
        // Data
        { 
            projId : projectId,
            form : function () {return $(e.target).serialize();}
        },
        // On success
        function (data, textStatus) {
            let jsonData = JSON.parse(data);
            
            if (jsonData.statusCode != 200) {
                $(e.target).find('.alert').html(jsonData.message);
            }
            console.log(textStatus);

            tasksTable.ajax.reload(null, false);
            $(e.target)[0].reset();
        }
    );
});

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
    Popup.showPopup(legendForm);
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

// Adds new task row on table
// $("button[data-toggle='row']").on('click', function (e) {
//     console.log("Add row");
//     $($(this).data('target')).append(generateRow("taskID", "#"));
//     e.stopPropagation();
// });

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
$.get(
    Settings.base_url + "/task/list",
    {projId : projectId},
    function (data, textStatus, jqXHR) {
        console.log(data);
    }
);