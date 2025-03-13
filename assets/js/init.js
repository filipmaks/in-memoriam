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
            if( $('html').hasClass('desktop') ) {
                $('header .main_nav li:not(.search)').toggleClass('hide');
            }
        });

        $('footer .search').on('click', function () {
            $('footer .aside_search_popup').toggleClass('active');
            $('footer .aside_search_popup input').focus();
            if( $('html').hasClass('desktop') ) {
                $('footer .nav_holder li:not(.search)').toggleClass('hide');
            }
        });

        $('.aside_search_popup .exit_popup').on('click', function () {
            $('.aside_search_popup').removeClass('active');
            if( $('html').hasClass('desktop') ) {
                $('.main_nav li:not(.search), .nav_holder li:not(.search)').removeClass('hide');

            }
        });

        $(".long-text-card article").each(function() {
            
            var founded = false,
                curr = $(this);

                curr.find("*").each(function() {
                
                    var html = $(this).html();
        
                    if (html.length > 0 && !founded) {
                        var firstChar = html.charAt(0);
                        var restOfHtml = html.slice(1);
                        $(this).html("<sup>" + firstChar + "</sup>" + restOfHtml);
                        founded = true;
                    }
                
                });
        });

        $('.play-btn').on('click', function() {
                    
            var currParent = $(this).parents('.video-holder'),
                curr = currParent.find('video').get(0);

                if (curr.paused) {
                    curr.play();
                    currParent.addClass('playing');
                } else {
                    curr.pause();
                    currParent.removeClass('playing');
                }
        });
       
        $('.share-icon').on('click', function(){
            var curr = $(this),
                currParent = curr.parents('.share-card'),
                sharePostH = $('.post-share');

                sharePostH.addClass('active');

                setTimeout(() => {
                    currParent.removeClass('active');
                }, 2000);
        });

        $('.post-share .exit').on('click', function(){
            var curr = $(this),
                sharePostH = $('.post-share');

                sharePostH.removeClass('active');
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

        $('.testimonial_slider').each(function(){
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

        // Copy to clipboard Browser URL

        $('.copy-to-clip').on('click', function(e){

            e.preventDefault();

            var tempInput = $("<input>");            
            $("body").append(tempInput);
            
            tempInput.val(window.location.href).select();

            document.execCommand("copy");
            tempInput.remove();

            alert("Link je kopiran");
        });
        
        $('.toggle-password').on('click', function() {
            let input = $($(this).attr('toggle'));
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        /* Form members search */
        var $search_input = $('.search_page input[type="text"]'),
            $searchResults = $('.search_results ul'),
            doneTypingInterval = 1000;
        
        var debouncedSearch = _.debounce(function(query) {
            // make ajax request to search WP posts
            $.ajax({
                url: '/wp-json/wp/v2/memorials',
                data: {
                    search: query,
                    per_page: 10, // limit results to 10
                    _embed: true  // request embedded data for featured image
                },
                success: function(results) {
                    // remove previous search results
                    $searchResults.empty();

                    // check if results are empty
                    if (results.length === 0) {
                        // display 'no results' message
                        $searchResults.append('<li>Osoba nije pronadjena.</li>');
                    } else {

                        // append new search results
                        results.forEach(function(result) {
                            var title = result.title.rendered,
                                link = result.link;
            
                            // retrieve the featured image
                            var featuredImage = '';
                            if (result._embedded['wp:featuredmedia']) {
                                featuredImage = result._embedded['wp:featuredmedia'][0].source_url;
                            }
            
                            var html = '<li>';
                            html += '<a href="' + link + '">';
                            // include the featured image
                            if (featuredImage) {
                                html += '<img src="' + featuredImage + '" alt="' + title + '">';
                            }
                            html += '<p>' + title + '</p></a>';
                            html += '</li>';
            
                            $searchResults.append(html);
                        });

                    }
        
                }
            });
        }, doneTypingInterval);
        
        $search_input.on('input', function() {
            var query = $(this).val().trim();
        
            // check if query has at least 3 characters
            if (query.length < 3) {
                $('.search_results').removeClass('active');
                // remove search results
                $searchResults.empty();
                return;
            } else {
                // debounce the search function
                $('.search_results').addClass('active');
                debouncedSearch(query);
            }
        
        });

        /* Single Membership */
        $('.three-dots').on('click', function(){
            var curr = $(this),
                currShare = curr.next(),
                currShareCard = curr.parent();

                currShareCard.addClass('active');
        });

        $('.hamburger').on('click', function(){
           	var curr = $(this), 
				header = $('header'),
            	currNav = $('.main_nav');

				header.toggleClass('nav-open');
        });

		$('.single-memoriam-content .row').each(function(){
			var curr = $(this),	
				currChildren = curr.children().length;

				switch (currChildren) {
					case 1:
						curr.addClass('one-column');
						break;
					case 2:
						curr.addClass('two-columns');
						break;
					case 3:
						curr.addClass('three-columns');
						break;
					case 4:
						curr.addClass('four-columns');
						break;
					case 5:
						curr.addClass('five-columns');
						break;
				}
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