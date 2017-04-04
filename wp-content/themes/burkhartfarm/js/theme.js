jQuery(function($) {
    var $ = jQuery;
    setOddsEndsWrapperHeight();
    setInsideBannerHeight();
    $('#mega-menu-primary a').each(function() {
        if ($(this).attr('href') == window.location.href) {
            $(this).parents('li').addClass('navPage');
        }
    });
    if($(".owl-carousel").length) {
        $(".owl-carousel").owlCarousel({
            items:1,
            margin:0,
            nav:true,
            navText:['<span class="fa fa-angle-left"></span>','<span class="fa fa-angle-right"></span>']
        });
    }
    $(window).resize(function() {
        //setMegaMenuWidth();
        setOddsEndsWrapperHeight();
        setInsideBannerHeight();
    });
    $('.top').click(function(event){
        $('html, body').animate({
            scrollTop: $('[name="top"]').offset().top -50
        }, 500);
        event.preventDefault();
    });
    $(".search-link").click(function() {
        var h = $(".search-container").height();
        $(".search-container").toggleClass('show-search');
    });
    $(".close-search").click(function() {
        $(".search-container").removeClass('show-search');
    });
});

function setDotsBgHeight() {
    var $ = jQuery;
    var screenH = $(document).height();
    $(".dots").css('height', screenH);
}

function setMegaMenuWidth() {
    var $ = jQuery;
    var screenW = $(document).width();
    if(screenW < 1150) {
        $("#mega-menu-wrap-primary #mega-menu-primary > li.mega-menu-megamenu > ul.mega-sub-menu").css('width', screenW);
    }
}

function setOddsEndsWrapperHeight() {
    var $ = jQuery;
    if($(document).width() > 767) {
        var h = $(".odds-ends-wrapper img").height();
        $(".odds-ends-wrapper").css('height', h);
    }
}

function setInsideBannerHeight() {
    var $ = jQuery;
    if($(document).width() > 767 && $(document).width() < 960) {
        var h = $("#inside-banner .inside-banner-wrapper img").height();
        $("#inside-banner .inside-banner-wrapper").css('height', h);
    }
}