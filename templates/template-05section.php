<?php
	/**
     * Template Name: 05 - Section
     * 
	 * The template for displaying all pages.
	 *
	 * This is the template that displays all pages by default.
	 * Please note that this is the WordPress construct of pages
	 * and that other 'pages' on your WordPress site will use a
	 * different template.
	 *
	 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
	 *
	 * @package 	WordPress
	 * @subpackage 	Starkers
	 * @since 		Starkers 4.0
	 */
	global $corp_theme_option;
	$trans_opt = $corp_theme_option['transitional-header-button'];
	$trans_page_opt = get_post_meta($post->ID,'page_options_trans-header',true);
	$collapse_opt = $corp_theme_option['collapsable-header-button'];
    $post_slug = $post->post_name;
    $section_bg = wp_get_attachment_url( get_post_thumbnail_id() );
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header' ) ); ?>

<!-- Main Information -->
<main <?php body_class(); ?>>

<?php if ( $trans_page_opt == 1 ) : ?> 
    <?php if ( $trans_opt ) : ?>
        <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/trans-header' ) ); ?>
    <?php elseif ( $collapse_opt ) : ?>
        <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/collapse-header' ) ); ?>
    <?php endif; ?>
<?php else : ?>
    <?php if ( $collapse_opt ) : ?>
        <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/collapse-header' ) ); ?>
    <?php else : ?>
        <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/header' ) ); ?>
    <?php endif; ?>
<?php endif; ?>

<section class="container-fluid section" id="<?php echo $post_slug; ?>" <?php if( !empty( $section_bg ) ) { ?> style="background-image:url('<?php echo $section_bg; ?>')" <?php } ?>>
    <div class="row">
        <div class="col-lg-12">
            <?php the_content(); ?>
        <!-- end .col-lg-12 --></div>
    <!-- end .row --></div>
<!-- end #section --></section>

<!-- end main --></main>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>