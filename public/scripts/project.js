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

// || Task
console.log("Project Id");
console.log(projectId);
let table = "#tasksTable";

let dtTable = {
    'dom' : '<"mesa-container"t>p',
    "autoWidth": false,
    "lengthChange": false,
    'paging' : false,
    'sort' : false,
    'searching' : false,
    'info' : false,
    "ajax" : Settings.base_url + "/projects/timeline/" + projectId,
    "columns" : [
        {'data' : 'order_no'}, 
        {'data' : 'description'}, 
        {'data' : 'start'},
        {'data' : 'end'},
        {'defaultContent' : ''}
    ],
    
    order: [
        [1, 'asc']
    ]
}

// Tasks Table
let tasksTable = $(table).DataTable(dtTable);


$('#newTask').submit((e) => {
    // e.preventDefault();

});

console.log("Create Task");
console.log($('[name="createTask"]').click((e) => {
    // e.preventDefault();
    $('#newTask').submit();
}));

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
// Add Legend Click Event
$("#addLegend").click(function (e) { 
    e.preventDefault();
    $("#legends").toggleClass("hide");
});

function generateLegendForm(legendID = "legendPopup") {
    let legend =    $('<div class="popup show popup-center" id="legendPopup" data-legend="' + legendID + '" tabindex="-1" aria-hidden="true">' +
                        '<div class="pcontainer popup-sm">' +
                            '<div class="pcontent">' +
                                '<div class="pheader">' +
                                    '<h2 class="ptitle">Legend</h2>' +
                                    '<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">' +
                                        '<span class="material-icons">close</span>' +
                                    '</button>' +
                                '</div>' +
                    
                                '<div class="pbody">' +
                                    '<div class="legend-preview">' +
                                        '<span></span>' +
                                        '<span id="color-preview"></span>' +
                                        '<span></span>' +
                                    '</div>' +

                                    '<form action=".?action=create" method="POST" id="legendForm">' +
                                        '<div class="form-group">' +
                                        '<label for="">Title</label>' +
                                        '<input type="text"' +
                                            'class="form-control" name="" id="" aria-describedby="helpId" placeholder="">' +
                                        '</div>' +

                                        '<label for="">Select a color</label>' +
                                        '<div class="color-selection">' +
                                            '<label for="row1.1" class="option-box">' +
                                            '<input type="radio" name="legendColor" id="row1.1"  value="#7bc86c">' +
                                            '</label>' +
                                            '<label for="row1.2" class="option-box">' +
                                            '<input type="radio" name="legendColor" id="row1.2"  value="#f5dd29">' +
                                            '</label>' +
                                            '<label for="row1.3" class="option-box">' +
                                            '<input type="radio" name="legendColor" id="row1.3"  value="#ffaf3f">' +
                                            '</label>' +
                                            '<label for="row1.4" class="option-box">' +
                                            '<input type="radio" name="legendColor" id="row1.4"  value="#ef7564">' +
                                            '</label>' +
                                            '<label for="row1.5" class="option-box">' +
                                            '<input type="radio" name="legendColor" id="row1.5"  value="#cd8de5">' +
                                            '</label>' +

                                            '<label for="row2.1" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row2.1"  value="#5aac44">' +
                                            '</label>' +
                                            '<label for="row2.2" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row2.2"  value="#e6c60d">' +
                                            '</label>' +
                                            '<label for="row2.3" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row2.3"  value="#e79217">' +
                                            '</label>' +
                                            '<label for="row2.4" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row2.4"  value="#cf513d">' +
                                            '</label>' +
                                            '<label for="row2.5" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row2.5"  value="#a86cc1">' +
                                            '</label>' +

                                            '<label for="row3.1" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row3.1"  value="#5ba4cf">' +
                                            '</label>' +
                                            '<label for="row3.2" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row3.2"  value="#29cce5">' +
                                            '</label>' +
                                            '<label for="row3.3" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row3.3"  value="#6deca9">' +
                                            '</label>' +
                                            '<label for="row3.4" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row3.4"  value="#ff8ed4">' +
                                            '</label>' +
                                            '<label for="row3.5" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row3.5"  value="#344563">' +
                                            '</label>' +

                                            '<label for="row4.1" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row4.1"  value="#026aa7">' +
                                            '</label>' +
                                            '<label for="row4.2" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row4.2"  value="#00aecc">' +
                                            '</label>' +
                                            '<label for="row4.3" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row4.3"  value="#4ed583">' +
                                            '</label>' +
                                            '<label for="row4.4" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row4.4"  value="#e568af">' +
                                            '</label>' +
                                            '<label for="row4.5" class="option-box">' +
                                                '<input type="radio" name="legendColor" id="row4.5"  value="#091e42">' +
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
                    '</div>');

    legend.find('.option-box').each((index, element) => {
        $(element).css('background-color', $(element).find('input').val());
        $(element).find('input').change((e) => {
            console.log("Input change");
            if (e.target.checked) {
                $('#color-preview').css('background-color', $(e.target).val());
            }
        });
    });

    initializePopup(legend);

    return legend;
}

$("button[data-toggle='legend']").on('click', (e) => {
    console.log("Legend button");
    let btn = $(e.target);
    let legendForm = generateLegendForm();

    console.log(btn);
    console.log(legendForm);

    if (btn.data("target") != null) {
        console.log("Target is not null");
        console.log(btn.data("target"));
        legendForm = $(generateLegendForm(btn.data("target")));
        legendForm.attr('data-legend', 'edit' );

    } else {
        legendForm.find(".ptitle").text("Create legend");
        legendForm.find(".pfooter .btn.danger-btn").remove();
    }

    console.log(legendForm);
    $('body').append(legendForm);
    showPopup(btn, legendForm);
});

$('.task-legend').each((index, element) => {
    console.log("Task Legend");
    let color = $(element).find('.leg-color');
    console.log(color.css('background-color', color.data('color')));
    $(element).find('.leg-title').css('background-color', color.data('color'));

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
$("button[data-toggle='row']").on('click', function (e) {
    console.log("Add row");
    $($(this).data('target')).append(generateRow("taskID", "#"));
    e.stopPropagation();
});

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
