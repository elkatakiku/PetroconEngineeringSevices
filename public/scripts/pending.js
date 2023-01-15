// Datatable
console.log(projectId);
let invitationTable = $("#inviteTable").DataTable({
    'dom' : '<"mesa-container"t><"linear"ip>',
    "autoWidth": false,
    "lengthChange": false,
    'paging' : true,
    'sort' : false,
    "ajax" : {
        url : Settings.base_url + "/people/invitations",
        type : 'GET',
        data : {projId : projectId}
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
                return '<p><strong>' + data.toUpperCase() + '</strong></p>';
            }
        }, 
        {'data' : 'email'},
        {
            'defaultContent' : '',
            'render' : function (data, type, row) {  
                return '<button class="btn danger-btn sm-btn">Remove</button>';
            }
        }, 
    ],
    
    order: [
        [1, 'asc']
    ]
});

// Incrementing number of table rows
invitationTable.on('order.dt search.dt', function () 
{
    let i = 1;

    invitationTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) 
    {
        this.data(i++);
    });
}).draw();

// Row click
// $('#projectsTable tbody').on('click', 'tr', function (e) {
//     let row = invitationTable.row(this).data();
//     window.location.href = Settings.base_url + "/project/details/" + row.id;
// });

// Table search 
$('#searchInvitations').keyup(function (e) { 
    invitationTable.search($(this).val()).draw();
});

// Table reload
// setInterval(() => {
//     console.log("Table reload");
//     invitationTable.ajax.reload(null, false);
// }, 3000);

$(window).on( 'hashchange', function( e ) {
    changeFilter();
});

$('#inviteForm').on('submit', (e) => {
    e.preventDefault();
    
    $.post(
        Settings.base_url + "/people/invite",
        {form : getFormData(e.target)},
        function (data, textStatus) {
            console.log(data);
            console.log("Edit Response");
            let response = JSON.parse(data);
            console.log(response);

            if (response.statusCode == 200) 
            {   // Clears form's inputs
                $(e.target).find('input, textarea').each((index, element) => {
                    $(element).val('');
                });
                
                // Reload table
                invitationTable.ajax.reload(null, false);
            }
            else
            {   // Shows alert on fail
                $(e.target).find('.alert-danger')
                    .addClass('show')
                    .text(response.message);
            }
        }
    );
});

function getFormData(form) {  
    console.log(projectId);
    return $(form).serialize() + "&projId=" + projectId;
}
