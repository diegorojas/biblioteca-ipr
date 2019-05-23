<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<?php
		while ( have_posts() ) : the_post();
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-12 box-quem-somos">
					<?php echo get_field("chamada_1") ?>
					<div class="col-md-6 chamada-2">	

						<?php echo get_field("chamada_2") ?>
					</div>
					<div class="col-md-6 chamada-3">	
						<span><?php echo get_field("chamada_3") ?></span>
					</div>
					<?php echo get_field("chamada_4") ?>
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
