			<div class="formulario-busca">
				<form method="get" id="searchform" class="form-inline interna" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
					<div class="form-group interna">
						<input type="text" placeholder="<?php 			
								if ( qtranxf_getLanguage()=='en' ){echo 'Search Authors';}
								elseif ( qtranxf_getLanguage()=='es' ){echo 'Buscar autores';}
								elseif ( qtranxf_getLanguage()=='fr' ){echo 'Rechercher des auteurs';}
								elseif ( qtranxf_getLanguage()=='de' ){echo 'Suche Autoren';}
								elseif ( qtranxf_getLanguage()=='ja' ){echo '検索著者';}
								elseif ( qtranxf_getLanguage()=='it' ){echo 'Cerca Autori';}
								else {echo 'Buscar autores';}
							?>" class="form-control bold" name="s" id="s" />
						<input type="hidden" name="post_type" value="autores" />
					</div>
				</form>
			</div>

<!---
			<div class="filtro-idioma">
				<?php
				$terms = get_terms( 'pais' );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					echo '<select class="selectpicker">';
					echo'<option class="bold" value="">'; printf( __( 'Country', 'odin' )); echo'</option>';
	
					foreach ( $terms as $term ) {
						if($_GET['pais'] == $term->slug){$selected = 'selected';}else{$selected = '';}
						echo '<option value="/autores?pais='. $term->slug .'" '.$selected.'>' . $term->name . '</option>';
					}
					echo '</select>';
				}
				?>
			</div>
-->