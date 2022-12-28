// Extension

// Color shade changer
const pSBC=(p,c0,c1,l)=>{
	let r,g,b,P,f,t,h,i=parseInt,m=Math.round,a=typeof(c1)=="string";
	if(typeof(p)!="number"||p<-1||p>1||typeof(c0)!="string"||(c0[0]!='r'&&c0[0]!='#')||(c1&&!a))return null;
	if(!this.pSBCr)this.pSBCr=(d)=>{
		let n=d.length,x={};
		if(n>9){
			[r,g,b,a]=d=d.split(","),n=d.length;
			if(n<3||n>4)return null;
			x.r=i(r[3]=="a"?r.slice(5):r.slice(4)),x.g=i(g),x.b=i(b),x.a=a?parseFloat(a):-1
		}else{
			if(n==8||n==6||n<4)return null;
			if(n<6)d="#"+d[1]+d[1]+d[2]+d[2]+d[3]+d[3]+(n>4?d[4]+d[4]:"");
			d=i(d.slice(1),16);
			if(n==9||n==5)x.r=d>>24&255,x.g=d>>16&255,x.b=d>>8&255,x.a=m((d&255)/0.255)/1000;
			else x.r=d>>16,x.g=d>>8&255,x.b=d&255,x.a=-1
		}return x};
	h=c0.length>9,h=a?c1.length>9?true:c1=="c"?!h:false:h,f=pSBCr(c0),P=p<0,t=c1&&c1!="c"?pSBCr(c1):P?{r:0,g:0,b:0,a:-1}:{r:255,g:255,b:255,a:-1},p=P?p*-1:p,P=1-p;
	if(!f||!t)return null;
	if(l)r=m(P*f.r+p*t.r),g=m(P*f.g+p*t.g),b=m(P*f.b+p*t.b);
	else r=m((P*f.r**2+p*t.r**2)**0.5),g=m((P*f.g**2+p*t.g**2)**0.5),b=m((P*f.b**2+p*t.b**2)**0.5);
	a=f.a,t=t.a,f=a>=0||t>=0,a=f?a<0?t:t<0?a:a*P+t*p:0;
	if(h) {
        return "rgb"+(f?"a(":"(")+r+","+g+","+b+(f?","+m(a*1000)/1000:"")+")";
    }
	else {
        return "#"+(4294967296+r*16777216+g*65536+b*256+(f?m(a*255):0)).toString(16).slice(1,f?undefined:-2);
    }
}

// Convert hex to rgb
function hexToRGB(hex, alpha) {
    var r = parseInt(hex.slice(1, 3), 16),
        g = parseInt(hex.slice(3, 5), 16),
        b = parseInt(hex.slice(5, 7), 16);

    if (alpha) {
        return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
    } else {
        return "rgb(" + r + ", " + g + ", " + b + ")";
    }
}


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

// Timeline
$('#timelineToggler button').click((e) => {
    $('.timeline').animate({
        'margin-left' : '0'
    }, 300, "swing");
});

$('.timeline header .back-btn').click((e) => {
    $('.timeline').animate({
        'margin-left' : '-100%'
    }, 300, "swing");
});

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
                console.log("TD");
                console.log(td);
                console.log("Cell data");
                console.log(cellData);
                $(td).addClass('taskCell');
            }
        }
    ],
    
    order: [
        [0, 'asc']
    ]
}

// Tasks Table
let tasksTable = $(table).DataTable(dtTable);

// Generate Activity
function generateTaskActivity(activity, color, start, end, newAct = false) {  
    let activityElement = $('<div class="form-input-group task-activity">' +
                                '<span class="linear-label">' +
                                    '<label for="">' + activity + '</label>' +
                                    (newAct ?
                                        '<button type="button" class="icon-btn close-btn" data-dismiss="activity" aria-label="Close">' +
                                            '<span class="material-icons">close</span>' +
                                        '</button>'
                                        :
                                        ''
                                    ) +
                                '</span>' +
                                '<div class="tb-date">' +
                                    '<input type="date" name="planStart" id="" value="' + start + '">' +
                                    '-' +
                                    '<input type="date" name="planEnd" id="" value="' + end + '">' +
                                '</div>' +
                            '</div>');

    activityElement.find('.close-btn').click((e) => {
        console.log("Close activity");
        activityElement.remove();
    });

    activityElement.css({
        'border-color' : hexToRGB ( color, 0.4 ),
        'box-shadow' : hexToRGB ( color, 0.4 )
    });

    activityElement.find('label').css('color', pSBC(-0.4, color));
    activityElement.find('input').css('border-bottom-color', pSBC(-0.4, color));

    return activityElement;
}

// Ajax response callback
unction loadActivities(id, activities) { 
    $.get(
        Settings.base_url + "/projects/taskActivities", 
        {taskId : id},
        function (data, status) {
            activities.empty();
    
            let jsonResponse = JSON.parse(data);

            for (let i = 0; i < jsonResponse.data.length; i++) {
                const activity = jsonResponse.data[i];
                activities.append(generateTaskActivity(
                    activity.title, 
                    activity.color, 
                    activity.start, 
                    activity.end
                ));
            }


        }
    );
}

function loadLegends(activities, legends) {
    $.get(
        Settings.base_url + "/projects/legends", 
        {id : projectId},
        function (response) {
            let jsonResponse = JSON.parse(response);
            if (jsonResponse.statusCode == 200) {

                legends.empty();

                for (let i = 0; i < jsonResponse.data.length; i++) {
                    const legendData = jsonResponse.data[i];

                        // console.log(legendData);
                        // console.log(legendData.color);

                    const legend = $('<div class="task-legend">' +
                                        '<span class="leg-color" data-color="' + legendData.color + '"></span>' +
                                        '<span class="leg-title">' + legendData.title + '</span>' +
                                        '<button class="btn icon-btn leg-edit" data-toggle="legend" data-target="' + legendData['id'] + '">' +
                                            '<span class="material-icons">edit</span>' +
                                        '</button>' +
                                    '</div>');

                    // console.log("Colors");
                    // console.log(legend.find('.leg-color').data('color'));
                    // console.log(pSBC(-0.4, legend.find('.leg-color').data('color')));
                    // console.log(hexToRGB ( color, 0.3 ));
                            
                    legend
                        .find('.leg-color, .leg-title')
                        .css('background-color', legend.find('.leg-color').data('color'))
                        .click((e) => {
                            let date = new Date();
                            let currentDate =   date.getFullYear() + '-' +
                                                ((date.getMonth() + 1) < 10 ? '0' : '') + (date.getMonth() + 1) + '-' +
                                                (date.getDay() < 10 ? '0' : '') + date.getDay();

                            activities.append(generateTaskActivity(
                                legendData.title, 
                                legendData.color, 
                                currentDate, 
                                currentDate,
                                true)
                            );
                        });

                    legends.append(legend);
                }
            }
        }
    );
}

// Row click. Open task activities
$(table + ' tbody').on('click', 'tr', function (e) {
    let rowData = tasksTable.row(this).data();

    // console.log("Row data");
    // console.log(rowData);
    // console.log("id");
    // console.log(rowData.id);
    
    // console.log("This");
    // console.log(this);
    // console.log("Row cells");
    // console.log(tasksTable.cells(this, null).render('display'));

    let rowDisplay = tasksTable.cells( this, '' ).render( 'display' );    
    let popup = $('#taskPopup');

    popup.find('.pmain .ptitle').text('Task ' + rowDisplay[0]);
    popup.find('.pmain textarea[name="taskDesc"]').val(rowDisplay[1]);

    let activities = popup.find('#taskActivities');
    activities.empty();
    let newActivities = popup.find('#newActivities');
    newActivities.empty();

    // Get task activities
    loadActivities(rowData.id, activities);
    // Refresh Activities
    setInterval(() => {
        console.log("Activities reload");
        loadActivities(rowData.id, activities);
    }, 3000);

    $('#legends').empty();

    // Get project legends
    loadLegends(newActivities, $('#legends'));
    // Refresh legends
    setInterval(() => {
        console.log("Legends reload");
        loadLegends(newActivities, $('#legends'));
    }, 3000);
   
    showPopup(popup);
});

$('#addTask').click((e) => {
    console.log("Add task");
    console.log(e.target);
    let btn = $(e.target);
    // console.log($(btn.data('target')));
    $(btn.data('target')).parent().removeClass('hide');
    // btn.parent('.table-action-row').addClass('hide');
});

function hideAddRow(e) {  
    console.log("Hide row");
    let form = '';
    if ($(e.target).is('form[data-row]')) {
        form = $(e.target);
    } else {
        form = $(e.target).parents('form[data-row]');
    }
    $(form.data('row')).find('.table-action-row').removeClass('hide');
    form.addClass('hide');
}

// New Row
$('form[data-row]').submit((e) => {
    e.preventDefault();

    $.post(
        // Url
        Settings.base_url + "/projects/newTask", 
        // Data
        { 
            projId : projectId,
            form : function () {return $(e.target).serialize();}
        },
        // On success
        function (data, textStatus) {
            console.log(data);
            console.log(JSON.parse(data));
            let jsonData = JSON.parse(data);
            
            if (jsonData.statusCode != 200) {
                $(e.target).find('.alert').html(jsonData.message);
            } else {
                hideAddRow(e);
            }
            console.log(textStatus);

            tasksTable.ajax.reload(null, false);
            $(e.target)[0].reset();
        }
    );
});

$('form[data-row] .neutral-btn').click(hideAddRow);

$('form[data-row] button[type="submit"]').click((e) => {
    e.preventDefault();

    console.log("Add new task");

    $(e.target).parents('form[data-row]').submit();
});

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
                                            '<input type="radio" name="color" id="row1.1"  value="#7bc86c">' +
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

    legendForm.find('#legendForm').submit((e) => {
        e.preventDefault();

        $.post(
            // Url
            Settings.base_url + "/projects/newLegend/" + projectId, 
            // Data
            { 
                projId : projectId,
                form : function () {return $(e.target).serialize();}
            },
            // On success
            function (newLegendResponse, textStatus) {
                console.log("Raw Response legeneds");
                console.log(newLegendResponse);
                let jsonResponse = JSON.parse(newLegendResponse);
                console.log("Response legeneds");
                console.log(jsonResponse.statusCode);

                if (jsonResponse.statusCode == 200) {
                    legendForm.find('button[data-dismiss]').trigger('click');
                    loadLegends(jsonResponse, $('.show #taskActivities'), $('.show #legends'));
                } else {
                    legendForm.find('.alert-danger')
                        .addClass('show')
                        .text(jsonResponse.message);
                }

                // Get project legends
                $.get(
                    Settings.base_url + "/projects/legends", 
                    {id : projectId},
                    function (response) {
                        if (jsonResponse.statusCode == 200) {
                            legendForm.find('button[data-dismiss]').trigger('click');
                            loadLegends(jsonResponse, $('.show #taskActivities'), $('.show #legends'));
                        } else {

                        }
                    }
                );
                // console.log(JSON.parse(data));
                // let jsonData = JSON.parse(data);
                
                // if (jsonData.statusCode != 200) {
                //     $(e.target).find('.alert').html(jsonData.message);
                // } else {
                //     hideAddRow(e);
                // }
                // console.log(textStatus);
    
                // tasksTable.ajax.reload(null, false);
                // $(e.target)[0].reset();
            }
        );
    });

    // console.log(legendForm);
    $('body').append(legendForm);
    showPopup(legendForm);
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