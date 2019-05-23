<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="form login">
						<?php
					
							if(is_user_logged_in()){
									echo '<meta http-equiv="refresh" content="0; url=http://pedroprado.com.br/profile" />';
									//echo '<h2 class="bold">'; printf( __( 'You are already logged in.', 'odin' )); echo '</h2>';
									//echo '<p>You want to <strong><a href="'.wp_logout_url( get_permalink() ).'">log out?</a></strong></p>';

							}else{
									echo '<h2 class="bold">'; printf( __( 'Enter the library', 'odin' )); echo '</h2>';
									the_content();
		
									login_with_ajax();
								?>
		
								<p><?php printf( __( 'Don’t have and account?', 'odin' ));  ?> <a class="bold" href="/register"> <?php printf( __( 'Click here and sign up.', 'odin' ));  ?></a></p>
						<?php } ?>
									</div>	
				</div>
			</div>
		</div>

	</div><!-- #content -->
</div><!-- #primary -->
<?php
get_footer();
