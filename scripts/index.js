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

// $("#createAccountBtn").click(function (e) { 
//     // e.preventDefault();
//     console.log(e);
//     $(".form-login").slideUp();
// });

$("#createAccountBtn").click(function(){
        // $(".form-login").hide();
    $(".form-login").css("left", "100%").fadeOut();
    
  });