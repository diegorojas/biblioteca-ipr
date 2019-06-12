</div><!-- #main -->
<div class="parceiros">
	<div class="container">

		<?php if( is_page(86) ): ?>

		<h4><?php printf( __( 'PARTNERS', 'odin' ));?></h4>
			
			<div class="row">
				<?php while( have_rows('Parceiros',86) ): the_row(); 

				$image = get_sub_field('imagem_parceiros');
				?>
				<div class="col-md-2  col-sm-2 col-xs-12 images-parceiros">
					<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
				</div>
				<?php endwhile; ?>
				
			</div>
			
		<?php endif; ?>
		
	</div>
</div>

</div>
<div class="menu in-footer">
	<div class="container">
		<div class="row">
			<nav id="main-navigation" role="navigation"  class="col-md-12">

				<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'odin' ); ?>"><?php _e( 'Skip to content', 'odin' ); ?></a>

					<div class="navbar-main-navigation">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'main-menu',
								'depth'          => 2,
								'container'      => false,
								'menu_class'     => 'nav navbar-nav col-md-12',
								'fallback_cb'    => 'Odin_Bootstrap_Nav_Walker::fallback',
								'walker'         => new Odin_Bootstrap_Nav_Walker()
							)
						);
					?>
					</div><!-- .navbar-collapse -->

				</nav><!-- #main-menu -->
			</div>
		</div>
	</div>
<footer id="footer" role="contentinfo" class="with-menu">
	<div class="container">	
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12 box-f">
				<a href="<?php echo home_url(); ?>">
					<img src="<?php bloginfo('template_directory'); ?>/assets/images/logo-footer.png" />
				</a>		
				
			</div>
			<div class="col-md-8 col-sm-8 col-xs-12  footer-link">				

			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'depth'          => 2,
						'container'      => false,
						'menu_class'     => 'nav navbar-nav col-md-12',
						'fallback_cb'    => 'Odin_Bootstrap_Nav_Walker::fallback',
						'walker'         => new Odin_Bootstrap_Nav_Walker()
						)
					);
			
			?>
	
			</div>
		</div>
	</div>
</footer><!-- #footer -->
</div><!-- .container -->
<?php wp_footer(); ?>
</body>
</html>
