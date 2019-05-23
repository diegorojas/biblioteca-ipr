<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<?php
		while ( have_posts() ) : the_post();
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12 fale-conosco">
					<div class="box-content">
						<h3><?php the_title(); ?></h3>
						<p><?php the_content();?></p>
					</div>	
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 contato-form">
					<div class="box-form">
						<?php

						gravity_form(1, false, false, false, '', true, 12);

						?>
					</div>
				</div>	

			</div>
		</div>
		<?php
		endwhile;
		?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php
get_footer();
