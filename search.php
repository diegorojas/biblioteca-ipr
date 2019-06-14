<?php get_header(); ?>
<section id="primary" class="">
	<div class="container">
		<div class="row">
			<div class="col-md-12  text-center">

				<?php if($_GET['post_type']=='autores'){ ?>
					<?php get_template_part('template','filtrar_autores'); ?>
				<?php }else{ ?>
					<?php get_template_part('template','filtrar'); ?>
				<?php } ?>

			</div>
		</div>
		
	<div id="content" class="site-content" role="main">

		<div class="container">
			<div class="content-news row">

			<div class="col-md-12 text-center">
				<h2 class="pagetitle"><?php
					
					if($_GET['post_type'] == 'artigos'){
	
							if ( qtranxf_getLanguage()=='en' ){echo 'Search Result for ';}
							elseif ( qtranxf_getLanguage()=='es' ){echo 'Resultado de la búsqueda para ';}
							elseif ( qtranxf_getLanguage()=='fr' ){echo 'Résultat de la recherche pour ';}
							elseif ( qtranxf_getLanguage()=='de' ){echo 'Suchergebnis für ';}
							elseif ( qtranxf_getLanguage()=='ja' ){echo 'の検索結果 ';}
							elseif ( qtranxf_getLanguage()=='it' ){echo 'Ricerca i risultati per ';}
							else {echo 'Resultado de busca para ';}

 /* Search Count */ $allsearch = new WP_Query("s=$s&showposts=-1&post_type=artigos"); $key = $s; $count = $allsearch->post_count; _e(''); _e('<span class="search-terms">"'); echo $key; _e('"</span>'); _e(' &mdash; '); echo $count . ' ';
 
							 if ( qtranxf_getLanguage()=='en' ){echo 'articles';}
							elseif ( qtranxf_getLanguage()=='es' ){echo 'artículos';}
							elseif ( qtranxf_getLanguage()=='fr' ){echo 'articles';}
							elseif ( qtranxf_getLanguage()=='de' ){echo 'artikel';}
							elseif ( qtranxf_getLanguage()=='ja' ){echo '物品';}
							else {echo 'artigos';}
							
  wp_reset_query(); } ?></h2>
			</div>


			<?php if ( have_posts() ) : ?>

				<?php
				while ( have_posts() ) : the_post();

					if($_GET['post_type'] == 'autores'){
						get_template_part( 'content', 'autores' );
					}else{
						get_template_part( 'content');
					}

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
	
				else :
							echo '<header class="col-md-12 page-header text-center">';
							if ( qtranxf_getLanguage() == 'en' ){echo '<h3 class="page-title">Nothing Found</h3>';}
							elseif ( qtranxf_getLanguage() == 'es' ){echo '<h3 class="page-title">Nada Encontrado</h3>';}
							elseif ( qtranxf_getLanguage() == 'fr' ){echo '<h3 class="page-title">rien na été trouvé</h3>';}
							elseif ( qtranxf_getLanguage() == 'de' ){echo '<h3 class="page-title">Nichts gefunden</h3>';}
							elseif ( qtranxf_getLanguage() == 'ja' ){echo '<h3 class="page-title">何も見つかりません</h3>';}
							else {echo '<h3 class="page-title">Nada encontrado</h3>';}
							echo '</header>';
				endif;
				?>

				<?php

				wpb_set_post_views(get_the_ID());
				?>

			</div>
		</div>


			<div class="container">
				
					<?php get_template_part( 'content', 'popular' ); ?>
					
			</div>
		</div><!-- #content -->
	</section><!-- #primary -->
	<?php
	get_footer();