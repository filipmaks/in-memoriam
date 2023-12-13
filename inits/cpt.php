<?php 
/**
 * Custom Post Types
 *
 * @package starter_wp_theme
 */


// Custom post type Memorials
function create_memorials_cpt(){
    $labels = array(
        'name'                  => __('Memorials'),
        'singular_name'         => __('Memorials'),
        'add_new'               => __('Add Memorial'),
        'add_new_item'          => __('Add New Memorial'),
        'edit_item'             => __('Edit Memorial'),
        'new_item'              => __('New Memorial'),
        'all_items'             => __('All Memorials'),
        'view_item'             => __('View Memorials'),
        'search_items'          => __('Search Memorials'),
        'not_found'             => __('No Memorials found'),
        'not_found_in_trash'    => __('No Memorials found in the Trash'),
        'menu_name'             => 'Memorials',
    );
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'menu_position'         => 24,
        'menu_icon'             => __( 'dashicons-groups' ),
        'supports'              => array('title',  'thumbnail'),
		'show_in_rest' 	        => true,
        'exclude_from_search'   => false
    );
    register_post_type('memorials', $args);
}
add_action('init', 'create_memorials_cpt');