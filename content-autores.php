<div class="col-md-3 col-sm-6 autor-box">
			<div class="autores">
				<p class="bold"><a href="/articles?autor=<?php echo get_the_ID(); ?>"><?php the_title(); ?></a></p>
				<a href="/articles?autor=<?php echo get_the_ID(); ?>">
					<?php //echo count(id_art_novo(id_art(get_field('id')))); ?> 
					<?php

										$args2 = array(
											'post_type' => 'artigos',
											'order' => 'ASC',
											'orderby' => 'title',
											'posts_per_page' => -1,
											'meta_query' => array(
												array(
													'key' => 'nome_autor',
													'value' => '"'.get_the_id().'"',
													'compare' => 'LIKE'
												)
											)
										);
										
										$art_array = id_art_novo(id_art(get_field('id'))); // artigos dos autores antigos
										
										$temp_query = new WP_Query( $args2 );
											
										if ( $temp_query->have_posts() ) :
									
											while ( $temp_query->have_posts() ) : $temp_query->the_post();
		
												$art_array[] = get_the_id(); // artigos dos autores novos
										
											endwhile;
																				
										 endif;
												
	 									// junta ambos em uma lista unica

										$args = array(
											'post_type' => 'artigos',
											'order' => 'ASC',
											'orderby' => 'title',
											'post__in' => $art_array,
											'posts_per_page' => -1,
										);
										
							$the_query = new WP_Query( $args );
						if( $the_query->post_count >= 1){ 
							echo $the_query->post_count.' '; printf( __( 'articles', 'odin' )); 
						}else{ 
							printf( __( 'articles', 'odin' )); 
						}
					
						wp_reset_query(); ?></a>
			</div>
			<a href="/articles?autor=<?php echo get_the_ID(); ?>" class=" autores-btn btn"><?php printf( __( 'See Articles', 'odin' ));?></a>		
</div>
