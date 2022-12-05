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
function expandSidebar() { 
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
        expandSidebar();
    }
});


// Responsive to width
$(window).on("resize", (e) => {
    // Removes width property
    if($(window).width() < 780) {
        $("#sidebar .collapsible").css({
          width: ""
        });
      }
});

$("#sidebarCollapseToggler").click((e) => {
    expandSidebar();
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

// Slide
function toggleSlide(toggle, slideElement) {
    let side = slideElement.data("side");
    console.log("toggle: " + toggle);
    console.log("side: " + side);
    switch (toggle) {
      case "show": 
        console.log("Opening slide");

        
        $(slideElement).addClass("active");
        $("body").addClass("slide-open");

        let leftPos = (side === "left") ? $(".slide[data-side='left']").width() + "px" : "auto";
        let rightPos = (side === "right") ? $(".slide[data-side='right']").width() + "px" : "auto";

        console.log("left: " + leftPos);
        console.log("right: " + rightPos);
        
        $(".custom-tab-container .slide[data-side='" + side + "']").animate({
          "left": leftPos,
          "right": rightPos
        }, 150);

        break;

      case "hide":
        console.log("Closing slide");

        let hidePosL = (side === "left") ? 0 : "auto";
        let hidePosR = (side === "right") ? 0 : "auto";
        
        $(".custom-tab-container .slide.active[data-side='" + side + "']").animate({
          "left" : hidePosL,
          "right" : hidePosR
        }, 150);
        
        $(".slide.active[data-side='" + side + "']").removeClass("active");
        $("body").removeClass("slide-open");
        break;
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
            const targetElementId = btnCLicked.data("target");
            const targetSlide = $(targetElementId);

            if ($("body").hasClass("slide-open")) {
                // Hides slide
                console.log("hide slide");
                toggleSlide("hide", targetSlide);

              } else {
                // Show slide
                console.log("show slide");
                toggleSlide("show", targetSlide);
              }
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
            toggleSlide("hide", $(".slide.active"));
            break;
    }
});


$("textarea").on("input", function() {
    this.style.minHeight = "1rem";
    this.style.height = "auto";
    this.style.height = (this.scrollHeight) + "px";
    this.style.overflowY = "hidden";
});