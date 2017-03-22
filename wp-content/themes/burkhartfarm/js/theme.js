jQuery(function($) {
    var $ = jQuery;
    setDotsBgHeight();

    $(window).resize(function() {
        setDotsBgHeight();
    });

});

function setDotsBgHeight() {
    var $ = jQuery;
    var screenH = $(document).height();
    $(".dots").css('height', screenH);
}