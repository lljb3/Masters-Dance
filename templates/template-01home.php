<?php
	/**
	 * Template Name: 01 - Home
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
    global $hmd_theme_option; 
    $trans_opt = $hmd_theme_option['transitional-header-button'];
    $trans_page_opt = get_post_meta($post->ID,'page_options_trans-header',true);
    $collapse_opt = $hmd_theme_option['collapsable-header-button'];
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header' ) ); ?>

<!-- Main Information -->
<main <?php body_class(); ?>>

<?php if ( $trans_page_opt == 'on' ) : ?> 
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
<div class="jumbotron" id="home">
    <div class="slider-text container-fluid">
        <div class="row" id="slider-text-inner">
            <div class="col-lg-10 offset-lg-1" id="slider-text-content">
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
            <!-- end .col-lg-10 --></div>
            <div class="down-arrow">
                <?php $scrdwnimg = $hmd_theme_option['scroll-down-icon-image']['url']; $scrdwnicon = $hmd_theme_option['scroll-down-icon-html']; $scrdwntxt = $hmd_theme_option['scroll-down-text']; $scrdwnline = $hmd_theme_option['scroll-down-line']; ?>
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
            <div class="row" id="content-section">
                <div class="col-lg-12">
                    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                        <div class="has-text"><?php the_content(); ?></div>
                    <?php endwhile; ?>
                <!-- end .col-lg-10 --></div>
            <!-- end .row --></div>
            <?php if( $hmd_theme_option['content-posts-container'] ) { ?>
                <div class="row" id="posts-section">
                    <?php // Display blog posts on any page @ http://m0n.co/l
                        $temp = $wp_query; 
                        $wp_query = null;
                        $postsno = $hmd_theme_option['blog-posts-number-of'];
                        $cat_array = $hmd_theme_option['blog-posts-category'];
                        $categories = str_replace(', ','+',$cat_array);
                        $wp_query = new WP_Query(); 
                        $wp_query->query('showposts=' . $postsno . '&paged='. $paged . '&category_name=' . $categories);
                        while ($wp_query->have_posts()) : $wp_query->the_post();
                    ?>
                    <?php if( $postsno == 4 || $postsno == 8 ) { ?>
                        <div class="col-lg-3">
                    <?php } else { ?>
                        <div class="col-lg-4">
                    <?php } ?>
                        <div class="post-item">
                            <?php $feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() ); ?>
                            <div class="post-thumbnail" <?php if ( has_post_thumbnail() ) { echo 'style="background-image:url(' . $feat_image_url . ');opacity:.3;"'; } ?>></div>
                            <h3 class="has-title">
                                <a href="<?php the_permalink(); ?>" title="Read more"><?php the_title(); ?></a>
                            <!-- end .has-title --></h3>
                            <?php global $more; $more = 0; ?>
                            <div class="has-text">
                                <div class="category text-accent">
                                    <span class="float-left"><?php the_category(', '); ?> -</span>
                                    <span class="float-left">&nbsp;<?php the_time(); ?> -</span>
                                    <span class="float-left">&nbsp;<?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?></span>
                                <!-- end .category --></div>
                                <div class="post">
                                    <a href="<?php the_permalink(); ?>" title="Read more" class="btn btn-success btn-sm read-more">Read More</a>
                                <!-- end .post --></div>
                            <!-- end .has-text --></div>
                        <!-- end .post-item --></div>
                    <!-- end .col-lg-4 --></div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <!-- end .row --></div>
            <?php } ?>
        <!-- end .col-lg-12 --></div>
    <!-- end .row --></div>
<!-- end #content --></div>

<!-- end main --></main>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>