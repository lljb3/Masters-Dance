<?php
    /**
     * The Template for displaying all single posts
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

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<!-- Container Information -->
<div class="container-fluid" id="content">
    <div class="row">
        <div class="col-lg-6 offset-lg-1" id="posts-section">
            <article class="post">
                <h1 class="post-title"><?php the_title(); ?></h1>
                <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
                <div class="has-post-thumbnail"><?php the_post_thumbnail('large',['class'=>'img-fluid mx-auto']); ?></div>
                <div class="has-text">
                    <?php the_content(); ?>			
                
                    <?php if ( get_the_author_meta( 'description' ) ) : ?>
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
                    <h3 class="post-title">About <?php echo get_the_author() ; ?></h3>
                    <?php the_author_meta( 'description' ); ?>
                    <?php endif; ?>
                
                    <?php comments_template( '', true ); ?>
                <!-- end .has-text --></div>
            <!-- end .post --></article>
            <?php endwhile; ?>
        <!-- end .col-lg-6 --></div>
        <div class="col-lg-4" id="posts-sidebar">
        	<?php dynamic_sidebar('posts-sidebar'); ?>
        <!-- end .col-lg-4 --></div>
    <!-- end .row --></div>
<!-- end #content --></div>

<!-- end main --></main>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>