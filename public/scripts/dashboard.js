function loadBarChart()
{
    $.get(
        Settings.base_url + "/dashboard/projectsCountByYear", 
        { year : function () {return $(e.target).serialize();} },
        function (data, textStatus) {
            console.log(data);
            let jsonData = JSON.parse(data);

            // Shows alert/error message
            if (jsonData.statusCode != 200) {
                $(e.target).find('.alert-danger')
                .addClass('show')
                .text(jsonData.message);
            } else {
                window.location.href = Settings.base_url + "/project/details/" + jsonData.data.id;
            }
        }
    );
}

$('select[name="projectYear"]').on('change', () => {
    alert($(this).val());
});

const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['2018', '2019', '2020', '2021', '2022', '2023'],
        datasets: [{
            label: '# of Projects',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

let taskTable = {
    'dom' : 't',
    'autoWidth': false,
    'lengthChange': false,
    'sort' : false,
    'paging' : false,

    "ajax" : datatableAjax(
        Settings.base_url + "/task/list",
        'GET',
        {projId : 'asd'},
        $('#taskTable')
    ),

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
                    '<button class="btn action-btn sm-btn edit-btn">Edit</button>' +
                    '</div>';
            }
        }
    ]
}

console.log(taskTable);

function datatableAjax(controller, type, data, table) {
    return {
        url : controller,
        type : type,
        data : data,
        'complete' : function (data) {
            console.log("Complete");
            reloadTimeout = setTimeout(() => {
                console.log("Reload");
                table.dataTable().api().ajax.reload(null, false)
            }, 5000);

            table.trigger('custom:reload');
        }
    }
}

// Projects
// $('.start-date').text(new Date(response.data.start).toLocaleString('default', {dateStyle : "medium"}));
// $('.end-date').text(new Date(response.data.end).toLocaleString('default', {dateStyle : "medium"}));