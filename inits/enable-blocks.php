<?php

    /**
    * Allow/Enable ACF blocks
    */

    function all_allowed_block_types( $allowed_block_types, $post ) {

        return array(
            'core/shortcode',
            'acf/hero',
            'acf/title-text',
            'acf/textual',
            'acf/info-cards',
            'acf/image-slider',
            'acf/search-page',
            'acf/full-width-image',
            'acf/buttons',
            'acf/contact-form',
            'acf/price-options',
            'acf/divider',
        );
    
        return $allowed_block_types;
    }
    add_filter( 'allowed_block_types_all', 'all_allowed_block_types', 10, 2 );