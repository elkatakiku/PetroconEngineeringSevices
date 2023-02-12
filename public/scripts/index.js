// Local
import * as Utils from '/PetroconEngineeringServices/public/scripts/module/utils.js';
import * as Popup from '/PetroconEngineeringServices/public/scripts/module/popup.js';

// Server
// import * as Utils from '/public/scripts/module/utils.js';
// import * as Popup from '/public/scripts/module/popup.js';

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
            if (e.direction === "left") {
                $('.carousel-item').eq(i).appendTo('.carousel-inner');
            } else {
                $('.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});

// Sidebar
const sidebar = $("#sidebar");
function expandSidebar(submenu = false) { 
    if (submenu && sidebar.hasClass("active")) {
        return;
    }

    if (sidebar.hasClass("active")) {
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
$("#sidebarCollapseToggler").on('click',() => {expandSidebar();});

// Closes sidebar when clicked anywhere
$(document).on('click',(e) => {
    let target = $(e.target);
    if (!target.is("#sidebar, #sidebar *, #sidebarCollapseToggler") && $('#sidebar.active').length > 0) {
        expandSidebar();
    }

    if (!target.is('.dots-menu-popup')) {
        $('.dots-menu-popup').remove();
    }
});


// || Popup
const POPUP = "popup";

// Dismisses popup when click elsewhere
$(".popup").on('click',(e) => {
    console.log("Popup clicked");

    // Closes popup when clicked outside popup content
    if ($(e.target).hasClass('popup')) {
        Popup.hide(e);
    }
});

// || Tab
const TAB = "custom-tab";

function switchTab (btn)
{
    const activeNavItem = $(".nav-tab-item.active");
    const targetNavItem = btn.parent();

    const currentTab = $(".custom-tab-content.show");
    const currentTabId = "#" + currentTab.attr("id");
    
    const targetTabId = btn.data("target");
    const targetTab = $(targetTabId);

    $('.nav-tab').trigger('custom:tabChange', [currentTab, targetTabId]);

    if (targetTabId !== currentTabId) {
        // Removes active to tab button
        activeNavItem.removeClass("active");

        // Hide current open tab
        currentTab.removeClass("show");
        currentTab.trigger('custom:hide');

        // Set tab button to active
        targetNavItem.addClass("active");

        // Display target tab
        targetTab.addClass("show");
    }
}

// Slide
const SLIDE = "slide";

function initSlide()
{
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
}

function toggleSlide(isShow, slide, isAnotherSlide = false) {
    let side = slide.data("side");

    if (isShow)
    {
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
                let activeSlide = $('.slide.active');

                if (!activeSlide.is(targetSlide)) {
                    slideToClose = activeSlide;
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
            switchTab(btnCLicked);
            break;
    }
});

// Button dismiss
$("button[data-dismiss]").on("click", function (e)
{
    const dismissElement = $(this).data("dismiss");
    switch (dismissElement) {
        case POPUP:
            Popup.hide(e);
            break;
        case SLIDE:
            toggleSlide(false, $(".slide.active"));
            break;
    }
});


// Textarea
let textAreas = $("textarea");
for (let i = 0; i < textAreas.length; i++) {
    Utils.autoHeight(textAreas[i]);
}

textAreas.on("input", function() {
    Utils.autoHeight(this);
});

// Image Overlay
let imageOverlay = $(".image-overlay");
if (imageOverlay.length > 0) {
    imageOverlay.css("backgroundImage", "url(" + Settings.base_url + "/public/images/" + imageOverlay.attr("data-image") + ")" );
    imageOverlay.css("height", imageOverlay.attr("data-height"));
}

// Background Cover
let cover = $('.cover-background');
cover.css('background-image', 'url("' + Settings.base_url + '/public/images/' + cover.data('image') + '")');

// Nav-item
$('#navItemBar .nav-item').on('click', (e) =>
{
    $(e.target).parent('.nav-item').siblings('.active').removeClass('active');
});

//  Form
$('form').on('custom:submitted', (e) => {
    Utils.toggleForm($(e.target), false);
});

// Remove alert on form inputs change
$('input, textarea').on('keydown', (e) => {
    $('.alert-danger').removeClass('show').text('');
});

// || Date Duration

// Start
$('input[data-start]').on('change', (e) => {
    $('input[data-end="'+e.target.dataset.start+'"]').attr('min', e.target.value);
});

// End
$('input[data-end]').on('change', (e) => {
    $('input[data-start="'+e.target.dataset.end+'"]').attr('max', e.target.value);
});

// || Data Validation
function validateInput(element, controller, errorMessage)
{
    $(element).siblings('.loading').show();

    element.setCustomValidity("Checking...");

    $.get(
        Settings.base_url + controller,
        {input : $(element).val()},
        function (data)
        {
            let response = JSON.parse(data);

            if (!response.data)
            {
                element.setCustomValidity(errorMessage);

                $(element)
                    .removeClass('success-border')
                    .addClass('danger-border')
                    .parents('.loading-input')
                    .siblings('.text-danger')
                    .text(element.validationMessage)
                    .show();
            }
            else
            {
                element.setCustomValidity("");
                $(element)
                    .removeClass('danger-border')
                    .addClass('success-border')
                    .parents('.loading-input')
                    .siblings('.text-danger')
                    .text(element.validationMessage)
                    .hide();
            }

            $(element).siblings('.loading').hide();
        }
    );
}

// Signup Email
let typeTimer;
const emailInput = $('[data-validate="userEmail"]');

emailInput.on('input', (e) =>
{
    e.target.setCustomValidity("");

    clearTimeout(typeTimer);
    if (e.target.checkValidity())
    {
        e.target.setCustomValidity("Checking...");

        typeTimer = setTimeout(() => {
            validateInput(e.target, '/user/checkEmail', 'Email is already taken');
        }, 1000);
    }

    emailInput
        .removeClass('success-border')
        .addClass('danger-border')
        .parents('.loading-input')
        .siblings('.text-danger')
        .text(e.target.validationMessage)
        .show();

});

// Password
const password = $('[data-validate="password"]');
let lowerCaseLetters = /[a-z]/g;
let upperCaseLetters = /[A-Z]/g;
let numbers = /[0-9]/g;

password.on('input', (e) =>
{
    let element = e.target;
    let error = "";

    if(!element.value.match(lowerCaseLetters)) {
        error = "Must contain at least one lowercase letters.";
    } else if (!element.value.match(upperCaseLetters)) {
        error = "Must contain at least one uppercase letters.";
    } else if (!element.value.match(numbers)) {
        error = "Must contain at least one number.";
    } else if (element.value.trim().length < 8) {
        error = "Must have a minimum of 8 characters.";
    }

    element.setCustomValidity(error);

    if (element.checkValidity()) {
        password
            .removeClass('danger-border')
            .addClass('success-border')
            .siblings('.text-danger')
            .text('')
            .hide();
    } else {
        password
            .removeClass('success-border')
            .addClass('danger-border')
            .siblings('.text-danger')
            .text(error)
            .show();
    }

    element.reportValidity();
})

// Password Repeat
const passwordRepeat = $('[data-validate="passwordRepeat"]');
passwordRepeat.on('input', (e) =>
{
    if (passwordRepeat.val() === password.val())
    {
        passwordRepeat
            .removeClass('danger-border')
            .addClass('success-border')
            .siblings('.text-danger')
            .text('')
            .hide();

        e.target.setCustomValidity('');
    } else {
        passwordRepeat
            .removeClass('success-border')
            .addClass('danger-border')
            .siblings('.text-danger')
            .text('Password does not match')
            .show();

        e.target.setCustomValidity('Password does not match.');
    }

    e.target.reportValidity();
});

// Contact Number
$('.contact-number').on('keyup keydown change', (e) =>
{
    if ((!/\d/.test(e.key) || e.target.value.trim().length >= 10) && e.key !== "Delete" && e.key !== "Backspace") {
        e.preventDefault();
    }
});