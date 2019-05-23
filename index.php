
<?php get_header(); ?>

</div>
<div id="primary" >
	<div id="content" class="site-content" role="main">
		<div class="container">
			<div class="row">

					<?php
					if ( have_posts() ) :

						while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

					endwhile;

					odin_paging_nav();

					else :

						get_template_part( 'content', 'none' );

					endif;
					?>
			</div>
		</div>
	</div><!-- #content -->
</div><!-- #primary -->

<?php
get_footer();
