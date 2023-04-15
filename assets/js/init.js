(function ($) {

     /* Transform Setter */
     function transformSetter(x,y,scale){
        return {
            '-webkit-transform': 'translateX(' + x + ') translateY(' + y + ') translateZ(0px) rotate(0deg) scale(' + scale + ')',
            '-moz-transform': 'translateX(' + x + ') translateY(' + y + ') translateZ(0px) rotate(0deg) scale(' + scale + ')',
            'transform': 'translateX(' + x + ') translateY(' + y + ') translateZ(0px) rotate(0deg) scale(' + scale + ')',
        }
    }

    /* Delay Animation */
    function delayAnimation(delay) {
        return {
            '-webkit-transition-delay': delay + 'ms',
            '-moz-transition-delay': delay + 'ms',
            '-ms-transition-delay': delay + 'ms',
            '-o-transition-delay': delay + 'ms',
            'transition-delay': delay + 'ms'
        }
    }

    /* Set every item to delay animation, add this class to PARENT */
    $('.set_animation').each(function(){
        var curr = $(this),
            child = curr.children();

            child.each(function(i){
                var currChild = $(this);
                if(curr.hasClass('faster')) {
                    currChild.css(delayAnimation(i * 50));
                } else if (curr.hasClass('slower')){
                    currChild.css(delayAnimation(i * 200));
                } else {
                    currChild.css(delayAnimation(i * 75));
                }
            });

    });

    /* In Viewport function */
    function inViewport() {
        var winHeight = $(window).height();
        var bodyScroll = $(document).scrollTop();
        var calcHeight = bodyScroll + winHeight;


        $('.animated').each(function(index, el) {
            if ($(this).offset().top < calcHeight && $(this).offset().top + $(this).height() > bodyScroll) {
                if (!$(this).hasClass('in_view')) {
                    $(this).addClass('in_view');
                }
            }
        });
    }

    /* Global vars */
    var contentLoaded = false;

    $(document).ready(function () {

        contentLoaded = true;

        setTimeout(() => {

            if( contentLoaded ) {
                inViewport();
                $('.loading_holder').addClass('finished');
            }
            
        }, 300);


        /* Search Form */
        $('.form .search_icon').on('click', function () {
            $( ".form #search" ).focus();
        });

        $('header .search').on('click', function () {
            $('header .aside_search_popup').toggleClass('active');
            $('header .aside_search_popup input').focus();
            $('header .main_nav li:not(.search)').toggleClass('hide');
        });

        $('footer .search').on('click', function () {
            $('footer .aside_search_popup').toggleClass('active');
            $('footer .aside_search_popup input').focus();
            $('footer .nav_holder li:not(.search)').toggleClass('hide');
        });

        $('.aside_search_popup .exit_popup').on('click', function () {
            $('.aside_search_popup').removeClass('active');
            $('.main_nav li:not(.search), .nav_holder li:not(.search)').removeClass('hide');
        });
       
        /* Swiper */
        $('.gallery_slider').each(function(){
            var curr = $(this),
                currPag = curr.find('.swiper-pagination');

            var img_slider = new Swiper(curr[0], {
                speed: 1200,
                effect: "fade",
                fadeEffect: { 
                    crossFade: true 
                },
                autoplay: {
                    delay: 2500,
                },
                pagination: {
                    el: currPag[0],
                },
            });
        });

    });

     /* On scroll logic */
     $(window).on('scroll', function(event) {

        inViewport();
        
    });
    
    /* On resize logic */
    $(window).on('resize', function(event) {

        inViewport();

    });

}(jQuery));