$('#newProject').on('submit',function (e)
{
    e.preventDefault();

    $.post(
        Settings.base_url + "/project/newProject",
        { form : function () {return $(e.target).serialize();} },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);

            // Shows alert/error message
            if (jsonData.statusCode !== 200) {
                $(e.target).find('.alert-danger')
                .addClass('show')
                .text(jsonData.message);
            } else {
                window.location.href = Settings.base_url + "/project/details/" + jsonData.data;
            }
        }
    );
});

let description = $('[name="taskDescription"]');
let start = $('[name="start"]');
let end = $('[name="end"]');

let taskForm = $('#taskForm');
let tasks = $('#tasksTable');

console.log("Validity");
$('#addTask').on('click', (e) => {
    if (taskForm[0].reportValidity()) {
        console.log(description.val());
        console.log(start.val());
        console.log(end.val());

        let task = $(
            '<tr>' +
            '<td>'+description.val()+'</td>' +
            '<td style="white-space: nowrap">'+
            new Date(start.val()).toLocaleString('default', {dateStyle : "medium"})+'</td>' +
            '<td style="white-space: nowrap">'+
            new Date(end.val()).toLocaleString('default', {dateStyle : "medium"})+'</td>' +
            '</td>' +
            '<td><button class="btn danger-btn delete-btn">Remove</button></td>' +
            '</tr>'
        );

        task.find('.delete-btn').on('click', removeTask);

        tasks.find('tbody').prepend(task);

        taskForm[0].reset();
    }

    tasks.trigger('custom:update');
});

$('.delete-btn').on('click', removeTask);

function removeTask(e) {
    $(e.target).parents('tr').remove();
    tasks.trigger('custom:update');
}

tasks.on('custom:update', (e) => {
    let body = $(e.target).find("tbody");
    if (body.children().length === 0) {
        body.addClass('empty-table');
        body.append(
            '<tr class="empty-table">' +
            '<td colspan="4" class="text-center" style="color: gray">No tasks added.</td>' +
            '</tr>');
    } else {
        body.removeClass('empty-table');
        body.find('.empty-table').remove();
    }
})

let completion = $('.completion-btn');
completion.on('click', (e) =>
{

    let project = $('#newProject').serialize();
    let taskData = [];
    let body = tasks.find('tbody');
    console.log(body.hasClass('empty-table'));
    if (!body.hasClass('empty-table'))
    {
        let tr = body.children();
        tr.each((index, element) =>
        {
            let td = $(element).children();
            let taskDataRow = [];
            td.each((index1, element1) =>
            {
                if (index1 !== (td.length - 1)) {
                    console.log($(element1).text());
                    taskDataRow.push($(element1).text());
                }
            });

            console.log(taskDataRow)
            taskData.push(JSON.stringify(taskDataRow))
        });

        console.log(taskData)

        console.log(JSON.stringify(taskData))


        $.get(
            Settings.base_url + "/project/completion",
            {
                project : function () {return $('#newProject').serialize();},
                task : JSON.stringify(taskData)
            },
            function (data) {
                console.log(data);
                let jsonData = JSON.parse(data);

                window.open("https://www.geeksforgeeks.org");
                //
                // // Shows alert/error message
                // if (jsonData.statusCode !== 200) {
                //     $(e.target).find('.alert-danger')
                //         .addClass('show')
                //         .text(jsonData.message);
                // } else {
                //     window.location.href = Settings.base_url + "/project/details/" + jsonData.data;
                // }
            }
        );
    }

});

// let actsArr = [];
//
// let activity = $(element);
// let actObj = {};
//
// console.log("Element");
// console.log(activity);
// if (!isNew) {
//     actObj['id'] = activity.attr('id');
// }
// actObj['legendId'] = activity.find('[name="legendId"]').val();
// actObj['start'] = activity.find('[name="start"]').val();
// actObj['end'] = activity.find('[name="end"]').val();
// console.log(actObj);
//
// actsArr.push(JSON.stringify(actObj));
//
// let formData = {
//     id : form.find('input[name="id"]').val(),
//     projId : projectId,
//     description : form.find('[name="taskDesc"]').val()
// };
//
//
//
// // Gets old activities data
// let oldActivities = [];
//
// form
//     .find('#taskActivities')
//     .children()
//     .each((index, element) => {
//         getActivityData(element, oldActivities);
//     });
//
// formData['oldActivities'] = oldActivities;
//
// // Gets new activities data
// let newActivities = [];
//
// form
//     .find('#newActivities')
//     .children('div:not(.hide)')
//     .each((index, element) => {
//         getActivityData(element, newActivities, true);
//     });
//
// formData['newActivities'] = newActivities;
//
// // Returs a json format form data
// return JSON.stringify(formData);