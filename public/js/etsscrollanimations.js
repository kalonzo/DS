/* 
 * Author: Ang
 * Description: We want target element when at a certain % of viewport to receive an animation type
 * e.g fade in
 */

//parameter screenpctoffset, offsets by a % of screen when the element is detected in viewport
//before some event is launched returns true or false
$.fn.isInViewport  = function(screenpctoffset) {
  var elementTop = $(this).offset().top;
  var elementBottom = elementTop +  $(this).outerHeight();

  var viewportTop = $(window).scrollTop();
  var viewportBottom = viewportTop + $(window).height();
  viewportBottom = viewportBottom*(1-screenpctoffset);

  return elementBottom > viewportTop && elementTop < viewportBottom;
};

$.fn.scrollInDisplay = function(fadeTime, offset) {
    var see =  $(this).isInViewport(offset);
    if(see){
        $(this).fadeIn(fadeTime);
    }
};

//
$(document).ready(function(){


 
//0-1
var itemsOffset = 0.3;
//ms
var fadeInTime = 1000;

//simple fade in on load after a short delay when page is ready
setTimeout(function() { 
    $( ".show-page section.ets-intro h1").scrollInDisplay(fadeInTime,itemsOffset);
    $( ".show-page section.ets-intro h2").scrollInDisplay(fadeInTime,itemsOffset);
    $( ".show-page section.ets-intro h3").scrollInDisplay(fadeInTime,itemsOffset);

 
/*
 .show-page section.ets-timetable
.show-page section:not(.ets-intro) h1
.show-page section:not(.ets-intro) h2
.show-page section:not(.ets-intro) h3
.show-page section.ets-contact .quick-map
 */

/*    
    $(window).scroll(function() {
        $(".show-page section:not(.ets-intro) h1").scrollInDisplay(fadeInTime, itemsOffset);
        $(".show-page section:not(.ets-intro) h2").scrollInDisplay(fadeInTime, itemsOffset);
        $(".show-page section:not(.ets-intro) h3").scrollInDisplay(fadeInTime, itemsOffset);
        $(".show-page section.ets-timetable").scrollInDisplay(fadeInTime, itemsOffset);
        $(".show-page section.ets-contact").scrollInDisplay(fadeInTime, itemsOffset);
    });
    */
   
}, 1000);

});


