(function($){

    $('.gallery').lightbox({minSize: 480,blur:false, nav:false});

})(jQuery);


/*no conflict jQuery*/
/*
var $j = jQuery.noConflict();

$j(function(){

    $j("#sidebar li a").hover(function(){
        $j(this).stop().animate({
            paddingLeft: "20px&"
        }, 400);
    }, function() {
        $j(this).stop().animate({
            paddingLeft: 0
        }, 400);
    });

});
*/
