<?php

    /**
    * Register ACF blocks
    */

    function register_acf_block_types() {

        acf_register_block_type(array(
            'name'              => 'hero',
            'title'             => __('Hero'),
            'description'       => __('Hero block.'),
            'render_template'   => 'partials/blocks/hero.php',
            'category'          => 'common',
            'icon'              => 'superhero',
            'keywords'          => array( 'page hero'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => false,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'title-text',
            'title'             => __('Title & Text'),
            'description'       => __('Title & Text block.'),
            'render_template'   => 'partials/blocks/title-text.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'title and text section'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'textual',
            'title'             => __('Textual'),
            'description'       => __('Textual block.'),
            'render_template'   => 'partials/blocks/textual.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'textual section'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

        
        acf_register_block_type(array(
            'name'              => 'info-cards',
            'title'             => __('Info Cards'),
            'description'       => __('Info Cards block.'),
            'render_template'   => 'partials/blocks/info-cards.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'info cards'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'image-slider',
            'title'             => __('Image Slider'),
            'description'       => __('Image Slider block.'),
            'render_template'   => 'partials/blocks/image-slider.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'image slider'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'search-page',
            'title'             => __('Search Page'),
            'description'       => __('Search Page block.'),
            'render_template'   => 'partials/blocks/search-page.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'search page'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'full-width-image',
            'title'             => __('Full Width Image'),
            'description'       => __('Full Width Image block.'),
            'render_template'   => 'partials/blocks/full-width-image.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'full width image'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'buttons',
            'title'             => __('Buttons'),
            'description'       => __('Buttons block.'),
            'render_template'   => 'partials/blocks/buttons.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'buttons'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'contact-form',
            'title'             => __('Contact Form'),
            'description'       => __('Contact Form block.'),
            'render_template'   => 'partials/blocks/contact-form.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'contact form'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => false,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'price-options',
            'title'             => __('Price Options Card'),
            'description'       => __('Price Options Card block.'),
            'render_template'   => 'partials/blocks/price-options.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'price options card'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'divider',
            'title'             => __('Divider'),
            'description'       => __('Divider block.'),
            'render_template'   => 'partials/blocks/divider.php',
            'category'          => 'common',
            'icon'              => 'text-page',
            'keywords'          => array( 'divider'),
            'mode'	            => 'edit',
            'supports' 			=> array(
                'multiple'      => true,
            ),
        ));

    }
    
    // Check if function exists and hook into setup.
    if( function_exists('acf_register_block_type') ) {
        add_action('acf/init', 'register_acf_block_types');
    }