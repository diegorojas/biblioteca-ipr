<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<?php
		while ( have_posts() ) : the_post();
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-12 box-quem-somos">
						<h1><strong><?php the_title(); ?></strong></h1>
						<?php the_content(); ?>
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
