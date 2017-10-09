
/*
transition effects
-webkit-transition: $menus-transition-speed ease;
-moz-transition: $menus-transition-speed ease;
-o-transition: $menus-transition-speed ease;
-ms-transition: $menus-transition-speed ease;
transition: $menus-transition-speed ease;
*/

//Movitebards, moves the bars in the side menu based upon div size of the element
//Try to target the whole outer div for correct movement
//e.g: $(".class").moveitbars();
$.fn.moveitbars = function(speed) {
    var offset = 41;
    var bookmarkSize =  offset - this.width();
    var thetarget = this;
    
    this.hover(function(event){
	    event.preventDefault();
	    thetarget.css({"margin-right" : bookmarkSize + "px", "transition" : speed +"s ease"}); 
	  });
  
    this.mouseleave(function(event){
	    event.preventDefault();
	    thetarget.css("margin-right", 0); 
	  });

};

$(document).ready(function(){
          $(".bookmark-contact").moveitbars(0.9);
          $(".bookmark-home").moveitbars(0.9);
          $(".bookmark-menu").moveitbars(0.5);
          $(".bookmark-photos").moveitbars(0.5);


});
