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

$("#createAccountBtn").click(function(){
        // $(".form-login").hide();
    $(".form-login").css("left", "100%").fadeOut();
});

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

const POPUP = "popup";
const SLIDE = "slide";
const TAB = "tab";

// Popup 
function showPopup(btn) {
    console.log("Target");
    console.log(targetElement);
    const targetElement = $(btn.data("target"));
    targetElement.addClass("show");
    $("body").addClass("popup-open");
    targetElement.css("padding-right", "");
    targetElement.css("display", "block");
    $("body").append("<div class='popup-backdrop'></div>");
}

function hidePopup() {
    console.log("Hiding popup");
    let POPUP_ELEMENT = $(".popup.show");
    // console.log(POPUP_ELEMENT);

    if (POPUP_ELEMENT.hasClass("fade")) {
        POPUP_ELEMENT.addClass("slide-out-top");
        POPUP_ELEMENT.on("animationend", function (e) {
        const ANIMATION_NAME = e.originalEvent.animationName;
        console.log(ANIMATION_NAME);
        if (ANIMATION_NAME === "slide-out-top") {
            $(".popup").removeClass(ANIMATION_NAME);
            endPopup(POPUP_ELEMENT);
        }
        });
    } else if (POPUP_ELEMENT.hasClass("popup-below")) {
        // console.log("Is a popup below");
        POPUP_ELEMENT.addClass("slide-down");

        POPUP_ELEMENT.on("animationend", function (e) {
            console.log(e);

            // Checks if slide down ended
            if (e.originalEvent.animationName === "slide-down") {
                $(".popup").removeClass("slide-down");
                endPopup(POPUP_ELEMENT);
            }
        });
    }
}

function endPopup(POPUP_ELEMENT) {
    $("body").removeClass("popup-open");
    POPUP_ELEMENT.removeClass("show");
    POPUP_ELEMENT.css("padding-right", "");
    POPUP_ELEMENT.css("display", "none");
    $(".popup-backdrop").remove();
}

// Tab
function switchTab (btn) {
    const activeNavItem = $(".nav-tab-item.active");
    const targetNavItem = btn.parent();

    const currentTab = $(".tab-content.show");
    const currentTabId = "#" + currentTab.attr("id");
    
    const targetTabId = btn.data("target");
    const targetTab = $(targetTabId);

    console.log("Button: " + targetTabId);
    console.log("Tab: " + currentTabId);

    if (targetTabId !== currentTabId) {
    // Removes active to tab button
    activeNavItem.removeClass("active");

    // Hide current open tab
    currentTab.css("display", "none");
    currentTab.removeClass("show");

    // Set tab button to active
    targetNavItem.addClass("active");

    // Display target tab
    targetTab.css("display", "block");
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
            console.log("Show slide");
            break;
        case TAB:
            switchTab(btnCLicked);
            break;
    }
});

$("button[data-dismiss]").on("click", function (e) {
    const DISMISS_ELEMENT = $(this).data("dismiss");
    console.log(DISMISS_ELEMENT);
    switch (DISMISS_ELEMENT) {
        case POPUP:
            hidePopup();
            break;
        case SLIDE:
            console.log("Dismiss slide");
            break;
    }

    console.log($(this).data("dismiss"));
});
