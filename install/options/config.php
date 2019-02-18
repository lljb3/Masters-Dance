<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: https://docs.reduxframework.com
**/

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }

        public function initSettings() {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { 				// No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /** 
			*This is a test function that will let you see when the compiler hook occurs. 
			*It only runs if a field	set with compiler=>true is changed. 
		**/
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values);							// Values that have changed since the last save
            echo "</pre>";
            //print_r($options);								//Option values
            //print_r($css);									// Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /* // Demo of how to use the dynamic CSS and write your own static CSS file
			$filename = dirname(__FILE__) . '/style' . '.css';
			global $wp_filesystem;
			if( empty( $wp_filesystem ) ) {
				require_once( ABSPATH .'/wp-admin/includes/file.php' );
				WP_Filesystem();
			}
			
			if( $wp_filesystem ) {
				$wp_filesystem->put_contents(
					$filename,
					$css,
					FS_CHMOD_FILE								// predefined mode settings for WP files
				);
			} */
        }

        /** 
		 * Custom function for filtering the sections array. Good for child themes to override or add to the sections. 
		 * Simply include this function in the child themes functions.php file.
		 *
		 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 * so you must use get_template_directory_uri() if you want to use any of the built in icons 
		**/
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /** 
			*Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions. 
		**/
        function change_arguments($args) {
            //$args['dev_mode'] = true;
            return $args;
        }

        /** 
			*Filter hook for filtering the default value of any given field. Very useful in development mode. 
		**/
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';
            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {
            /** 
			 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples 
			**/
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :
                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();
                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {
                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS //
			
			/* Global Text */
            global $font_list;
			$custom_fonts = $font_list;
			$theme_url = get_stylesheet_directory_uri();
            
			/* ==============================
				General
			============================== */
            $this->sections[] = array(
	            'title'		=> __('General', 'redux-framework-demo'),
	            'desc'		=> __('The basic site setup. Please fill all fields out.', 'redux-framework-demo'),
	            'icon'		=> 'el el-icon-cog',
	            'fields'	=> array(
					array(
						'id'	=> 'color-body-background',
						'type'	=> 'background',
						'output'	=> array('body'),
						'title'	=> __('Body Background Color', 'redux-framework-demo'),
						'subtitle'	=> __('Site Background Color (default: #f8f8f8)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#f8f8f8' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					), 
					array(
						'id'	=> 'color-content-background',
						'type'	=> 'background',
						'output'	=> array('#content,#section-container section'),
						'title'	=> __('Content Background Color', 'redux-framework-demo'),
						'subtitle'	=> __('Content Background Color (default: #f8f8f8)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#f8f8f8' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					), 
					array(
						'id'	=> 'color-accent',
						'type'	=> 'color',
						'output'	=> array('.btn,.wpcf7-submit'),
						'title'	=> __('Accent Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Accent Color, covers buttons and links. (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'favicon',
						'type'	=> 'media',
						'title'     => __('Favicon', 'redux-framework-demo'),
						'compiler'  => 'true',
						'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'      => __('Upload Square Graphic (Recommendation: 64x64 PNG file)', 'redux-framework-demo' ),
						'subtitle'  => __('', 'redux-framework-demo'),
					),
					array(
						'id'        => 'logo-menu',
						'type'      => 'media',
						'title'     => __('Logo', 'redux-framework-demo'),
						'compiler'  => 'true',
						'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'      => __('Image will be displayed at 50% width & height for Retina-Ready purpose. For example: 300x60 image shows at 150x30. <br /> Also, Max. height: 50px. Upload your logo accordingly.', 'redux-framework-demo'),
						'subtitle'  => __('', 'redux-framework-demo'),
					),
					array(
						'id'        => 'logo-login',
						'type'      => 'media',
						'title'     => __('WordPress Login Page - Logo', 'redux-framework-demo'),
						'compiler'  => 'true',
						'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'      => __('Max. dimension: 320x80', 'redux-framework-demo'),
						'subtitle'  => __('', 'redux-framework-demo'),
					),
					array(
						'id'	=> 'background-login',
						'type'	=> 'color',
						'title'	=> __('WordPress Login Page - Background Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Default: #f8f8f8', 'redux-framework-demo'),
						'default'	=> '#f8f8f8',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> '404-page',
						'type'	=> 'select',
						'data'	=> 'pages',
						'title'	=> __('Custom 404 Error Page', 'redux-framework-demo'),
						'subtitle'	=> __('Content of selected page will be shown to visitors who request a non-existing, so called "404 Error Page".', 'redux-framework-demo'),
						'desc'	=> __('If nothing selected, default 404 Content will be displayed.', 'redux-framework-demo'),
					),
					array(
						'id'	=> 'custom-styles',
						'type'	=> 'ace_editor',
						'mode'	=> 	'css',
						'theme'	=> 	'chrome',
						'title'	=> __('Custom Styles (CSS)', 'redux-framework-demo'),
						'subtitle'	=> __('Inline CSS right before closing <strong>&lt;/head&gt;</strong>', 'redux-framework-demo'),
						'desc'	=> __('Important: CSS tags are already in, do not put style tags! This will break the header file!', 'redux-framework-demo'),
						'default'	=> '',
					),
					array(
						'id'	=> 'custom-scripts',
						'type'	=> 'ace_editor',
						'mode'	=> 	'markdown',
						'theme'	=> 	'chrome',
						'title'	=> __('Custom Scripts (Google Analytics etc.)', 'redux-framework-demo'),
						'subtitle'	=> __('Inline scripts right before closing <strong>&lt;/body&gt;</strong>.', 'redux-framework-demo'),
						'desc'	=> __('Use "jQuery" selector, instead of "$" shorthand.', 'redux-framework-demo'),
						'default'	=> '',
					),
				)
            );
            
			/* ==============================
				Header
			============================== */
			$corp_options = get_option('corp_theme_option');
			$this->sections[] = array(
	            'title'     => __('Header', 'redux-framework-demo'),
	            'desc'      => __('The header. Make sure to double check every section.', 'redux-framework-demo'),
	            'icon'      => 'el el-lines',
				'fields'	=> array(
					array(
						'id' => 'color-hamburger-background',
						'type'	=> 'background',
						'output'	=> array('.navbar-toggler .icon-bar,.navbar-toggler .icon-bar:hover,.navbar-toggler .icon-bar:focus,.navbar-toggler .icon-bar:active,.navbar-toggler .icon-bar:visited'),
						'title'	=> __('Hamburger Background', 'redux-framework-demo'),
						'subtitle'	=> __('Handles the hamburger menu icon bar colors (default: #f8f8f8)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#f8f8f8' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					),
					// Trans Header Options
					array(
						'id'   =>'section-start',
						'title' => __('Transitional Header Options', 'redux-framework-demo'),
						'subtitle' => __('Update the trans header with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'	=> 'transitional-header-button',
						'type'	=> 'switch',
						'title'	=> __('Transitional Header', 'redux-framework-demo'),
						'subtitle'	=> __('Make Header on Home Page Transitional', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						'default'	=> true
					),
					array(
						'id'        => 'trans-header-logo',
						'type'      => 'media',
						'required' => array('transitional-header-button', 'equals', true),
						'title'     => __('Transitional Logo', 'redux-framework-demo'),
						'compiler'  => 'true',
						'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'      => __('Image will be displayed at 50% width & height for Retina-Ready purpose. For example: 300x60 image shows at 150x30. <br /> Also, Max. height: 50px. Upload your logo accordingly.', 'redux-framework-demo'),
						'subtitle'  => __('', 'redux-framework-demo'),
					),
					array(
						'id'   => 'color-trans-header-border',
						'type' => 'border',
						'required' => array('transitional-header-button', 'equals', true),
						'title' => __('Trans Header Border Color', 'redux-framework-demo'),
						'subtitle' => __('Change Trans Header Border Color'),
						'desc'	=> __('', 'redux-framework-demo'),
						'output' => array('#trans-menu.large'),
						'default'  => array(
							'border-color'  => '#c8c8c8', 
							'border-style'  => 'solid', 
							'border-bottom' => '0px', 
						),
						'all' => false,
						'left' => false,
						'right' => false,
						'top' => false,
						'bottom' => true,
						'style' => true,
						'color' => true,
					),
					array(
						'id'   => 'color-trans-header-background',
						'type' => 'background',
						'required' => array('transitional-header-button', 'equals', true),
						'title' => __('Trans Header Background Color', 'redux-framework-demo'),
						'subtitle' => __('Change Header Background Color'),
						'output' => array('#trans-menu.large'),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> true,
						'background-size'	=> false,
					),
					array(
						'id'	=> 'color-trans-header',
						'type'	=> 'color',
						'required' => array('transitional-header-button', 'equals', true),
						'title'	=> __('Trans Header Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Trans Header Color (default: #ffffff)', 'redux-framework-demo'),
						'default'	=> '#ffffff',
						'output' => array('#trans-menu.large'),
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'typography-trans-header',
						'type'	=> 'typography',
						'required' => array('transitional-header-button', 'equals', true),
						'title'	=> __('Typography Trans Header', 'redux-framework-demo'),
						'google'	=> true,
						'fonts'		=> $custom_fonts,
						'ext-font-css' => $theme_url . '/style.css',
						'font-backup'	=> true,
						'font-style'	=> true,
						'font-weight'	=> true,
						'text-align'	=> false,
						'text-transform' => true,
						//'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'	=> true,
						'line-height'	=> true,
						'word-spacing'	=> true, // Defaults to false
						'letter-spacing'	=> true, // Defaults to false
						'color'	=> true,
						//'preview'	=> false, // Disable the previewer
						'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('#trans-menu.large'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> 'Roboto',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'color-trans-header-link',
						'type'	=> 'color',
						'required' => array('transitional-header-button', 'equals', true),
						'title'	=> __('Trans Header Link Color', 'redux-framework-demo'),
						'output'	=> array('#trans-menu.large a,#trans-menu.large a:visited,#trans-menu.large a:focus,#trans-menu.large .fab,#trans-menu.large .fab:visited,#trans-menu.large .fab:focus'),
						'subtitle'	=> __('Trans Header Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'color-trans-header-link-hover',
						'type'	=> 'color',
						'required' => array('transitional-header-button', 'equals', true),
						'title'	=> __('Trans Content Hover Link Color', 'redux-framework-demo'), 
						'output'	=> array('#trans-menu.large a:hover,#trans-menu.large a:active,#trans-menu.large .fab:hover,#trans-menu.large .fab:active'),
						'subtitle'	=> __('Trans Content Hover Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					// Collapsable Header Options
					array(
						'id'   =>'section-start',
						'title' => __('Collapsable Header Options', 'redux-framework-demo'),
						'subtitle' => __('Update the collapsable header with these options. Will be overriden if Transitional header Options is turned on.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'	=> 'collapsable-header-button',
						'type'	=> 'switch',						
						'title'	=> __('Collapsable Header', 'redux-framework-demo'),
						'subtitle'	=> __('Make Header on Home Page Collapsable', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						'default'	=> false,
					),
					array(
						'id'        => 'collapsable-header-logo',
						'type'      => 'media',
						'required' => array('collapsable-header-button', 'equals', true),
						'title'     => __('Collapsable Logo', 'redux-framework-demo'),
						'compiler'  => 'true',
						'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'      => __('Image will be displayed at 50% width & height for Retina-Ready purpose. For example: 300x60 image shows at 150x30. <br /> Also, Max. height: 50px. Upload your logo accordingly.', 'redux-framework-demo'),
						'subtitle'  => __('', 'redux-framework-demo'),
					),
					array(
						'id'   => 'color-collapsable-header-background',
						'type' => 'background',
						'required' => array('collapsable-header-button', 'equals', true),
						'title' => __('Collapsable Header Background Color', 'redux-framework-demo'),
						'subtitle' => __('Change Header Background Color'),
						'output' => array('#collapse-menu'),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> true,
						'background-size'	=> false,
					),
					array(
						'id'   => 'color-collapsable-header-border',
						'type' => 'border',
						'required' => array('collapsable-header-button', 'equals', true),
						'title' => __('Collapsable Header Border Color', 'redux-framework-demo'),
						'subtitle' => __('Change Trans Header Border Color'),
						'desc'	=> __('', 'redux-framework-demo'),
						'output' => array('#collapse-menu'),
						'default'  => array(
							'border-color'  => '#c8c8c8', 
							'border-style'  => 'solid', 
							'border-bottom' => '0px', 
						),
						'all' => false,
						'left' => false,
						'right' => false,
						'top' => false,
						'bottom' => true,
						'style' => true,
						'color' => true,
					),
					array(
						'id'   => 'color-collapsable-panel-background',
						'type' => 'color_rgba',
						'required' => array('collapsable-header-button', 'equals', true),
						'title' => __('Collapsable Panel Background Color', 'redux-framework-demo'),
						'subtitle' => __('Change Header Background Color'),
						'output' => array('background-color' => '#panel-navbar-collapse'),
						'default'   => array(
							'color'     => '#242424',
							'alpha'     => .5
						),
					),
					array(
						'id'	=> 'color-collapsable-header',
						'type'	=> 'color',
						'required' => array('collapsable-header-button', 'equals', true),
						'title'	=> __('Collapsable Header Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Collapsable Header Color (default: #ffffff)', 'redux-framework-demo'),
						'default'	=> '#ffffff',
						'output' => array('#collapse-menu'),
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'typography-collapsable-header',
						'type'	=> 'typography',
						'required' => array('collapsable-header-button', 'equals', true),
						'title'	=> __('Typography Collapsable Header', 'redux-framework-demo'),
						'google'	=> true,
						'fonts'		=> $custom_fonts,
						'ext-font-css' => $theme_url . '/style.css',
						'font-backup'	=> true,
						'font-style'	=> true,
						'font-weight'	=> true,
						'text-align'	=> false,
						'text-collapsableform' => true,
						//'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'	=> true,
						'line-height'	=> true,
						'word-spacing'	=> true, // Defaults to false
						'letter-spacing'	=> true, // Defaults to false
						'color'	=> true,
						//'preview'	=> false, // Disable the previewer
						'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('#collapse-menu,#panel-navbar-collapse'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> 'Roboto',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'color-collapsable-header-link',
						'type'	=> 'color',
						'required' => array('collapsable-header-button', 'equals', true),
						'title'	=> __('Collapsable Header Link Color', 'redux-framework-demo'),
						'output'	=> array('#panel-navbar-collapse a,#panel-navbar-collapse a:visited,#panel-navbar-collapse a:focus'),
						'subtitle'	=> __('Collapsable Header Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'color-collapsable-header-link-hover',
						'type'	=> 'color',
						'required' => array('collapsable-header-button', 'equals', true),
						'title'	=> __('Collapsable Content Hover Link Color', 'redux-framework-demo'), 
						'output'	=> array('#panel-navbar-collapse a:hover,#panel-navbar-collapse a:active'),
						'subtitle'	=> __('Collapsable Content Hover Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					// Header Options
					array(
						'id'   =>'section-start',
						'title' => __('Header Options', 'redux-framework-demo'),
						'subtitle' => __('Update the header with these options. Acts as small menu for Transitional Header as well as regular header. Can be overriden by Collapsable Header.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'   => 'color-header-border',
						'type' => 'border',
						'title' => __('Header Border', 'redux-framework-demo'),
						'subtitle' => __('Header Border'),
						'desc'	=> __('', 'redux-framework-demo'),
						'output' => array('#trans-menu.small, #header-menu'),
						'default'  => array(
							'border-color'  => '#c8c8c8', 
							'border-style'  => 'solid', 
							'border-bottom' => '1px', 
						),
						'all' => false,
						'left' => false,
						'right' => false,
						'top' => false,
						'bottom' => true,
						'style' => true,
						'color' => true,
					),
					array(
						'id'	=> 'color-header-background',
						'type'	=> 'background',
						'output'	=> array('#trans-menu.small, #trans-menu .dropdown-menu, #header-menu, #header-menu .dropdown-menu, .navbar-collapse.show'),
						'title'	=> __('Site Header Background Color', 'redux-framework-demo'),
						'subtitle'	=> __('Site Header Background Color (default: #242424333)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#242424333' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					),
					array(
						'id'	=> 'color-header',
						'type'	=> 'color',
						'title'	=> __('Site Header Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Site Header Color (default: #ffffff)', 'redux-framework-demo'),
						'default'	=> '#ffffff',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'typography-header',
						'type'	=> 'typography',
						'title'	=> __('Typography Header', 'redux-framework-demo'),
						'google'	=> true,
						'fonts'		=> $custom_fonts,
						'ext-font-css' => $theme_url . '/style.css',
						'font-backup'	=> true,
						'font-style'	=> true,
						'font-weight'	=> true,
						'text-align'	=> false,
						'text-transform' => true,
						//'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'	=> true,
						'line-height'	=> true,
						'word-spacing'	=> true, // Defaults to false
						'letter-spacing'	=> true, // Defaults to false
						'color'	=> true,
						//'preview'	=> false, // Disable the previewer
						'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('#header-menu,#trans-menu.small'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> 'Roboto',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'color-header-link',
						'type'	=> 'color',
						'title'	=> __('Site Header Link Color', 'redux-framework-demo'),
						'output'	=> array('header a,header a:visited,header a:focus,header .fab,header .fab:visited,header .fab:focus,#header-container a,#header-container a:visited,#header-container a:focus,#trans-menu.small a,#trans-menu.small a:visited,#trans-menu.small a:focus'),
						'subtitle'	=> __('Site Header Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'color-header-link-hover',
						'type'	=> 'color',
						'title'	=> __('Site Content Hover Link Color', 'redux-framework-demo'), 
						'output'	=> array('header a:hover,header a:active,#header-container a:hover,#header-container a:focus,#trans-menu.small a:hover,#trans-menu.small a:active'),
						'subtitle'	=> __('Site Content Hover Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'   =>'section-start',
						'title' => __('Contact Options', 'redux-framework-demo'),
						'subtitle' => __('Update the header button contact info with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'	=> 'site-header-phone',
						'type'	=> 'text',
						'title'	=> __('Phone Number', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'numeric',
						'default'	=> '+1 555 22 66 8890',
					),
					array(
						'id'	=> 'site-header-email',
						'type'	=> 'text',
						'title'	=> __('Email Address', 'redux-framework-demo'),
						'subtitle'  => __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'numeric',
						'default'	=> 'info@yourcompany.com',
					),
					array(
						'id'	=> 'site-header-chat',
						'type'	=> 'ace_editor',
						'mode'	=> 	'javascript',
						'theme'	=> 	'chrome',
						'title'	=> __('Header Chat', 'redux-framework-demo'),
						'subtitle'	=> __('Inline scripts right before chat tag call in header.', 'redux-framework-demo'),
						'desc'	=> __('Use "jQuery" selector, instead of "$" shorthand. Important: Do not put script tags! This will break the footer file!', 'redux-framework-demo'),
						'default'	=> '',
					),
					array(
						'id'	=> 'site-header-chat-click',
						'type'	=> 'ace_editor',
						'mode'	=> 	'javascript',
						'theme'	=> 	'chrome',
						'title'	=> __('Header Chat onClick Code', 'redux-framework-demo'),
						'subtitle'	=> __('Script that fills out onClick chat code of link tag.', 'redux-framework-demo'),
						'desc'	=> __('Insert ONLY the code in the onClick attribute of the link tag (e.g.: onClick="COPY_EVERYTHING_IN_BETWEEN_THESE_QUOTES" Important: Do not put script tags! This will break the footer file!', 'redux-framework-demo'),
						'default'	=> '',
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
				)
            );
                        
			/* ==============================
				Slider
			============================== */
			$this->sections[] = array(
				'title'     => __('Slider', 'redux-framework-demo'),
				'desc'      => __('Use to color the text above the LayerSlider. Only use so if you are using one slide per page.', 'redux-framework-demo'),
				'icon'      => 'el el-screen',
				'fields'    => array(
					array(
						'id'	=> 'color-jumbotron-background',
						'type'	=> 'background',
						'output'	=> array('.jumbotron .slider-wash'),
						'title'	=> __('Jumbotron Background Color', 'redux-framework-demo'),
						'subtitle'	=> __('Jumbotron Background Color (default: #f8f8f8)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#f8f8f8' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					),
					array(
						'id'	=> 'opacity-slider',
						'type'	=> 'slider',
						'output' => array('.jumbotron .slider'),
						'title'	=> __('Jumbotron Slider Opacity', 'redux-framework-demo'),
						'subtitle'	=> __('Changes the opacity of the LayerSlider (default: .5)', 'redux-framework-demo'),
						'default' => 0.5,
						'min' => 0,
						'step' => 0.1,
						'max' => 1,
						'resolution' => 0.1,
						'display_value' => 'text'
					),
					array(
						'id'	=> 'jumbotron-headers',
						'type'	=> 'typography',
						'title'	=> __('Jumbotron Header', 'redux-framework-demo'),
						'google'	=> true,
						'fonts'		=> $custom_fonts,
						'ext-font-css' => $theme_url . '/style.css',
						'font-backup'	=> false,
						'font-style'	=> true,
						'font-weight'	=> true,
						'text-align'	=> true,
						'text-transform' => true,
						//'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'	=> true,
						'line-height'	=> true,
						'word-spacing'	=> true, // Defaults to false
						'letter-spacing' => true, // Defaults to false
						'color'	=> true,
						//'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('.jumbotron h1,.jumbotron h2,.jumbotron h3,.jumbotron h4,.jumbotron h5,.jumbotron h6'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> 'Roboto',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'jumbotron-text',
						'type'	=> 'typography',
						'output'	=> array('.jumbotron,.jumbotron p,.jumbotron .slider-text'),
						'title'	=> __('Jumbotron Text', 'redux-framework-demo'),
						'google'	=> true,
						'fonts'		=> $custom_fonts,
						'ext-font-css' => $theme_url . '/style.css',
						'font-backup'	=> false,
						'font-style'	=> true,
						'font-weight'	=> true,
						'text-align'	=> true,
						'text-transform' => true,
						//'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'	=> true,
						'line-height'	=> true,
						'word-spacing'	=> true, // Defaults to false
						'letter-spacing' => true, // Defaults to false
						'color'	=> true,
						//'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> 'Roboto',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'color-jumbotron-link',
						'type'	=> 'color',
						'output'	=> array('.jumbotron a,.jumbotron a:visited,.jumbotron a:focus'),
						'title'	=> __('Jumotron Color Link', 'redux-framework-demo'), 
						'subtitle'	=> __('Jumotron Color Link (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'color-jumbotron-link-hover',
						'type'	=> 'color',
						'output'	=> array('.jumbotron a:hover,.jumbotron a:active'),
						'title'	=> __('Jumotron Color Link Hover', 'redux-framework-demo'), 
						'subtitle'	=> __('Jumotron Color Link Hover (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id' => 'jumbotron-button-padding',
						'type' => 'spacing',
						'output' => array('.jumbotron .slider-text .btn'),
						'mode' => 'padding',
						'units' => array('em', 'px'),
						'units_extended' => 'false',
						'title' => __('Jumbotron Button Padding', 'redux-framework-demo'),
						'subtitle' => __('If you want a button for your Jumbotron links, adjust the padding here (important).', 'redux-framework-demo'),
						'desc' => __('You can enable or disable any piece of this field. Top, Right, Bottom, Left, or Units.', 'redux-framework-demo'),
						'default' => array(
							'padding-top'     => '15', 
							'padding-right'   => '15', 
							'padding-bottom'  => '15', 
							'padding-left'    => '15',
							'units'          => 'px', 
						),
					),
					array(
						'id' => 'color-jumbotron-button-background',
						'type'	=> 'background',
						'output'	=> array('.jumbotron .slider-text a,.jumbotron .slider-text a:visited,.jumbotron .slider-text a:focus'),
						'title'	=> __('Jumbotron Button Background', 'redux-framework-demo'),
						'subtitle'	=> __('Handles all button colors if you want a button style (default: #242424)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#242424' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					),
					array(
						'id' => 'color-jumbotron-button-background-hover',
						'type'	=> 'background',
						'output'	=> array('.jumbotron .slider-text a:hover,.jumbotron .slider-text a:active'),
						'title'	=> __('Jumbotron Button Background Hover', 'redux-framework-demo'),
						'subtitle'	=> __('Handles all button color hovers if you want a button style (default: #242424)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#242424' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					),
					// Scroll Down Button
					array(
						'id'   =>'section-start',
						'title' => __('Scroll Down Options', 'redux-framework-demo'),
						'subtitle' => __('Update the scroll down button visuals with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id' => 'scroll-down-icon-image', 
						'type'      => 'media',
						'title'     => __('Scroll Down Icon Image', 'redux-framework-demo'),
						'compiler'  => 'true',
						'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
						'desc'      => __('Max. dimension: 42x42', 'redux-framework-demo'),
						'subtitle'  => __('An image version of a scroll down button. Overrides the icon option if filled out.', 'redux-framework-demo'),
					),
					array(
						'id' => 'scroll-down-icon-html',
						'type' => 'text',
						'validate' => 'css',
						'title' => __('Scroll Down Icon', 'redux-framework-demo'),
						'subtitle'  => __('A icon version of a scroll down button. Will be overridden by the image version.', 'redux-framework-demo'),
						'desc' => __('eg: fa fa-hand-o-down', 'redux-framework-demo'),
					),
					array(
						'id' => 'scroll-down-text',
						'type' => 'text',
						'validate' => 'html',
						'title' => __('Scroll Down Text', 'redux-framework-demo'),
						'subtitle'  => __('Text that denotes scroll down. Can say anything if needed from site design.', 'redux-framework-demo'),
					),
					array(
						'id'	=> 'scroll-down-text-color',
						'type'	=> 'color',
						'title'	=> __('Scroll Down Line Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Scroll Down Line Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'output'	=> array('.down-arrow .scroll-text,.down-arrow .scroll-text:hover,.down-arrow .scroll-text:focus,.down-arrow .scroll-text:active'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'scroll-down-line',
						'type'	=> 'switch',
						'title'	=> __('Scroll Down Line', 'redux-framework-demo'),
						'subtitle'	=> __('Adds a line on the scroll down.', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						'default'	=> false
					),
					array(
						'id'	=> 'scroll-down-line-color',
						'type'	=> 'color',
						'title'	=> __('Scroll Down Line Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Scroll Down Line Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'output'	=> array('.down-arrow .line:before'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
						'required' => array('scroll-down-line', 'equals', true),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
				)
			);

			/* ==============================
				Typography
			============================== */
			$this->sections[] = array(
	            'title'     => __('Typography', 'redux-framework-demo'),
	            'desc'      => __('This section is to set the overall typography for the body (not including the header and footer.', 'redux-framework-demo'),
	            'icon'      => 'el el-fontsize',
	            'fields'    => array(
					// Link Options
					array(
						'id'   =>'section-start',
						'title' => __('Link Options', 'redux-framework-demo'),
						'subtitle' => __('Update the content a tags and other links with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'	=> 'color-content-link',
						'type'	=> 'color',
						'title'	=> __('Site Content Link Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Site Content Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'output'	=> array('a,a:visited,a:focus'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'color-content-link-hover',
						'type'	=> 'color',
						'title'	=> __('Site Content Hover Link Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Site Content Hover Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'output'	=> array('a:hover,a:active'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					// Headings Options
					array(
						'id'   =>'section-start',
						'title' => __('Link Options', 'redux-framework-demo'),
						'subtitle' => __('Update the content a tags and other links with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'	=> 'typography-headings',
						'type'	=> 'typography',
						'title'	=> __('Typography Headings', 'redux-framework-demo'),
						'google'	=> true,
						'fonts'		=> $custom_fonts,
						'ext-font-css' => $theme_url . '/style.css',
						'font-backup'   => true,
						'font-style'    => true,
						'font-weight'	=> true,
						'text-align'	=> true,
						'text-transform' => true,
						//'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'     => true,
						'line-height'   => true,
						'word-spacing'  => true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'	=> true,
						//'preview'	=> false, // Disable the previewer
						'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('h1,h2,h3,h4,h5,h6'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> 'Roboto',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'typography-headings-h1',
						'type'	=> 'typography',
						'title'	=> __('H1', 'redux-framework-demo'),
						'google'	=> false,
						'font-family'	=> false,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'	=> false,
						'text-align'	=> false,
						'text-transform' => true,
						'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'     => true,
						'line-height'   => true,
						'word-spacing'  => true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'	=> true,
						'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('h1,#content h1'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('Overrides the main headings for H1 tags. Try not to get color crazy. Use a color wheel and know color complement theory.', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> '',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'typography-headings-h2',
						'type'	=> 'typography',
						'title'	=> __('H2', 'redux-framework-demo'),
						'google'	=> false,
						'font-family'	=> false,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'	=> false,
						'text-align'	=> false,
						'text-transform' => true,
						'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'     => true,
						'line-height'   => true,
						'word-spacing'  => true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'	=> true,
						'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('h2,#content h2'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('Overrides the main headings for H2 tags. Try not to get color crazy. Use a color wheel and know color complement theory.', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> '',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'typography-headings-h3',
						'type'	=> 'typography',
						'title'	=> __('H3', 'redux-framework-demo'),
						'google'	=> false,
						'font-family'	=> false,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'	=> false,
						'text-align'	=> false,
						'text-transform' => true,
						'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'     => true,
						'line-height'   => true,
						'word-spacing'  => true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'	=> true,
						'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('h3,#content h3'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('Overrides the main headings for H3 tags. Try not to get color crazy. Use a color wheel and know color complement theory.', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> '',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'typography-headings-h4',
						'type'	=> 'typography',
						'title'	=> __('H4', 'redux-framework-demo'),
						'google'	=> false,
						'font-family'	=> false,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'	=> false,
						'text-align'	=> false,
						'text-transform' => true,
						'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'     => true,
						'line-height'   => true,
						'word-spacing'  => true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'	=> true,
						'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('h4,#content h4'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('Overrides the main headings for H4 tags. Try not to get color crazy. Use a color wheel and know color complement theory.', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> '',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'typography-headings-h5',
						'type'	=> 'typography',
						'title'	=> __('H5', 'redux-framework-demo'),
						'google'	=> false,
						'font-family'	=> false,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'	=> false,
						'text-align'	=> false,
						'text-transform' => true,
						'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'     => true,
						'line-height'   => true,
						'word-spacing'  => true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'	=> true,
						'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('h5,#content h5'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('Overrides the main headings for H5 tags. Try not to get color crazy. Use a color wheel and know color complement theory.', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> '',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'	=> 'typography-headings-h6',
						'type'	=> 'typography',
						'title'	=> __('H6', 'redux-framework-demo'),
						'google'	=> false,
						'font-family'	=> false,
						'font-backup'   => false,
						'font-style'    => false,
						'font-weight'	=> false,
						'text-align'	=> false,
						'text-transform' => true,
						'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'     => true,
						'line-height'   => true,
						'word-spacing'  => true, // Defaults to false
						'letter-spacing'=> true, // Defaults to false
						'color'	=> true,
						'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('h6,#content h6'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('Overrides the main headings for H6 tags. Try not to get color crazy. Use a color wheel and know color complement theory.', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> '',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					// Body Options
					array(
						'id'   =>'section-start',
						'title' => __('Body Options', 'redux-framework-demo'),
						'subtitle' => __('Update the content p tags and other links with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'	=> 'typography-body',
						'type'	=> 'typography',
						'title'	=> __('Typography Body', 'redux-framework-demo'),
						'google'	=> true,
						'fonts'		=> $custom_fonts,
						'ext-font-css' => $theme_url . '/style.css',
						'font-backup'	=> true,
						'font-style'	=> true,
						'font-weight'	=> true,
						'text-align'	=> true,
						'text-transform' => true,
						//'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'	=> true,
						'line-height'	=> true,
						'word-spacing'	=> true, // Defaults to false
						'letter-spacing'	=> true, // Defaults to false
						'color'	=> true,
						//'preview'	=> false, // Disable the previewer
						'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('body,p'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('', 'redux-framework-demo'),
						'default'	=> array(
							'font-family'	=> 'Roboto',
							'font-style'	=> '400',
							'google'	=> true,
							'color'	=> '#242424'
						),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
				)
            );  

			/* ==============================
				Content
			============================== */
            $this->sections[] = array(
	            'title' => __('Content', 'redux-framework-demo'),
	            'desc' => __('This is to cover the typography that consist of the buttons and map icons on the body.', 'redux-framework-demo'),
	            'icon' => 'el el-book',
	            'fields' => array(
					array(
						'id'   =>'section-start',
						'title' => __('AJAX Options', 'redux-framework-demo'),
						'subtitle' => __('Update asynchronous loading with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id' => 'pjax-loader',
						'type'	=> 'switch',
						'title'	=> __('SmoothStateJS Instant Loader', 'redux-framework-demo'),
						'subtitle'	=> __('Turns on SmoothStateJS for a PJAX/AJAX styled fast page by page load. Be warned in using this in conjuction with WooCommerce Cart and Checkout pages.', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						'default' => false
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					// Blog Posts Options
					array(
						'id'   =>'section-start',
						'title' => __('Blog Post Options', 'redux-framework-demo'),
						'subtitle' => __('Update the home page blog post visuals with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id' => 'content-posts-container',
						'type'	=> 'switch',
						'title'	=> __('Show Posts on Front Page', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						'default' => true
					),
					array(
						'id' => 'content-posts-section-page-container',
						'type'	=> 'switch',
						'title'	=> __('Show Posts on Section Container Template', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						'default' => true,
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id' => 'blog-posts-number-of',
						'type' => 'slider',
						'required' => array('content-posts-container', 'equals', true),
						'title'	=> __('Number of Blog Posts', 'redux-framework-demo'),
						'subtitle'	=> __('Set the number of blog posts to generate', 'redux-framework-demo'),
						'desc'	=> __('Do not choose 5 or 7 unless you want to be uneven on the bottom.', 'redux-framework-demo'),
						'default' => 3,
						'min' => 3,
						'step' => 1,
						'max' => 9,
						'resolution' => 1,
						'display_value' => 'text'
					),
					array(
						'id' => 'blog-posts-category',
						'type' => 'text',
						'title' => __('Front Page Blog Posts Category', 'redux-framework-demo'),
						'subtitle'  => __('Write which category of blog posts that will appear on front page.', 'redux-framework-demo'),
						'desc' => __('eg: category1, category2, ...', 'redux-framework-demo'),
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id' => 'color-blog-posts-background',
						'type'	=> 'background',
						'output' => array('.home #content #posts-section .post-item,.page-template-template-01home #content #posts-section .post-item,.page-template-template-04sctcontainer #blog-section #posts-section .post-item,.blog #content #posts-section .thumbnail'),
						'title'	=> __('Blog Post Background', 'redux-framework-demo'),
						'subtitle'	=> __('Handles read more image background color wash (default: #242424)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#242424' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id' => 'color-blog-posts-header',
						'type'	=> 'color',
						'title'	=> __('Blog Post Header Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Handles read more button border colors (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'output' => array('.home #content #posts-section .post-item .has-title,.page-template-template-01home #content #posts-section .post-item .has-item,.page-template-template-04sctcontainer #blog-section #posts-section .post-item .has-item'), // An array of CSS selectors to apply this font style to dynamically
						'transparent'	=> false,
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id' => 'color-blog-posts-header-hover',
						'type'	=> 'color',
						'title'	=> __('Blog Post Header Hover Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Handles read more button border colors (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'output' => array('.home #content #posts-section .post-item .has-title:hover,.page-template-template-01home #content #posts-section .post-item .has-item:hover,.page-template-template-04sctcontainer #blog-section #posts-section .post-item .has-item:hover'), // An array of CSS selectors to apply this font style to dynamically
						'transparent'	=> false,
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id' => 'color-blog-posts-read-more-bg',
						'type'	=> 'color',
						'title'	=> __('Read More Button Border Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Handles read more button border colors (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id' => 'color-blog-posts-read-more-bg-hover',
						'type'	=> 'color',
						'title'	=> __('Read More Button Background Color Hover', 'redux-framework-demo'), 
						'subtitle'	=> __('Handles read more hover button background colors (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id' => 'color-blog-posts-read-more-text',
						'type'	=> 'color',
						'title'	=> __('Read More Button Link Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Handles read more button text colors (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id' => 'color-blog-posts-read-more-text-hover',
						'type'	=> 'color',
						'title'	=> __('Read More Button Hover Link Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Handles read more hover button text colors (default: #f8f8f8)', 'redux-framework-demo'),
						'default'	=> '#f8f8f8',
						'validate'	=> 'color',
						'transparent'	=> false,
						'required' => array('content-posts-container', 'equals', true),
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					// Button Options
					array(
						'id'   =>'section-start',
						'title' => __('Button Options', 'redux-framework-demo'),
						'subtitle' => __('Update the button visuals with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id' => 'color-button-background',
						'type'	=> 'background',
						'output'	=> array('.btn,.btn:focus,.btn:visited,.wpcf7-submit,.wpcf7-submit:focus,.wpcf7-submit:visited,.button,.button:visited,.button:focus,button,button:focus,button:visited,.submit,.submit:focus,.submit:visited, #shop-main .button,#shop-main .button:visited,#shop-main .button:focus'),
						'title'	=> __('Button Background', 'redux-framework-demo'),
						'subtitle'	=> __('Handles all button colors (default: #242424)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#242424' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					),
					array(
						'id' => 'color-button-background-hover',
						'type'	=> 'background',
						'output'	=> array('.btn:hover,.btn:active,.wpcf7-submit:hover,.wpcf7-submit:active,.button:hover,.button:active,button:hover,button:active,.submit:hover,.submit:active,#shop-main .button:active,#shop-main .button:hover'),
						'title'	=> __('Button Background Hover', 'redux-framework-demo'),
						'subtitle'	=> __('Handles all button color hovers (default: #242424)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#242424' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					),
					array(
						'id' => 'color-button-text',
						'type'	=> 'color',
						'output'	=> array('.btn,.btn:focus,.btn:visited,.wpcf7-submit,.wpcf7-submit:focus,.wpcf7-submit:visited,.button,.button:visited,.button:focus,button,button:focus,button:visited,.submit,.submit:focus,.submit:visited,#shop-main .button,#shop-main .button:visited,#shop-main .button:focus'),
						'title'	=> __('Button Link Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Handles all button text colors (default: #f8f8f8)', 'redux-framework-demo'),
						'default'	=> '#f8f8f8',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id' => 'color-button-text-hover',
						'type'	=> 'color',
						'output'	=> array('.btn:hover,.btn:active,.wpcf7-submit:hover,.wpcf7-submit:active,.button:hover,.button:active,button:hover,button:active,.submit:hover,.submit:active,,#shop-main .button:active,#shop-main .button:hover'),
						'title'	=> __('Button Link Color Hover', 'redux-framework-demo'), 
						'subtitle'	=> __('Handles all button text color hovers (default: #f8f8f8)', 'redux-framework-demo'),
						'default'	=> '#f8f8f8',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
					array(
						'id'   =>'section-start',
						'title' => __('Map Options', 'redux-framework-demo'),
						'subtitle' => __('Update the map API key and visuals with these options.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'	=> 'map-options-api-key',
						'type'	=> 'text',
						'title'	=> __('Google Maps API Key', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '',
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
				),
			);
            
			/* ==============================
				Footer
			============================== */
            $this->sections[] = array(
	            'title'     => __('Footer', 'redux-framework-demo'),
	            'desc'      => __('The footer info. Make sure to fill every option.', 'redux-framework-demo'),
	            'icon'      => 'el el-wrench',
	            'fields'    => array(
					array(
						'id' => 'footer-sitemap',
						'type'	=> 'switch',
						'title'	=> __('Show Sitemap on Footer', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						'default' => false
					),
					array(
						'id'	=> 'color-footer-background',
						'type'	=> 'background',
						'output'	=> array('#footer-sitemap'),
						'title'	=> __('Footer Top Background Color', 'redux-framework-demo'),
						'subtitle'	=> __('Footer Top Background Color (default: #424242)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#424242' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
						'required' => array('footer-sitemap', 'equals', true),
					),
					array(
						'id'	=> 'color-footer-bottom-background',
						'type'	=> 'background',
						'output'	=> array('#footer-container'),
						'title'	=> __('Footer Bottom Background Color', 'redux-framework-demo'),
						'subtitle'	=> __('Footer Bottom Background Color (default: #242424)', 'redux-framework-demo'),
						'default'	=> array( 'background-color' => '#242424' ),
						'background-repeat'	=> false,
						'background-attachment'	=> false,
						'background-position'	=> false,
						'background-image'	=> false,
						'transparent'	=> false,
						'background-size'	=> false,
					),
					array(
						'id' => 'typography-footer',
						'type' => 'typography',
						'title'	=> __('Typography Footer', 'redux-framework-demo'),
						'google' => true,
						'fonts' => $custom_fonts,
						'ext-font-css' => $theme_url . '/style.css',
						'font-backup' => false,
						'font-style' => false,
						'font-weight' => true,
						'text-align'	=> false,
						'text-transform' => true,
						//'subsets'	=> false, // Only appears if google is true and subsets not set to false
						'font-size'	=> false,
						'line-height' => false,
						'word-spacing' => true, // Defaults to false
						'letter-spacing' => true, // Defaults to false
						'color'	=> true,
						//'preview'	=> false, // Disable the previewer
						'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
						'output' => array('#footer-container,#footer-sitemap'), // An array of CSS selectors to apply this font style to dynamically
						'units'	=> 'px', // Defaults to px
						'subtitle'	=> __('', 'redux-framework-demo'),
						'default'	=> array(
							'font-family' => 'Roboto',
							'font-style' => '400',
							'google' => true,
							'color'	=> '#fff'
						),
					),
					array(
						'id'	=> 'color-footer-link',
						'type'	=> 'color',
						'output'	=> array('#footer-container a,#footer-container a:visited'),
						'title'	=> __('Site Footer Link Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Site Footer Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'color-footer-link-hover',
						'type'	=> 'color',
						'output'	=> array('#footer-container a:hover,#footer-container a:active,#footer-container a:focus'),
						'title'	=> __('Site Content Hover Link Color', 'redux-framework-demo'), 
						'subtitle'	=> __('Site Content Hover Link Color (default: #70b9a0)', 'redux-framework-demo'),
						'default'	=> '#70b9a0',
						'validate'	=> 'color',
						'transparent'	=> false,
					),
					array(
						'id'	=> 'copyright',
						'type'	=> 'text',
						'title'	=> __('Copyright Text', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('Type the copyright here. HTML is allowed.', 'redux-framework-demo'),
						//'validate'	=> 'numeric',
						'default'	=> '&copy;2018 <a href="https://prodhmd.com"><strong>ProdHMD</strong></a>',
					),
					array(
						'id'	=> 'developer-text',
						'type'	=> 'text',
						'title'	=> __('Developer Text', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('Type the developer name here.', 'redux-framework-demo'),
						//'validate'	=> 'numeric',
						'default'	=> 'Kake Multimedia',
					),
					array(
						'id'	=> 'developer-link',
						'type'	=> 'text',
						'title'	=> __('Developer Link', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('Type the developer URL here.', 'redux-framework-demo'),
						//'validate'	=> 'numeric',
						'default'	=> 'https://kakemultimedia.com',
					),
					array(
						'id'	=> 'footer-show-up-button',
						'type'	=> 'switch',
						'title'	=> __('Display "To The Top" Button', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						'default'	=> true
					),
					// Social Media Options
					array(
						'id'   =>'section-start',
						'title' => __('Social Media', 'redux-framework-demo'),
						'subtitle' => __('Add social media links here.', 'redux-framework-demo'),
						'type' => 'section',
						'indent' => true,
					),
					array(
						'id'	=> 'social-facebook',
						'type'	=> 'text',
						'title'	=> __('Faceook URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '#',
					),
					array(
						'id'	=> 'social-twitter',
						'type'	=> 'text',
						'title'	=> __('Twitter URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '#',
					),
					array(
						'id'	=> 'social-google',
						'type'	=> 'text',
						'title'	=> __('Google+ URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '#',
					),
					array(
						'id'	=> 'social-linkedin',
						'type'	=> 'text',
						'title'	=> __('LinkedIn URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '',
					),
					array(
						'id'	=> 'social-pinterest',
						'type'	=> 'text',
						'title'	=> __('Pinterest URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '',
					),
					array(
						'id'	=> 'social-instagram',
						'type'	=> 'text',
						'title'	=> __('Instagram URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'  => 'url',
						'default'	=> '',
					),
					array(
						'id'	=> 'social-youtube',
						'type'	=> 'text',
						'title'	=> __('YouTube URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '',
					),
					array(
						'id'	=> 'social-skype',
						'type'	=> 'text',
						'title'	=> __('Skype URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '',
					),
					array(
						'id'	=> 'social-yelp',
						'type'	=> 'text',
						'title'	=> __('Yelp URL', 'redux-framework-demo'),
						'subtitle'	=> __('', 'redux-framework-demo'),
						'desc'	=> __('', 'redux-framework-demo'),
						//'validate'	=> 'url',
						'default'	=> '',
					),
					array(
						'id'     => 'section-end',
						'type'   => 'section',
						'indent' => false,
					),
				)
			);
	        
            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'	=> 'el-icon-book',
                    'title'	=> __('Documentation', 'redux-framework-demo'),
                    'content'	=> nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {
            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );
            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**
		 * All the possible arguments for Redux.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
        **/
        public function setArguments() {
            $theme = wp_get_theme();							// For use with some settings. Not necessary.
            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'corp_theme_option',		// This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'submenu',               // Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'redux-framework-demo'),
                'page_title'        => __('Theme Options', 'redux-framework-demo'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyB66Y-sRZ5P60QYBoGHn3PhplGX2i7o87k', // Must be defined to add google fonts to the typography module
                'async_typography'  => false,					// Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,					// Show the time the page took to load, etc
                'customizer'        => false,					// Enable basic customizer support
                //'open_expanded'     => true,					// Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,					// Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => 'corp_theme_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                'footer_credit'     => '&nbsp;',				// Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '',					// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false,				// REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            /* SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.fabcebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            ); */

            /* Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo'); */
        }
    }
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
 * Custom function for the callback referenced above
**/
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
 * Custom function for the callback validation referenced above
**/
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
		
        /* do your validation
		if(something) {
			$value = $value;
		} elseif(something else) {
			$error = true;
			$value = $existing_value;
			$field['msg'] = 'your custom error message';
		}  */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
