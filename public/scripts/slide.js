function initSlide() {
    $(".custom-tab-container:has(.slide[data-side='left'])").css("margin-left", "-" + $(".slide[data-side='left']").width() + "px");
    $(".custom-tab-container:has(.slide[data-side='right'])").css("margin-right", "-" + $(".slide[data-side='right']").width() + "px");
}

let resizeObserver = new ResizeObserver(entries => {
    console.log("The element was resized");
    initSlide();
});

resizeObserver.observe($(".slide[data-side='left']")[0]);
resizeObserver.observe($(".slide[data-side='right']")[0]);

initSlide();