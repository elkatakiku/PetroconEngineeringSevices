  //JQUERY FOR EDITABLE TABLE
        
  $("#usermanform").submit(function(e) {
    e.preventDefault();   
    var name=$("input[name='name']").val(); 
    var uname=$("input[name='uname']").val();
    var email=$("input[name='email']").val();
    var pass=$("input[name='pass']").val();
    var position=$("input[name='position']").val();
    var address=$("input[name='address']").val();
    var contact=$("input[name='contact']").val();
    var bdate=$("input[name='bdate']").val();

    //mesa tbody kung san malalagay ung ininput pag nagclick submit
    $(".mesa tbody").append("<tr data-name='"+name+"' data-uname='"+uname+"' data-email='"+email+"' data-pass='"+pass+"' data-position='"+position+"' data-address='"+address+"' data-contact='"+contact+"' data-bdate='"+bdate+"'><td>"+name+"</td><td>"+uname+"</td><td>"+email+"</td><td>"+pass+"</td><td>"+position+"</td><td>"+address+"</td><td>"+contact+"</td><td>"+bdate+"</td><td><button class='btn btn-danger btn-lg btn-delete mr-3' type='button'>Delete</button><button class='btn btn-info btn-lg btn-edit' type='button'>Edit</button></td></tr>");

    $("input[name='']").val("");
  });

  $('body').on('click','.btn-delete',function() {
  $(this).parents('tr').remove();
  });

  $('body').on('click','.btn-edit',function() {
  var name=$(this).parents('tr').attr('data-name');
  var uname=$(this).parents('tr').attr('data-uname');
  var email=$(this).parents('tr').attr('data-email');
  var pass=$(this).parents('tr').attr('data-pass');
  var position=$(this).parents('tr').attr('data-position');
  var address=$(this).parents('tr').attr('data-address');
  var contact=$(this).parents('tr').attr('data-contact');
  var bdate=$(this).parents('tr').attr('data-bdate');

  $(this).parents('tr').find('td:eq(0)').html("<input name='edit_name' value='"+name+"'>");
  $(this).parents('tr').find('td:eq(1)').html("<input name='edit_uname' value='"+uname+"'>");
  $(this).parents('tr').find('td:eq(2)').html("<input name='edit_email' value='"+email+"'>");
  $(this).parents('tr').find('td:eq(3)').html("<input name='edit_pass' value='"+pass+"'>");
  $(this).parents('tr').find('td:eq(4)').html("<input name='edit_position' value='"+position+"'>");
  $(this).parents('tr').find('td:eq(5)').html("<input name='edit_address' value='"+address+"'>");
  $(this).parents('tr').find('td:eq(6)').html("<input name='edit_contact' value='"+contact+"'>");
  $(this).parents('tr').find('td:eq(7)').html("<input name='edit_bdate' value='"+bdate+"'>");

  $(this).parents('tr').find('td:eq(8)').prepend("<button type='button' class='btn btn-info btn-lg btn-update mr-3'>Update</button>");
  $(this).hide()
  });

  $('body').on('click','.btn-update',function() {
  var name=$(this).parents('tr').find("input[name='edit_name']").val();
  var uname=$(this).parents('tr').find("input[name='edit_uname']").val();
  var email=$(this).parents('tr').find("input[name='edit_email']").val();
  var pass=$(this).parents('tr').find("input[name='edit_pass']").val();
  var position=$(this).parents('tr').find("input[name='edit_position']").val();
  var address=$(this).parents('tr').find("input[name='edit_address']").val();
  var contact=$(this).parents('tr').find("input[name='edit_contact']").val();
  var bdate=$(this).parents('tr').find("input[name='edit_bdate']").val();

  $(this).parents('tr').find('td:eq(0)').text(name);
  $(this).parents('tr').find('td:eq(1)').text(uname);
  $(this).parents('tr').find('td:eq(2)').text(email);
  $(this).parents('tr').find('td:eq(3)').text(pass);
  $(this).parents('tr').find('td:eq(4)').text(position);
  $(this).parents('tr').find('td:eq(5)').text(address);
  $(this).parents('tr').find('td:eq(6)').text(contact);
  $(this).parents('tr').find('td:eq(7)').text(bdate);

  $(this).parents('tr').attr('data-name',name);
  $(this).parents('tr').attr('data-uname',uname);
  $(this).parents('tr').attr('data-email',email);
  $(this).parents('tr').attr('data-pass',pass);
  $(this).parents('tr').attr('data-position',position);
  $(this).parents('tr').attr('data-address',address);
  $(this).parents('tr').attr('data-contact',contact);
  $(this).parents('tr').attr('data-bdate',bdate);

  $(this).parents('tr').find('.btn-edit').show();
  $(this).parents('tr').find('.btn-update').remove();

  })