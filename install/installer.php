<?php
	// TGM Plugin Activation
	require_once( 'installer/class-tgm-plugin-activation.php' );
	/* Theme Required Plugins */
	function kaketheme_require_plugins() {
		$plugins = array( /* The array to install plugins */ 
			array(
				'name'      => 'Fusion Page Builder',
				'slug'      => 'fusion',
				'required'  => true,
			),
			array(
				'name'      => 'Fusion: Extension - Image',
				'slug'      => 'fusion-extension-image',
				'required'  => true,
			),
			array(
				'name'      => 'Responsive Lightbox & Gallery',
				'slug'      => 'responsive-lightbox',
				'required'  => true,
			),
			array(
				'name'      => 'Jetpack',
				'slug'      => 'jetpack',
				'required'  => true,
			),
			array(
				'name'      => 'Contact Form 7',
				'slug'      => 'contact-form-7',
				'required'  => true,
			),
			array(
				'name'		=> 'WP Add Custom CSS',
				'slug'		=> 'wp-add-custom-css',
				'required'  => true,
			),
			array(
				'name'		=> 'Classic Editor',
				'slug'		=> 'classic-editor',
				'required'  => true,
			),
			array(
				'name'               => 'AnimateWP', // The plugin name.
				'slug'               => 'animatewp', // The plugin slug (typically the folder name).
				'source'             => get_template_directory_uri() . '/install/installer/plugins/animatewp.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '1.1.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'               => 'Slider Revolution', // The plugin name.
				'slug'               => 'revslider', // The plugin slug (typically the folder name).
				'source'             => get_template_directory_uri() . '/install/installer/plugins/revslider.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '5.4.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'      => 'GTMetrix',
				'slug'      => 'gtmetrix-for-wordpress',
				'required'  => false,
			),
			array(
				'name'      => 'Wordfence',
				'slug'      => 'wordfence',
				'required'  => true,
			),
			array(
				'name'               => 'WP Rocket', // The plugin name.
				'slug'               => 'wp-rocket', // The plugin slug (typically the folder name).
				'source'             => get_template_directory_uri() . '/install/installer/plugins/wprocket.zip', // The plugin source.
				'required'           => false, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '2.11.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'               => 'WP Smush Pro', // The plugin name.
				'slug'               => 'wp-smush-pro', // The plugin slug (typically the folder name).
				'source'             => get_template_directory_uri() . '/install/installer/plugins/wpsmushpro.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				'version'            => '2.9.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'      => 'Yoast SEO',
				'slug'      => 'wordpress-seo',
				'required'  => true,
			),
			array(
				'name'      => 'WooCommerce',
				'slug'      => 'woocommerce',
				'required'  => false,
			),
			array(
				'name'      => 'Menu Icons',
				'slug'      => 'menu-icons',
				'required'  => true,
			),
			array(
				'name'      => 'Duplicate Page',
				'slug'      => 'duplicate-page',
				'required'  => true,
			),
			array(
				'name'      => 'All-In-One WP Migration',
				'slug'      => 'all-in-one-wp-migration',
				'required'  => true,
			),			
			array(
				'name'      => 'Redux Framework',
				'slug'      => 'redux-framework',
				'required'  => true,
			),
		);
		$config = array( /* The array to configure TGM Plugin Activation */ 
			'default_path' => '',                      // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
			'strings'      => array(
				'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
				'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
				'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
				'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
				'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
				'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
			)
		);
		tgmpa( $plugins, $config );
	}
	add_action( 'tgmpa_register', 'kaketheme_require_plugins' );	