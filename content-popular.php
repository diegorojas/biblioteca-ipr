<?php ?>
<div class="container populares">
<h3 class="title-box"><?php printf( __( 'See also', 'odin' ));?></a></h3>
<div class="row">

		<?php 
		$args = array( 
			'post_type' => 'artigos',
			'posts_per_page' => 3,
			'orderby'        => 'rand',
			'suppress_filters' => true			
		);
		?>
		
		<?php $the_query = new WP_Query( $args ); ?>
		
		<?php if ( $the_query->have_posts() ) : ?>
		
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

		
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="popular post">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
						<a href="<?php the_permalink(); ?>">	
							<?php if( has_post_thumbnail() ){
								the_post_thumbnail();
							}else{
								echo '<img src="'.get_first_image().'">';
							} ?>
						</a>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-6 content-home">
								<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<?php if(get_field('fonte')){ echo '<span>'; printf( __( 'By', 'odin' )); echo ': '. get_field('fonte').'</span>';} ?>
								<?php if(get_field('data_exemplar')){ echo '<span>'; printf( __( 'Year', 'odin' )); echo ': '. get_field('data_exemplar').'</span>';} ?>
								<?php echo '<p>'.strip_tags(wpautop(html_entity_decode(excerpt(15)))).'</p>'; ?>
								<p></p>
								<a href="<?php the_permalink(); ?>" class="home btn"><?php printf( __( 'Read more', 'odin' ));?></a>
						</div>
					</div>
				</div>
			</div>
	 
	
		<?php endwhile; ?>
	
		<?php wp_reset_postdata(); ?>
	
	<?php endif; ?>	
	
</div>
</div>

<?php ?>