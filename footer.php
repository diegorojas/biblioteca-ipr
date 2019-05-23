</div><!-- #main -->
<div class="parceiros">
	<div class="container">

		<?php if( is_page(86) ): ?>

		<h4><?php printf( __( 'PARTNERS', 'odin' ));?></h4>
			
			<div class="row">
				<?php while( have_rows('Parceiros',86) ): the_row(); 

				$image = get_sub_field('imagem_parceiros');
				?>
				<div class="col-md-2 col-xs-4 images-parceiros">
					<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
				</div>
				<?php endwhile; ?>
				
			</div>
			
		<?php endif; ?>
		
	</div>
</div>

</div>

<footer id="footer" role="contentinfo">
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
