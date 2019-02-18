<?php
	/* Testimonials Plugin */
	
	// Start Plugin
	if ( ! function_exists('testimonals_post_type') ) {
		// Register Custom Post Type
		function testimonals_post_type() {
			$labels = array(
				'name'                  => _x( 'Testimonials', 'Post Type General Name', 'testimonials' ),
				'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'testimonials' ),
				'menu_name'             => __( 'Testimonials', 'testimonials' ),
				'name_admin_bar'        => __( 'Testimonials', 'testimonials' ),
				'archives'              => __( 'Testimonial Archives', 'testimonials' ),
				'parent_item_colon'     => __( 'Parent Testimonial:', 'testimonials' ),
				'all_items'             => __( 'All Testimonials', 'testimonials' ),
				'add_new_item'          => __( 'Add New Testimonial', 'testimonials' ),
				'add_new'               => __( 'Add New Testimonial', 'testimonials' ),
				'new_item'              => __( 'New Testimonial', 'testimonials' ),
				'edit_item'             => __( 'Edit Testimonial', 'testimonials' ),
				'update_item'           => __( 'Update Testimonial', 'testimonials' ),
				'view_item'             => __( 'View Testimonial', 'testimonials' ),
				'search_items'          => __( 'Search Testimonial', 'testimonials' ),
				'not_found'             => __( 'Not found', 'testimonials' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'testimonials' ),
				'featured_image'        => __( 'Featured Image', 'testimonials' ),
				'set_featured_image'    => __( 'Set featured image', 'testimonials' ),
				'remove_featured_image' => __( 'Remove featured image', 'testimonials' ),
				'use_featured_image'    => __( 'Use as featured image', 'testimonials' ),
				'insert_into_item'      => __( 'Insert into testimonial', 'testimonials' ),
				'uploaded_to_this_item' => __( 'Uploaded to this testimonial', 'testimonials' ),
				'items_list'            => __( 'Testimonials list', 'testimonials' ),
				'items_list_navigation' => __( 'Testimonials list navigation', 'testimonials' ),
				'filter_items_list'     => __( 'Filter testimonials list', 'testimonials' ),
			);
			$args = array(
				'label'                 => __( 'Testimonial', 'testimonials' ),
				'description'           => __( 'Testimonials from customers, clients, etc. go here.', 'testimonials' ),
				'labels'                => $labels,
				'supports'              => array( 'title', 'editor', 'thumbnail', 'trackbacks', 'revisions', 'post-formats', ),
				'taxonomies'            => array( 'testimonial_types' ),
				'hierarchical'          => true,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'menu_icon'             => '',
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => false,		
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'page',
			);
			register_post_type( 'testimonials', $args );
		
		}
		add_action( 'init', 'testimonals_post_type', 0 );
	
		// Post Type Icon
		function namespaced_admin_styles_function() {
			echo '<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css"  rel="stylesheet">';
			echo '<style type="text/css">#adminmenu #menu-posts-testimonials .wp-menu-image:before {
				content: "\f0c0";
				font-family: "FontAwesome" !important;
				font-size: 18px !important;
			}</style>';
		}
		add_action('admin_head', 'namespaced_admin_styles_function');
	
	}

// Add Shortcode
function testimonials_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'posts' => '-1',
			'orderby' => 'date',
			'order' => 'ASC',
		),
		$atts
	);

	$args = array(
	    'post_type' => 'testimonials',
	    'nopaging' => false,
	    'posts_per_page' => $atts['posts'],
	    'order' => $atts['order'],
	    'orderby' => $atts['orderby'],
	);
	$query = new WP_Query( $args );

	ob_start();
	
	if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post();
	
	echo '<div class="testimonial-post">';
	    echo the_content();
	echo '</div>';
	
	endwhile; wp_reset_postdata(); endif;

	return ob_get_clean();

}
add_shortcode( 'testimonial-posts', 'testimonials_shortcode' );