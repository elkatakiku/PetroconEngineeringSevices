// Local
import * as Popup from '/PetroconEngineeringServices/public/scripts/module/popup.js';

// Server
// import * as Popup from '/public/scripts/module/popup.js';

// || NAV TABS
let reloadTimeout;

function reloadDatatable(timeout, datatable) {
    clearTimeout(timeout);
    reloadTimeout = null;
    datatable.ajax.reload(null, false);
}

const joinedProjectTable = $('#joinedProjectTable');

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
            'complete' : function (data) {
                console.log("Complete");
                reloadTimeout = setTimeout(() => {
                    console.log("Reload");
                    if (DataTable.isDataTable(joinedProjectTable)) {
                        joinedProjectTable.dataTable().api().ajax.reload(null, false)
                    }
                }, 5000);

                joinedProjectTable.trigger('custom:reload');
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
                "targets": 5,
                "createdCell": function (td, cellData, rowData, rowIndex, colIndex)
                {
                    console.log(rowData);
                    let cell = $(td);

                    cell.find('.remove-btn').on('click', (e) =>
                    {
                        Popup.promptDelete('person', rowData.id, (deletePopup) =>
                        {
                            $.post(
                                Settings.base_url + "/people/remove",
                                {form : function () {return deletePopup.find('#deleteForm').serialize();}},
                                function (data)
                                {
                                    let response = JSON.parse(data);

                                    if (response.statusCode === 200)
                                    {   // Dismiss delete popup
                                        deletePopup.find('button[data-dismiss]').trigger('click');

                                        // Reload resources
                                        reloadDatatable(reloadTimeout, joinedProjectTable.dataTable().api());

                                        //  Show feedback
                                        Popup.feedback({
                                            'feedback' : 'success',
                                            'message' : response.message
                                        });
                                    }
                                }
                            );
                        }, true);
                    });
                }
            }
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
            {
                'defaultContent' : '',
                'render' : function () {
                    return  '<div class="action-cell-content">' +
                        '<button class="btn outline-danger-btn icon-btn remove-btn">Remove' +
                        '</button>' +
                        '</div>';
                }
            }
        ],

        order: [
            [1, 'asc']
        ],

        // initComplete : function () {
        //     // Sets click functionality of rows
        //     $(this).find('tbody').on('click', 'tr', (e) => {
        //
        //         console.log("TR CLICKED");
        //
        //         let dt = this.api();
        //         let row = $(e.target).parents('tr');
        //         let rowData = dt.row(row).data();
        //
        //         let popup = buildResourcePopup();
        //         popup.find('.pfooter .btn.delete-btn').show();
        //     });
        // }
    }
};

joinedProjectTable.DataTable(datatableSettings.joinedProjectTable);

$('#deleteAccount').on('click', (e) =>
{
    Popup.promptDelete('invitation', e.target.dataset.account, (deletePopup) =>
    {
        $.post(
            Settings.base_url + "/user/remove",
            {form : function () {return deletePopup.find('#deleteForm').serialize();}},
            function (data) {
                console.log(data)
                let jsonData = JSON.parse(data);
                if (jsonData.statusCode === 200)
                {   // Dismiss delete popup and reload legends list on success
                    deletePopup.find('button[data-dismiss]').trigger('click');

                    window.location.href = Settings.base_url + "/user/list#all";
                }
            }
        );
    }, true);
});