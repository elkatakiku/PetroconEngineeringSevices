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
            'complete' : function (data) {
                // console.log("Complete");
                // console.log(data);
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
                    // let display;
                    // if (data === 1) {
                    //     display = '<span class="status" data-status="done">Done</span>'
                    // } else {
                    //     display = '<span class="status" data-status="in-progress">Ongoing</span>'
                    // }
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
                // let rowDisplay = dt.cells( row, '' ).render( 'display' );

                let popup = buildResourcePopup();
                popup.find('.pfooter .btn.delete-btn').show();

                // popup.find('[name="id"]').val(rowData.id);
                // popup.find('[name="item"]').val(rowData.item);
                // popup.find('[name="quantity"]').val(rowData.quantity);
                // popup.find('[name="price"]').val(rowData.price);
                // popup.find('[name="total"]').val(rowData.total);
                // popup.find('[name="notes"]').val(rowData.notes);

                // Delete task actions
                // popup.find('.delete-btn').click(() => {
                //     console.log("DELETE CLICKED");
                //     Popup.promptDelete('resource', rowData.id, (deletePopup) => {
                //         $.post(
                //             Settings.base_url + "/resource/remove",
                //             {form : function () {return deletePopup.find('#deleteForm').serialize();}},
                //             function (data, textStatus) {
                //                 console.log("Response delete");
                //                 console.log(data);
                //                 let jsonData = JSON.parse(data);
                //                 if (jsonData.statusCode == 200)
                //                 {   // Dismiss delete popup and reload legends list on success
                //                     deletePopup.find('button[data-dismiss]').trigger('click');

                //                     deletePopup.on('custom:dismissPopup', (e) => {
                //                         popup.find('button[data-dismiss]').trigger('click');
                //                     });

                //                     // Reload tasks
                //                     dt.ajax.reload(null, false);
                //                 }
                //             }
                //         );
                //     }, true);
                // });

                // Submit action
                // popup.find('#itemForm').submit((e) => {
                //     e.preventDefault();

                //     $.post(
                //         Settings.base_url + "/resource/update",
                //         {form : function () {return $(e.target).serialize();}},
                //         function (data, textStatus) {
                //             console.log(data);
                //             console.log("Edit Response");
                //             let response = JSON.parse(data);
                //             console.log(response);

                //             if (response.statusCode == 200)
                //             {   // Dismiss legend's form and reload legends list on success
                //                 popup.find('button[data-dismiss]').trigger('click');

                //                 // Reload resources
                //                 $("#resourceTable").dataTable().api().ajax.reload(null, false);
                //             }
                //             else
                //             {   // Shows alert on fail
                //                 popup.find('.alert-danger')
                //                     .addClass('show')
                //                     .text(response.message);
                //             }
                //         }
                //     );
                // });

                // Finally shows popup
                // Popup.show(popup);
            });
        }
    }
};

$('#joinedProjectTable').DataTable(datatableSettings.joinedProjectTable);