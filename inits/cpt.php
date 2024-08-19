<?php 
/**
 * Custom Post Types
 *
 * @package starter_wp_theme
 */


// Custom post type Memorials
function create_memorials_cpt(){
    $labels = array(
        'name'                  => __('Spomen Strane'),
        'singular_name'         => __('Spomen Strane'),
        'add_new'               => __('Kreiraj spomen stranu'),
        'add_new_item'          => __('Kreiraj spomen stranu'),
        'edit_item'             => __('Izmeni spomen stranu'),
        'new_item'              => __('Nova spomen strana'),
        'all_items'             => __('Tvoje spomen strane'),
        'view_item'             => __('Vidi spomen strane'),
        'search_items'          => __('Pretrazi spomen strane'),
        'not_found'             => __('Spomen strana nije pronadjena'),
        'not_found_in_trash'    => __('Spomen strana nije pronadjena u smecu'),
        'menu_name'             => 'Spomen Strane',
    );
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'menu_position'         => 24,
        'menu_icon'             => __( 'dashicons-groups' ),
        'supports'              => array('title',  'thumbnail'),
		'show_in_rest' 	        => true,
        'exclude_from_search'   => false,
    );
    register_post_type('memorials', $args);
}
add_action('init', 'create_memorials_cpt');