<?php
	/**
     * Template Name: 02 - Hero
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

<!-- Jumbotron Information -->
<div class="jumbotron" id="other">
    <div class="slider-text container-fluid">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <?php 
                    $slidertitle = get_post_meta($post->ID, "slidermeta-text", true); 
                    $sliderimage = get_post_meta($post->ID, "slidermeta-image", true); 
                    if( !empty( $slidertitle ) && empty( $sliderimage ) ) { 
                ?>
                    <h1 class="slider-title"><?php echo $slidertitle; ?></h1>
                <?php } elseif( empty( $slidertitle ) && !empty( $sliderimage ) ) { ?>
                    <h1 class="slider-title">
                        <img src="<?php echo $sliderimage; ?>" alt="" class="img-fluid mx-auto" />
                    <!-- end .slider-title --></h1>
                <?php } elseif( !empty( $slidertitle ) && !empty( $sliderimage ) ) { ?>
                    <h1 class="slider-title">
                        <img src="<?php echo $sliderimage; ?>" alt="" class="img-fluid mx-auto" />
                        <?php echo $slidertitle; ?>
                    <!-- end .slider-title --></h1>
                <?php } ?>
                <?php 
                    $slidertext = get_post_meta($post->ID, "slidermeta-textarea", true);
                    if( $slidertext ) { 
                ?>
                    <p><?php echo $slidertext; ?></p>
                <?php } ?>
                <?php 
                    $sliderbutton = get_post_meta($post->ID, "slidermeta-button", true); 
                    $sliderlink = get_post_meta($post->ID, "slidermeta-link", true); 
                    if( $sliderbutton ) {
                ?>
                    <a href="<?php echo $sliderlink; ?>" class="btn btn-lg button-success"><?php echo $sliderbutton; ?></a>
                <?php } ?>
                <div class="down-arrow">
                    <?php $scrdwnimg = $corp_theme_option['scroll-down-icon-image']['url']; $scrdwnicon = $corp_theme_option['scroll-down-icon-html']; $scrdwntxt = $corp_theme_option['scroll-down-text']; $scrdwnline = $corp_theme_option['scroll-down-line']; ?>
                    <?php if( !empty( $scrdwnimg ) && empty( $scrdwnicon ) ) { ?>
                        <a href="#content" data-scroll><img src="<?php echo $scrdwnimg ?>" alt="" /></a><br />
                    <?php } elseif( !empty( $scrdwnicon ) ) { ?>
                        <a href="#content" data-scroll><i class="<?php echo $scrdwnicon ?>"></i></a>
                    <?php } if( !empty( $scrdwntxt ) ) { ?>
                        <a href="#content" class="scroll-text" data-scroll><span><?php echo $scrdwntxt; ?></span></a><br />
                    <?php } if( ( $scrdwnline ) ) { ?>
                        <span class="line"></span>
                    <?php } ?>
                <!-- end .down-arrow --></div>
            <!-- end .col-lg-10 --></div>
        <!-- end .row --></div>
    <!-- end .slider-text --></div>
    <?php $jumboimg = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
    <div class="slider">
        <?php $slidername = get_post_meta($post->ID, 'slidermeta-slug', true); ?>
        <?php if( !empty( $slidername ) ) { echo do_shortcode('[rev_slider alias="' . $slidername . '"]'); } elseif( empty($slidername) && !empty($jumboimg) ) { echo '<div class="jumbotron-img" style="background-image:url(' . $jumboimg . ');"></div>'; } else { } ?>
    <!-- end .slider --></div>
    <div class="slider-wash"></div>
<!-- end .jumbotron --></div>

<!-- Content Information -->
<div class="container-fluid" id="content">
    <div class="row">
        <div class="col-lg-12">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                <h2 class="has-title text-center hidden"><?php the_title(); ?></h2>
                <div class="has-text"><?php the_content(); ?></div>
            <?php endwhile; ?>
        <!-- end .col-lg-10 --></div>
    <!-- end .row --></div>
<!-- end #content --></div>

<!-- end main --></main>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>