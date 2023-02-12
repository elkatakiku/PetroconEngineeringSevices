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