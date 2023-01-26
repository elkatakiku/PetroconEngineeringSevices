// Local
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';

// Server
// import * as Utils from '/public/scripts/module/utils.js';

$('[name="oldPass"]').on('blur', (e) => {
    Utils.valdiateInput(e.target, '#changePassForm', '/user/validatePassword', 'Incorrect password');
});

$('[name="newPassRepeat"], [name="newPass"]').on('blur', (e) => 
{
    let hasError;
    if ($('[name="newPassRepeat"]').val().length > 0 && $('[name="newPass"]').val().length > 0) 
    {    
        if ($('[name="newPassRepeat"]').val() === $('[name="newPass"]').val()) 
        {
            $('[name="newPassRepeat"], [name="newPass"]')
                .removeClass('danger-border')
                .addClass('success-border')
                .siblings('.text-danger')
                    .text('')
                    .hide();
            
            hasError = false;
        } 
        else 
        {
            $('[name="newPassRepeat"], [name="newPass"]')
                .removeClass('success-border')
                .addClass('danger-border')
                .siblings('.text-danger')
                    .text('Password does not match')
                    .show();

            hasError = true;
        }

        $('#changePassForm').trigger('custom:inputChange', [hasError]);
    }
});

$('#changePassForm').on('custom:inputChange', (e, hasError) => {
    $('[name="changePassSubmit"]').prop('disabled', hasError);
});
