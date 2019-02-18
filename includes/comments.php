<?php
    /**
	 * Custom callback for outputting comments 
	 *
	 * @return void
     * @author James Burrell
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment img-fluid'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
			<li class="col-md-12" id="comment-post">
				<article class="row" id="comment-<?php comment_ID(); ?>">
					<div class="gravatar col-sm-2 float-left" id="main-icon">
						<?php echo get_avatar( $comment, 54 ); ?>
					<!-- end #main-icon --></div>
					<div class="comment-info col-sm-10 float-left" id="comment-info">
						<h4 class="has-title"><?php comment_author_link() ?></h4>
						<time class="comment-time">
							<a href="#comment-<?php comment_ID() ?>" pubdate class="date-time">
								<?php comment_date() ?> at <?php comment_time() ?>
							<!-- end .date-time --></a>
						<!-- end .comment-time --></time>
						<?php comment_text() ?>
					<!-- end #comment-info --></div>
				<!-- end #comment-nth --></article>
			<!-- #comment-post --></li>
        <?php endif;
	}

	function starkers_comment_form( $fields ) {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$label     = $req ? '*' : ' ' . __( '(optional)', 'text-domain' );
		$aria_req  = $req ? "aria-required='true'" : '';
	
		$fields['author'] =
			'<p class="comment-form-author">
				<label for="author">' . __( "Name", "text-domain" ) . $label . '</label>
				<input id="author" name="author" type="text" placeholder="' . esc_attr__( "Name* (e.g.: Jane Doe)", "text-domain" ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30" ' . $aria_req . ' />
			</p>';
	
		$fields['email'] =
			'<p class="comment-form-email">
				<label for="email">' . __( "Email", "text-domain" ) . $label . '</label>
				<input id="email" name="email" type="email" placeholder="' . esc_attr__( "Email* (e.g.: name@email.com)", "text-domain" ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size="30" ' . $aria_req . ' />
			</p>';
	
		$fields['url'] =
			'<p class="comment-form-url">
				<label for="url">' . __( "Website", "text-domain" ) . '</label>
				<input id="url" name="url" type="url"  placeholder="' . esc_attr__( "Website (e.g.: https://google.com)", "text-domain" ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" />
				</p>';
	
		return $fields;
	}
	add_filter( 'comment_form_default_fields', 'starkers_comment_form' );

	function my_update_comment_field( $comment_field ) {
		$comment_field =
		  '<p class="comment-form-comment">
				  <label for="comment">' . __( "Comment", "text-domain" ) . '</label>
				  <textarea required id="comment" name="comment" placeholder="' . esc_attr__( "Comment*", "text-domain" ) . '" cols="45" rows="8" aria-required="true"></textarea>
			  </p>';
	  
		return $comment_field;
	  }
	  add_filter( 'comment_form_field_comment', 'my_update_comment_field' );