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
const FORM = "form";

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
if ($("#topbar").length > 0) {
    $(".slide.slide-fixed").css({
        "top": $("#topbar")[0].scrollHeight + "px"
    });
    
    $(".slide.slide-fixed .slide-content").css({
        "height": 'calc(100vh - ' + $("#topbar")[0].scrollHeight + "px" + ')'
    });
} else {
    console.log("Error! No topbar found.");
}

function initSlide() {
    console.log("Initializing slide");
    $(".slide-container .slide[data-side='left']").css("margin-left", "-" + $(".slide[data-side='left']").width() + "px");
    $(".slide-container .slide[data-side='right']").css("margin-right", "-" + $(".slide[data-side='right']").width() + "px");
}

if ($(".slide").length > 0) {
    let resizeObserver = new ResizeObserver(entries => {
        console.log("The element was resized");
        initSlide();
    });
    
    resizeObserver.observe($(".slide[data-side='left']")[0]);
    resizeObserver.observe($(".slide[data-side='right']")[0]);

    initSlide();
}

function toggleSlide(toggle, slideElement) {
    let side = slideElement.data("side");
    console.log("toggle: " + toggle);
    console.log("side: " + side);
    
    switch (toggle) {
        
      case "show": 
        console.log("Opening slide");

        $(slideElement).addClass("active");
        $("body").addClass("slide-open");

        // Fixed slide
        if (slideElement.hasClass("slide-fixed")) {
            switch (side) {
                case "left":
                    slideElement.animate({
                        "left": 0
                    }, 150);
                    break;
            
                case "right":
                    slideElement.animate({
                        "right": 0
                    }, 150);
                    
                    break;
            }
            
            return;
            break;
        }
        // Contained slide
        else {
            let leftPos = (side === "left") ? $(".slide[data-side='left']").width() + "px" : "auto";
            let rightPos = (side === "right") ? $(".slide[data-side='right']").width() + "px" : "auto";

            console.log("left: " + leftPos);
            console.log("right: " + rightPos);
            
            $(".slide-container .slide[data-side='" + side + "']").animate({
            "left": leftPos,
            "right": rightPos
            }, 150);
        }

        break;

      case "hide":
        console.log("Closing slide");

        // Fixed slide
        if (slideElement.hasClass("slide-fixed")) {
            switch (side) {
                case "left":
                    slideElement.animate({
                        "left": "-" + $(".slide.slide-fixed.active[data-side='" + side + "']").width()
                    }, 150);
                    break;
            
                case "right":
                    slideElement.animate({
                        "right": "-" + $(".slide.slide-fixed.active[data-side='" + side + "']").width()
                    }, 150);
                    break;
            }
        } 
        // Contained slide
        else {
            let hidePosL = (side === "left") ? 0 : "auto";
            let hidePosR = (side === "right") ? 0 : "auto";
            
            $(".slide-container .slide.active[data-side='" + side + "']").animate({
                "left" : hidePosL,
                "right" : hidePosR
            }, 150);
        }

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
    const targetElementId = btnCLicked.data("target");
    
    switch (toggleElement) {
        case POPUP:
            showPopup(btnCLicked);
            break;
        case SLIDE:
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
        case FORM:
            console.log("Form button");
              let form = $(btnCLicked.data("target"));

              switch(btnCLicked.data("action")) {

                case "edit":
                    
                    let submitBtn = $("button[data-toggle='form'][data-action='submit'][data-target='" + targetElementId + "']");
                    
                    btnCLicked.removeClass("show");
                    btnCLicked.addClass("hide");

                    submitBtn.addClass("show");
                    submitBtn.removeClass("hide");

                    form.addClass("form-open");
                    form.find(".form-input-group").removeClass("display");

                    break;

                case "submit": 
                    let editBtn = $("button[data-toggle='form'][data-action='edit'][data-target='" + targetElementId + "']");
                    btnCLicked.removeClass("show");
                    btnCLicked.addClass("hide");

                    editBtn.addClass("show");
                    editBtn.removeClass("hide");

                    form.removeClass("form-open");
                    form.find(".form-input-group").addClass("display");
                    break;
              }
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