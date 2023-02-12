// Local
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';
import * as Popup from '/PetroconEngineeringServices/public/scripts/module/popup.js';

// Server
// import * as Utils from '/public/scripts/module/utils.js';
// import * as Popup from '/public/scripts/module/popup.js';

// Datatable
let reloadTimeout;
let invitationTable = $("#inviteTable").DataTable({
    'dom' : 't<"linear"ip>',
    "autoWidth": false,
    "lengthChange": false,
    'paging' : true,
    'sort' : false,
    "ajax" : {
        url : Settings.base_url + "/people/invitations",
        type : 'GET',
        data : {projId : projectId},
        'complete' : function () {
            let table = $('#inviteTable');
            reloadTimeout = setTimeout(() => {
                table.dataTable().api().ajax.reload(null, false)
            }, 5000);

            table.trigger('custom:reload');
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
                return '<p><strong>' + data.toUpperCase() + '</strong></p>';
            }
        },
        {'data' : 'email'},
        {
            'data' : 'type_id',
            'render' : function (data, type, row) {
                return (data === 'PTRCN-TYPE-20222') ? 'Employee' : 'Client';
            }
        },
        {
            'defaultContent' : '',
            'render' : function (data, type, row) {
                return '<button class="btn danger-btn sm-btn remove-btn">Remove</button>';
            }
        },
    ],

    order: [
        [1, 'asc']
    ],

    initComplete : function ()
    {
        let table = this;
        let datatable = table.api();
        console.log("Initialization complete");

        //  Re-initializes buttons every reload
        $('#inviteTable').on('custom:reload', (e) =>
        {
            $(table).find('td .remove-btn').each((index, element) =>
            {
                $(element).on('click', () =>
                {
                    let rowData = datatable.row($(element).parents('tr')).data();
                    Popup.promptDelete('invitation', rowData.id, (deletePopup) => {
                        $.post(
                            Settings.base_url + "/people/removeInvitation",
                            {form : function () {return deletePopup.find('#deleteForm').serialize();}},
                            function (data)
                            {
                                let jsonData = JSON.parse(data);
                                if (jsonData.statusCode === 200)
                                {   // Dismiss delete popup and reload legends list on success
                                    deletePopup.find('button[data-dismiss]').trigger('click');

                                    // Reload invitations
                                    reloadDatatable(reloadTimeout, datatable)

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
            });
        });
    }
});

function reloadDatatable(timeout, datatable) {
    clearTimeout(timeout);
    reloadTimeout = null;
    datatable.ajax.reload(null, false);
}

// Incrementing number of table rows
invitationTable.on('order.dt search.dt', function () 
{
    let i = 1;

    invitationTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) 
    {
        this.data(i++);
    });
}).draw();

// Table search 
$('#searchInvitations').on('keyup',function (e) {
    invitationTable.search($(this).val()).draw();
});

//  Changes filter on hashChange
$(window).on( 'hashchange', function( e ) {
    changeFilter();
});

let submitButton = $('#inviteSubmit');

submitButton.on('custom:clicked', (e) => {
    submitButton.siblings('.cstm-spinner').hide();
});

//  Invite submit action
let inviteForm = $('#inviteForm');
inviteForm.on('submit', (e) =>
{
    e.preventDefault();

    let form = $(e.target);

    $.post(
        Settings.base_url + "/people/invite",
        {form : getFormData(form)},
        function (data)
        {
            let response = JSON.parse(data);

            if (response.statusCode === 200)
            {   // Clears form's inputs
                $(e.target).find('input, textarea').each((index, element) => {
                    $(element).val('');
                });

                // Reload table
                reloadDatatable(reloadTimeout, invitationTable);

                //  Show feedback
                Popup.feedback({
                    'feedback' : 'success',
                    'message' : 'Invitation has been sent.'
                });
            }
            else
            {   // Shows alert on fail
                $(e.target).find('.alert-danger')
                    .addClass('show')
                    .text(response.message);
            }

            form.trigger('custom:submitted');
        }
    );

    Utils.toggleForm(form, true);
});

function getFormData(form) {
    return form.serialize() + "&projId=" + projectId;
}

