/**
* Transition effects for bookmark menu items
*/
$.fn.moveItBars = function (speed) {
    var visiblePartWidth = this.find('.glyphicon').width();
    var hiddenPartWidth = this.width() - visiblePartWidth;

    this.hover(function (event) {
        event.preventDefault();
        this.css({"margin-right": -hiddenPartWidth + "px", "transition": speed + "s ease"});
    });

    this.mouseleave(function (event) {
        event.preventDefault();
        this.css("margin-right", 0);
    });

};

$(document).ready(function () {
    $(".bookmark-contact").moveItBars(0.9);
    $(".bookmark-home").moveItBars(0.9);
    $(".bookmark-menu").moveItBars(0.5);
    $(".bookmark-photos").moveItBars(0.5);
});
