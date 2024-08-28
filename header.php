<!DOCTYPE html>
<html lang="en" dir="ltr" id="modernizrcom" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php if(is_home()) bloginfo('name'); else wp_title(''); ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">

    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

	<?php wp_head(); ?>

    <script type="text/javascript">
        function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'sr',
            includedLanguages: 'en,sr',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</head>

<body <?php body_class(); ?>>

	<header>
        <div class="wrapper">
            <div class="holder">
                <?php 
                    $current_user = wp_get_current_user();

                    $header_logo    = get_field('header_logo', 'option');
                    if( $header_logo ) :
                ?>
                <div class="logo">
                    <a href="<?php echo site_url(); ?>">
                        <img src="<?php echo $header_logo['url']; ?>" alt="Logo">
                    </a>
                </div>
                <?php endif; ?>
                <ul class="main_nav">
                    <?php wp_nav_menu(array('menu' => 'Header Menu', 'container' => false, 'items_wrap' => '%3$s')); ?>
                    
                    <li class="my-profile for-log-in">
                        <a href="<?php echo site_url(); ?>/author/<?php echo $current_user->display_name; ?>">
                            <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon">
                                <ellipse cx="8.99955" cy="7.57171" rx="5.64408" ry="5.71429" stroke="black" stroke-width="2"></ellipse>
                                <path d="M1 20.9997C2.63828 18.9481 5.77641 18.1426 9 18.1426C12.2236 18.1426 15.3617 18.9481 17 20.9997" stroke="black" stroke-width="2"></path>
                            </svg>
                        </a>
                    </li>

                    <li class="translate">
                        <a href="#" class="active">Lat /</a> <a href="#">Cir</a>
                    </li>

                    <li class="search">
                        <?php echo file_get_contents(get_template_directory().'/assets/icons/lupa2.svg'); ?>
                        <div class="mobile-form">
                            <form action="/" method="get">
                                <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Marko Markovic"/>
                                <input type="submit" id="searchsubmit" value="Trazi" />
                            </form>
                        </div>
                    </li>
                </ul>

                <div class="hamburger">
                    <span></span><span></span><span></span>
                </div>

                <div class="aside_search_popup">
                    <div class="search_holder">
                        <form action="/" method="get">
                            <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Marko Markovic"/>
                        </form>
                        <div class="exit_popup"></div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <div class="loading_holder"></div>

    <div id="main" class="main">

    <div id="google_translate_element" style="display:none;"></div>
<button onclick="translateToEnglish()">Translate to English</button>

<script type="text/javascript">
function translateToEnglish() {
  var combo = document.querySelector('.goog-te-combo');
  if (combo) {
    combo.value = 'en'; // Change this value to 'en' for English
    combo.dispatchEvent(new Event('change'));
  }
}
</script>
