<?php
	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	class Starkers_Script_Enqueuer {

		public function starkers_script_enqueuer() {
			/* App Base */
			$app_base = get_template_directory_uri() . '/assets/js';

			/* React JS */
			wp_enqueue_script( 'reactjs', 'https://unpkg.com/react@16/umd/react.production.min.js', array('jquery'), null, true );
			wp_enqueue_script( 'reactdomjs', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', array('jquery'), null, true );

			/* React Component JS */
			wp_enqueue_script( 'reactcomjs', $app_base . '/app.js', array('jquery'), null, true );

			/* Barba JS */
			wp_enqueue_script( 'barbajs', $app_base . '/lib/barba.js', array('jquery'), null, true );

			/* Smooth Scroll JS */
			wp_enqueue_script( 'smoothscrolljs', $app_base . '/lib/smooth-scroll.polyfills.js', array('jquery'), null, true );

			/* Theme JS */
			wp_enqueue_script( 'bundlejs',  $app_base . '/bundle.min.js', '', null, true );
			
			/* Theme CSS */
			wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
			wp_enqueue_style( 'screen' );
		}
		
		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'starkers_script_enqueuer' ), 20, 1 );
		}

	}
	new Starkers_Script_Enqueuer;