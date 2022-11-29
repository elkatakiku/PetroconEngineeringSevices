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

// $("#createAccountBtn").click(function(){
        // $(".form-login").hide();
    // $(".form-login").css("left", "100%").fadeOut();
// });

// Sidebar
function expand() { 
    $('#sidebar').toggleClass('inactive');
    $('.sub-menu.show').collapse('hide');
}

// Sidebar Buttons Listener
$('#sidebarExpandToggler, #sidebarCollapseToggler').on('click', expand);
$('.sub-menu').on('show.bs.collapse' , () => {
    if ($(window).width() > 768) {
        $('#sidebar').removeClass('inactive');
    }
});

// Toggles
const POPUP = "popup";
const SLIDE = "slide";
const TAB = "custom-tab";

// Animation Names
const SLIDE_OUT_TOP = "slide-out-top";
const SLIDE_DOWN = "slide-down";

// Popup 
function showPopup(btn) {
    $(btn.data("target")).addClass("show");
    $("body").addClass("popup-open");
    $("body").append("<div class='popup-backdrop'></div>");
}

function hidePopup() {
    console.log("Hide popup");
    let popupElement = $(".popup.show");

    popupElement.on("animationend", function (e) {
        console.log("Animation end: " + e.originalEvent.animationName);
        const ANIMATION_NAME = e.originalEvent.animationName;
        // removeAnimation(e.originalEvent.animationName);
        // console.log("Animation end: " + animationName);
        switch (ANIMATION_NAME) {
            case SLIDE_OUT_TOP:
                $(".popup").removeClass(SLIDE_OUT_TOP);
                removePopup(popupElement);
                break;
            case SLIDE_DOWN:
                $(".popup").removeClass(SLIDE_DOWN);
                removePopup(popupElement);
                break;
            default:
                console.log("removeAnimation: Error! " + ANIMATION_NAME + " name not valid.");
                break;
        }

    });

    if (popupElement.hasClass("fade")) {
        console.log("Is fade");
        popupElement.addClass(SLIDE_OUT_TOP);
    } else if (popupElement.hasClass("popup-below")) {
        console.log("Is popup below");
        popupElement.addClass(SLIDE_DOWN);
    }
}

function removeAnimation(animationName) {
    console.log("Animation end: " + animationName);
    switch (animationName) {
        case SLIDE_OUT_TOP:
            $(".popup").removeClass(SLIDE_OUT_TOP);
            break;
        case SLIDE_DOWN:
            $(".popup").removeClass(SLIDE_DOWN);
            break;
        default:
            console.log("removeAnimation: Error! " + animationName + " name not valid.");
            break;
    }
}

function removePopup(popupElement) {
    $("body").removeClass("popup-open");
    popupElement.removeClass("show");
    $(".popup-backdrop").remove();
}

// Tab
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


$("button[data-toggle]").on("click", function (e) {
    console.log("Button clicked");
    console.log($(this).attr("id"));

    const btnCLicked = $(this);
    const toggleElement = btnCLicked.data("toggle");
    
    switch (toggleElement) {
        case POPUP:
            showPopup(btnCLicked);
            break;
        case SLIDE:
            console.log("index.js: Show slide");
            break;
        case TAB:
            console.log("index.js: Show tab");
            switchTab(btnCLicked);
            break;
    }
});

$("button[data-dismiss]").on("click", function (e) {
    const btnCLicked = $(this);
    const dismissElement = $(this).data("dismiss");
    console.log(dismissElement);
    switch (dismissElement) {
        case POPUP:
            hidePopup();
            break;
        case SLIDE:
            console.log("Dismiss slide");
            break;
    }
});
