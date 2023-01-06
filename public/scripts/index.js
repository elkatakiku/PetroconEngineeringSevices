import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';
import * as Popup from '/PetroconEngineeringServices/public/scripts/module/popup.js';

// console.log(Utils.double(5));
// console.log(Utils.otherStuff());

// $.fn.hasVerticalScrollBar = function () {
//     return this[0].clientHeight < this[0].scrollHeight;
// }

// $.fn.hasHorizontalScrollBar = function () {
//    return this[0].clientWidth < this[0].scrollWidth;
// }

// console.log("Horizontal Scrollbar");
// console.log($('#projectGanttChart .gantt-chart').hasHorizontalScrollBar());
// console.log("Vretical Scrollbar");
// console.log($('#projectGanttChart .gantt-chart').hasVerticalScrollBar());
/*
Carousel
*/
console.log("JS Connected");
$('#project-carousel').on('slide.bs.carousel', function(e) {
    /*
        CC 2.0 License Iatek LLC 2018 - Attribution required
    */
    var idx = $(e.relatedTarget).index(); 
    var itemsPerSlide = 5;
    var totalItems = $('.carousel-item').length; // 8
    if (idx >= totalItems - (itemsPerSlide - 1)) { // 7 >= 8 - 4 = 4
        var it = itemsPerSlide - (totalItems - idx); // 5-(8-1) = 2
        for (var i = 0; i < it; i++) {
            // append slides to end
            if (e.direction == "left") {
                $('.carousel-item').eq(i).appendTo('.carousel-inner');
            } else {
                $('.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});

// Sidebar
function expandSidebar(submenu = false) { 
    if (submenu && $("#sidebar").hasClass("active")) {
        return;
    }

    if ($("#sidebar").hasClass("active")) {
        // Collapse sidebar
        if($(window).width() > 780) {
            $("#sidebar.active .collapsible").animate({
                width: "0"
            }, 150); 
        }
        $('.sub-menu.show').collapse('hide');
    } 
    else { 
        // Show sidebar        
        if($(window).width() > 780) {
            $("#sidebar .collapsible").animate({
                width: "250px"
            }, 150);
        }
    }

    $('#sidebar').toggleClass('active');
}

// Sidebar Buttons Listener
$('.sub-menu').on('show.bs.collapse' , () => {
    if ($(window).width() > 768) {
        expandSidebar(true);
    }
});

// Responsive to width
$(window).on("resize", (e) => {

    console.log($('.popup-center')[0]);

    // if ($('.popup-center')[0].scrollHeight > $(window).height()) {
    //     $('.popup-center').find('.pcontainer').css({
    //         top : 0,
    //         transform : "translate(-50%, 0%)"
    //     });
    // } else {
    //     $('.popup-center').find('.pcontainer').css({
    //         top : '50%',
    //         transform : "translate(-50%, -50%)"
    //     });
    // }

    // Removes sidebar collapsibles width property
    if($(window).width() < 768) {
        $("#sidebar .collapsible").css('width', "");
        // $(".wrapper .content, .content > .mesa-container").css("max-width", "");
    } else {
        // console.log("768+");
        // console.log($(".wrapper .content, .content > .mesa-container"));
        // $(".wrapper .content, .content > .mesa-container").css("max-width", "calc(100% - " + $("#sidebar").width() + "px)");
    }

});

// Sidebar Listener
$("#sidebarCollapseToggler").click(() => {expandSidebar();});



// || Popup
const POPUP = "popup";

// Dismisses popup when click elsewhere
$(".popup").click((e) => {
    console.log("Popup clicked");

    // Closes popup when clicked outside popup content
    if ($(e.target).hasClass('popup')) {
        Popup.hide(e);
    }
});

// Animates popup container to center
// function animate(popup) {
//     console.log("Animating popup");
//     popup.find('.pcontainer')
//         .css({
//             top: '-' + popup.find('.pcontainer').height() + 'px'
//         })
//         .animate({
//             top: "0"
//         }, 300, "swing");
// }

// Shows popup
// function show(popup) {
//     console.log("Popup button clicked");
//     console.log(popup);
    
//     popup.addClass("show");

//     if (popup.hasClass("popup-center")) {
//         console.log("Popup Center");
//         animate(popup);
//         $("body").addClass("popup-open");
//     } else if(!popup.hasClass("popup-contained")) {   
//         $("body").addClass("popup-open");
//     } else {
//         let container = popup.find('.pcontainer');
//         container.css({
//             'top': container.data('top'),
//             'right': container.data('right'),
//             'bottom': container.data('bottom'),
//             'left': container.data('left'),
//         });
//     }

//     popup.trigger('custom:show');
// }

// Hides popup
// function hide(e) {
//     console.log("Hide popup");
//     // console.log(e.target);
//     let popup = $(e.target).closest(".popup.show");
//     // console.log("Opened popup");
//     // console.log(popup);

//     if (popup.hasClass("popup-center")) {
//         popup.find('.pcontainer').animate({
//                 top: '-' + popup.find('.pcontainer').height() + 'px'
//             }, 300, "swing", () => {
//                 remove(popup);
//             });
//         return;
//     }

//     remove(popup);
// }

// Removes popup
// function remove(popup) {
    
//     if ($('.popup.show').length <= 1) {
//         $("body").removeClass("popup-open");
//     }
    
//     popup.removeClass("show");
//     $(".popup-backdrop").remove();
    
//     popup.trigger('custom:dismissPopup');
    
//     // Dynamic Popup
//     if (popup.is($('#legendPopup'))) {
//         popup.remove();
//     }

// }

// Initialize popup listeners
// function initializePopup(popup) {
//     popup.find('button[data-dismiss]').on('click', Popup.hide);

//     popup.on('custom:dismissPopup', (e) => {
//         popup.off('custom:show');
//         popup.off('custom:dismissPopup');
//     });
// }

// || Delete Popup
// function generateDeletePopup(item) { 
//     let popup = $(
//         '<div class="popup popup-center show popup-delete" id="deletePopup" tabindex="-1" aria-hidden="true">' +
//             '<div class="pcontainer popup-sm">' +
//                 '<div class="pcontent">' +
//                     '<div class="pheader">' +
//                         '<h2 class="ptitle">Delete ' + item + '</h2>' +
//                         '<button type="button" class="icon-btn close-btn" data-dismiss="popup" aria-label="Close">' +
//                             '<span class="material-icons">close</span>' +
//                         '</button>' +
//                     '</div>' +
        
//                     '<div class="pbody">' +
//                         '<form action="#" id="deleteForm">' +
//                             '<input type="hidden" name="id">' +
//                         '</form>' +
//                         '<p>Are you sure you want to delete this ' + item + '?</p>' +
//                     '</div>' +
        
//                     '<div class="pfooter">' +
//                         '<button type="submit" form="deleteForm" class="btn danger-btn">Delete</button>' +
//                         '<button type="button" class="btn link-btn" data-dismiss="popup">Cancel</button>' +
//                     '</div>' +
//                 '</div>' +
//             '</div>' +
//         '</div>'
//     );

//     $('body').append(popup);

//     // Listeners
//     Popup.initializePopup(popup);

//     popup.on('custom:dismissPopup', (e) => {
//         console.log("Delete dismiss");
//         popup.find('#deleteForm').off('submit');
//         popup.remove();
//     });

//     return popup;
// }


// || Tab
const TAB = "custom-tab";

function switchTab (btn) {
    const activeNavItem = $(".nav-tab-item.active");
    const targetNavItem = btn.parent();

    const currentTab = $(".custom-tab-content.show");
    const currentTabId = "#" + currentTab.attr("id");
    
    const targetTabId = btn.data("target");
    const targetTab = $(targetTabId);

    console.log("Button: " + targetTabId);
    console.log("Tab: " + currentTabId);

    if (targetTabId !== currentTabId) {
        // Removes active to tab button
        console.log("removing active to tab nav");
        activeNavItem.removeClass("active");

        // Hide current open tab
        console.log("removing show to tab");
        currentTab.removeClass("show");

        // Set tab button to active
        console.log("adding active to tab nav");
        targetNavItem.addClass("active");

        // Display target tab
        console.log("adding show to tab nav");
        targetTab.addClass("show");
    }
}

// Slide
const SLIDE = "slide";

function initSlide() {
    console.log("Initializing slide");
    $(".slide-container .slide[data-side='left']").css("margin-left", "-" + $(".slide[data-side='left']").width() + "px");
    $(".slide-container .slide[data-side='right']").css("margin-right", "-" + $(".slide[data-side='right']").width() + "px");

    $(".slide-fixed[data-side='right']:not(.active)").css("right", "-" + $(".slide[data-side='right']").width() + "px");
    $(".slide-fixed.active[data-side='right']").css("right", 0);

    $(".slide-container .slide.active[data-side='left']").css("left", $(".slide[data-side='left']").width() + "px");
    $(".slide-container .slide.active[data-side='right']").css("right", $(".slide[data-side='right']").width() + "px");
}

if ($(".slide[data-side]").length > 0) {
    let resizeObserver = new ResizeObserver(entries => {
        console.log("The element was resized");
        initSlide();
    });

    $(".slide[data-side]").each((index, element) => {
        console.log("Element Each");
        console.log(element);
        resizeObserver.observe(element);
    });

    initSlide();
} else {
    console.log("Info: No slide found.");
}

function toggleSlide(isShow, slide, isAnotherSlide = false) {
    let side = slide.data("side");
    console.log("isShow: " + isShow);
    console.log("side: " + side);

    if (isShow) {
        console.log("Opening slide");

        $(slide).addClass("active");

        if (!isAnotherSlide) {
            $("body").addClass("slide-open");
        }

        // Fixed slide
        if (slide.hasClass("slide-fixed")) {
            switch (side) {
                case "left":
                    slide.animate({left: 0}, 150);
                    break;
            
                case "right":
                    slide.animate({right: 0}, 150);
                    break;
            }
        }
        // Contained slide
        else {
            let leftPos = (side === "left") ? $(".slide[data-side='left']").width() + "px" : "auto";
            let rightPos = (side === "right") ? $(".slide[data-side='right']").width() + "px" : "auto";

            console.log("left: " + leftPos);
            console.log("right: " + rightPos);
            
            $(".slide-container .slide[data-side='" + side + "']").animate({
                left: leftPos,
                right: rightPos
            }, 150);
        }
    } else {
        console.log("Closing slide");

        // Fixed slide
        if (slide.hasClass("slide-fixed")) {
            switch (side) {
                case "left":
                    slide.animate({
                        left: "-" + $(".slide.slide-fixed.active[data-side='" + side + "']").width()
                    }, 150);
                    break;
            
                case "right":
                    slide.animate({
                        right: "-" + $(".slide.slide-fixed.active[data-side='" + side + "']").width()
                    }, 150);
                    break;
            }
        } 
        // Contained slide
        else {
            let hidePosL = (side === "left") ? 0 : "auto";
            let hidePosR = (side === "right") ? 0 : "auto";
            
            $(".slide-container .slide.active[data-side='" + side + "']").animate({
                left : hidePosL,
                right : hidePosR
            }, 150);
        }

        $(".slide.active[data-side='" + side + "']").removeClass("active");
        if (!isAnotherSlide) {
            $("body").removeClass("slide-open");
        }
    }
}

// || Form
const FORM = "form";

function editForm (formId) { 
    console.log($(formId));
    form = $(formId).find("form");

    form.addClass("edit");
    console.log(form.attr("action", "./link/submit"));
}

// || Buttons Listeners
$("button[data-toggle]").on("click", function (e) {
    console.log("Button clicked");

    const btnCLicked = $(this);
    const toggleElement = btnCLicked.data("toggle");
    const targetElementId = btnCLicked.data("target");
    
    switch (toggleElement) {
        case POPUP:
            console.log("Popup type");
            Popup.show($(btnCLicked.data("target")));
            break;
        case SLIDE:
            const targetSlide = $(targetElementId);

            if ($("body").hasClass("slide-open")) {
                console.log("A slide is open");

                let slideToClose = targetSlide;
                let isAnotherSlide = false;

                if (!$('.slide.active').is(targetSlide)) {
                    slideToClose = $('.slide.active');
                    isAnotherSlide = true;
                    toggleSlide(true, targetSlide, isAnotherSlide);
                }
                
                // Hides slide
                console.log("hide slide");
                toggleSlide(false, slideToClose, isAnotherSlide);
              } else {
                // Show slide
                console.log("show slide");
                toggleSlide(true, targetSlide);
              }
            break;
        case TAB:
            console.log("index.js: Show tab");
            switchTab(btnCLicked);
            break;
        // case FORM:
        //     console.log("Form button");
        //     let form = $("#" + btnCLicked.attr("form"));

        //       switch(btnCLicked.data("action")) {

        //         case "edit":
                    
        //             break;

        //         case "submit":
        //             console.log("Submit");
        //             // form.find("textarea, input").attr("readonly", true);

        //             // btnCLicked.text("Edit");
        //             // btnCLicked.data("action", "edit");
        //             btnCLicked.attr("type", "submit");
        //             break;
        //       }
        //     break;
    }
});

// function editForm(btn, fun = null) {  
//     console.log("Edit Form");

//     let form = $("#" + btn.attr("form"));

//     form.find("textarea, input").removeAttr("readonly");

//     btn.text("Done");
//     btn.data("action", "submit");
//     btn.attr("type", "button");

//     if (fun != null) {
//         fun(asdasd);
//     }
// }



$("button[data-dismiss]").on("click", function (e) {
    console.log("Button dismiss");
    const btnCLicked = $(this);
    const dismissElement = $(this).data("dismiss");
    // console.log(dismissElement);
    switch (dismissElement) {
        case POPUP:
            Popup.hide(e);
            break;
        case SLIDE:
            console.log("Dismiss slide");
            toggleSlide(false, $(".slide.active"));
            break;
    }
});



// Textarea
let textAreas = document.getElementsByTagName("textarea");
for (let i = 0; i < textAreas.length; i++) {
    Utils.autoHeight(textAreas[i]);
}

$("textarea").on("input", function() {
    Utils.autoHeight(this);
});