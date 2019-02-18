<?php
	/* WooCommerce Theme Support */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	remove_action( 'woocommerce_sidebar', 'action_woocommerce_sidebar', 10, 2 ); 
	// Theme Wrapper	
	function my_theme_wrapper_start() {
		echo '<section id="main">';
	}
	add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
	function my_theme_wrapper_end() {
		echo '</section>';
	}
	add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
	// Woo Support
	function woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'woocommerce_support' );
    // WooCommerce Extra Feature (e.g.:[product_categories_dropdown orderby="title" count="0" hierarchical="0"])
    function kake_wc_product_dropdown_categories( $args = array(), $deprecated_hierarchical = 1, $deprecated_show_uncategorized = 1, $deprecated_orderby = '' ) {
        global $wp_query;
        if ( ! is_array( $args ) ) {
            wc_deprecated_argument( 'wc_product_dropdown_categories()', '2.1', 'show_counts, hierarchical, show_uncategorized and orderby arguments are invalid - pass a single array of values instead.' );

            $args['show_count']         = $args;
            $args['hierarchical']       = $deprecated_hierarchical;
            $args['show_uncategorized'] = $deprecated_show_uncategorized;
            $args['orderby']            = $deprecated_orderby;
        }
        $current_product_cat = isset( $wp_query->query_vars['product_cat'] ) ? $wp_query->query_vars['product_cat'] : '';
        $defaults            = array(
            'pad_counts'         => 1,
            'show_count'         => 1,
            'hierarchical'       => 1,
            'hide_empty'         => 1,
            'show_uncategorized' => 1,
            'orderby'            => 'name',
            'selected'           => $current_product_cat,
            'menu_order'         => false,
        );
        $args = wp_parse_args( $args, $defaults );
        if ( 'order' === $args['orderby'] ) {
            $args['menu_order'] = 'asc';
            $args['orderby']    = 'name';
        }
        $terms = get_terms( 'product_cat', apply_filters( 'wc_product_dropdown_categories_get_terms_args', $args ) );
        if ( empty( $terms ) ) {
            return;
        }
        $output  = "<select name='product_cat' id='product_cat' class='dropdown_product_cat'>";
        //$output .= '<option value="" ' . selected( $current_product_cat, '', false ) . '>' . esc_html__( 'Select a category', 'woocommerce' ) . '</option>';
        $output .= wc_walk_category_dropdown_tree( $terms, 0, $args );
        if ( $args['show_uncategorized'] ) {
            $output .= '<option value="0" ' . selected( $current_product_cat, '0', false ) . '>' . esc_html__( 'Uncategorized', 'woocommerce' ) . '</option>';
        }
        $output .= "</select>";
        echo $output;
    }
    function woo_product_categories_dropdown( $atts ) {
        extract(shortcode_atts(array(
            'show_count'    => '0',
            'hierarchical'  => '0',
            'orderby'       => ''
        ), $atts));
        ob_start();
            $c = $count;
            $h = $hierarchical;
            $o = ( isset( $orderby ) && $orderby != '' ) ? $orderby : 'order';
            // Stuck with this until a fix for http://core.trac.wordpress.org/ticket/13258
            kake_wc_product_dropdown_categories( $c, $h, 0, $o );
            ?>
                <script type='text/javascript'>
                    /* <![CDATA[ */
                        var product_cat_dropdown = jQuery(".dropdown_product_cat");
                        product_cat_dropdown.change(function() {
                            if ( product_cat_dropdown.val() !=='' ) {
                                location.href = "<?php echo home_url(); ?>/?product_cat="+product_cat_dropdown.val();
                            }
                        });
                    /* ]]> */
                </script>
            <?php
        return ob_get_clean();
    }
    add_shortcode( 'product_categories_dropdown', 'woo_product_categories_dropdown' );