(function ($) {
    $(document).ready(function () {
       
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