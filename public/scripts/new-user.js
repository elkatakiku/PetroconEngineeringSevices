$('#signupForm').submit(function (e) {
    e.preventDefault();
    alert($(e.target).serialize());

    $.post(
        Settings.base_url + "/user/newUser", 
        { form : function () {return $(e.target).serialize();} },
        function (data, textStatus) {
            console.log(data);
            let jsonData = JSON.parse(data);

            // Shows alert/error message
            if (jsonData.statusCode != 200) {
                $(e.target).find('.alert-danger')
                    .addClass('show')
                    .text(jsonData.message);
            } else {
                window.location.href = Settings.base_url + "/user/list#all";
            }
        }
    );
});

let hasError = false;

$('select[name="type"]').on('change', function() {
    if ($(this).val() == types.employee) {

        let positions = $(
        '<div class="form-group">' + 
            '<label for="position">Position</label>' + 
            '<select class="form-control" name="position" id="position">' + 
            '</select>' + 
        '</div>'
        );

        // Gets employee positions
        $.post(
            Settings.base_url + "/account/positions",
            function (data, textStatus) {
                console.log("Positions");
                console.log(data);
                let response = JSON.parse(data);
                console.log(response);
                
                response.data.forEach(position => {
                    positions
                        .find('select[name="position"]')
                        .append('<option value="' + position.id + '">' + position.name + '</option>');
                });

                $('.form-group:has(select[name="type"])').after(positions);
            }
        );
    } else {
        $('.form-group:has([name="position"])').remove();
    }
});

$('[name="email"]').on('blur', (e) => {valdiateInput(e.target, 'checkEmail', 'Email is already taken');});
$('[name="username"]').on('blur', (e) => {valdiateInput(e.target, 'checkUserName', 'Username is already taken');});
$('[name="passwordRepeat"], [name="password"]').on('blur', (e) => {
    let hasError;
    
    if ($('[name="passwordRepeat"]').val() === $('[name="password"]').val()) {
        $('[name="passwordRepeat"], [name="password"]')
            .removeClass('danger-border')
            .addClass('success-border')
            .siblings('.text-danger')
                .text('')
                .hide();
        
        hasError = false;
    } else {
        $('[name="passwordRepeat"], [name="password"]')
            .removeClass('success-border')
            .addClass('danger-border')
            .siblings('.text-danger')
                .text('Password does not match')
                .show();

        hasError = true;
    }

    $('#signupForm').trigger('custom:inputChange', [hasError]);
});

function valdiateInput(element, validation, errorMessage) {  
    if ($(element).val().trim().length !== 0) {
            
        $(element).siblings('.loading').show();
        $.get(
            Settings.base_url + "/user/" + validation,
            {input : $(element).val()},
            function (data, textStatus) {
                console.log(data);
                let response = JSON.parse(data);
                console.log(response);

                if (!response.data) {
                    $(element)
                        .removeClass('success-border')
                        .addClass('danger-border')
                        .parents('.loading-input')
                        .siblings('.text-danger')
                            .text(errorMessage)
                            .show();
                    hasError = true;
                } else {
                    $(element)
                        .removeClass('danger-border')
                        .addClass('success-border')
                        .parents('.loading-input')
                        .siblings('.text-danger')
                            .hide();

                    hasError = false;
                }

                $(element).siblings('.loading').hide();
                $('#signupForm').trigger('custom:inputChange');
            }
        );
    }
}

$('#signupForm').on('custom:inputChange', (e) => {
    $('[name="createUser"]').prop('disabled', hasError);
});