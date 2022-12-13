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
$(".popup").click((e) => {
    if ($(e.target).hasClass('popup')) {
        hidePopup();
    }
});

function showPopup(btn) {
    console.log("Popup button clicked");
    $(btn.data("target")).addClass("show");

    if(!$(btn.data("target")).hasClass("popup-contained")) {   
        $("body").addClass("popup-open");
    }

    if (btn.data("backdrop") !== false) {
        $("body").append("<div class='popup-backdrop'></div>");
    }


    if (btn.data("action")) {
        editForm(btn.data("target"));
    }
}

function hidePopup() {
    console.log("Hide popup");
    let popupElement = $(".popup.show");

    popupElement.on("animationend", function (e) {
        console.log("Animation end: " + e.originalEvent.animationName);
        const ANIMATION_NAME = e.originalEvent.animationName;
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
    } else {
        removePopup(popupElement);
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
    console.log("Info: No topbar found.");
}

function initSlide() {
    console.log("Initializing slide");
    $(".slide-container .slide[data-side='left']").css("margin-left", "-" + $(".slide[data-side='left']").width() + "px");
    $(".slide-container .slide[data-side='right']").css("margin-right", "-" + $(".slide[data-side='right']").width() + "px");

    $(".slide-container .slide.active[data-side='left']").css("left", $(".slide[data-side='left']").width() + "px");
    $(".slide-container .slide.active[data-side='right']").css("right", $(".slide[data-side='right']").width() + "px");
}

if ($(".slide[data-side]").length > 0) {
    let resizeObserver = new ResizeObserver(entries => {
        console.log("The element was resized");
        initSlide();
    });
    
    resizeObserver.observe($(".slide[data-side='left']")[0]);
    resizeObserver.observe($(".slide[data-side='right']")[0]);

    initSlide();
} else {
    console.log("Info: No slide found.");
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
            let form = $("#" + btnCLicked.attr("form"));

              switch(btnCLicked.data("action")) {

                case "edit":
                    console.log("Edit Form");
                    form.find("textarea, input").removeAttr("readonly");

                    btnCLicked.text("Done");
                    btnCLicked.data("action", "submit");
                    btnCLicked.attr("type", "button");
                    break;

                case "submit": 
                    console.log("Submit");
                    form.find("textarea, input").attr("readonly", true);

                    btnCLicked.text("Edit");
                    btnCLicked.data("action", "edit");
                    btnCLicked.attr("type", "submit");
                    break;
              }
            break;
    }
});

function editForm (formId) { 
    console.log($(formId));
    form = $(formId).find("form");

    form.addClass("edit");
    console.log(form.attr("action", "./link/submit"));
}

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

// Textarea
let textAreas = document.getElementsByTagName("textarea");
for (let i = 0; i < textAreas.length; i++) {
    autoHeight(textAreas[i]);
}

function autoHeight(input) {
    console.log("AutoHeight");
    console.log(input);
    input.style.minHeight = "1rem";
    input.style.height = "auto";
    input.style.height = (input.scrollHeight) + "px";
    input.style.overflowY = "hidden";
}

$("textarea").on("input", function() {
    autoHeight(this);
});