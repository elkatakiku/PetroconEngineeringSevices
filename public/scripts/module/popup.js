// Local
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';

// Server
// import * as Utils from '/public/scripts/module/utils.js';

const HTML_BODY = $('body');

// Animates popup container to center
export function animate(popup)
{
    popup.find('.pcontainer')
        .css({
            top: '-' + popup.find('.pcontainer').height() + 'px'
        })
        .animate({
            top: "0"
        }, 300, "swing");
}

// Shows popup
export function show(popup)
{
    popup.addClass("show");

    if (popup.hasClass("popup-center"))
    {
        animate(popup);
        HTML_BODY.addClass("popup-open");
    }
    else if (popup.hasClass('feedback'))
    {
        const dissolve = () =>
        {
            popup.fadeOut(3000, () => {
                popup.find('button[data-dismiss]').trigger('click');
                popup.remove();

                removeFeedback();
            });
        };

        let feedbackTimeout = setTimeout(dissolve, 5000);

        popup.on('mouseenter', () =>
        {
            clearTimeout(feedbackTimeout);
            popup.css('opacity', '1');
            popup.stop().animate({opacity:'100'});
        })

        popup.on('mouseleave', () =>
        {
            feedbackTimeout = setTimeout(dissolve, 5000);
        });

    }
    else
    {
        let container = popup.find('.pcontainer');
        container.css({
            'top': container.data('top'),
            'right': container.data('right'),
            'bottom': container.data('bottom'),
            'left': container.data('left'),
        });
    }

    popup.trigger('custom:show');
}

// Hides popup
export function hide(e)
{
    let popup = $(e.target).parents(".popup.show, .feedback");

    if (popup.hasClass("popup-center")) {
        popup.find('.pcontainer').animate({
                top: '-' + popup.find('.pcontainer').height() + 'px'
            }, 300, "swing", () => {
                remove(popup);
            });
        return;
    }

    remove(popup);
}

// Removes popup
export function remove(popup)
{
    if ($('.popup.show').length <= 1) {
        HTML_BODY.removeClass("popup-open");
    }
    
    popup.removeClass("show");
    $(".popup-backdrop").remove();
    
    popup.trigger('custom:dismissPopup', [popup]);
    
    // Dynamic Popup
    if (popup.is($('.popup-legend, .feedback'))) {
        popup.remove();
    }

}

// Initialize popup listeners
export function initialize(popup, load = false)
{
    popup.find('button[data-dismiss]').one('click', hide);
    reset(popup);

    // On show
    popup.on('custom:show', () =>
    {
        popup
            .find('textarea')
            .each((index, element) =>
            {
                Utils.autoHeight(element);
                if (load) {
                    $(element).on("input", function() {
                        Utils.autoHeight(this);
                    });
                }
            });
    });

    // On dismiss
    popup.on('custom:dismissPopup', (e, p) =>
    {
        if (load) {
            popup.empty();
        } else  {
            popup.find('button[data-dismiss]').off('click');
            popup.find('form').off('submit');
            popup.off('custom:show');
            popup.off('custom:dismissPopup');
            reset(popup);
        }
        e.stopPropagation();
    });
}

export function reset(popup, exempt, callback = null)
{
    popup.find('.alert-danger').text('');
    popup.find('.alert-danger').removeClass('show');

    popup.find('form').each((index, element) => {
            element.reset();
        })
        .find('input[type="checkbox"], input[type="radio"]').trigger('change');

    popup.find('input, textarea, button').removeAttr('disabled');

    if (callback != null) {
        callback();
    }
}

// || Delete Popup
export function generateDeletePopup(item) { 
    let popup = $(
        '<div class="popup popup-center show popup-prompt" id="deletePopup" tabindex="-1" aria-hidden="true">' +
            '<div class="pcontainer popup-delete popup-sm">' +
                '<div class="pcontent">' +
                    '<div class="pheader">' +
                        '<h2 class="ptitle">Delete ' + item + '</h2>' +
                        '<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">' +
                            '<span class="material-icons">close</span>' +
                        '</button>' +
                    '</div>' +
        
                    '<div class="pbody">' +
                        '<form action="#" id="deleteForm">' +
                            '<input type="hidden" name="id">' +
                        '</form>' +
                        '<p>Are you sure you want to delete this ' + item + '?</p>' +
                    '</div>' +
        
                    '<div class="pfooter">' +
                        '<button type="submit" form="deleteForm" class="btn danger-btn">Delete</button>' +
                        '<button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>'
    );

    HTML_BODY.append(popup);

    // Listeners
    initialize(popup);

    popup.on('custom:dismissPopup', () =>
    {
        popup.find('#deleteForm').off('submit');
        popup.remove();
    });

    return popup;
}

// Show delete popup
export function promptDelete(item, id, callback, preventDefault = false)
{
    let deletePopup = generateDeletePopup(item);

    deletePopup.find('input[name="id"]').val(id);
    deletePopup.find('#deleteForm').on('submit', (e) => {
        if (preventDefault) {e.preventDefault();}
        callback(deletePopup);
    });

    show(deletePopup);
}

function generateFeedback() {
    let feedback =  $('<div class="feedback"> ' +
                            '<h2 class="feedback-title">Feedback</h2> ' +
                            '<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close"> ' +
                                '<span class="material-icons">close</span> ' +
                            '</button> ' +

                            '<p class="feedback-message">Feedback message</p> ' +
                        '</div>');

    HTML_BODY.append(feedback);

    // Listeners
    initialize(feedback);

    feedback.on('custom:dismissPopup', () =>
    {
        feedback.remove();
        removeFeedback();
    });

    return feedback;

}

export function feedback({feedback, title, message})
{

    let feedbackContainer = $('.feedback-container');

    if (feedbackContainer.length <= 0) {
        feedbackContainer = $('<div class="feedback-container"></div>');
        HTML_BODY.append(feedbackContainer);
    }

    let popup = generateFeedback();

    switch (feedback.toLowerCase())
    {
        case 'success':
            if (typeof title === 'undefined' || title.trim() === "") {
                title = "Success";
            }

            popup.addClass('success-border');
            break;
        case 'fail':
            break;
    }

    popup.find('.feedback-title').text(title);
    popup.find('.feedback-message').text(message);

    feedbackContainer.append(popup);
    show(popup);
}

function removeFeedback() {
    let feedbackContainer = $('.feedback-container');

    if (feedbackContainer.children('.feedback').length === 0) {
        feedbackContainer.remove();
    }
}