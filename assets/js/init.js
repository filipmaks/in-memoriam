(function ($) {
    $(document).ready(function () {

        /* Search Form */
        $('.form .search_icon').on('click', function () {
            $( ".form #search" ).focus();
        });

        $('header .search').on('click', function () {
            $('.aside_search_popup').toggleClass('active');
            $('.aside_search_popup input').focus();
            $('.main_nav li:not(.search)').toggleClass('hide');
        });

        $('.aside_search_popup .exit_popup').on('click', function () {
            $('.aside_search_popup').removeClass('active');
            $('.main_nav li:not(.search)').removeClass('hide');
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

}(jQuery));