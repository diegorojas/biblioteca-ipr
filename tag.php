<?php get_header(); ?>

	<section id="primary" class="<?php echo odin_page_sidebar_classes(); ?>">
		<div id="content" class="site-content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="archive-header">
					<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'odin' ), single_tag_title( '', false ) ); ?></h1>
				</header><!-- .archive-header -->

				<?php

						while ( have_posts() ) : the_post();

							get_template_part( 'content', get_post_format() );

						endwhile;

						odin_paging_nav();

					else :

						get_template_part( 'content', 'none' );

				endif;
			?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
