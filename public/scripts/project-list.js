console.log($('#projectsTable'));

// $(selector).load("url", "data", function (response, status, request) {
//     this; // dom element
    
// });

// $(selector).load("url", "data", function (response, status, request) {
//     this; // dom element
    
// });

// $(selector).unload(function () { 
    
// });

console.log(Settings.base_url + "/projects/projects");

// let counter = 1;

let projectTable = $("#projectsTable").DataTable({
    'dom' : '<"mesa-container"t>p',
    "autoWidth": false,
    "lengthChange": false,
    'paging' : true,
    'sort' : false,
    // 'searching' : false,
    'info' : false,
    "ajax" : {
        url : Settings.base_url + "/projects/projects",
        type : 'POST',
        data : {
            filterStatus : function () { 
                return $('#filterTable').serialize();
            }
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
            'data' : 'name',
            'render' : function (data, type, row) { 
                return '<p><strong>' + data + '</strong></p>' +
                        '<small>' + row.location + '</small>';
            }
        }, 
        {'data' : 'company'},
        {'data' : 'status'}
    ],
    
    order: [
        [1, 'asc']
    ]
});

projectTable.on('order.dt search.dt', function () {
    let i = 1;

    projectTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
        console.log('cell');
        console.log(cell);

        console.log(this.data());

        this.data(i++);
    });
}).draw();

// Row click
$('#projectsTable tbody').on('click', 'tr', function (e) {
    let row = projectTable.row(this).data();
    console.log("Row data");
    console.log(row);
    console.log("id");
    console.log(row.id);

    // Redirect to project
    window.location.href = Settings.base_url + "/projects/project/" + row.id;
});

// $('#filterTable')
//     .submit(function (e) { 
//         e.preventDefault();
//         projectTable.ajax.reload();
//     })
//     .find('select[name="status"]')
//         .change(function (e) { 
//             $('#filterTable').submit();
//         });

// Table filter
$('#filterTable')
    .submit(function (e) { 
        e.preventDefault();
        // counter = 1;
        projectTable.ajax.reload();
    })
    .find('input[name="status"]')
        .change(function (e) { 
            $('#filterTable').submit();
            // console.log($(this).val());
            console.log(
            $(this).parent('.filter-tab-item')
                .addClass('active')
                .siblings('.filter-tab-item.active')
                    .removeClass('active')
            );

            // $('#samp').load(Settings.base_url + "/projects/samp", {
            //     filterStatus : function () {return $('#filterTable').serialize();}
            // }, () => {
            //     alert("Alert");
            // });
        });

// Table search 
$('#searchProject').keyup(function (e) { 
    projectTable.search($(this).val()).draw();
});

// Table reload
setInterval(() => {
    console.log("Table reload");
    projectTable.ajax.reload(null, false);
}, 15000);

// $('#asd').click((e) => {
//     e.preventDefault();
//     $('#samp').load(Settings.base_url + "/projects/samp", {
//         filterStatus : function () {return $('#filterTable').serialize();}
//     }, () => {
//         alert("Alert");
//     });
// });