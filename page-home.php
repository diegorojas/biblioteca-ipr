<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<?php
		while ( have_posts() ) : the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content home-page">

				<div class="container">
					<h3><?php printf( __( 'NEW ACQUISITIONS', 'odin' ));?></h3>
					<div class="row">
						

							<?php 
							$args = array( 
								'post_type' => 'artigos',
								'posts_per_page' => 2,
								'suppress_filters' => true
							);
							?>
							
							<?php $the_query = new WP_Query( $args ); ?>
							
							<?php if ( $the_query->have_posts() ) : ?>
							
							<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="recent post">
									<div class="row">
										<div class="col-md-5">
											<a href="<?php the_permalink(); ?>">	
												<?php if( has_post_thumbnail() ){
													the_post_thumbnail();
												}else{
													echo '<img src="'.get_first_image().'">';
												} ?>
											</a>
										</div>
	
										<div class="col-md-6 content-home">
											<?php $link = get_the_permalink(); ?>
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<?php // if(get_field('fonte')){ echo '<span>'; echo get_field('fonte').'</span>';} ?>
								<?php if(get_field('nome_autor')){
									$post_objects = get_field('nome_autor');$k = 0;
									asort($post_objects);
								    foreach( $post_objects as $post_object):$k++;
										if($k <= 2){echo get_the_title($post_object).'';}
										if($k < 2 && count($post_objects) != 1){echo '; ';}
										if($k == 3){echo ' et al.';}
										
								    endforeach;		
								}else{
									$k = 0;
									$args = array('post_type' => 'autores', 'meta_key' => 'id','meta_value'   => id_aut(get_field('id')),'meta_compare' => 'IN', 'orderby' => 'title', 'order'   => 'ASC'); $wp_query = new WP_Query( $args ); if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); $k++; if($k <= 2){the_title(); } if($k == 2){echo ' et al.';}elseif($k == $wp_query->post_count){echo '';}elseif($k < 2){echo '; ';} endwhile; endif; wp_reset_query(); 			
	

								}		
				?>
											<?php // if(get_field('data_exemplar')){echo '<span>';   echo  substr(get_field('data_exemplar'),0,4).'</span>';} ?>
								<?php echo '<p>'.strip_tags(wpautop(html_entity_decode(excerpt(35)))).'</p>'; ?>

											<a href="<?php echo $link; ?>" class="home btn btn-normal"><?php printf( __( 'Read more', 'odin' ));?></a>
										</div>
									</div>
								</div>
							</div>
						
							<?php endwhile; ?>
						
							<?php wp_reset_postdata(); ?>
						
						<?php endif; ?>						
							
							
					</div>
					<div class="content-news row">
							
							
							<?php 
							$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
							
							if($paged == 1){
								$args = array( 
									'post_type' => 'artigos',
									'posts_per_page' =>  15,
									'offset' => 2,
									'paged' => $paged ,
									'suppress_filters' => true,								
								);
							}else{
								$args = array( 
									'post_type' => 'artigos',
									'posts_per_page' =>  15,
									'paged' => $paged ,
									'suppress_filters' => true,								
								);
							}
							?>
							<?php $the_query = new WP_Query( $args ); ?>
							<?php if ( $the_query->have_posts() ) : ?>
							<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

								<div class="recent post cont-box col-xs-6">
											<a href="<?php the_permalink(); ?>">	
												<?php if( has_post_thumbnail() ){
													the_post_thumbnail();
												}else{
													echo '<img src="'.get_first_image().'">';
												} ?>
												<div class="box-cont">
													<h4><?php the_title(); ?></h4>
													<?php // if(get_field('fonte')){echo '<span>';  echo ''. get_field('fonte').'</span>';} ?>
								<?php if(get_field('nome_autor')){
									$post_objects = get_field('nome_autor');$k = 0;
									asort($post_objects);
								    foreach( $post_objects as $post_object):$k++;
										if($k <= 2){echo get_the_title($post_object).'';}
										if($k < 2 && count($post_objects) != 1){echo '; ';}
										if($k == 3){echo ' et al.';}
								    endforeach;									
								}else{
									$k = 0;
									$args = array('post_type' => 'autores', 'meta_key' => 'id','meta_value'   => id_aut(get_field('id')),'meta_compare' => 'IN', 'orderby' => 'title', 'order'   => 'ASC'); $wp_query = new WP_Query( $args ); if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); $k++; if($k <= 2){the_title(); } if($k == 2){echo ' et al.';}elseif($k == $wp_query->post_count){echo '';}elseif($k < 2){echo '; ';} endwhile; endif; wp_reset_query(); 			

								}		
				?>
													
													<?php // if(get_field('data_exemplar')){echo '<span>'; echo ''. get_field('data_exemplar').'</span>';} ?>
												</div>	
											</a>
								</div>

							<?php endwhile; ?>
							
							<?php 
								$big = 999999999; // need an unlikely integer
								echo '<div class="pagination-wrap pagination-alt">';
								echo paginate_links( array(
									'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format' => '?paged=%#%',
									'current' => max( 1, get_query_var('page') ),
									'total' => $the_query->max_num_pages,
									'before_page_number' => '',
									'after_page_number'  => ''
								) );
								echo '</div>';
							?>
							
							<?php wp_reset_postdata(); ?>
							
						<?php endif; ?>						

							
														
					</div>
					
					<?php get_template_part( 'content', 'popular' ); ?>
					
				</div>

			</div><!-- .entry-content -->
		</article><!-- #post-## -->
		<?php
		endwhile;
		?>
	</div><!-- #content -->
</div><!-- #primary -->


<?php if ( get_field('mostrar_popup') ){ ?>

<button id="btn-modal" type="button" data-toggle="modal" data-target="#myModal" style="width: 0px;height: 0px; opacity: 0;"></button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div style="padding: 30px 20px 40px; text-align: center;color: #59300F;font-weight: bold;line-height: 35px;font-size: 20px;">
			<?php echo get_field('mensagem'); ?>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php } ?>

<?php
get_footer();?>
