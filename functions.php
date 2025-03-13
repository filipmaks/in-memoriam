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

	// Get content
	function get_clean_content() {

		$content = get_the_content();
	
		$clean_content = strip_tags($content);
	
		return substr($clean_content, 0, 200);
	}
	
	function add_memorials_capabilities_to_roles() {
		$role = get_role('contributor');
		
		if ($role) {
			$role->add_cap('edit_memorial');
			$role->add_cap('read_memorial');
			$role->add_cap('delete_memorial');
			$role->add_cap('edit_memorials');
			$role->add_cap('edit_others_memorials');
			$role->add_cap('publish_memorials');
			$role->add_cap('read_private_memorials');
			$role->add_cap('edit_posts');
			$role->add_cap('edit_published_posts');
			$role->remove_cap('publish_posts');
		}
	}
	add_action('init', 'add_memorials_capabilities_to_roles');
	
	function show_only_own_posts($query) {
		global $pagenow;
	
		$post_type = 'memorials'; // your custom post type
		$current_user = wp_get_current_user();
	
		if (is_admin() && $pagenow == 'edit.php') {
			$query->set('contributor', $current_user->ID);
		}
	
		return $query;
	}
	add_filter('pre_get_posts', 'show_only_own_posts');
	
	function hide_admin_menus_for_members() {
		if (in_array('contributor', wp_get_current_user()->roles)) {
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
			'posts_per_page' => -1, // Retrieve all posts to count them
			'post_status' => 'any',
		);
		
		$query = new WP_Query($args);
		return ($query->found_posts >= 3);
	}

	// Remove "Add Memorial" button on the front end
	function remove_add_memorial_button() {
		if (is_user_logged_in() && current_user_can('contributor')) {
			$user_id = get_current_user_id();
			$user_select = get_field('subscribe_level', 'user_' . $user_id);
			$broj_postova = get_field('broj_postova', 'user_' . $user_id);
			
			if (user_has_memorials_post($user_id)) {
				// Remove button by its class or ID
				echo '<style>
					.page-title-action, .menupop, #wp-admin-bar-comments, #wp-admin-bar-new-content, #wp-admin-bar-top-secondary, #screen-meta-links, .author-other, .check-column{
						display: none !important;
					}
				</style>';
			} else {
				// Remove button by its class or ID
				echo '<style>
					#wp-admin-bar-comments, #wp-admin-bar-new-content, #wp-admin-bar-top-secondary, #screen-meta-links, .author-other, .check-column{
						display: none !important;
					}
				</style>';
			}
	
			// Check if user's memorial posts exceed or equal the allowed number
			if (user_has_memorials_post($user_id) >= $broj_postova) {
				echo '<script type="text/javascript">
					document.addEventListener("DOMContentLoaded", function() {
						var button = document.querySelector(".page-title-action");
						if (button) {
							button.remove();
						}
					});
				</script>';
			}
		}
	}
	add_action('admin_menu', 'remove_add_memorial_button', 999);

	// Remove "Add Memorial" from admin menu
	function remove_add_memorial_menu() {
		if (current_user_can('contributor')) {
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

	// function limit_acf_rows_by_subscription_level( $value, $post_id, $field ) {
	// 	// Get the current user ID
	// 	$current_user_id = get_current_user_id();
		
	// 	// Get the user's subscription level
	// 	$subscribe_level = get_field('subscribe_level', 'user_' . $current_user_id);
		
	// 	// Determine the maximum number of rows based on subscription level
	// 	$max_rows = 6; // default to the highest level
	// 	if ($subscribe_level === 'lvl3') {
	// 		$max_rows = 4;
	// 	} elseif ($subscribe_level === 'lvl2') {
	// 		$max_rows = 5;
	// 	}
	
	// 	// Check if the number of rows exceeds the maximum allowed
	// 	if (is_array($value) && count($value) > $max_rows) {
	// 		// Trim the array to the maximum allowed rows
	// 		$value = array_slice($value, 0, $max_rows);
	// 	}
	
	// 	return $value;
	// }
	// add_filter('acf/update_value/name=row_content', 'limit_acf_rows_by_subscription_level', 10, 3);

	// function validate_acf_rows_by_subscription_level( $valid, $value, $field, $input ) {
	// 	if (!$valid) {
	// 		return $valid;
	// 	}
	
	// 	// Get the current user ID
	// 	$current_user_id = get_current_user_id();
		
	// 	// Get the user's subscription level
	// 	$subscribe_level = get_field('subscribe_level', 'user_' . $current_user_id);
		
	// 	// Determine the maximum number of rows based on subscription level
	// 	$max_rows = 6; // default to the highest level
	// 	if ($subscribe_level === 'lvl3') {
	// 		$max_rows = 4;
	// 	} elseif ($subscribe_level === 'lvl2') {
	// 		$max_rows = 5;
	// 	}
	
	// 	// Check if the number of rows exceeds the maximum allowed
	// 	if (is_array($value) && count($value) > $max_rows) {
	// 		$valid = sprintf('Dozvoljeno vam je da dodate do %d redova u okviru vaseg nivoa pretplate.', $max_rows);
	// 	}
	
	// 	return $valid;
	// }
	// add_filter('acf/validate_value/name=row_content', 'validate_acf_rows_by_subscription_level', 10, 4);


	// OVO RADI
	function limit_acf_rows_and_flexible_content_by_subscription_level($value, $post_id, $field) {
		// Get the current user ID
		$current_user_id = get_current_user_id();
		
		// Get the user's subscription level
		$subscribe_level = get_field('subscribe_level', 'user_' . $current_user_id);
		
		// Determine the maximum number of rows based on subscription level
		$max_rows = 3; // default to the highest level
		if ($subscribe_level === 'lvl3') {
			$max_rows = 9;
		} elseif ($subscribe_level === 'lvl2') {
			$max_rows = 6;
		}
	
		// Define the block limits based on subscription level
		$limits = [
			'lvl1' => ['image' => 1, 'video' => 1, 'quote' => 1, 'text' => 1, 'long_text' => 1],
			'lvl2' => ['image' => 2, 'video' => 2, 'quote' => 2, 'text' => 2, 'long_text' => 2],
			'lvl3' => ['image' => 3, 'video' => 3, 'quote' => 3, 'text' => 3, 'long_text' => 3],
		];
		
		// Get the limits for the current user
		$max_blocks = $limits[$subscribe_level] ?? $limits['lvl3'];
		
		// Count the current blocks across all rows
		$block_counts = [
			'image' => 0,
			'video' => 0,
			'quote' => 0,
			'text' => 0,
			'long_text' => 0,
		];
	
		// Enforce row limits
		if (is_array($value) && count($value) > $max_rows) {
			$value = array_slice($value, 0, $max_rows);
		}
	
		// Enforce flexible content limits across all rows
		if (is_array($value)) {
			foreach ($value as &$row) {
				if (isset($row['profile_content']) && is_array($row['profile_content'])) {
					foreach ($row['profile_content'] as $key => $block) {
						if (isset($block_counts[$block['acf_fc_layout']])) {
							$block_counts[$block['acf_fc_layout']]++;
							if ($block_counts[$block['acf_fc_layout']] > $max_blocks[$block['acf_fc_layout']]) {
								unset($row['profile_content'][$key]);
							}
						}
					}
					// Re-index the profile_content array to avoid gaps
					$row['profile_content'] = array_values($row['profile_content']);
				}
			}
		}
	
		return $value;
	}
	add_filter('acf/update_value/name=row_content', 'limit_acf_rows_and_flexible_content_by_subscription_level', 10, 3);
	
	function validate_acf_rows_and_flexible_content_by_subscription_level($valid, $value, $field, $input) {
		if (!$valid) {
			return $valid;
		}
	
		// Get the current user ID
		$current_user_id = get_current_user_id();
		
		// Get the user's subscription level
		$subscribe_level = get_field('subscribe_level', 'user_' . $current_user_id);
		
		// Determine the maximum number of rows based on subscription level
		$max_rows = 3; // default to the highest level
		if ($subscribe_level === 'lvl3') {
			$max_rows = 9;
		} elseif ($subscribe_level === 'lvl2') {
			$max_rows = 6;
		}
	
		// Check if the number of rows exceeds the maximum allowed
		if (is_array($value) && count($value) > $max_rows) {
			return sprintf('Mozete da dodate do maksimalno %d redova na osnovu vase pretplate.', $max_rows);
		}
	
		// Define the block limits based on subscription level
		$limits = [
			'lvl1' => ['image' => 1, 'video' => 1, 'quote' => 1, 'text' => 1, 'long_text' => 1],
			'lvl2' => ['image' => 2, 'video' => 2, 'quote' => 2, 'text' => 2, 'long_text' => 2],
			'lvl3' => ['image' => 3, 'video' => 3, 'quote' => 3, 'text' => 3, 'long_text' => 3],
		];
		
		// Get the limits for the current user
		$max_blocks = $limits[$subscribe_level] ?? $limits['lvl3'];
		
		// Count the current blocks across all rows
		$block_counts = [
			'image' => 0,
			'video' => 0,
			'quote' => 0,
			'text' => 0,
			'long_text' => 0,
		];
		
		if (is_array($value)) {
			foreach ($value as $row) {
				if (isset($row['profile_content']) && is_array($row['profile_content'])) {
					foreach ($row['profile_content'] as $block) {
						if (isset($block_counts[$block['acf_fc_layout']])) {
							$block_counts[$block['acf_fc_layout']]++;
							if ($block_counts[$block['acf_fc_layout']] > $max_blocks[$block['acf_fc_layout']]) {
								return sprintf(
									'Dostigli ste maksimalan broj %s blokova. Dozvoljeno vam je %d %s blokova na osnovu vase pretplate.',
									$block['acf_fc_layout'],
									$max_blocks[$block['acf_fc_layout']],
									$block['acf_fc_layout']
								);
							}
						}
					}
				}
			}
		}
	
		return $valid;
	}
	add_filter('acf/validate_value/name=row_content', 'validate_acf_rows_and_flexible_content_by_subscription_level', 10, 4);

	// Limitiraj broj testimoanialsa
	function validate_acf_testimonial_rows_by_subscription_level($valid, $value, $field, $input) {
		if (!$valid) {
			return $valid;
		}
	
		// Get the current user ID
		$current_user_id = get_current_user_id();
	
		// Get the user's subscription level
		$subscribe_level = get_field('subscribe_level', 'user_' . $current_user_id);
	
		// Determine the maximum number of rows based on subscription level
		$max_rows = 5;
		if ($subscribe_level === 'lvl1') {
			$max_rows = 5;
		} elseif ($subscribe_level === 'lvl2') {
			$max_rows = 10;
		} elseif ($subscribe_level === 'lvl3') {
			$max_rows = 20;
		}
	
		// Check if the number of rows exceeds the maximum allowed
		if (is_array($value) && count($value) > $max_rows) {
			return sprintf('Mozete da dodate do maksimalno %d redova na osnovu vase pretplate.', $max_rows);
		}
	
		return $valid;
	}
	
	add_filter('acf/validate_value/name=testimonials', 'validate_acf_testimonial_rows_by_subscription_level', 10, 4);	

	function disable_toolbar_for_non_admins() {
		if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
			show_admin_bar( false );
		}
	}
	add_action( 'after_setup_theme', 'disable_toolbar_for_non_admins' );	
