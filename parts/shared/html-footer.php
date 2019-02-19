<?php
	global $hmd_theme_option;
	$custom_scripts = $hmd_theme_option['custom-scripts'];
?>

<!-- File Calls -->
<?php wp_footer(); ?>

<!-- Custom JavaScript -->
<?php echo $custom_scripts; ?>

<?php if( $hmd_theme_option['pjax-loader'] ) : ?>
	<!-- End BarbaJS -->
		</div>
	</div>
<?php endif; ?>

<!-- End App -->
</div>

<!-- End of Site -->
</body>
</html>