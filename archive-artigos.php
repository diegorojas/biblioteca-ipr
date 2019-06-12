<?php get_header(); ?>
<section id="primary" class="">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<?php get_template_part('template','filtrar'); ?>
				<?php if( isset($_GET['autor']) ){ $aut_id = get_field('id', $_GET['autor']);} ?>
				
			</div>
		</div>
	<div id="content" class="site-content" role="main">

		<div class="container">
			<div class="content-news row">
<?php
	
/* // cria vinculo entre antigo e novo
$the_query_a = new WP_Query( $args = array( 'post_type' => 'artigos', 'posts_per_page' =>  -1) );
$the_query_a = new WP_Query( $args );


if ( $the_query_a->have_posts() ) :
echo '$arr = array(';
while ( $the_query_a->have_posts() ) : $the_query_a->the_post();
	if(get_field('id')){
		echo 'array("id_antigo" => '.get_field('id').',"id_novo" => '.get_the_id().'), ';
	}
endwhile;
echo ');';
endif; 
*/
?>

				<?php 
				
				if( isset($_GET['ap']) )	{
							
						if ( have_posts() ) :

/*
								echo '<h4 class="text-center">'.$the_query->post_count ;
									if ( qtranxf_getLanguage()=='en' ){echo ' articles';}
									elseif ( qtranxf_getLanguage()=='es' ){echo ' artículos';}
									elseif ( qtranxf_getLanguage()=='fr' ){echo ' articles';}
									elseif ( qtranxf_getLanguage()=='de' ){echo ' artikel';}
									elseif ( qtranxf_getLanguage()=='ja' ){echo ' 物品';}
									else {echo ' artigos';}
								echo '</h4>';
*/
						
							while ( have_posts() ) : the_post();
		
								get_template_part( 'content' );
		
							endwhile;
							
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
					
				}else{
						
					if(isset($_GET['data']) || isset($_GET['data_mes']) || isset($_GET['autor']) || isset($_GET['publicacao']) || isset($_GET['idioma']) ):
				

							if(isset($_GET['idioma'])):
											
									$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;																	
									$args = array(
										'post_type' => 'artigos',
										'order' => 'ASC',
										'orderby' => 'title',
										'paged' => $paged,
										'tax_query' => array(
											array(
												'taxonomy' => 'idioma',
												'field'    => 'slug',
												'terms'    => $_GET['idioma'],
											),
										),
									);

								$the_query_c = new WP_Query( $args = array( 'post_type' => 'artigos', 'tax_query' => array(array('taxonomy' => 'idioma','field'    => 'slug','terms'    => $_GET['idioma'],),),'posts_per_page' =>  -1) );
					
							elseif(isset($_GET['autor'])):
									$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;											

 									if(isset($aut_id)){
	 									
										$args2 = array(
											'post_type' => 'artigos',
											'order' => 'ASC',
											'orderby' => 'title',
											'paged' => $paged,
											'meta_query' => array(
												array(
													'key' => 'nome_autor',
													'value' => '"'.$_GET['autor'].'"',
													'compare' => 'LIKE'
												)
											)
										);
										
										$art_array = id_art_novo(id_art($aut_id)); // artigos dos autores antigos
										
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
											'paged' => $paged,
										);
										
								
										
									}else{
										
										$args = array(
											'post_type' => 'artigos',
											'order' => 'ASC',
											'orderby' => 'title',
											'paged' => $paged,
											'meta_query' => array(
												array(
													'key' => 'nome_autor',
													'value' => '"'.$_GET['autor'].'"',
													'compare' => 'LIKE'
												)
											)
										);
									}
									
								$the_query_c = new WP_Query( $args = array( 'post_type' => 'artigos', 'meta_key'     => 'id','meta_value'   => id_art($aut_id), 'meta_compare' => 'IN', 'posts_per_page' =>  -1) );
					
							elseif(isset($_GET['publicacao'])):
											
									$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;																	
									$args = array(
										'post_type' => 'artigos',
										'order' => 'ASC',
										'orderby' => 'title',
										'paged' => $paged,
										'tax_query' => array(
											array(
												'taxonomy' => 'publicacao',
												'field'    => 'slug',
												'terms'    => $_GET['publicacao']
											),
										),
									);

								$the_query_c = new WP_Query( $args = array( 'post_type' => 'artigos', 'tax_query' => array( array( 'taxonomy' => 'publicacao','field' => 'slug', 'terms' => $_GET['publicacao'], ), ), 'posts_per_page' =>  -1) );
					
							else:
					
									if(isset($_GET['data_mes'])){
										$meta_query = array(
											array(
												'key' => 'data_exemplar',
												'value' => $_GET['data_mes'],
												'compare' => 'LIKE'
											)
										);		
	
									}else{
										
										$meta_query = array(
											array(
												'key' => 'data_exemplar',
												'value' => $_GET['data'],
												'compare' => 'LIKE'
											)
										);		
									}				
									
									$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;													
									$args = array(
										'post_type' => 'artigos',
										'order' => 'DESC',
										'orderby' => 'meta_value_num',
										'meta_key' => 'data_exemplar',
										'meta_query' => $meta_query,
										'paged' => $paged
									);	
									
									$the_query_c = new WP_Query( $args = array( 'post_type' => 'artigos', 'meta_key' => 'data_exemplar', 'meta_query' => $meta_query, 'posts_per_page' =>  -1) );
										
							endif;				

								$the_query = new WP_Query( $args );
								
								
									if(isset($_GET['autor'])){
										echo '<h4 class="text-center">';
										echo get_the_title($_GET['autor']);
										_e(' &mdash; ');
										echo $the_query->post_count ;
									}else{
										echo '<h4 class="text-center">'.$the_query->post_count ;
									}
	
										if ( qtranxf_getLanguage()=='en' ){echo ' articles';}
										elseif ( qtranxf_getLanguage()=='es' ){echo ' artículos';}
										elseif ( qtranxf_getLanguage()=='fr' ){echo ' articles';}
										elseif ( qtranxf_getLanguage()=='de' ){echo ' artikel';}
										elseif ( qtranxf_getLanguage()=='ja' ){echo ' 物品';}
										else {echo ' artigos';}
									echo '</h4>';
	
								
								if ( $the_query->have_posts() ) :
								
									while ( $the_query->have_posts() ) : $the_query->the_post();

										get_template_part( 'content');
								
									endwhile;
								 
					echo '<div class="pagination-wrap"><ul class="page-numbers">';
					
					$big = 999999999; // need an unlikely integer
					
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $the_query->max_num_pages,
						'type'      => 'list',
					
						
					) );
					echo '</ul></div>';						




								else :

									 get_template_part( 'content', 'none' );
									 
								endif; 
								
				else:
				
					
				

								$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;																	
								$args = array(
									'post_type' => 'artigos',
									'order' => 'ASC',
									'orderby' => 'title',
									'paged' => $paged
								);

									
								$the_query = new WP_Query( $args );
/*
								$the_query_c = new WP_Query( $args = array( 'post_type' => 'artigos', 'posts_per_page' =>  -1) );
							
								echo '<h4 class="text-center">'.$the_query_c->post_count ;
									if ( qtranxf_getLanguage()=='en' ){echo ' articles';}
									elseif ( qtranxf_getLanguage()=='es' ){echo ' artículos';}
									elseif ( qtranxf_getLanguage()=='fr' ){echo ' articles';}
									elseif ( qtranxf_getLanguage()=='de' ){echo ' artikel';}
									elseif ( qtranxf_getLanguage()=='ja' ){echo ' 物品';}
									else {echo ' artigos';}
								echo '</h4>';
*/

							
								if ( $the_query->have_posts() ) :

									while ( $the_query->have_posts() ) : $the_query->the_post();
								
										get_template_part( 'content');
								
									endwhile;
				
												
									echo '<div class="pagination-wrap"><ul class="page-numbers">';
									
									$big = 999999999; // need an unlikely integer
									
									echo paginate_links( array(
										'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
										'format' => '?paged=%#%',
										'current' => max( 1, get_query_var('paged') ),
										'total' => $the_query->max_num_pages,
										'type'      => 'list',
									
										
									) );
									echo '</ul></div>';						

								else :
								
									 get_template_part( 'content', 'none' );
									 
								endif; 

				endif;
				wpb_set_post_views(get_the_ID()); 
				}
				?>

			</div>
		</div>


			<div class="container populares">
				
					<?php get_template_part( 'content', 'popular' ); ?>
					
			</div>
		</div><!-- #content -->
	</section><!-- #primary -->
	<?php
	get_footer();