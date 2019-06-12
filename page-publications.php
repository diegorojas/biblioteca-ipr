<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<div class="entry-content">
			<div class="container">
				<div class="row">				
					<?php
					$terms = get_terms( 'publicacao' );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
						foreach ( $terms as $term ) {
							?>
							<div class="col-md-3 col-sm-6 col-xs-6">
								<a href="<?php echo home_url('/articles'); ?>/?publicacao=<?php echo $term->slug ?>" class="publicacoes">
									<div class="text-publicacoes">
										<?php
										$image = get_field('capa_publicacao', 'publicacao_'.$term->term_id);
										?>
												<?php if( get_field('capa_publicacao', 'publicacao_'.$term->term_id) ){
													echo '<img src="'.$image['sizes']['medium'].'" />';

												}else{
													echo '<img src="'.get_first_image().'">';
												} ?>

										<p class="bold"><?php echo $term->name  ?></p>
										<p><?php echo $term->count ?> <?php printf( __( 'Articles', 'odin' ));?></p>
									</div>
								</a>
							</div>
							<?php
						}
					}				
					?>	
				</div>
			</div>
		</div><!-- .entry-content -->
	</article><!-- #post-## -->

</div><!-- #content -->
</div><!-- #primary -->
<?php
get_footer();
