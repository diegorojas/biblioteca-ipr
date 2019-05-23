<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<div class="container">
			<div class="row">
				<?php 
					if(is_user_logged_in()){ ?>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="form login">

					<?php 					
							echo '<h2 class="bold">'; printf( __( 'You are already logged in.', 'odin' )); echo '</h2>';
							echo '<p>You want to <strong><a href="'.wp_logout_url( get_permalink() ).'">log out?</a></strong></p>';

					echo '</div></div>';
					}else{
				?>


				<div class="col-md-8 col-sm-8 col-xs-12">

					<?php gravity_form(2, false, false, false, '', true, ''); ?>

				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 text-cadastro">
				<?php
					while ( have_posts() ) : the_post();
				?>
					<?php
						the_content();
					?>
	
				<?php
					endwhile;
				?>
				</div>
					<?php } ?>


			</div>
		</div>
	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer();
