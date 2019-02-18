<?php
	global $corp_theme_option;
	if ( !empty( $corp_theme_option['logo-menu'] ) ) {
		$logo = $corp_theme_option['logo-menu']['url'];
	}
    $chat = $corp_theme_option['site-header-chat'];
    $chat_click = $corp_theme_option['site-header-chat-click'];
    $phone = $corp_theme_option['site-header-phone'];
    $copyright = $corp_theme_option['copyright'];
    $dev_name = $corp_theme_option['developer-text'];
	$dev_link = $corp_theme_option['developer-link'];
	$facebook = $corp_theme_option['social-facebook'];
	$twitter = $corp_theme_option['social-twitter'];
    $google = $corp_theme_option['social-google'];
	$youtube = $corp_theme_option['social-youtube'];
    $instagram = $corp_theme_option['social-instagram'];
	$soundcloud = $corp_theme_option['social-soundcloud'];
    $bandcamp = $corp_theme_option['social-bandcamp'];
	$apple = $corp_theme_option['social-apple'];
?>

<!-- Header Information -->
<header id="header-container" class="container-fluid" data-scroll-header>
    <div class="row" id="collapse-menu">
        <nav class="col-lg-10 offset-lg-1" id="menu-container">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="navbar-brand float-left" id="navbar-brand">
                <?php if( empty( $logo ) ) { ?>
                    <span><?php bloginfo('name'); ?></span>
                <?php } else { ?>
                    <img src="<?php echo $logo; ?>" alt="" class="img-fluid">
                <?php } ?>
            <!-- end .navbar-brand --></a>
            <button type="button" class="navbar-toggler collapsed float-right" data-toggle="collapse" data-target="#panel-navbar-collapse">
                <span class="sr-only">Menu</span>
                <span class="icon-bar top-bar float-left"></span>
                <span class="icon-bar middle-bar float-left"></span>
                <span class="icon-bar bottom-bar float-left"></span>
            <!-- .navbar-toggler --></button>
        <!-- end #menu-container --></div>
    <!-- end #collapse-menu --></header>
    <div class="collapse panel-collapse" id="panel-navbar-collapse">
        <div class="container-fluid" id="panel-collapse-inner">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
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
                    <!-- end .navbar-nav --></ul>
                    <div class="navbar-nav" id="header-info">
                        <div id="site-social">
                            <?php if ( $facebook ) { ?><a href="<?php echo $facebook; ?>"><i aria-hidden="true" class="fab fa-facebook-f facebook"></i></a><?php } ?>
                            <?php if ( $twitter ) { ?><a href="<?php echo $twitter; ?>"><i aria-hidden="true" class="fab fa-twitter twitter"></i></a><?php } ?>
                            <?php if ( $google ) { ?><a href="<?php echo $google; ?>"><i aria-hidden="true" class="fab fa-google-plus-g google"></i></a><?php } ?>
                            <?php if ( $linkedin ) { ?><a href="<?php echo $linkedin; ?>"><i aria-hidden="true" class="fab fa-linkedin-in linkedin"></i></a><?php } ?>
                            <?php if ( $youtube ) { ?><a href="<?php echo $youtube; ?>"><i aria-hidden="true" class="fab fa-youtube youtube"></i></a><?php } ?>
                            <?php if ( $pinterest ) { ?><a href="<?php echo $pinterest; ?>"><i aria-hidden="true" class="fab fa-pinterest-p pinterest"></i></a><?php } ?>
                            <?php if ( $instagram ) { ?><a href="<?php echo $instagram; ?>"><i aria-hidden="true" class="fab fa-instagram instagram"></i></a><?php } ?>
                            <?php if ( $skype ) { ?><a href="<?php echo $skype; ?>"><i aria-hidden="true" class="fab fa-skype skype"></i></a><?php } ?>
                            <?php if ( $yelp ) { ?><a href="<?php echo $yelp; ?>"><i aria-hidden="true" class="fab fa-yelp yelp"></i></a><?php } ?>
                        <!-- #site-social --></div>
                    <!-- end #header-info --></div>
                    <div class="navbar-nav" id="credits-info">
                        <p><?php echo $copyright; ?> | <a href="/terms-of-use/"><strong>Terms</strong></a> | <a href="/privacy-policy/"><strong>Privacy</strong></a> | Developed by <a href="<?php echo $dev_link; ?>" target="blank"><strong><?php echo $dev_name; ?></strong></a></p>
                    <!-- end #credits-info --></div>
                <!-- end .col-lg-10 --></div>
            <!-- end .row --></div>
        <!-- end #panel-collapse-inner --></div>
    <!-- end #panel-navbar-collapse --></div>
<!-- end #header-container --></header>