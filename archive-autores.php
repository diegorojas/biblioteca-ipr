<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12  text-center">
			<?php 
			 get_template_part('template','filtrar_autores'); 
			?>
		</div>
	</div>



	<div id="primary">
		<div id="content" class="site-content" role="main">
			<div class="container">
				<div class="row">
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post();

						get_template_part( 'content', 'autores' );

					?>

				<?php
					endwhile;
					//odin_paging_nav();
					echo '<div class="pagination-wrap"><ul class="page-numbers">';
					
					global $wp_query;
					
					$big = 999999999; // need an unlikely integer
					
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $wp_query->max_num_pages,
						'type'      => 'list',
					
						
					) );
					echo '</ul></div>';						
				else:
					echo '<div class="box-sem-login">';
					echo '<center class="h3">'; printf( __( 'No author found', 'odin' ));  echo '</center>';
					echo '</div>';
				endif;
				?>

				</div>
			</div><!-- #content -->
		</div><!-- #primary -->
	</div>
</div>
<?php
get_footer();
