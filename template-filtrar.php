			<div class="formulario-busca">
				<form method="get" id="searchform" class="form-inline interna" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
					<div class="form-group interna">
						<input type="text" placeholder="<?php if ( qtranxf_getLanguage()=='en' ){echo ' Search';}
									elseif ( qtranxf_getLanguage()=='es' ){echo ' Búsqueda';}
									elseif ( qtranxf_getLanguage()=='fr' ){echo ' Recherche';}
									elseif ( qtranxf_getLanguage()=='de' ){echo ' Suchen';}
									elseif ( qtranxf_getLanguage()=='ja' ){echo ' 検索';}
									elseif ( qtranxf_getLanguage()=='it' ){echo ' Riserca';}
									else {echo ' Buscar';} ?>" class="form-control bold" name="s" id="s" />
						<input type="hidden" name="post_type" value="artigos" />
					</div>
				</form>
			</div>


			<div class="filtro-autor">
				<?php
				$terms = get_terms( 'autores' );
					echo '<select class="selectpicker">';
					echo'<option class="bold" value="">'; printf( __( 'Authors', 'odin' ));  echo '</option>';
					
					

					$args = array('post_type' => 'autores','order' => 'ASC', 'orderby' => 'title', 'posts_per_page' => -1 );
						$query = new WP_Query( $args );
						if ( $query->have_posts() ) :
						while ( $query->have_posts() ) : $query->the_post();

							if( isset($_GET['autor']) ){
								if($_GET['autor'] == the_slug()){$selected = 'selected';}
							}else{$selected = '';}			
							echo '<option value="/articles?autor='. get_the_ID() .'" '.$selected.'>' . get_the_title() . '</option>';

						endwhile;
						wp_reset_postdata();						
						endif;
										

					echo '</select>';
				?>
			</div>

			<div class="filtro-idioma">
				<?php
				$terms = get_terms( 'idioma' );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					echo '<select class="selectpicker">';
					echo'<option class="bold" value="">'; printf( __( 'Language', 'odin' )); echo'</option>';

					foreach ( $terms as $term ) {
						if( isset($_GET['idioma']) ){
							if($_GET['idioma'] == $term->slug){$selected = 'selected';}
						}else{$selected = '';}
						echo '<option value="/articles?idioma='. $term->slug .'" '.$selected.'>' . $term->name . '</option>';
					}
					echo '</select>';
				}
				?>
			</div>


			<div class="filtro-data">
				<?php
				$terms = get_terms( 'ano' );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					echo '<select class="selectpicker">';
					echo'<option class="bold" value="">'; printf( __( 'Year', 'odin' )); echo'</option>';

					$terms_ano = array();
					foreach ( $terms as $term ) {
						$terms_ano = explode('-', $term->name);
						$term_ano[] = $terms_ano[0];
					}
					
					$anos = array_unique($term_ano);
					
					foreach ( $anos as $ano ) {
						if( isset($_GET['data']) ){						
							if($_GET['data'] == $term->slug){$selected = 'selected';}
						}else{$selected = '';}
						echo '<option value="/articles/?data='. $ano .'" '.$selected.'>' . $ano . '</option>';
					}
					echo '</select>';
				}
				?>
			</div>


			<div class="filtro-data">
				<?php
					echo '<select class="selectpicker">';
					echo'<option class="bold" value="">'; printf( __( 'Month', 'odin' )); echo'</option>';

						if(isset($_GET['data'])){
							$data_ano = substr($_GET['data'],0,4);
							echo '<option value="/articles/?data='.$data_ano.'-01" '; echo '>'; printf( __( 'January', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-02" '; echo '>'; printf( __( 'February', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-03" '; echo '>'; printf( __( 'March', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-04" '; echo '>'; printf( __( 'April', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-05" '; echo '>'; printf( __( 'May', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-06" '; echo '>'; printf( __( 'June', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-07" '; echo '>'; printf( __( 'July', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-08" '; echo '>'; printf( __( 'August', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-09" '; echo '>'; printf( __( 'September', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-10" '; echo '>'; printf( __( 'October', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-11" '; echo '>'; printf( __( 'November', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data='.$data_ano.'-12" '; echo '>'; printf( __( 'December', 'odin' )); echo'</option>';
						}else{
							
							if( isset( $_GET['data_mes']) ){
							echo '<option value="/articles/?data_mes=-01-" '; if($_GET['data_mes'] == 01){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'January', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-02-" '; if($_GET['data_mes'] == 02){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'February', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-03-" '; if($_GET['data_mes'] == 03){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'March', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-04-" '; if($_GET['data_mes'] == 04){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'April', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-05-" '; if($_GET['data_mes'] == 05){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'May', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-06-" '; if($_GET['data_mes'] == 06){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'June', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-07-" '; if($_GET['data_mes'] == 07){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'July', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-08-" '; if($_GET['data_mes'] == '08'){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'August', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-09-" '; if($_GET['data_mes'] == '09'){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'September', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-10-" '; if($_GET['data_mes'] == 10){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'October', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-11-" '; if($_GET['data_mes'] == 11){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'November', 'odin' )); echo'</option>';
							echo '<option value="/articles/?data_mes=-12-" '; if($_GET['data_mes'] == 12){$selected = 'selected';}else{$selected = '';} echo '>'; printf( __( 'December', 'odin' )); echo'</option>';
							}
						}
					echo '</select>';
				?>
			</div>
			
			
			<?php if( isset($_GET['data']) || isset($_GET['data_mes']) || isset($_GET['autor']) || isset($_GET['idioma']) ){ ?>
				<div class="formulario-reset hide">
					<a class="btn resetar" href="/articles">
<?php
	
	 if ( qtranxf_getLanguage()=='en' ){echo 'Reset';}
							elseif ( qtranxf_getLanguage()=='es' ){echo 'Reiniciar';}
							elseif ( qtranxf_getLanguage()=='fr' ){echo 'Réinitialiser';}
							elseif ( qtranxf_getLanguage()=='de' ){echo 'rücksetzen';}
							elseif ( qtranxf_getLanguage()=='ja' ){echo 'リセット';}
							else {echo 'Limpar';}	
?>						
					</a>
				</div>
			<?php } ?>

			