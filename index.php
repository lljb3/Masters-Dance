<?php
    /**
     * The main template file
     * This is the most generic template file in a WordPress theme
     * and one of the two required files for a theme (the other being style.css).
     * It is used to display a page when nothing more specific matches a query.
     * E.g., it puts together the home page when no home.php file 
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

<!-- Container Information -->
<div class="container-fluid" id="content">
    <div class="row">
        <h1 class="col-lg-10 offset-lg-1 has-title text-center">Latest Posts</h1>	
        <div class="col-lg-6 offset-lg-1" id="posts-section">
			<?php if ( have_posts() ): ?>
            <ol class="row list-unstyled">
            <?php while ( have_posts() ) : the_post(); ?>
                <li class="col-lg-12">
                    <article class="post container-fluid">
                        <div class="post-row row">
                            <div class="thumbnail col-lg-3 col-sm-3"><?php the_post_thumbnail('large',['class'=>'img-responsive mx-auto']); ?></div>
                            <div class="post-inner col-lg-9 col-sm-9">
                                <h2 class="post-title"><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
                                <?php the_content('Continue Reading'); ?>
                            <!-- end .post-inner --></div>
                        <!-- end .post-row --></div>
                    <!-- end .post --></article>
                <!-- end .col-lg-12 --></li>
            <?php endwhile; ?>
            <!-- end .row --></ol>
            <?php else: ?>
            <h4 class="has-title">No posts to display</h4>
            <?php endif; ?>
            <div class="row" id="pagination">
            	<div class="col-lg-12">
                	<?php starkers_numeric_posts_nav(); ?>
                <!-- end .col-lg-12 --></div>
            <!-- end #pagination --></div>
        <!-- end .col-lg-6 --></div>
        <div class="col-lg-4" id="posts-sidebar">
        	<?php dynamic_sidebar('posts-sidebar'); ?>
        <!-- end .col-lg-4 --></div>
    <!-- end .row --></div>
<!-- end #content --></div>

<!-- end main --></main>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>