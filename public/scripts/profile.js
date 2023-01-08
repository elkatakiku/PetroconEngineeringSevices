import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';

let param = Utils.getUrlVars();

$('.page-footer').hide();

if (param.hasOwnProperty('action') && param.action === "edit") {
    $('input').each(function (index, element) {
        $(element).attr('readonly', false);
    });
    $('#editProfile').hide();
    $('.page-footer').show();
}

