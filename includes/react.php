<?php

    // Add various fields to the JSON output
    function Corp_Full_Theme_4_register_fields() {
        // Add Author Name
        register_rest_field( 'post',
            'author_name',
            array(
                'get_callback'      => 'Corp_Full_Theme_4_get_author_name',
                'update_callback'   => null,
                'schema'            => null
            )
        );
        // Add Featured Image
        register_rest_field( 'post',
            'featured_image_src',
            array(
                'get_callback'      => 'Corp_Full_Theme_4_get_image_src',
                'update_callback'   => null,
                'schema'            => null
            )
    );
    // Add Published Date
        register_rest_field( 'post',
        'published_date',
        array(
            'get_callback'      => 'Corp_Full_Theme_4_published_date',
            'update_callback'   => null,
            'schema'            => null
        )
        );
    }
    add_action( 'rest_api_init', 'Corp_Full_Theme_4_register_fields' );

    function Corp_Full_Theme_4_get_author_name( $object, $field_name, $request ) {
        return get_the_author_meta( 'display_name' );
    }
    function Corp_Full_Theme_4_get_image_src( $object, $field_name, $request ) {
    if($object[ 'featured_media' ] == 0) {
        return $object[ 'featured_media' ];
    }
        $feat_img_array = wp_get_attachment_image_src( $object[ 'featured_media' ], 'thumbnail', true );
    return $feat_img_array[0];
    }
    function Corp_Full_Theme_4_published_date( $object, $field_name, $request ) {
        return get_the_time('F j, Y');
    }

    $url = trailingslashit( home_url() );
    $path = trailingslashit( parse_url( $url, PHP_URL_PATH ) );

    wp_scripts()->add_data( 
        'reactcomjs', 'data', sprintf( 
            'var reactComJS = %s;', wp_json_encode( 
                array(
                    'title' => get_bloginfo( 'name', 'display' ),
                    'path' => $path,
                    'URL' => array(
                        'api' => esc_url_raw( get_rest_url( null, '/wp/v2' ) ),
                        'root' => esc_url_raw( $url ),
                    ),
                    'woo' => array(
                        'url' => esc_url_raw( get_rest_url( null, '/wp-json/wc/v2/' ) ),
                        'consumer_key' => 'ck_803bcdcaa73d3a406a0f107041b07ef6217e05b9',
                        'consumer_secret' => 'cs_c50ba3a77cc88c3bf46ebac49bbc96de3a543f03'
                    ),
                )
            )
        )
    );