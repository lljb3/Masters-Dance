<?php 
	global $corp_theme_option;
	$copyright = $corp_theme_option['copyright'];
	$dev_name = $corp_theme_option['developer-text'];
	$dev_link = $corp_theme_option['developer-link'];
	$facebook = $corp_theme_option['social-facebook'];
	$twitter = $corp_theme_option['social-twitter'];
	$google = $corp_theme_option['social-google'];
	$linkedin = $corp_theme_option['social-linkedin'];
	$pinterest = $corp_theme_option['social-pinterest'];
	$instagram = $corp_theme_option['social-instagram'];
	$youtube = $corp_theme_option['social-youtube'];
	$skype = $corp_theme_option['social-skype'];
	$yelp = $corp_theme_option['social-yelp'];
?>
	
<?php if ( $corp_theme_option['footer-show-up-button'] ) { ?>
	<!-- Back to Top -->
	<a data-scroll href="#totop" class="totop fadeOut"><span class="fas fa-caret-up"></span></a>
<?php } ?>

<?php if ( $corp_theme_option['footer-sitemap'] ) { ?>
	<!-- Sitemap Information -->
	<div class="container-fluid" id="footer-sitemap">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="row">
					<?php $sitemap1 = has_nav_menu('sitemap1'); if ( $sitemap1 ) { ?>
						<div class="col-md-2 split">
							<?php wp_nav_menu( 
								array(
									'theme_location'	=> 'sitemap1',
									'container'			=> 'ul',
									'menu_class'		=> 'list-unstyled',
									'echo'				=> true,
									'link_before'		=> '<span>',
									'link_after'		=> '</span>',
									'items_wrap'		=> '<ul class="list-unstyled">%3$s</ul>',
									'depth'				=> 0,
									'walker'			=> new WP_Bootstrap_Navwalker()
								)
							); ?>
						<!-- end .split --></div>
					<?php } $sitemap2 = has_nav_menu('sitemap2'); if ( $sitemap2 ) { ?>
						<div class="col-md-2 split">
							<?php wp_nav_menu( 
								array(
									'theme_location'	=> 'sitemap2',
									'container'			=> 'ul',
									'menu_class'		=> 'list-unstyled',
									'echo'				=> true,
									'link_before'		=> '<span>',
									'link_after'		=> '</span>',
									'items_wrap'		=> '<ul class="list-unstyled">%3$s</ul>',
									'depth'				=> 0,
									'walker'			=> new WP_Bootstrap_Navwalker()
								)
							); ?>
						<!-- end .split--></div>
					<?php } $sitemap3 = has_nav_menu('sitemap3'); if ( $sitemap3 ) { ?>
						<div class="col-md-2 split">
							<?php wp_nav_menu( 
								array(
									'theme_location'	=> 'sitemap3',
									'container'			=> 'ul',
									'menu_class'		=> 'list-unstyled',
									'echo'				=> true,
									'link_before'		=> '<span>',
									'link_after'		=> '</span>',
									'items_wrap'		=> '<ul class="list-unstyled">%3$s</ul>',
									'depth'				=> 0,
									'walker'			=> new WP_Bootstrap_Navwalker()
								)
							); ?>
						<!-- end .split --></div>
					<?php } $sitemap4 = has_nav_menu('sitemap4'); if ( $sitemap4 ) { ?>
						<div class="col-md-2 split">
							<?php wp_nav_menu( 
								array(
									'theme_location'	=> 'sitemap4',
									'container'			=> 'ul',
									'menu_class'		=> 'list-unstyled',
									'echo'				=> true,
									'link_before'		=> '<span>',
									'link_after'		=> '</span>',
									'items_wrap'		=> '<ul class="list-unstyled">%3$s</ul>',
									'depth'				=> 0,
									'walker'			=> new WP_Bootstrap_Navwalker()
								)
							); ?>
						<!-- end .split --></div>
					<?php } $sitemap5 = has_nav_menu('sitemap5'); if ( $sitemap5 ) { ?>
						<div class="col-md-2 split">
							<?php wp_nav_menu( 
								array(
									'theme_location'	=> 'sitemap5',
									'container'			=> 'ul',
									'menu_class'		=> 'list-unstyled',
									'echo'				=> true,
									'link_before'		=> '<span>',
									'link_after'		=> '</span>',
									'items_wrap'		=> '<ul class="list-unstyled">%3$s</ul>',
									'depth'				=> 0,
									'walker'			=> new WP_Bootstrap_Navwalker()
								)
							); ?>
						<!-- end .split --></div>
					<?php } $sitemap6 = has_nav_menu('sitemap6'); if ( $sitemap6 ) { ?>
						<div class="col-md-2 split">
							<?php wp_nav_menu( 
								array(
									'theme_location'	=> 'sitemap6',
									'container'			=> 'ul',
									'menu_class'		=> 'list-unstyled',
									'echo'				=> true,
									'link_before'		=> '<span>',
									'link_after'		=> '</span>',
									'items_wrap'		=> '<ul class="list-unstyled">%3$s</ul>',
									'depth'				=> 0,
									'walker'			=> new WP_Bootstrap_Navwalker()
								)
							); ?>
						<!-- end .split --></div>
					<?php } ?>
				<!-- end .row --></div>
			<!-- end .col-md-12 --></div>
		<!-- end .row --></div>
	<!-- end #footer-sitemap --></div>
<?php } ?>

<!-- Footer Information -->	
<footer id="footer-container">
    <div class="container-fluid">
        <div class="row" id="footer-info">
            <div class="col-lg-6 offset-lg-1 col-sm-12">
            	<div class="has-text float-left">
                	<?php echo $copyright; ?> | <a href="/terms-of-use/"><strong>Terms</strong></a> | <a href="/privacy-policy/"><strong>Privacy</strong></a> | Developed by <a href="<?php echo $dev_link; ?>" target="blank"><strong><?php echo $dev_name; ?></strong></a>
                <!-- end .has-text --></div>
            <!-- end .col-lg-5 --></div>
            <div class="col-lg-4 col-sm-12">
                <div class="social float-right">
                    <?php if ( $facebook ) { ?><a href="<?php echo $facebook; ?>"><i aria-hidden="true" class="fab fa-facebook-f facebook"></i></a><?php } ?>
                    <?php if ( $twitter ) { ?><a href="<?php echo $twitter; ?>"><i aria-hidden="true" class="fab fa-twitter twitter"></i></a><?php } ?>
                    <?php if ( $google ) { ?><a href="<?php echo $google; ?>"><i aria-hidden="true" class="fab fa-google-plus-g google"></i></a><?php } ?>
                    <?php if ( $linkedin ) { ?><a href="<?php echo $linkedin; ?>"><i aria-hidden="true" class="fab fa-linkedin-in linkedin"></i></a><?php } ?>
                    <?php if ( $youtube ) { ?><a href="<?php echo $youtube; ?>"><i aria-hidden="true" class="fab fa-youtube youtube"></i></a><?php } ?>
                    <?php if ( $pinterest ) { ?><a href="<?php echo $pinterest; ?>"><i aria-hidden="true" class="fab fa-pinterest-p pinterest"></i></a><?php } ?>
                    <?php if ( $instagram ) { ?><a href="<?php echo $instagram; ?>"><i aria-hidden="true" class="fab fa-instagram instagram"></i></a><?php } ?>
                    <?php if ( $skype ) { ?><a href="<?php echo $skype; ?>"><i aria-hidden="true" class="fab fa-skype skype"></i></a><?php } ?>
                    <?php if ( $yelp ) { ?><a href="<?php echo $yelp; ?>"><i aria-hidden="true" class="fab fa-yelp yelp"></i></a><?php } ?>
				<!-- end .social --></div>
            <!-- end .col-lg-5 --></div>
        <!-- end .row --></div>
    <!-- end .container-fluid --></div>
<!-- end #footer-container --></footer>