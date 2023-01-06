import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';

// Animates popup container to center
export function animate(popup) {
    console.log("Animating popup");
    popup.find('.pcontainer')
        .css({
            top: '-' + popup.find('.pcontainer').height() + 'px'
        })
        .animate({
            top: "0"
        }, 300, "swing");
}

export function wew(p) {  
    console.log("Show popup");
}

// Shows popup
export function show(popup) {
    console.log("Show popup");
    
    popup.addClass("show");

    if (popup.hasClass("popup-center")) {
        console.log("Popup center");
        animate(popup);
        $("body").addClass("popup-open");
    } else if(!popup.hasClass("popup-contained")) {   
        console.log("Popup contained");
        $("body").addClass("popup-open");
    } else {
        console.log("Popup other");
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
export function hide(e) {
    console.log("Hide popup");
    let popup = $(e.target).closest(".popup.show");

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
export function remove(popup) {
    console.log("Remove popup");
    
    if ($('.popup.show').length <= 1) {
        $("body").removeClass("popup-open");
    }
    
    popup.removeClass("show");
    $(".popup-backdrop").remove();
    
    popup.trigger('custom:dismissPopup', [popup]);
    
    // Dynamic Popup
    if (popup.is($('.popup-legend'))) {
        popup.remove();
    }

}

// Initialize popup listeners
export function initialize(popup) {
    console.log("Popup Initialize");
    console.log(popup);
    console.log(popup.find('button[data-dismiss]'));
    popup.find('button[data-dismiss]').one('click', hide);

    // On show
    popup.on('custom:show', (e) => {
        console.log("Popup shown");
        popup
            .find('textarea')
            .each((index, element) => {
                Utils.autoHeight(element);
            });
    });

    // On dimiss
    popup.on('custom:dismissPopup', (e, p) => {
        console.log("Popup dismissed");
        console.log(p);
        console.log(popup.is(p));
        popup.find('button[data-dismiss]').off('click');
        popup.off('custom:show');
        popup.off('custom:dismissPopup');
        e.stopPropagation();
    });
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

    $('body').append(popup);

    // Listeners
    initialize(popup);

    popup.on('custom:dismissPopup', (e) => {
        console.log("Delete dismiss");
        popup.find('#deleteForm').off('submit');
        popup.remove();
    });

    return popup;
}