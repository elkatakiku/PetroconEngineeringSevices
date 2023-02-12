const signupForm = $('#signupForm');

// Signup Submit
signupForm.on('submit',function (e)
{
    e.preventDefault();

    $.post(
        Settings.base_url + "/user/newUser", 
        { form : function () {return $(e.target).serialize();} },
        function (data) {
            console.log(data);
            let jsonData = JSON.parse(data);

            // Shows alert/error message
            if (jsonData.statusCode !== 200) {
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

$('select[name="type"]').on('change', function()
{
    if ($(this).val() === types.employee) {

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

$('[name="username"]').on('blur', (e) => {validateInput(e.target, 'checkUserName', 'Username is already taken');});
function validateInput(element, validation, errorMessage)
{
    if ($(element).val().trim().length !== 0)
    {
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
                signupForm.trigger('custom:inputChange');
            }
        );
    }
}

signupForm.on('custom:inputChange', (e) => {
    $('[name="createUser"]').prop('disabled', hasError);
});