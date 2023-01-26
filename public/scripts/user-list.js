// Local
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';

// Server
// import * as Utils from '/public/scripts/module/utils.js';

// Datatable
let userTable = $("#usersTable").DataTable({
    'dom' : '<"mesa-container"t><"linear"ip>',
    "autoWidth": false,
    "lengthChange": false,
    'paging' : true,
    'sort' : false,
    
    "ajax" : {
        url : Settings.base_url + "/user/getList",
        type : 'GET',
        data : {form : function () { return $('#filterTable').serialize();}},
        'complete' : function () {
            console.log("Complete");
            let table = $('#usersTable');
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
      {
        "targets": 4,
        "createdCell": function (td, cellData, rowData, row, col) {
            $(td).addClass('cut-text');
        },
        'seachable' : false
      }
    ],

    "columns" : [
        {'defaultContent' : ''},
        {
          'defaultContent' : '',
          'render' : function (data, type, row) {
              console.log("render");
              console.log(row);
              let middleInitial = (row.middlename.trim().length > 0) ? row.middlename.charAt(0) + '.' : '';
              return row.lastname + ', ' + row.firstname + ' ' + middleInitial;
          }
        },
        {'data' : 'email'},
        {'data' : 'username'}, 
        {
          'data' : 'password',
          'render' : function (data, type, row) {
            return '<span class="pass-col cut-text">' + data + '</span>';
          },
          'seachable' : false
        },
        {'defaultContent' : ''}
    ],
    
    order: [
        [1, 'asc']
    ]
});

// Incrementing number of table rows
userTable.on('order.dt search.dt', function () {
    let i = 1;

    userTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) 
    {
      this.data(i++);
    });
}).draw();

// Row click
$('#usersTable tbody').on('click', 'tr', function (e) {
    let row = userTable.row(this).data();
    window.location.href = Settings.base_url + "/user/details/" + row.id;
});

// Table filter
$('#filterTable')
    .on('submit', function (e) {
        e.preventDefault();
        console.log("Submit filter");
        userTable.ajax.reload();
    })
    .find('input[name="type"]')
        .change(function (e) { 
            console.log("Submit filter");
            $('#filterTable').trigger('submit');

            $(this).parent('.filter-tab-item')
                .addClass('active')
                .siblings('.filter-tab-item.active')
                    .removeClass('active');

            window.location.hash = $(this).val();
        });

// Table search 
$('#searchUser').on('input', function (e) { 
    console.log($(this).val());
    userTable.search($(this).val()).draw();
});

//  Change filter on hash change
$(window).on( 'hashchange', function( e ) {
    Utils.changeFilter('[value="'+window.location.hash.slice(1)+'"]');
});

Utils.changeFilter('[value="'+window.location.hash.slice(1)+'"]');