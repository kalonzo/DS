
/**
*transition effects for bookmark menu items
*/

$.fn.moveItBars = function (speed) {
    //offset = height of icon to show a square
    var offset = this.height();
    var bookmarkSize = offset - this.width();
    var theTarget = this;

    this.hover(function (event) {
        event.preventDefault();
        theTarget.css({"margin-right": bookmarkSize + "px", "transition": speed + "s ease"});
    });

    this.mouseleave(function (event) {
        event.preventDefault();
        theTarget.css("margin-right", 0);
    });

};

$(document).ready(function () {
    $(".bookmark-contact").moveItBars(0.9);
    $(".bookmark-home").moveItBars(0.9);
    $(".bookmark-menu").moveItBars(0.5);
    $(".bookmark-photos").moveItBars(0.5);
});
