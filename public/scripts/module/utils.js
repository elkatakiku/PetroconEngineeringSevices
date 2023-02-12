export function autoHeight(input) {
    console.log("AutoHeight");
    input.style.minHeight = "1rem";
    input.style.height = "auto";
    input.style.height = (input.scrollHeight) + "px";
    input.style.overflowY = "hidden";
}

// Read a page's GET URL variables and return them as an associative array.
export function getUrlVars()
{
    let queryParam = {};
    let hashes = window.location.search.slice(window.location.search.indexOf('?') + 1).split('&');
    for(let i = 0; i < hashes.length; i++)
    {
        let hash = hashes[i].split('=');
        queryParam[hash[0]] = hash[1];
    }

    return queryParam;
}

let hasError = false;

export function validateInput(element, form, controller, errorMessage) {
    console.log("Validate input");
    if ($(element).val().trim().length !== 0) {
            
        $(element).siblings('.loading').show();
        $.get(
            Settings.base_url + controller,
            {input : $(element).val()},
            function (data) {
                console.log(data);
                let response = JSON.parse(data);
                console.log(response);

                if (!response.data)
                {
                    $(element)
                        .removeClass('success-border')
                        .addClass('danger-border')
                        .parents('.loading-input')
                        .siblings('.text-danger')
                            .text((response.hasOwnProperty('message')) ? response.message : errorMessage)
                            .show();
                    hasError = true;
                }
                else
                {
                    $(element)
                        .removeClass('danger-border')
                        .addClass('success-border')
                        .parents('.loading-input')
                        .siblings('.text-danger')
                            .hide();

                    hasError = false;
                }

                $(element).siblings('.loading').hide();
                $(form).trigger('custom:inputChange', [hasError]);
            }
        );
    }
}


//  Form
export function toggleForm(form, toggle) {
    form.find('input, textarea, button').prop('disabled', toggle);
    $('button[form="' + form.attr('id') + '"]').prop('disabled', toggle);
}

//  Filter
export function changeFilter(element) {
    console.log("changeFilter");
    let radio = $(element);

    radio.prop('checked', true);
    radio.trigger('change');
}