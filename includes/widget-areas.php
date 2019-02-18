<?php
	/* Widget Areas */
	function arphabet_widgets_init() {
		register_sidebar( array(
			'name'          => ( 'Posts Sidebar' ),
			'id'            => 'posts-sidebar',
			'description'   => __( 'Appears on posts and pages in the sidebar.', 'arphabet_widgets_ini' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		
		register_sidebar( array(
			'name'          => ( 'Home Left Sidebar' ),
			'id'            => 'home-left-sidebar',
			'description'   => __( 'Appears in the left section of the home page.', 'arphabet_widgets_ini' ),
			'before_widget' => '<aside id="%1$s" class="widget-inner"><div class="widget %2$s">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		
		register_sidebar( array(
			'name'          => ( 'Home Bottom Sidebar' ),
			'id'            => 'home-bottom-sidebar',
			'description'   => __( 'Appears in the bottom section of the home page.', 'arphabet_widgets_ini' ),
			'before_widget' => '<aside id="%1$s" class="widget-inner col-md-4"><div class="widget %2$s">',
			'after_widget'  => '</div></aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
					
		register_sidebar( array(
			'name'          => ( 'WooCommerce Sidebar' ),
			'id'            => 'woo-sidebar',
			'description'   => __( 'Appears on WooCommerce pages.', 'arphabet_widgets_ini' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	add_action( 'widgets_init', 'arphabet_widgets_init' );