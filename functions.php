<?php
	/**
	 * Starkers functions and definitions
	 * Rewritten for Kake HMD Corporate Full Theme
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package WordPress
 	 * @subpackage Starkers
 	 * @since Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	/* Starkers Utilities */
	require_once( 'external/starkers-utilities.php' );

	/* Redux Framework */
	require_once( 'install/installer.php' );
	require_once( 'install/options.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	function register_my_menu() {
		register_nav_menu( 'primary', 'Home Menu' );
		register_nav_menu( 'secondary', 'Other Menu' );
		// Site Map
		register_nav_menu( 'sitemap1', 'Site Map 1' );
		register_nav_menu( 'sitemap2', 'Site Map 2' );
		register_nav_menu( 'sitemap3', 'Site Map 3' );
		register_nav_menu( 'sitemap4', 'Site Map 4' );
		register_nav_menu( 'sitemap5', 'Site Map 5' );
		register_nav_menu( 'sitemap6', 'Site Map 6' );
	}
	add_action( 'after_setup_theme', 'register_my_menu' );

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here
	
	======================================================================================================================== */

	require_once( 'includes/testimonials.php' );

	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	require_once('includes/scripts.php');
	require_once( 'includes/react.php' );

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	require_once('includes/comments.php');
	
	/* ========================================================================================================================
	
	Extra Functions
	
	======================================================================================================================== */
	
	/* Slider Post Custom Meta */
	require_once('includes/slidermeta.php');
		
	/* Widget Areas */
	require_once('includes/widget-areas.php');
	
	/* Media Shortcode Modify */
	require_once('includes/media-shortcode.php');
			
	/* Register Custom Navigation Walker */
	require_once('includes/bootstrap-navwalker.php');

	/* WooCommerce Functions */
	require_once('includes/woocommerce.php');
	
	/* Other Theme Functions */
	require_once('includes/others.php');