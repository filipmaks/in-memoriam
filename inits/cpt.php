<?php 
/**
 * Custom Post Types
 *
 * @package starter_wp_theme
 */


// Custom post type People
// function create_testimonials_cpt(){
//     $labels = array(
//         'name'                  => __('Testimonials'),
//         'singular_name'         => __('Testimonials'),
//         'add_new'               => __('Add Testimonial'),
//         'add_new_item'          => __('Add New Testimonial'),
//         'edit_item'             => __('Edit Testimonial'),
//         'new_item'              => __('New Testimonial'),
//         'all_items'             => __('All Testimonials'),
//         'view_item'             => __('View Testimonials'),
//         'search_items'          => __('Search Testimonials'),
//         'not_found'             => __('No Testimonials found'),
//         'not_found_in_trash'    => __('No Testimonials found in the Trash'),
//         'menu_name'             => 'Testimonials',
//         );
//     $args = array(
//         'labels'        => $labels,
//         'public'        => true,
//         'menu_position' => 24,
//         'menu_icon'     => __( 'dashicons-groups' ),
//         'supports'      => array('title',  'thumbnail', 'editor'),
// 		'show_in_rest' 	=> true,
//         'exclude_from_search' => false
//     );
//     register_post_type('testimonials', $args);
// }
// add_action('init', 'create_testimonials_cpt');