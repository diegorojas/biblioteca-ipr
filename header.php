<!DOCTYPE html>
<!--[if IE 7]>
<html class="no-js ie ie7 lt-ie9 lt-ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="no-js ie ie8 lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta property="og:title" content="<?php the_title(); ?>"/>
	<meta property="og:description" content="<?php echo the_excerpt(); ?>"/>
	<meta property="og:url" content="<?php the_permalink(); ?>"/>
	<meta property="og:type" content="<?php if (is_single() || is_page()) { echo "article"; } else { echo "website";} ?>"/>
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js"></script>
    <![endif]-->
	    
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-71671775-22', 'auto');
	  ga('send', 'pageview');
	
	</script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope="" itemtype="http://schema.org/WebPage">
	<header id="header" role="banner ">
		<div class="container">
			<div class="row">
				<div class="logo col-md-4 col-xs-8">
					<?php if ( is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" id="logo"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<div class="site-title h1"><a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" id="logo"><?php bloginfo( 'name' ); ?></a></div>
					<?php endif ?>
				</div>

				<div class="col-md-6 col-xs-7 search-box">
					<form method="get" id="searchform" class="form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
						<div class="form-group">


					<input type="text" placeholder="<?php printf( __( 'Content Search', 'odin' )); ?>" class="form-control odin-tooltip" name="s" id="s" data-toggle="tooltip" data-placement="bottom" title="You can also use Ctrl+F/Cmd+F to find words on this page" />
		
							<input type="hidden" name="post_type" value="artigos" />
							<input type="submit" class="btn-search" value="<?php esc_attr_e( 'Search', 'odin' ); ?>" />
						</div>
					</form>
				</div>
				
					<div class="col-md-2 col-xs-4 idioma">

				<!-- Chamada direta do codigo gerador do menu de idiomas do plugin qTranslateX -->
						<?php echo qtranxf_generateLanguageSelectCode('both'); ?>
						
						<div class="dropdown  language-dropdown">
						  <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    <span class="lang-flag"></span>
						    <span class="caret"></span>
						  </button>
						  
						  <ul id="qtranslate-chooser" class="language-chooser dropdown-menu">
						  </ul>
						  
						</div>
										
						<div class="menu-global">
<?php
	
//echo __('[:en]en-text[:ja]ja-text[:]');

    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) {
		echo '<a class="link-menu" href="'. esc_url( home_url( '/login' ) ).'">'; printf( __( 'Enter', 'odin' )); echo '</a>
			  <a class="link-menu" href="'. esc_url( home_url( '/register' ) ).'">'; printf( __( 'sign up', 'odin' )); echo '</a>';
    }else{

		echo '<a class="link-menu" href="'. esc_url( home_url( '/profile' ) ).'" style="font-size: 16px; line-height: 18px; display: block; margin-bottom: -10px;"><strong>' . $current_user->display_name.'</strong></a>
		      <a class="link-menu" href="'. wp_logout_url( home_url('/') ).'"><small style="font-size: 12px; position: relative; bottom: -8px; color: #ad8766;">'; 
		      printf( __( 'Log Out', 'odin' ));
				echo '</small></a>';
	    
    }
?>							
						</div>
					</div>
				</div>

			</div>

		</div>
	</header><!-- #header -->


	<div class="bg-home">

		<?php
		
		if ( is_page() ) {

			$image = get_field('destaque_imagem');

			if (!empty($image)): ?>
			<div class="bg-banner" style="background: url(<?php echo $image; ?>) center bottom; background-size: cover;">
				<div class="banner-content">
					<div class="container">
						<h2><?php the_title();?></h2>
					</div>
				</div>
			</div>
		<?php endif; 
	}elseif(is_archive()){
		$image = wp_get_attachment_image_url( get_post_meta(12,'destaque_imagem')[0], 'full');
	?>
		<div class="bg-banner" style="background: url(<?php echo $image; ?>) center bottom; background-size: cover;">
				<div class="banner-content">
					<div class="container">
						<?php
							
						if(is_post_type_archive('autores')){
									
							if ( qtranxf_getLanguage()=='en' ){echo '<h2>Authors</h2>';}
							elseif ( qtranxf_getLanguage()=='es' ){echo '<h2>Autores</h2>';}
							elseif ( qtranxf_getLanguage()=='fr' ){echo '<h2>Auteurs</h2>';}
							elseif ( qtranxf_getLanguage()=='de' ){echo '<h2>Autoren</h2>';}
							elseif ( qtranxf_getLanguage()=='ja' ){echo '<h2>著者</h2>';}
							else {echo '<h2>Autores</h2>';}
						
						}else{
						
							if ( qtranxf_getLanguage()=='en' ){echo '<h2>Articles</h2>';}
							elseif ( qtranxf_getLanguage()=='es' ){echo '<h2>Artículos</h2>';}
							elseif ( qtranxf_getLanguage()=='fr' ){echo '<h2>Articles</h2>';}
							elseif ( qtranxf_getLanguage()=='de' ){echo '<h2>Artikel</h2>';}
							elseif ( qtranxf_getLanguage()=='ja' ){echo '<h2>物品</h2>';}
							else {echo '<h2>Artigos</h2>';}
							
						}	
						?>
					</div>
				</div>
		</div>
	<?php 
	}elseif(is_single()){
		$image = get_field('destaque_imagem',12);
	?>
		<div class="bg-banner" style="background: url(<?php echo $image; ?>) center; background-size: cover;">
				<div class="banner-content">
					<div class="container">
						<h2><?php printf( __( 'Articles', 'odin' ));?></h2>
					</div>
				</div>
		</div>
	<?php 
	}elseif(is_search()){
		$image = get_field('destaque_imagem',12);
	?>
		<div class="bg-banner" style="background: url(<?php echo $image; ?>) center bottom; background-size: cover;">
				<div class="banner-content">
					<div class="container">
						<h2><?php printf( __( 'Search', 'odin' ));?></h2>
					</div>
				</div>
		</div>
	<?php 
	}else{
		$image = get_field('destaque_imagem',12);
	?>
		<div class="bg-banner" style="background: url(<?php echo $image; ?>) center bottom; background-size: cover;">
				<div class="banner-content">
					<div class="container">
						<h2><?php the_title(); ?></h2>
					</div>
				</div>
		</div>
	<?php 
	}
?>



</div>
<div class="menu">
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


<?php

		echo '<div id="main" class="site-main">';
?>
