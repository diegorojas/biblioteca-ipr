<div class="recent post cont-box">
	<a href="<?php the_permalink(); ?>">
		<?php if( has_post_thumbnail() ){
			the_post_thumbnail();
		}else{
			echo '<img src="'.get_first_image().'">';
		} ?>
		<div class="box-cont">
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<?php //if(get_field('fonte')){ echo '<span>';  echo get_field('fonte').'</span>';} ?>
					<span class="author-name">
					<?php if(get_field('nome_autor')){ $k = 0;
						$post_objects = get_field('nome_autor');
						asort($post_objects);
					    foreach( $post_objects as $post_object): $k++;
							if($k <= 2){echo get_the_title($post_object).'';}
							if($k < 2 && count($post_objects) != 1){echo '; ';}
							if($k == 3){echo ' et al.';}
					    endforeach;
	
					}else{
						
						$k = 0;
						$args = array('post_type' => 'autores', 'meta_key' => 'id','meta_value'   => id_aut(get_field('id')),'meta_compare' => 'IN', 'orderby' => 'title', 'order'   => 'ASC'); $wp_query = new WP_Query( $args ); if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); $k++; if($k <= 2){the_title(); } if($k == 2){echo ' et al.';}elseif($k == $wp_query->post_count){echo '';}elseif($k < 2){echo '; ';} endwhile; endif; wp_reset_query(); 			
		
						
						/*			
						$arr = id_aut_novo(id_aut(get_field('id'))); $k = 0;
						asort($arr);
						foreach ($arr as $r) {$k++;
							if($k <= 2){echo get_the_title($r).'; ';}if($k == 2){echo ' et al.';}
						}
						
						*/
						
					}		
					?>
				</span>
			<?php //if(get_field('data_exemplar')){echo '<span>';  echo substr(get_field('data_exemplar'),0,4).'</span>';} ?>
		</div>	
	</a>
</div>
