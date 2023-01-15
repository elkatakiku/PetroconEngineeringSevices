// alert(window.location.href);
// alert(window.location.protocol);
// alert(window.location.host);
// alert(window.location.hostname);
// alert(window.location.port);
// alert(window.location.pathname);
// alert(window.location.search);
// alert(window.location.hash);

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    let queryParam = [];
    let hashes = window.location.search.slice(window.location.search.indexOf('?') + 1).split('&');
    for(let i = 0; i < hashes.length; i++)
    {
        let hash = hashes[i].split('=');
        queryParam[hash[0]] = hash[1];
    }
    return queryParam;
}

/* ================================================================== */

// let query = getUrlVars();
// let filter = query.hasOwnProperty("filter") ? query.filter : '';
// alert(Settings.base_url + "/project/list/" + window.location.hash.slice(1));


// Datatable
let projectTable = $("#projectsTable").DataTable({
    'dom' : '<"mesa-container"t><"linear"ip>',
    "autoWidth": false,
    "lengthChange": false,
    'paging' : true,
    'sort' : false,
    // 'searching' : false,
    // 'info' : false,
    "ajax" : {
        url : Settings.base_url + "/project/getlist",
        type : 'POST',
        data : {form : function () { return $('#filterTable').serialize();}}
        // ,
        // success : function (data) {
        //     console.log(data);
        //     console.log("Ajax data");
        //     console.log(data.filter);
        //     console.log("URL");
        //     console.log(Settings.base_url + "/project/list/" + window.location.hash.slice(1));
        // }
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
            'data' : 'description',
            'render' : function (data, type, row) { 
                return '<p><strong>' + data + '</strong></p>' +
                        '<small>' + row.location + '</small>';
            }
        }, 
        {'data' : 'company'},
        {
            'data' : 'done',
            'render' : function (data, type, row) {
                let display;
                if (data === 1) {
                    display = '<span class="status" data-status="done">Done</span>'
                } else {
                    display = '<span class="status" data-status="in-progress">Ongoing</span>'
                }
                return display;
            }
        }
    ],
    
    order: [
        [1, 'asc']
    ]
});

// Incrementing number of table rows
projectTable.on('order.dt search.dt', function () {
    let i = 1;

    projectTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
        // console.log('cell');
        // console.log(cell);

        // console.log(this.data());

        this.data(i++);
    });
}).draw();

// Row click
$('#projectsTable tbody').on('click', 'tr', function (e) {
    let row = projectTable.row(this).data();
    // console.log("Row data");
    // console.log(row);
    // console.log("id");
    // console.log(row.id);

    // Redirect to project
    window.location.href = Settings.base_url + "/project/details/" + row.id;
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
        projectTable.ajax.reload();
    })
    .find('input[name="status"]')
        .change(function (e) { 
            console.log("Submit filter");
            $('#filterTable').submit();

            $(this).parent('.filter-tab-item')
                .addClass('active')
                .siblings('.filter-tab-item.active')
                    .removeClass('active');

            window.location.hash = $(this).val();
        });

function changeFilter() {
    $('#filterTable')
        .find('input[name="status"]')
        .each(function (index, element) { 
            console.log("Each");
            console.log($(element).val());
            console.log(window.location.hash.slice(1));
            if ($(element).val() == window.location.hash.slice(1)) {
                $(element).prop('checked', true);

                $(element).trigger('change');
            }
        });
}

// Table search 
$('#searchProject').keyup(function (e) { 
    projectTable.search($(this).val()).draw();
});

// Table reload
setInterval(() => {
    console.log("Table reload");
    projectTable.ajax.reload(null, false);
}, 3000);

$(window).on( 'hashchange', function( e ) {
    changeFilter();
} );