<?php get_header(); ?>

<div id="primary">
	<div id="content" class="site-content" role="main">
		<div class="container" style="margin-bottom: 100px">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="perfil">

<?php
    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) {
    echo '<div class="topo">
			<h2 class="bold">'; printf( __( 'You are not registered', 'odin' ));echo '</h2>
			<a href="/login" class="home btn">'; printf( __( 'Enter', 'odin' ));echo '</a>
			<p>'; printf( __( 'We will send you a registration confirmation link to your email.', 'odin' ));echo '</p>
		</div>';
	} else {
    
	    echo '<div class="topo">
				<h2 class="bold">'; printf( __( 'Welcome', 'odin' )); echo', ' . $current_user->display_name . '</h2>
				<a href="'.wp_logout_url('/').'" class="home btn" style="width: 60px; margin-left: 10px;">'; printf( __( 'Log Out', 'odin' ));echo '</a>
				<a href="'. esc_url( home_url( '/edit-profile' ) ).'" class="home btn">'; printf( __( 'Edit profile', 'odin' ));echo '</a>
			</div>';
			echo '<p>'; printf( __( 'Email', 'odin' )); echo': ' . $current_user->user_email . '</p>';
			echo '<p>'; printf( __( 'Country', 'odin' )); echo': ' . $current_user->pais . '</p>';
			if($current_user->escola){echo '<p>'; printf( __( 'School', 'odin' ));echo ': ' . $current_user->escola . '</p>';}
			echo '<p>'; printf( __( 'Profession', 'odin' ));echo ': ' . $current_user->profissao . '</p>';
    }
?>


					</div>	
				</div>
			</div>

		</div>
			<?php // get_template_part( 'content', 'popular' ); ?>

	</div><!-- #content -->
</div><!-- #primary -->
<?php
get_footer();
