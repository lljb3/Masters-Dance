<?php
	global $corp_theme_option;
	if ( !empty( $corp_theme_option['logo-menu'] ) ) {
		$logo = $corp_theme_option['logo-menu']['url'];
    }
    if ( !empty( $corp_theme_option['trans-header-logo'] ) ) {
		$trans_logo = $corp_theme_option['trans-header-logo']['url'];
	}
    $chat = $corp_theme_option['site-header-chat'];
    $phone = $corp_theme_option['site-header-phone'];
?>

<!-- Header Information -->
<header id="header-container" class="container-fluid" data-scroll-header>
    <div class="row large" id="trans-menu">
        <nav class="navbar navbar-expand-lg navbar-light col-lg-10 offset-lg-1" id="menu-container">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="navbar-brand float-left" id="navbar-brand">
                <?php if( empty( $logo ) ) { ?>
                    <span><?php bloginfo('name'); ?></span>
                <?php } else { ?>
                    <img src="<?php echo $logo; ?>" alt="" class="img-fluid">
                <?php } ?>
            <!-- end .navbar-brand --></a>
            <button type="button" class="navbar-toggler collapsed float-right" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Menu</span>
                <span class="icon-bar top-bar float-left"></span>
                <span class="icon-bar middle-bar float-left"></span>
                <span class="icon-bar bottom-bar float-left"></span>
            <!-- .navbar-toggler --></button>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <?php wp_nav_menu( 
                    array(
                        'theme_location'  => 'primary',
                        'container'       => '<ul>',
                        'container_class' => 'navbar-nav ml-auto text-center',
                        'container_id'    => 'navbar-container',
                        'menu_class'      => 'navbar-nav ml-auto text-center',
                        'echo'            => true,
                        'link_before'     => '<span>',
                        'link_after'      => '</span>',
                        'depth'           => 2,
                        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                        'walker'		  => new WP_Bootstrap_Navwalker()
                    )
                ); ?>
                <ul class="navbar-nav text-center" id="extra-menu">
                    <?php if( !empty( $chat ) ) { 
                        echo '<script type="text/javascript">' . $chat . '</script>';
                        echo '<li class="menu-chat menu-item nav-item"><i class="fas fa-comments-o" aria-hidden="true"></i></li>'; 
                    } ?>
                    <?php if( !empty( $phone ) ) { 
                        echo '<li class="menu-phone menu-item nav-item"><a title="Call" href="tel:' . $phone . '"><i class="fas fa-mobile" aria-hidden="true" ></i></a></li>'; 
                    } ?>
                <!-- end .navbar-light --></ul>
            <!-- end #navbar-collapse --></div>
        <!-- end #menu-container --></div>
    <!-- end #header-menu --></header>
<!-- end #header-container --></header>