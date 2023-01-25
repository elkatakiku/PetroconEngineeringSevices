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
        taskBar.load("data.txt", {
            firstName: "Eli",
            lastName: "Lamzon"
        }, () => {
            console.log("Open Task/Row Clicked");
            console.log(selectedRow.addClass("active"));
        });
        
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