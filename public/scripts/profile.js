// Local
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';

// Server
// import * as Utils from '/public/scripts/module/utils.js';

let param = Utils.getUrlVars();
const HTML_FOOTER = $('.page-footer');

HTML_FOOTER.hide();

if (param.hasOwnProperty('action') && param.action === "edit") {
    $('input').each(function (index, element) {
        $(element).attr('readonly', false);
    });
    $('#editProfile').hide();
    HTML_FOOTER.show();
}

