$.fn.myfunction = function() {
    // alert('hello world');
    console.log(this);

    return this;
 };

$('.linear').myfunction();

console.log($(".linear-container").data('padding'));

// Cover
$('.cover-background').css('background-image', 'url("../images/' + $('.cover-background').data('image') + '")');