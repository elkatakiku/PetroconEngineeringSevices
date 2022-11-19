/*
Carousel
*/
console.log("JS Connected");
$('#project-carousel').on('slide.bs.carousel', function(e) {
    /*
        CC 2.0 License Iatek LLC 2018 - Attribution required
    */
    var idx = $(e.relatedTarget).index(); 
    // console.log("previous element: ");
    // console.log($(e.relatedTarget).prev());
    // console.log("current element: ");
    // console.log(e);
    // console.log(idx);
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
$('#sidebarExpandToggler').on('click', expand);
$('#sidebarCollapseToggler').on('click', expand);

    // if ($(window).width() < 768) {
    //     console.log('Less than 768');
    //  }
    //  else {
    //     $("#sidebar").mouseover(function() {
    //         if ($(window).width() > 768) {
    //             if(!setExpand) {
    //                 $('#sidebar').removeClass('inactive');
    //             }
    //         }
    //     }).mouseleave(function () { 
    //         if(!setExpand) {
    //             $('#sidebar').addClass('inactive');
    //         }
    //     });
    //  }
