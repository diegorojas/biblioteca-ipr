<?php get_header(); ?>

<div id="primary" >	
	<div id="content" class="site-content" role="main">
		<div class="container">
			<div class="row">
				<div class="box-post">


							<?php if( has_post_thumbnail() ){
								echo '<div class="col-md-4 col-sm-4 col-xs-12 img-post">';
									the_post_thumbnail();
								echo '</div>
								<div class="col-md-8 col-sm-8 col-xs-12">';
							}else{
								echo '<div class="col-md-12">';								
							} ?>
							<div class="content-post">
								<div class="box-lang">
									<div class="dropdown">
										<?php

// lista os idiomas já traduzidos quando vindos pelo wpml
										if ( qtranxf_getLanguage()=='en' ){$idi = array('Portuguese', 'English ', 'Spanish', 'French', 'German', 'Japanese', 'Italiano'); $trad = '<small>(Translation by Google)</small>';}
										elseif ( qtranxf_getLanguage()=='es' ){$idi = array('Portugués', 'Inglés', 'Español', 'Francés', 'Alemán', 'Japonés', 'Italiano'); $trad = '<small>(Traducción de Google)</small>';}
										elseif ( qtranxf_getLanguage()=='fr' ){$idi = array('Portugais', 'Anglais', 'Espagnol', 'Français', 'Allemand', 'Japonais', 'italien'); $trad = '<small>(Traduction par Google)</small>';}
										elseif ( qtranxf_getLanguage()=='de' ){$idi = array('Portugiesisch', 'Englisch', 'Spanisch', 'Französisch', 'Deutsch', 'Japanisch', 'Italienisch'); $trad = '<small>(Übersetzung von Google)</small>';}
										elseif ( qtranxf_getLanguage()=='ja' ){$idi = array('ポルトガル語', '英語', 'スペイン語', 'フランス語', 'ドイツ語', '日本語', 'イタリアの'); $trad = '<small>(Googleによる翻訳)</small>';}
										elseif ( qtranxf_getLanguage()=='it' ){$idi = array('Portoghese', 'English', 'Spagnolo', 'francese', 'tedesco', 'giapponese', 'Italiano'); $trad = '<small>(Traduzione a cura di Google)</small>';}
										else {$idi = array('Português', 'Inglês', 'Espanhol', 'Francês', 'Alemão', 'Japonês', 'Italiano'); $trad = '<small>(Tradução do Google)</small>';}

$terms = get_the_terms( $post->ID, 'idioma');
if($terms){
	foreach ( $terms as $term ) {
	    $termID[] = $term->slug;
	}
}

if($termID[0]){	$term_slug = $termID[0]; }else{ $term_slug = qtranxf_getLanguage();}

										echo '<button class="btn-lang qtranxs_flag_'.$term_slug.' dropdown-toggle" type="button" data-toggle="dropdown">';
										 printf( __( 'Choose', 'odin' )); echo '<br>'; printf( __( 'the language of the article', 'odin' )); echo'<span class="caret"></span></button>';
										echo '<ul class="dropdown-menu">';

if(has_term('pb','idioma')){ echo '<li class="li-pt bt-traduzir" data-lang="pt"><a href="/articles/'.the_slug().'/?lang=pb" class="qtranxs_flag_pb qtranxs_flag_and_text">'.$idi[0].'</a></li>'; }
if(has_term('en','idioma')){ echo '<li class="li-en bt-traduzir" data-lang="en"><a href="/articles/'.the_slug().'/?lang=en" class="qtranxs_flag_en qtranxs_flag_and_text">'.$idi[1].'</a></li>'; }
if(has_term('es','idioma')){ echo '<li class="li-es bt-traduzir" data-lang="es"><a href="/articles/'.the_slug().'/?lang=es" class="qtranxs_flag_es qtranxs_flag_and_text">'.$idi[2].'</a></li>'; }
if(has_term('fr','idioma')){ echo '<li class="li-fr bt-traduzir" data-lang="fr"><a href="/articles/'.the_slug().'/?lang=fr" class="qtranxs_flag_fr qtranxs_flag_and_text">'.$idi[3].'</a></li>'; }
if(has_term('de','idioma')){ echo '<li class="li-de bt-traduzir" data-lang="de"><a href="/articles/'.the_slug().'/?lang=de" class="qtranxs_flag_de qtranxs_flag_and_text">'.$idi[4].'</a></li>'; }
if(has_term('ja','idioma')){ echo '<li class="li-ja bt-traduzir" data-lang="ja"><a href="/articles/'.the_slug().'/?lang=ja" class="qtranxs_flag_ja qtranxs_flag_and_text">'.$idi[5].'</a></li>'; }
if(has_term('it','idioma')){ echo '<li class="li-it bt-traduzir" data-lang="it"><a href="/articles/'.the_slug().'/?lang=it" class="qtranxs_flag_it qtranxs_flag_and_text">'.$idi[6].'</a></li>'; }

										echo '</ul>';
										?>
								</div>	

							</div>
							<div class="the-post-content">
								<h4><?php the_title();?></h4>
								<h6><strong><?php printf( __( 'By', 'odin' )); echo ': ';?>
								<?php if(get_field('nome_autor')){
									$post_objects = get_field('nome_autor');
								    foreach( $post_objects as $post_object):
										echo get_the_title($post_object).'; ';
//										echo $post_object;
								    endforeach;
								}else{
									$arr = id_aut_novo(id_aut(get_field('id')));
									
									foreach ($arr as $r) {
										echo get_the_title($r).'; ';
									}
								}		
								?>
								
								</strong></h6>

						</div>
					</p>

					<div class="box-limite">
						<p><?php echo get_field('subtitulo'); ?></p>

						<p><?php printf( __( 'Published', 'odin' )); ?>: <span><?php echo strip_tags(get_the_term_list( $post->ID, 'publicacao', ''));?></span></p>
						<p><?php printf( __( 'Year', 'odin' )); ?>: <span><?php echo substr(get_field('data_exemplar'),0,4);?></span></p>
						<p><?php printf( __( 'Month', 'odin' )); ?>: <span>
						
						<?php
							if(substr(get_field('data_exemplar'),5,2) == 01){ printf( __( 'January', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 02){ printf( __( 'February', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 03){ printf( __( 'March', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 04){ printf( __( 'April', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 05){ printf( __( 'May', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 06){ printf( __( 'June', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 07){ printf( __( 'July', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == '08'){ printf( __( 'August', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == '09'){ printf( __( 'September', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 10){ printf( __( 'October', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 11){ printf( __( 'November', 'odin' )); }
							if(substr(get_field('data_exemplar'),5,2) == 12){ printf( __( 'December', 'odin' )); }							
						?>
						</span></p>
						<p><?php printf( __( 'Language', 'odin' )); ?>: <span><?php echo strip_tags(get_the_term_list( $post->ID, 'idioma', '', ', ' ));?></span></p>

						<?php if(get_field('volume')){echo '<p>';printf( __( 'Vol', 'odin' )); echo ': <span>'. get_field('volume').'</span></p>';} ?>
							<?php if(get_field('numero')){echo '<p>';printf( __( 'Number', 'odin' )); echo ': <span>'. get_field('numero').'</span></p>';} ?>
								<?php if(get_field('pagina')){echo '<p>';printf( __( 'Page', 'odin' )); echo ': <span>'. get_field('pagina').'</span></p>';} ?>

								</div>

								<?php
								if ( has_excerpt() ) {

									echo html_entity_decode(get_the_excerpt());

								}  
								?>



								<?php
								$current_user = wp_get_current_user();
								if ( 0 == $current_user->ID ) {
								} else {
									if(get_field('arquivo')){
										echo '<div class="box-download">
											<a href="'.get_field('arquivo').'" class="btn">'; printf( __( 'Download', 'odin' )); echo '</a>
										</div>';

									}elseif( (get_field('id') >= 1080 && get_field('id') <= 1457) || (get_field('id') >= 952 && get_field('id') <= 960) || (get_field('id') >= 837 && get_field('id') <= 848) || (get_field('id') == 746) || (get_field('id') == 747) || (get_field('id') == 749) || (get_field('id') == 865)  ){
										echo '<div class="box-download">
											<a href="http://www.pedroprado.com.br/imgs/pdf/'.get_field('id').'.pdf" target="_blank" class="btn">'; printf( __( 'Download', 'odin' )); echo '</a>
										</div>';
										
									}
							}
							?>	

						</div>
					</div>

					<div class="col-md-12 single-content traducao">

						<?php
						$current_user = wp_get_current_user();
						if ( 0 == $current_user->ID ) {
							echo '<div class="box-sem-login">';
							printf( __( 'To have full access to the subject of this article you need to be registered on the site.', 'odin' )); echo'<br><a href="/login"><strong>';printf( __( 'Login on the website', 'odin' )); echo'</strong></a>';printf( __( 'or', 'odin' ));echo'  <a href="/register"><strong>'; printf( __( 'sign up', 'odin' )); echo'</strong></a>.';
						echo '</div>';
					} else {
						echo wpautop(html_entity_decode(get_post_field('post_content', get_the_id())));
//						echo wpautop(html_entity_decode(get_the_content()));
					}
					?>	
				</div>

		</div>

	</div>

	<?php get_template_part( 'content', 'veja_tambem' ); ?>
	
</div>


</div>




</div>
</div><!-- #content -->
</div><!-- #primary -->

<?php get_footer();