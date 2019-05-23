<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<?php gravity_form(4, false, false, false, '', true, ''); ?>
				</div>
			</div>
		</div>
	</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer();
