<?php
/**
 * INITIALIZE theme assets
 *
 * @package starter-wp-theme-v2
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inits' . DIRECTORY_SEPARATOR . 'includes.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inits' . DIRECTORY_SEPARATOR . 'cpt.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inits' . DIRECTORY_SEPARATOR . 'tax.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inits' . DIRECTORY_SEPARATOR . 'shortcodes.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inits' . DIRECTORY_SEPARATOR . 'blocks.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inits' . DIRECTORY_SEPARATOR . 'enable-blocks.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inits' . DIRECTORY_SEPARATOR . 'registration.php';

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function the_theme_widgets_init() {
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'the_theme_widgets_init' );

// Post thumbnails
add_theme_support('post-thumbnails');

/**
 *  Remove all the filters and actions from
 * the /wp-includes/default-filters.php file 
 **/
	function microdot_remove_emoji_support() {
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'embed_head', 'print_emoji_detection_script' );
	}
	add_action('init', 'microdot_remove_emoji_support');

	// Remove the `wp_emoji` plugin added to TinyMCE in
	// the /wp-includes/class-wp-editor.php file
	function microdot_remove_emoji_from_tinymce( $plugins ) {
		$key = array_search( 'wpemoji', $plugins );

		if( $key !== false ) {
			unset( $plugins[$key] );
		}

		return $plugins;
	}
	add_filter( 'tiny_mce_plugins', 'microdot_remove_emoji_from_tinymce', 9999, 1 );

	// Removed the DNS prefetch for the Emoji CDN via the filter found in
	// the /wp-includes/general-template.php file
	function microdot_filter_wp_resource_hints( $urls, $relation_type ) {
		if( $relation_type === 'dns-prefetch') {
			$key = array_search( 'https://s.w.org/images/core/emoji/2/svg/', $urls );
			if( $key !== false ) {
				unset( $urls[$key] );
			}
		}

		return $urls;
	}
	add_filter('wp_resource_hints', 'microdot_filter_wp_resource_hints', 999, 2);
	
	
	// Limit except length to 125 characters.
	function get_excerpt( $count ) {
		$permalink = get_permalink($post->ID);
		$excerpt = get_the_content();
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $count);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = '<p>'.$excerpt.'...</p>';
		return $excerpt;
	}

	// create Theme Settings in ACF
	if( function_exists('acf_add_options_page') ) {

		$parent = acf_add_options_page(array(
			'page_title' 	=> 'Theme General Settings',
			'menu_title'	=> 'Theme Settings',
			'menu_slug' 	=> 'theme-general-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));	

		// acf_add_options_sub_page(array(
		// 	'page_title'    => 'Contact Page',
		// 	'menu_title'    => 'Contact Page',
		// 	'parent_slug'   => $parent['menu_slug'],
		// ));

	}

	// ACF title change
	function my_layout_title($title, $field, $layout, $i) {
		if($value = get_sub_field('describe_title')) {
			return $value;
		} else {
			foreach($layout['sub_fields'] as $sub) {
				if($sub['name'] == 'describe_title') {
					$key = $sub['key'];
					if(array_key_exists($i, $field['value']) && $value = $field['value'][$i][$key])
						return $value;
				}
			}
		}
		return $title;
	}
	add_filter('acf/fields/flexible_content/layout_title', 'my_layout_title', 10, 4);

	function enable_rest_api_for_membership_post() {
		register_post_type('membership-post', array(
			'show_in_rest' => true,
			'rest_base' => 'membership-posts',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		));
	  }
	add_action('init', 'enable_rest_api_for_membership_post');

	// Get content
	function get_clean_content() {
		// Get the content
		$content = get_the_content();
	
		// Strip the HTML tags
		$clean_content = strip_tags($content);
	
		// Return the first 200 characters
		return substr($clean_content, 0, 200);
	}
	
	function add_memorials_capabilities_to_roles() {
		$role = get_role('members');
		
		if ($role) {
			$role->add_cap('edit_memorial');
			$role->add_cap('read_memorial');
			$role->add_cap('delete_memorial');
			$role->add_cap('edit_memorials');
			$role->add_cap('edit_others_memorials');
			$role->add_cap('publish_memorials');
			$role->add_cap('read_private_memorials');
		}
	}
	add_action('init', 'add_memorials_capabilities_to_roles');
	
	function show_only_own_posts($query) {
		global $pagenow;
	
		$post_type = 'memorials'; // your custom post type
		$current_user = wp_get_current_user();
	
		if (is_admin() && $pagenow == 'edit.php' && isset($query->query['post_type']) && $query->query['post_type'] == $post_type && in_array('members', $current_user->roles)) {
			$query->set('author', $current_user->ID);
		}
	
		return $query;
	}
	add_filter('pre_get_posts', 'show_only_own_posts');
	
	function hide_admin_menus_for_members() {
		if (in_array('members', wp_get_current_user()->roles)) {
			remove_menu_page('index.php');                  // Dashboard
			remove_menu_page('edit.php');                   // Posts
			remove_menu_page('upload.php');                 // Media
			remove_menu_page('edit.php?post_type=page');    // Pages
			remove_menu_page('wpcf7');    					// WPCF7
			remove_menu_page('theme-general-settings' );	// Theme Settings
			remove_menu_page('edit-comments.php');          // Comments
			remove_menu_page('themes.php');                 // Appearance
			remove_menu_page('plugins.php');                // Plugins
			remove_menu_page('users.php');                  // Users
			remove_menu_page('profile.php');          		// Profile
			remove_menu_page('tools.php');                  // Tools
			remove_menu_page('options-general.php');        // Settings
			remove_menu_page('post-new.php');
		}
	}
	add_action('admin_menu', 'hide_admin_menus_for_members', 999);	


	// Check if the current user has created a 'memorials' post
	function user_has_memorials_post($user_id) {
		$args = array(
			'author' => $user_id,
			'post_type' => 'memorials',
			'posts_per_page' => 1,
			'post_status' => 'any',
		);
		
		$query = new WP_Query($args);
		return $query->have_posts();
	}

	// Remove "Add Memorial" button on the front end
	function remove_add_memorial_button() {
		if (is_user_logged_in() && current_user_can('members')) {
			$user_id = get_current_user_id();
			$user_select = get_field('subscribe_level', 'user_' . $user_id);
			if (user_has_memorials_post($user_id)) {
				// Remove button by its class or ID
				echo '<style>
					.page-title-action, .menupop{
						display: none !important;
					}
				</style>';
			}
		}
	}
	add_action('admin_menu', 'remove_add_memorial_button', 999);

	// Remove "Add Memorial" from admin menu
	function remove_add_memorial_menu() {
		if (current_user_can('members')) {
			$user_id = get_current_user_id();
			if (user_has_memorials_post($user_id)) {
				global $menu;
				global $submenu;

				// Remove "Add New" under "Memorials" post type
				foreach ($submenu as $key => $value) {
					if ($key == 'edit.php?post_type=memorials') {
						foreach ($value as $subkey => $submenu_item) {
							if ($submenu_item[2] == 'post-new.php?post_type=memorials') {
								unset($submenu[$key][$subkey]);
							}
						}
					}
				}
			}
		}
	}
	add_action('admin_menu', 'remove_add_memorial_menu', 999);
