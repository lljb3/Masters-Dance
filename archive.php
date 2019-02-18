<?php
    /**
     * The template for displaying Archive pages.
     *
     * Used to display archive-type pages if nothing more specific matches a query.
     * For example, puts together date-based pages if no date.php file exists.
     *
     * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
        <h2 class="has-title text-center">The Archives</h2>	
        <div class="col-lg-6 offset-lg-1" id="posts-section">
			<?php if ( have_posts() ): ?>
            
            <?php if ( is_day() ) : ?>
            <h2>Archive: <?php echo  get_the_date( 'D M Y' ); ?></h2>							
            <?php elseif ( is_month() ) : ?>
            <h2>Archive: <?php echo  get_the_date( 'M Y' ); ?></h2>	
            <?php elseif ( is_year() ) : ?>
            <h2>Archive: <?php echo  get_the_date( 'Y' ); ?></h2>								
            <?php else : ?>
            <h2>Archive</h2>	
            <?php endif; ?>
            
            <ol class="row list-unstyled">
            <?php while ( have_posts() ) : the_post(); ?>
                <li class="col-lg-12">
                    <article class="post row">
                        <div class="thumbnail col-lg-3 col-sm-3"><?php the_post_thumbnail('large',['class'=>'img-responsive mx-auto']); ?></div>
                        <div class="post-inner col-lg-9 col-sm-9">
                            <h2 class="post-title"><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                            <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
                            <?php the_content('Continue Reading'); ?>
                        </div>
                    <!-- end .post --></article>
                <!-- end .col-lg-12 --></li>
            <?php endwhile; ?>
            <!-- end .list-unstyled --></ol>
            <?php else: ?>
            <h2>No posts to display</h2>	
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

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>