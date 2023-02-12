// Local
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';

// Server
// import * as Utils from '/public/scripts/module/utils.js';

// Datatable
let reloadTimeout;
let projectTable = $("#projectsTable");

let projectDatatableSettings =
    {
    'dom' : '<"mesa-container"t><"linear"ip>',
    "autoWidth": false,
    "lengthChange": false,
    'paging' : true,
    'sort' : false,
    "ajax" : {
        url : Settings.base_url + "/project/getlist",
        type : 'POST',
        data : {form : function () { return $('#filterTable').serialize();}},
        'complete' : function (data)
        {
            reloadTimeout = setTimeout(() => {
                projectTable.dataTable().api().ajax.reload(null, false);
            }, 5000);
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
        {
            "targets": 3,
            "createdCell": function (td, cellData, rowData, rowIndex, colIndex) {
                $(td).css('white-space', 'nowrap');
            }
        }
    ],

    "columns" : [
        {'defaultContent' : ''}, 
        {
            'data' : 'description',
            'render' : function (data, type, row) {
                return '<p><strong>' + data + '</strong></p>' +
                        '<small>' + row.company + '</small>';
            }
        },
        {
            'data' : 'progress',
            'render' : function (data) {
                return (data === "100.00%") ? '<strong class="success-text">'+data+'</strong>' : data;
            }
        },
        {'data' : 'completion'}
    ],
    
    order: [
        [1, 'asc']
    ]
};

let projectDatatable = projectTable.DataTable(projectDatatableSettings);

// Incrementing number of table rows
projectDatatable.on('order.dt search.dt', function () {
    let i = 1;

    projectDatatable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
        this.data(i++);
    });
}).draw();

// Row click
projectTable.find('tbody').on('click', 'tr', function (e) {
    let row = projectDatatable.row(this).data();

    // Redirect to project
    window.location.href = Settings.base_url + "/project/details/" + row.id;
});

// Table search 
$('#searchProject').on('input', function (e) {
    projectDatatable.search($(this).val()).draw();
});

$(window).on( 'hashchange', function( e ) {
    Utils.changeFilter('[value="'+window.location.hash.slice(1)+'"]');
});

// Table filter
$('#filterTable')
    .on('submit',function (e) {
        e.preventDefault();
        clearTimeout(reloadTimeout);
        reloadTimeout = null;
        projectDatatable.ajax.reload();
    })
    .find('input[name="status"]')
    .on('change', function (e)
    {
        $('#filterTable').trigger('submit');

        let radio = $(this);
        radio.parent('.filter-tab-item')
            .addClass('active')
            .siblings('.filter-tab-item.active')
            .removeClass('active');
    });

// BUG: Reloads datatable twice
Utils.changeFilter('[value="'+window.location.hash.slice(1)+'"]');
