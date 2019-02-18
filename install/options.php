<?php
	/* ReduxCore Loader */
	include_once( 'reduxcore/loader.php' );
	require_once( 'reduxcore/framework.php' );
	
	/* ReduxCore Options */
	require_once( 'options/config.php' );
	
	/* ========================
		Login Functions
	======================== */
	function tt_custom_login() {
		// Login Page Logo
		$output  = '<style type="text/css">';
			global $corp_theme_option;
			$login_logo = $corp_theme_option['logo-login']['url'];
			$background_login = $corp_theme_option['background-login'];
			if ( !empty( $login_logo ) ) {
				$output .= '.login h1 a { background: url(' . $login_logo . ') 50% 50% no-repeat !important; width: auto; }';
			}
			if ( $background_login ) {
				$output .= '.login { background-color: ' . $background_login . '; }';
			}
			else {
				$output .= '.login { background-color: #f8f8f8; }';
			}
			$output .= '.login form input[type="submit"] { border-radius: 0; border: none; -webkit-box-shadow: none; box-shadow: none; }';
			$output .= '.login form .input, .login .form input:focus { padding: 5px 10px; color: #666; -webkit-box-shadow: none; box-shadow: none; }';
			$output .= 'input[type=checkbox]:focus, input[type=email]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=url]:focus, select:focus, textarea:focus { -webkit-box-shadow: none; box-shadow: none; }';
		$output .= '</style>';
		
		echo $output;
		
		// Remove Login Shake
		remove_action('login_head', 'wp_shake_js', 12);
	}
	add_action('login_head', 'tt_custom_login');
	
	// Login Logo Link
	function tt_wp_login_url() {
		return home_url();
	}
	add_filter('login_headerurl', 'tt_wp_login_url');
	
	// Add Lost Password Link
	function tt_add_lost_password_link() {
		return '<a href="' . wp_lostpassword_url(false) . '">Lost Password?</a>';
	}
	add_action( 'login_form_bottom', 'tt_add_lost_password_link' );
	
	// Login Failed
	function tt_login_failed( $user ) {
		$referrer = $_SERVER['HTTP_REFERER'];
		// Check that were not on the default login page
		if ( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) && $user != null ) {
		// Make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed' ) ) {
			// Redirect to login page and append a querystring of login failed
			wp_redirect( $referrer . '?login=failed');
		} else {
			wp_redirect( $referrer );
		}
			exit;
		}
	}
	add_action( 'wp_login_failed', 'tt_login_failed' );
	function tt_login_blank( $user ) {
		$referrer = $_SERVER['HTTP_REFERER'];
		$error = false;
		// Check Login
		if( isset($_POST['log']) && $_POST['log'] == '' || isset($_POST['pwd']) && $_POST['pwd'] == '') {
			$error = true;
		}
		// Check that were not on the default login page
		if ( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer, 'wp-admin' ) && $error ) {
		// Make sure we don't already have a failed login attempt
		if ( !strstr($referrer, '?login=failed') ) {
			// Redirect to the login page and append a querystring of login failed
			wp_redirect( $referrer . '?login=failed' );
		} else {
			wp_redirect( $referrer );
		}
			exit;
		}
	}
	add_action( 'authenticate', 'tt_login_blank');

	// Disable WP Admin for Non Users
	function tt_remove_admin_bar() {
		if ( ! current_user_can('administrator') && ! is_admin() ) {
		  show_admin_bar(false);
		}
	}
	add_action('after_setup_theme', 'tt_remove_admin_bar'); 
	function tt_disable_wp_admin_for_non_admins() {
		if ( is_admin() && ! current_user_can( 'administrator' ) && 
		! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			wp_redirect( home_url() );
			exit;
		}
	}
	add_action('admin_init', 'tt_disable_wp_admin_for_non_admins');

	// Login with Email or Username
	function tt_allow_email_login( $user, $username, $password ) {
		if ( is_email( $username ) ) {
			$user = get_user_by_email( $username );
			if ( $user ) {
				$username = $user->user_login;
			}
		}
		return wp_authenticate_username_password(null, $username, $password );
	}
	add_filter('authenticate', 'tt_allow_email_login', 20, 3);
	
	
	/* ========================
		Custom Styles
	======================== */
	function tt_custom_styles() {
		global $corp_theme_option;
		$opacity = $corp_theme_option['opacity-slider'];
		// Content Buttons
		$btn_bg = $corp_theme_option['color-content-link'];
		$btn_bg_hover = $corp_theme_option['color-content-link'];
		$btn_text = $corp_theme_option['color-content-link'];
		$btn_text_hover = $corp_theme_option['color-button-text'];
		// Read More Buttons
		$read_more_bg = $corp_theme_option['color-blog-posts-read-more-bg'];
		$read_more_bg_hover = $corp_theme_option['color-blog-posts-read-more-bg-hover'];
		$read_more_text = $corp_theme_option['color-blog-posts-read-more-text'];
		$read_more_text_hover = $corp_theme_option['color-blog-posts-read-more-text-hover'];
		// Custom Styles
		$custom_styles = $corp_theme_option['custom-styles'];
		$style_type = 'type="text/css"';
		
		echo '<style '. $style_type .'>';
			// Add any extra styles here if needed.
			echo '.jumbotron .slider { opacity: '. $opacity .' }';
			echo '.home #content #posts-section .read-more,.page-template-template-01home #content #posts-section .read-more,.page-template-template-04sctcontainer #blog-section #posts-section .read-more { border-color: '. $read_more_bg .'; color: '. $read_more_text .' }';
			echo '.home #content #posts-section .read-more:hover,.page-template-template-01home #content #posts-section .read-more:hover,.page-template-template-04sctcontainer #blog-section #posts-section .read-more:hover { background-color: '. $read_more_bg_hover .'; color: '. $read_more_text_hover .'; border-color: '. $read_more_bg_hover .'; }';
			echo $custom_styles;
		echo '</style>';
	}
	add_action( 'wp_head', 'tt_custom_styles', 151 ); // Fire after Redux