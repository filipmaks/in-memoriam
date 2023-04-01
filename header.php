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
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<header>
        <div class="wrapper">
            <div class="holder">
                <div class="logo">
                    <img src="#" alt="Logo">
                </div>
                <ul class="main_nav">
                    <?php wp_nav_menu(array('menu' => 'Header Menu', 'container' => false, 'items_wrap' => '%3$s')); ?>
                </ul>
            </div>
        </div>
    </header>

    <div id="main">