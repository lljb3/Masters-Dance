<?php
	/**
	 * The template for displaying 404 pages (Not Found)
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
<main <?php body_class(); ?> id="barba-wrapper">
<div class="barba-container">

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

<!-- Content Information -->
<div class="container-fluid" id="content">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
			<h1 class="has-title">You have reached a missing page!</h1>
            <p>Please return to the previous link by clicking <a href="javascript:history.back()">here</a>.</p>
        <!-- end .col-lg-10 --></div>
    <!-- end .row --></div>
<!-- end #content --></div>

<!-- end .barba-container --></div>
<!-- end #barba-wrapper --></main>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>