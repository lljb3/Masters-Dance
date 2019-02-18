<?php
	global $corp_theme_option;
	$custom_scripts = $corp_theme_option['custom-scripts'];
?>

<!-- File Calls -->
<?php wp_footer(); ?>

<!-- Custom JavaScript -->
<?php echo $custom_scripts; ?>

<?php if( $corp_theme_option['pjax-loader'] ) : ?>
	<!-- End SmoothStateJS -->
	</div>
<?php endif; ?>

<!-- End App -->
</div>

<!-- End of Site -->
</body>
</html>