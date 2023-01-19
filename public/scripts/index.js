import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';
import * as Popup from '/PetroconEngineeringServices/public/scripts/module/popup.js';

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
    var totalItems = $('.carousel-item').length; 
    if (idx >= totalItems - (itemsPerSlide - 1)) {
        var it = itemsPerSlide - (totalItems - idx);
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

    // Removes sidebar collapsibles width property
    if($(window).width() < 768) {
        $("#sidebar .collapsible").css('width', "");
    }

});

// Sidebar Listener
$("#sidebarCollapseToggler").click(() => {expandSidebar();});

// Closes sidebar when clicked anywhere
$(document).click((e) => {
    if (!$(e.target).is("#sidebar, #sidebar *, #sidebarCollapseToggler") && $('#sidebar.active').length > 0) {
        expandSidebar();
    }
});


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

    $('.nav-tab').trigger('custom:tabChange', [currentTab, targetTabId]);

    if (targetTabId !== currentTabId) {
        // Removes active to tab button
        console.log("removing active to tab nav");
        activeNavItem.removeClass("active");

        // Hide current open tab
        console.log("removing show to tab");
        currentTab.removeClass("show");
        currentTab.trigger('custom:hide');

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

// Image Overlay
if ($(".image-overlay").length > 0) {   
    $(".image-overlay").css("backgroundImage", "url(" + Settings.base_url + "/public/images/" + $(".image-overlay").attr("data-image") + ")" );
    $(".image-overlay").css("height", $(".image-overlay").attr("data-height"));
}

// Cover
$('.cover-background').css('background-image', 'url("' + Settings.base_url + '/public/images/' + $('.cover-background').data('image') + '")');


// || Slider
// $('.slider').children().each((index, element) => {
//     console.log(element);
//     $(element).hide();
// });
// $('.slider').find()

let prevText;

$('[data-slider]').on('click', (e) => {
    console.log("Slider");

    $(e.target).prop('disabled', true);
    let btn = $(e.target);
    let slider = $(btn.data('slider'));
    let active = slider.find('div.active');
    let next = active.next();
    let prev = active.prev();

    let after = () => {
        active.removeClass('active');
        active.css('margin-left', '');
        btn.trigger('custom:clicked', [btn]);
    };

    if (btn.data('action') === 'next' && next.index() !== -1) 
    {
        $('[data-slider="' + btn.data('slider') +'"][data-action="prev"]').show();
        next.addClass('active');
        active.animate({
            'margin-left' : '-100%'
        }, after);

        if (next.next() !== -1) {
            // if (typeof btn.attr('form') != 'undefined') {
            //     btn.attr('type', 'submit');
            //     prevText = btn.text();
            //     btn.text('Submit');
            // } else {
                btn.hide();
            // }
        }
    } else if (btn.data('action') === 'prev' && prev.index() !== -1) 
    {
        $('[data-slider="' + btn.data('slider') +'"][data-action="next"]')
            .text(prevText)
            .show();
        prev.addClass('active');
        prev.css('margin-left', '-100%')
            .animate({
                'margin-left' : '0'
            }, after);

        if (prev.prev() !== -1) {
            btn.hide();
        }
    } else {
        btn.trigger('custom:clicked', [btn]);
    }
});
console.log('Buttons');
console.log($('button'));
$('button').on('custom:clicked', (e, btn) => {
    console.log("Disable")
    $(e.target).prop('disabled', false);
});

// Nav-item
$('#navItemBar .nav-item').on('click', (e) => {
    console.log($(e.target).parent('.nav-item').siblings('.active').removeClass('active'));
});
$('input, textarea').on('keydown', (e) => {
    $('.alert-danger').removeClass('show').text('');
});

//  Form
$('form').on('custom:submitted', (e) => {
    Utils.toggleForm($(e.target), false);
});