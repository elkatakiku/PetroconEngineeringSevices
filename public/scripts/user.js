// || NAV TABS
// Nav tab datatbles
let datatableSettings = {
    joinedProjectTable : {
        'dom' : 't',
        "autoWidth": false,
        "lengthChange": false,
        'paging' : true,
        'sort' : false,

        "ajax" : {
            url : Settings.base_url + "/people/joinedProjects",
            type : 'GET',
            data : {accountId : ACCOUNT_ID},
            'complete' : function (data)
            {
                let table = $('#joinedProjectTable');
                setTimeout(() => {
                    console.log("Reload");
                    table.dataTable().api().ajax.reload(null, false)
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
        ],

        "columns" : [
            {'defaultContent' : ''},
            {
                'data' : 'description',
                'render' : function (data, type, row) {
                    return '<span class="text-wrap">'+data+'</span>';
                }
            },
            {'data' : 'location'},
            {'data' : 'date'},
            {
                'data' : 'done',
                'render' : function (data, type, row) {
                    return (data === 1) ? 'Done' : 'Ongoing';
                }
            },
            {'defaultContent' : ''}
        ],

        order: [
            [1, 'asc']
        ],

        initComplete : function () {
            // Sets click functionality of rows
            $(this).find('tbody').on('click', 'tr', (e) => {

                console.log("TR CLICKED");

                let dt = this.api();
                let row = $(e.target).parents('tr');
                let rowData = dt.row(row).data();

                let popup = buildResourcePopup();
                popup.find('.pfooter .btn.delete-btn').show();
            });
        }
    }
};

$('#joinedProjectTable').DataTable(datatableSettings.joinedProjectTable);

$('#deleteAccount').on('click', (e) => {
    Popup.promptDelete('invitation', rowData.id, (deletePopup) => {
        $.post(
            Settings.base_url + "/user/remove",
            {form : function () {return deletePopup.find('#deleteForm').serialize();}},
            function (data, textStatus) {
                console.log(data)
                let jsonData = JSON.parse(data);
                if (jsonData.statusCode === 200)
                {   // Dismiss delete popup and reload legends list on success
                    deletePopup.find('button[data-dismiss]').trigger('click');

                    // Reload invitations
                    reloadDatatable(reloadTimeout, datatable)
                    // datatable.ajax.reload(null, false);

                    //  Show feedback
                    Popup.feedback({
                        'feedback' : 'success',
                        'message' : 'Successfully removed invitation.'
                    });
                }
            }
        );
    }, true);
});