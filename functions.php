<?php

/**
 * Odin Classes.
 */
require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';
require_once get_template_directory() . '/core/classes/class-shortcodes.php';
require_once get_template_directory() . '/core/classes/widgets/class-widget-like-box.php';
//require_once get_template_directory() . '/core/classes/class-thumbnail-resizer.php';
// require_once get_template_directory() . '/core/classes/class-post-type.php';
// require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/class-metabox.php';


/**
 * Core Helpers.
 */
require_once get_template_directory() . '/core/helpers.php';

/** Comments loop. */
require_once get_template_directory() . '/inc/comments-loop.php';

/** WP optimize functions. */
require_once get_template_directory() . '/inc/optimize.php';

/** Custom template tags. */
require_once get_template_directory() . '/inc/template-tags.php';

/** ACF PRO Fields */
//require_once get_template_directory() . '/inc/fields.php';








/**
 * Load site scripts.
 */
function odin_enqueue_scripts() {
	$template_url = get_template_directory_uri();

	// CSS
	wp_enqueue_style( 'style', get_stylesheet_uri(), array(), null, 'all' );
//	wp_enqueue_style( 'slick', $template_url . '/assets/js/slick/slick.css', array(), null, 'all' );

	// CSS Theme
	wp_enqueue_style( 'theme', $template_url . '/assets/css/theme.css', array(), null, 'all' );
//	wp_enqueue_style( 'theme-gabriel', $template_url . '/assets/css/theme-gabriel.css', array(), null, 'all' );
	wp_enqueue_style( 'responsive', $template_url . '/assets/css/responsive.css', array(), null, 'all' );

	wp_enqueue_style( 'select-css', $template_url . '/assets/css/bootstrap-select.css', array(), null, 'all' );

	// JS e jQuery.
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap', $template_url . '/assets/js/bootstrap.min.js', array(), null, true );
//	wp_enqueue_script( 'slickSlider', $template_url . '/assets/js/slick/slick.min.js', array(), null, true );
//	wp_enqueue_script( 'easing', $template_url . '/assets/js/jquery.easing.1.3.js', array(), null, true );
//	wp_enqueue_script( 'viewport', $template_url . '/assets/js/jquery.viewportchecker.js', array(), null, true );
	wp_enqueue_script( 'main', $template_url . '/assets/js/main.js', array(), null, true );
	wp_enqueue_script( 'select-js', $template_url . '/assets/js/bootstrap-select.js', array(), null, true );

		
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );



add_filter( 'wp_title', 'wpdocs_hack_wp_title_for_home' );
 
/**
 * Customize the title for the home page, if one is not set.
 *
 * @param string $title The original title.
 * @return string The title to use.
 */
function wpdocs_hack_wp_title_for_home( $title )
{
  if ( empty( $title ) && ( is_home() || is_front_page() ) ) {
    $title = __( 'Home', 'textdomain' ) . ' | ' . get_bloginfo( 'description' );
  }
  return $title;
}



//
//   admin login CSS
//

function css_login() {
	$template_url = get_template_directory_uri();
	echo '<link rel="stylesheet" href="'.$template_url.'/assets/css/admin.css" type="text/css" media="all" />';
	echo "<script type='text/javascript' src='/wp-includes/js/jquery/jquery.js?ver=1.12.4'></script>";
	echo "<script type='text/javascript' src='".$template_url."/assets/js/admin.js?".date('mdhis')."'></script>";
}

add_action('login_head', 'css_login');


//
//   admin CSS
//

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
	$template_url = get_template_directory_uri();
	echo '<link rel="stylesheet" href="'.$template_url.'/assets/css/admin.css" type="text/css" media="all" />';
}





function my_secondary_menu_classes( $classes, $item, $args ) {
    // Only affect the menu placed in the 'secondary' wp_nav_bar() theme location
	if ( 'main-menu' === $args->theme_location ) {
        // Make these items 3-columns wide in Bootstrap
		$classes[] = 'col-md-4';
	}

	return $classes;
}

add_filter( 'nav_menu_css_class', 'my_secondary_menu_classes', 10, 3 ); 


/**
 * Setup theme features
 */
function odin_setup_features() {

	/*
	 * Add post_thumbnails suport.
	 */
	add_theme_support( 'post-thumbnails' );
	
	if ( function_exists( 'add_image_size' ) ) {
	  //add_image_size( 'fullsize', 940, 340, true );
	  add_image_size( 'capa', 255, 320, true );
	}
	
	/**
	 * Register nav menus.
	 */
	register_nav_menus( array( 'main-menu' => __( 'Menu Principal', 'odin' )) );
	register_nav_menus( array( 'footer-menu' => __( 'Menu do rodapé', 'odin' )) );
	register_nav_menus( array( 'global-menu' => __( 'Menu global', 'odin' )) );

	/**
	 * Support Custom Editor TinyMCE Style.
	 */
	add_editor_style( 'assets/css/editor-style.css' );

	function odin_stylesheet_uri( $uri, $dir ) {
		return $dir . '/assets/css/style.css';
	}
	
	add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

	load_theme_textdomain( 'odin', get_template_directory() . '/languages' );
	
	
	
	/**
	 * Add support for Post Formats.
	 */
	// add_theme_support( 'post-formats', array(
	//     'aside',
	//     'gallery',
	//     'link',
	//     'image',
	//     'quote',
	//     'status',
	//     'video',
	//     'audio',
	//     'chat'
	// ) );

}

add_action( 'after_setup_theme', 'odin_setup_features' );


/**
 * Register sidebars.
 */
function odin_widgets_init() {
	register_sidebar(
		array(
			'name' => __( 'Main Sidebar', 'odin' ),
			'id' => 'main-sidebar',
			'description' => __( 'Site Main Sidebar', 'odin' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widgettitle widget-title">',
			'after_title' => '</h3>',
			)
		);
}

add_action( 'widgets_init', 'odin_widgets_init' );

/**
 * Flush Rewrite Rules for new CPTs and Taxonomies.
 */
function odin_flush_rewrite() {
	flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );

/**
 * Comments loop.
 */
require_once get_template_directory() . '/inc/comments-loop.php';

/**
 * Core Helpers.
 */
require_once get_template_directory() . '/core/helpers.php';

/**
 * WP optimize functions.
 */
require_once get_template_directory() . '/inc/optimize.php';


 




/*
| -------------------------------------------------------------------
| raincake
| -------------------------------------------------------------------
*/

//
// Remover escolha de cor do usuário e definir cor default
//
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

function update_user_option_admin_color( $color_scheme ) {
	$color_scheme = 'midnight';

	return $color_scheme;
}

add_filter( 'get_user_option_admin_color', 'update_user_option_admin_color', 5 );


//
// fist e last menu class
//

function wpb_first_and_last_menu_class($items) {
	$items[1]->classes[] = 'first';
	$items[count($items)]->classes[] = 'last';
	return $items;
}

add_filter('wp_nav_menu_objects', 'wpb_first_and_last_menu_class');


//
// mudar email de cadastro do wordpress <wordpress@site.com.br>
//

function from_email($email) {
	$wpfrom = get_option('admin_email');
	return $wpfrom;
}

function from_name($email){
	$wpfrom = get_option('blogname');
	return $wpfrom;
}

add_filter('wp_mail_from', 'from_email');
add_filter('wp_mail_from_name', 'from_name');


//
// Page Slug Body Class
//

function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type.'-'.$post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );


//
// menu slug Class
//

function nav_id_filter( $id, $item ) {
	return sanitize_title('nav-'.$item->title);
}
add_filter( 'nav_menu_item_id', 'nav_id_filter', 10, 2 );




//
// Renomear menus
//
/*
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Artigos';
    $submenu['edit.php'][5][0] = 'Artigos';
    $submenu['edit.php'][10][0] = 'Adicionar Artigo';
    $submenu['edit.php'][15][0] = 'Categorias'; // Change name for categories
    $submenu['edit.php'][16][0] = 'Tags'; // Change name for tags
    echo '';
}

add_action( 'admin_menu', 'change_post_menu_label' );
*/



//
// Remove menus
//

function remove_admin_menus () {
remove_menu_page('edit.php'); // posts
//remove_menu_page('upload.php'); // midia
//remove_menu_page('edit.php?post_type=page'); // pagina
remove_menu_page('edit-comments.php'); // comentario
	
//	remove_menu_page('themes.php'); // tema
//	remove_menu_page('plugins.php'); // plugins
	//remove_menu_page('users.php'); // usuarios
//	remove_menu_page('tools.php'); // ferramentas
	
//	remove_menu_page('gf_edit_forms');
//	remove_menu_page('edit.php?post_type=acf-field-group');
	remove_submenu_page( 'admin.php', 'loco-translate-settings' );
	remove_submenu_page( 'gf_edit_forms', 'gf_update' ); 
	remove_submenu_page( 'gf_edit_forms', 'gf_addons' ); 
	remove_submenu_page( 'gf_edit_forms', 'gf_help' ); 
	remove_submenu_page( 'wpseo_dashboard', 'wpseo_licenses' ); 
	//	remove_submenu_page('edit.php?post_type=usuarios','post-new.php?post_type=usuarios');	
if ( !is_super_admin() ) {
	remove_menu_page('options-general.php');

	remove_menu_page( 'wpcf7' ); 
}
remove_submenu_page( 'themes.php', 'widgets.php' );
}


add_action('admin_menu', 'remove_admin_menus', 999);


//
// Remove links do user bar
//

function remove_admin_bar_options() {
	global $wp_admin_bar;

	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('comments');  
	$wp_admin_bar->remove_menu('updates');  
//	$wp_admin_bar->remove_menu('new-content');  
}

add_action('wp_before_admin_bar_render', 'remove_admin_bar_options', 0);


//
// Remove comment from post and pages
//
function remove_comment_support() {
//    remove_post_type_support( 'post', 'comments' );
//    remove_post_type_support( 'page', 'comments' );
}

add_action('init', 'remove_comment_support');



//
// dashboard
//

function disable_dashboard_widgets() {  
	
//    remove_meta_box('dashboard_right_now', 'dashboard', 'core');  
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');  
	remove_meta_box('dashboard_activity', 'dashboard', 'core');  
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');  
	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core'); 
	
	// Yoast's SEO Plugin Widget
	remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
	
}  
add_action('wp_dashboard_setup', 'disable_dashboard_widgets');



//
// texto rodapé
//

function change_admin_footer () {
	echo date( 'Y' ) . ' - Desenvolvido por <a href="http://www.raincake.com.br" target="_blank">Raincake</a>.';
}

add_filter('admin_footer_text', 'change_admin_footer');


//
// avisa que existe submenu
//

function add_menu_parent_class( $items ) {
	
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'nav-parent'; 
		}
	}
	
	return $items;    
}

add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );


//
// meta author
//

function rc_author(){
	echo '<meta name="web_author" content="www.raincake.com.br" />';
}
add_action('wp_head', 'rc_author');



//
//	Add Browser Detection Body Class
//

function ag_browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

add_filter('body_class','ag_browser_body_class');


//
// remover campos de usuarios
// 

function add_twitter_contactmethod( $contactmethods ) {
	unset($contactmethods['aim']);
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);

	$profile_fields['twitter'] = 'Twitter';
	$profile_fields['facebook'] = 'Facebook';
	$profile_fields['gplus'] = 'Google+';
	return $contactmethods;
}

add_filter('user_contactmethods','add_twitter_contactmethod',10,1);


//
// trocar o author por autor
// 

function change_author_permalinks() {

	global $wp_rewrite;

	$wp_rewrite->author_base = 'autor';
	$wp_rewrite->flush_rules();
}

add_action('init','change_author_permalinks');




//
// remover mensagens de atualização
// 

function no_update_notification() {
	if (!current_user_can('activate_plugins')) remove_action('admin_notices', 'update_nag', 3);
}
add_action('admin_notices', 'no_update_notification', 1);





//
// Usar primeira imagem para o facebook
// 
/*
function get_first_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches[1][0];

	if(empty($first_img)) {
		$first_img = get_template_directory_uri()."/assets/images/sem-imagem.jpg";
	}
	return $first_img;
}
*/

//
// Upload de imagens sem link
// 

function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}

add_action('admin_init', 'wpb_imagelink_setup', 10);



//
// Remove link "personalizar" do admin bar
// 

add_action( 'wp_before_admin_bar_render', 'wpse200296_before_admin_bar_render' ); 

function wpse200296_before_admin_bar_render(){
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('customize');
}


//
// Remover meta boxes dos posts e pages
// 

function remove_meta_boxes() {

	// posts
	//remove_meta_box('postcustom','post','normal');
	//remove_meta_box('trackbacksdiv','post','normal');
	//remove_meta_box('commentstatusdiv','post','normal');
	//remove_meta_box('commentsdiv','post','normal');
	//remove_meta_box('categorydiv','post','normal');
	//remove_meta_box('tagsdiv-post_tag','post','normal');
	//remove_meta_box('authordiv','post','normal');

	// pages
	//remove_meta_box('postcustom','page','normal');
	//remove_meta_box('commentstatusdiv','page','normal');
	//remove_meta_box('trackbacksdiv','page','normal');
	//remove_meta_box('commentsdiv','page','normal');
	//remove_meta_box('authordiv','page','normal');

}
add_action('admin_init','remove_meta_boxes');




//
// Adiciona coluna na lista de posts
// 

/*
// Para CPT troque o post pelo slug	
function post_custom_columns( $columns ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'featured_image' => 'Imagem',
        'title' => 'Titulo',
        'categories' => 'Categoria',
        'tags' => 'Tags',
        'author' => 'Autor',
        'date' => 'Data'
     );
    return $columns;
}
add_filter('manage_post_posts_columns' , 'post_custom_columns');


function post_custom_columns_data( $column, $post_id ) {
    switch ( $column ) {
    case 'featured_image':
        echo '<a href="'.get_edit_post_link().'">';
        echo the_post_thumbnail( 'thumbnail' );
        echo '</a>';
        break;
    }
}
add_action( 'manage_post_posts_custom_column' , 'post_custom_columns_data', 10, 2 ); 

*/

/** Admin Slug Function */
function the_slug($echo=true){
	$slug = basename(get_permalink());
	do_action('before_slug', $slug);
	$slug = apply_filters('slug_filter', $slug);
	return $slug;
}


function wpb_set_post_views($postID) {
	$count_key = 'wpb_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return strip_tags($excerpt);
}

add_filter( 'pre_get_posts', 'be_archive_query' );
function be_archive_query( $query ) {

	if( $query->is_main_query() && $query->is_post_type_archive('autores') && !is_admin() ) {
		$query->set( 'posts_per_page', 12 );
	}
}



function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['pais'] = 'País';
	$profile_fields['profissao'] = 'Profissão';
	$profile_fields['outra_profissao'] = 'Outra Profissão';
	$profile_fields['escola'] = 'Escola';
	$profile_fields['ultimo_acesso'] = 'Último Acesso';
	$profile_fields['acessos'] = 'Acessos';
	$profile_fields['cadastro'] = 'Data do cadastro';
	$profile_fields['validacao'] = 'Email validado';

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');




$current_user = wp_get_current_user();
$acessos = ($current_user->acessos+1);

if(is_user_logged_in()){
	setcookie("biblioteca", 'acesso_permitido', time()+1800);
	if(isset($_COOKIE["biblioteca"])){}else{
	    update_user_meta( $current_user->ID, 'acessos', $acessos );
	}
		update_user_meta( $current_user->ID, 'ultimo_acesso', current_time("Y-m-d H:i:s") );
}	

/**
 * Add Shortcode lastlogin
 *
 */
  
add_shortcode('lastlogin','wpb_lastlogin');




// remove barra do admin
add_action('set_current_user', 'cc_hide_admin_bar');
function cc_hide_admin_bar() {
  if (!current_user_can('edit_posts')) {
    show_admin_bar(false);
  }
}

// remove acesso ao admin
add_action('init', 'block_dashboard');
function block_dashboard() {
    $file = basename($_SERVER['PHP_SELF']);
    if (is_user_logged_in() && is_admin() && !current_user_can('edit_posts') && $file != 'admin-ajax.php'){
		//return '<meta http-equiv="refresh" content="0; url=http://pedroprado.com.br/login/?login=failed" />';
    }
}



add_action("gform_user_registered", "autologin", 10, 4);
function autologin($user_id, $config, $entry, $password) {
    wp_set_auth_cookie($user_id, false, '');
}




add_action( 'init', 'artigos_post_type' );
add_action( 'init', 'autor_post_type' );


function artigos_post_type() {
	$labels = array(
		'name'               => _x( 'Articles', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Article', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Artigos', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Artigos', 'add new on admin bar', 'your-plugin-textdomain' ),
		);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-media-document',
		'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
		'rewrite' 			 => array('slug' => 'articles', 'with_front' => false)
		);

	register_post_type( 'artigos', $args );
}



function autor_post_type() {
	$labels = array(
		'name'               => _x( 'Authors', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Author', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Autores', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Autores', 'add new on admin bar', 'your-plugin-textdomain' ),
		);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-businessman',
		'supports'           => array('title'),
		'rewrite' 			 => array('slug' => 'authors', 'with_front' => false)
		
		);

	register_post_type( 'autores', $args );
}



add_action( 'init', 'create_tax_artigos' );

function create_tax_artigos() {
	register_taxonomy(
		'publicacao',
		'artigos',
		array(
			'label' => __( 'Publicações' ),
			'rewrite' => array( 'slug' => 'publicacao' ),
			'hierarchical' => true,
			)
		);

	register_taxonomy(
		'idioma',
		'artigos',
		array(
			'label' => __( 'Idioma' ),
			'rewrite' => array( 'slug' => 'idioma' ),
			'hierarchical' => true,
			)
		);
/// é necessário para o filtro
	register_taxonomy(
		'ano',
		'artigos',
		array(
			'label' => __( 'Data' ),
			'rewrite' => array( 'slug' => 'ano' ),
			'hierarchical' => true,
			)
		);
/*
		
	register_taxonomy(
		'mes',
		'artigos',
		array(
			'label' => __( 'Mês' ),
			'rewrite' => array( 'slug' => 'mes' ),
			'hierarchical' => true,
			)
		);
*/

}

function langcode_post_id($post_id){
    global $wpdb;
 
    $query = $wpdb->prepare('SELECT language_code FROM ' . $wpdb->prefix . 'icl_translations WHERE translation_id="%d"', $post_id);
    $query_exec = $wpdb->get_row($query);
 
    return $query_exec->language_code;
}



// mostra todos os posts mesmos os que não tiverem tradução
function remove_filters(){
	if(!is_admin()){
		global $sitepress;
		remove_filter( 'posts_where', array( $sitepress, 'posts_where_filter' ) );
		remove_filter( 'posts_join', array( $sitepress, 'posts_join_filter' ) );
	}
}
add_action('init','remove_filters');



// function and action to order classes alphabetically

function alpha_order_classes( $query ) {
    if ( $query->is_post_type_archive('autores') && $query->is_main_query() ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}

add_action( 'pre_get_posts', 'alpha_order_classes' );

function get_post_by_title($page_title, $post_type ='artigos' , $output = OBJECT) {
    global $wpdb;
        $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type= %s", $page_title, $post_type));
        if ( $post )
            return get_post($post, $output);

    return null;
}


// identificação antiga para art_aut = artigo_autor

$arr = array(array("id_art" => 1244,"id_aut" => 673), array("id_art" => 1242,"id_aut" => 672), array("id_art" => 1238,"id_aut" => 671), array("id_art" => 1238,"id_aut" => 670), array("id_art" => 1236,"id_aut" => 669), array("id_art" => 1235,"id_aut" => 668), array("id_art" => 1234,"id_aut" => 667), array("id_art" => 1206,"id_aut" => 666), array("id_art" => 1204,"id_aut" => 664), array("id_art" => 1457,"id_aut" => 663), array("id_art" => 1456,"id_aut" => 662), array("id_art" => 1453,"id_aut" => 661), array("id_art" => 1448,"id_aut" => 660), array("id_art" => 1445,"id_aut" => 659), array("id_art" => 1441,"id_aut" => 658), array("id_art" => 1442,"id_aut" => 657), array("id_art" => 1439,"id_aut" => 656), array("id_art" => 1435,"id_aut" => 655), array("id_art" => 1434,"id_aut" => 654), array("id_art" => 1433,"id_aut" => 653), array("id_art" => 1432,"id_aut" => 652), array("id_art" => 1428,"id_aut" => 651), array("id_art" => 1424,"id_aut" => 650), array("id_art" => 1406,"id_aut" => 648), array("id_art" => 1406,"id_aut" => 647), array("id_art" => 1405,"id_aut" => 646), array("id_art" => 1405,"id_aut" => 645), array("id_art" => 1404,"id_aut" => 644), array("id_art" => 1397,"id_aut" => 643), array("id_art" => 1396,"id_aut" => 642), array("id_art" => 1400,"id_aut" => 642), array("id_art" => 1347,"id_aut" => 641), array("id_art" => 1331,"id_aut" => 640), array("id_art" => 1331,"id_aut" => 639), array("id_art" => 1331,"id_aut" => 638), array("id_art" => 1445,"id_aut" => 638), array("id_art" => 1331,"id_aut" => 637), array("id_art" => 1329,"id_aut" => 636), array("id_art" => 1327,"id_aut" => 635), array("id_art" => 1325,"id_aut" => 634), array("id_art" => 1322,"id_aut" => 633), array("id_art" => 1449,"id_aut" => 633), array("id_art" => 1312,"id_aut" => 632), array("id_art" => 1311,"id_aut" => 631), array("id_art" => 1310,"id_aut" => 630), array("id_art" => 1309,"id_aut" => 629), array("id_art" => 1308,"id_aut" => 628), array("id_art" => 1302,"id_aut" => 627), array("id_art" => 1302,"id_aut" => 626), array("id_art" => 1301,"id_aut" => 625), array("id_art" => 1296,"id_aut" => 624), array("id_art" => 1334,"id_aut" => 624), array("id_art" => 1296,"id_aut" => 623), array("id_art" => 1295,"id_aut" => 622), array("id_art" => 1293,"id_aut" => 621), array("id_art" => 1261,"id_aut" => 620), array("id_art" => 1259,"id_aut" => 619), array("id_art" => 1248,"id_aut" => 618), array("id_art" => 1231,"id_aut" => 616), array("id_art" => 1229,"id_aut" => 615), array("id_art" => 1228,"id_aut" => 614), array("id_art" => 1268,"id_aut" => 614), array("id_art" => 1228,"id_aut" => 613), array("id_art" => 1227,"id_aut" => 612), array("id_art" => 1228,"id_aut" => 612), array("id_art" => 1230,"id_aut" => 612), array("id_art" => 1348,"id_aut" => 612), array("id_art" => 1228,"id_aut" => 611), array("id_art" => 1265,"id_aut" => 611), array("id_art" => 1223,"id_aut" => 610), array("id_art" => 1220,"id_aut" => 609), array("id_art" => 1218,"id_aut" => 608), array("id_art" => 1215,"id_aut" => 607), array("id_art" => 1195,"id_aut" => 606), array("id_art" => 1193,"id_aut" => 605), array("id_art" => 1187,"id_aut" => 604), array("id_art" => 1186,"id_aut" => 603), array("id_art" => 1184,"id_aut" => 602), array("id_art" => 1183,"id_aut" => 601), array("id_art" => 1180,"id_aut" => 600), array("id_art" => 1202,"id_aut" => 600), array("id_art" => 1178,"id_aut" => 599), array("id_art" => 1398,"id_aut" => 599), array("id_art" => 1172,"id_aut" => 598), array("id_art" => 1389,"id_aut" => 598), array("id_art" => 1169,"id_aut" => 597), array("id_art" => 1371,"id_aut" => 597), array("id_art" => 1163,"id_aut" => 596), array("id_art" => 1175,"id_aut" => 596), array("id_art" => 1161,"id_aut" => 595), array("id_art" => 1160,"id_aut" => 594), array("id_art" => 1159,"id_aut" => 593), array("id_art" => 1158,"id_aut" => 592), array("id_art" => 1157,"id_aut" => 591), array("id_art" => 1155,"id_aut" => 590), array("id_art" => 1154,"id_aut" => 589), array("id_art" => 1153,"id_aut" => 588), array("id_art" => 1151,"id_aut" => 587), array("id_art" => 1287,"id_aut" => 587), array("id_art" => 1147,"id_aut" => 586), array("id_art" => 1139,"id_aut" => 585), array("id_art" => 1135,"id_aut" => 584), array("id_art" => 1136,"id_aut" => 584), array("id_art" => 1129,"id_aut" => 583), array("id_art" => 1213,"id_aut" => 583), array("id_art" => 1221,"id_aut" => 583), array("id_art" => 1294,"id_aut" => 583), array("id_art" => 1321,"id_aut" => 583), array("id_art" => 1331,"id_aut" => 583), array("id_art" => 1125,"id_aut" => 582), array("id_art" => 1390,"id_aut" => 582), array("id_art" => 1122,"id_aut" => 581), array("id_art" => 1381,"id_aut" => 581), array("id_art" => 1119,"id_aut" => 580), array("id_art" => 1386,"id_aut" => 580), array("id_art" => 1118,"id_aut" => 579), array("id_art" => 1379,"id_aut" => 579), array("id_art" => 1115,"id_aut" => 578), array("id_art" => 1141,"id_aut" => 578), array("id_art" => 1384,"id_aut" => 578), array("id_art" => 1400,"id_aut" => 578), array("id_art" => 1406,"id_aut" => 578), array("id_art" => 1109,"id_aut" => 577), array("id_art" => 1105,"id_aut" => 576), array("id_art" => 1150,"id_aut" => 576), array("id_art" => 1347,"id_aut" => 576), array("id_art" => 1104,"id_aut" => 575), array("id_art" => 1099,"id_aut" => 574), array("id_art" => 1096,"id_aut" => 573), array("id_art" => 1101,"id_aut" => 573), array("id_art" => 1165,"id_aut" => 573), array("id_art" => 1167,"id_aut" => 573), array("id_art" => 1191,"id_aut" => 573), array("id_art" => 1228,"id_aut" => 573), array("id_art" => 1250,"id_aut" => 573), array("id_art" => 1267,"id_aut" => 573), array("id_art" => 1289,"id_aut" => 573), array("id_art" => 1350,"id_aut" => 573), array("id_art" => 1096,"id_aut" => 572), array("id_art" => 1096,"id_aut" => 571), array("id_art" => 1313,"id_aut" => 571), array("id_art" => 1092,"id_aut" => 570), array("id_art" => 1137,"id_aut" => 570), array("id_art" => 1083,"id_aut" => 569), array("id_art" => 1082,"id_aut" => 568), array("id_art" => 749,"id_aut" => 567), array("id_art" => 749,"id_aut" => 565), array("id_art" => 1084,"id_aut" => 565), array("id_art" => 749,"id_aut" => 564), array("id_art" => 750,"id_aut" => 563), array("id_art" => 750,"id_aut" => 562), array("id_art" => 750,"id_aut" => 561), array("id_art" => 750,"id_aut" => 560), array("id_art" => 750,"id_aut" => 559), array("id_art" => 750,"id_aut" => 558), array("id_art" => 750,"id_aut" => 557), array("id_art" => 750,"id_aut" => 556), array("id_art" => 934,"id_aut" => 555), array("id_art" => 934,"id_aut" => 554), array("id_art" => 934,"id_aut" => 553), array("id_art" => 934,"id_aut" => 552), array("id_art" => 934,"id_aut" => 551), array("id_art" => 934,"id_aut" => 550), array("id_art" => 934,"id_aut" => 549), array("id_art" => 934,"id_aut" => 548), array("id_art" => 1008,"id_aut" => 547), array("id_art" => 1081,"id_aut" => 547), array("id_art" => 1008,"id_aut" => 546), array("id_art" => 1008,"id_aut" => 545), array("id_art" => 1008,"id_aut" => 544), array("id_art" => 1077,"id_aut" => 543), array("id_art" => 1209,"id_aut" => 543), array("id_art" => 1297,"id_aut" => 543), array("id_art" => 1448,"id_aut" => 543), array("id_art" => 1076,"id_aut" => 542), array("id_art" => 1075,"id_aut" => 541), array("id_art" => 1080,"id_aut" => 541), array("id_art" => 1232,"id_aut" => 541), array("id_art" => 1331,"id_aut" => 541), array("id_art" => 1445,"id_aut" => 541), array("id_art" => 1068,"id_aut" => 540), array("id_art" => 1068,"id_aut" => 539), array("id_art" => 1067,"id_aut" => 538), array("id_art" => 1063,"id_aut" => 536), array("id_art" => 1057,"id_aut" => 535), array("id_art" => 1086,"id_aut" => 535), array("id_art" => 1133,"id_aut" => 535), array("id_art" => 1142,"id_aut" => 535), array("id_art" => 1052,"id_aut" => 534), array("id_art" => 1051,"id_aut" => 533), array("id_art" => 1050,"id_aut" => 532), array("id_art" => 1197,"id_aut" => 532), array("id_art" => 1262,"id_aut" => 532), array("id_art" => 1320,"id_aut" => 532), array("id_art" => 1049,"id_aut" => 531), array("id_art" => 1025,"id_aut" => 530), array("id_art" => 1021,"id_aut" => 529), array("id_art" => 934,"id_aut" => 528), array("id_art" => 984,"id_aut" => 528), array("id_art" => 934,"id_aut" => 527), array("id_art" => 984,"id_aut" => 527), array("id_art" => 1012,"id_aut" => 526), array("id_art" => 1011,"id_aut" => 525), array("id_art" => 1010,"id_aut" => 524), array("id_art" => 1005,"id_aut" => 523), array("id_art" => 1008,"id_aut" => 523), array("id_art" => 1095,"id_aut" => 523), array("id_art" => 1096,"id_aut" => 523), array("id_art" => 1100,"id_aut" => 523), array("id_art" => 1346,"id_aut" => 523), array("id_art" => 990,"id_aut" => 522), array("id_art" => 1114,"id_aut" => 522), array("id_art" => 1383,"id_aut" => 522), array("id_art" => 990,"id_aut" => 521), array("id_art" => 1114,"id_aut" => 521), array("id_art" => 1383,"id_aut" => 521), array("id_art" => 1443,"id_aut" => 521), array("id_art" => 995,"id_aut" => 520), array("id_art" => 996,"id_aut" => 519), array("id_art" => 1170,"id_aut" => 519), array("id_art" => 1372,"id_aut" => 519), array("id_art" => 1426,"id_aut" => 519), array("id_art" => 997,"id_aut" => 518), array("id_art" => 998,"id_aut" => 517), array("id_art" => 1014,"id_aut" => 517), array("id_art" => 1402,"id_aut" => 517), array("id_art" => 1430,"id_aut" => 517), array("id_art" => 1000,"id_aut" => 516), array("id_art" => 989,"id_aut" => 515), array("id_art" => 1403,"id_aut" => 515), array("id_art" => 985,"id_aut" => 514), array("id_art" => 980,"id_aut" => 513), array("id_art" => 975,"id_aut" => 512), array("id_art" => 974,"id_aut" => 511), array("id_art" => 1113,"id_aut" => 511), array("id_art" => 1382,"id_aut" => 511), array("id_art" => 1425,"id_aut" => 511), array("id_art" => 965,"id_aut" => 510), array("id_art" => 972,"id_aut" => 509), array("id_art" => 972,"id_aut" => 508), array("id_art" => 973,"id_aut" => 508), array("id_art" => 969,"id_aut" => 507), array("id_art" => 967,"id_aut" => 506), array("id_art" => 966,"id_aut" => 504), array("id_art" => 966,"id_aut" => 503), array("id_art" => 955,"id_aut" => 499), array("id_art" => 967,"id_aut" => 499), array("id_art" => 1130,"id_aut" => 499), array("id_art" => 1182,"id_aut" => 499), array("id_art" => 1203,"id_aut" => 499), array("id_art" => 1216,"id_aut" => 499), array("id_art" => 1299,"id_aut" => 499), array("id_art" => 954,"id_aut" => 498), array("id_art" => 952,"id_aut" => 497), array("id_art" => 1047,"id_aut" => 497), array("id_art" => 1057,"id_aut" => 497), array("id_art" => 1105,"id_aut" => 497), array("id_art" => 1152,"id_aut" => 497), array("id_art" => 1165,"id_aut" => 497), array("id_art" => 948,"id_aut" => 496), array("id_art" => 961,"id_aut" => 496), array("id_art" => 991,"id_aut" => 496), array("id_art" => 1224,"id_aut" => 496), array("id_art" => 1431,"id_aut" => 496), array("id_art" => 943,"id_aut" => 495), array("id_art" => 942,"id_aut" => 494), array("id_art" => 941,"id_aut" => 493), array("id_art" => 1438,"id_aut" => 493), array("id_art" => 940,"id_aut" => 491), array("id_art" => 939,"id_aut" => 490), array("id_art" => 1324,"id_aut" => 490), array("id_art" => 938,"id_aut" => 488), array("id_art" => 937,"id_aut" => 487), array("id_art" => 936,"id_aut" => 486), array("id_art" => 1445,"id_aut" => 486), array("id_art" => 935,"id_aut" => 485), array("id_art" => 1086,"id_aut" => 485), array("id_art" => 1142,"id_aut" => 485), array("id_art" => 1220,"id_aut" => 485), array("id_art" => 1251,"id_aut" => 485), array("id_art" => 1331,"id_aut" => 485), array("id_art" => 1445,"id_aut" => 485), array("id_art" => 933,"id_aut" => 484), array("id_art" => 926,"id_aut" => 482), array("id_art" => 924,"id_aut" => 481), array("id_art" => 911,"id_aut" => 480), array("id_art" => 209,"id_aut" => 477), array("id_art" => 900,"id_aut" => 476), array("id_art" => 896,"id_aut" => 471), array("id_art" => 934,"id_aut" => 471), array("id_art" => 984,"id_aut" => 471), array("id_art" => 895,"id_aut" => 470), array("id_art" => 1107,"id_aut" => 470), array("id_art" => 892,"id_aut" => 468), array("id_art" => 1002,"id_aut" => 468), array("id_art" => 1103,"id_aut" => 468), array("id_art" => 883,"id_aut" => 467), array("id_art" => 882,"id_aut" => 466), array("id_art" => 886,"id_aut" => 466), array("id_art" => 878,"id_aut" => 464), array("id_art" => 976,"id_aut" => 464), array("id_art" => 878,"id_aut" => 463), array("id_art" => 976,"id_aut" => 463), array("id_art" => 878,"id_aut" => 462), array("id_art" => 976,"id_aut" => 462), array("id_art" => 878,"id_aut" => 461), array("id_art" => 976,"id_aut" => 461), array("id_art" => 875,"id_aut" => 460), array("id_art" => 874,"id_aut" => 459), array("id_art" => 873,"id_aut" => 458), array("id_art" => 986,"id_aut" => 458), array("id_art" => 1148,"id_aut" => 458), array("id_art" => 837,"id_aut" => 456), array("id_art" => 856,"id_aut" => 455), array("id_art" => 855,"id_aut" => 453), array("id_art" => 851,"id_aut" => 452), array("id_art" => 952,"id_aut" => 452), array("id_art" => 962,"id_aut" => 452), array("id_art" => 1092,"id_aut" => 452), array("id_art" => 851,"id_aut" => 451), array("id_art" => 849,"id_aut" => 450), array("id_art" => 962,"id_aut" => 450), array("id_art" => 993,"id_aut" => 450), array("id_art" => 1057,"id_aut" => 450), array("id_art" => 1060,"id_aut" => 450), array("id_art" => 1116,"id_aut" => 450), array("id_art" => 1331,"id_aut" => 450), array("id_art" => 1373,"id_aut" => 450), array("id_art" => 1445,"id_aut" => 450), array("id_art" => 847,"id_aut" => 448), array("id_art" => 1236,"id_aut" => 448), array("id_art" => 846,"id_aut" => 447), array("id_art" => 1330,"id_aut" => 447), array("id_art" => 842,"id_aut" => 446), array("id_art" => 842,"id_aut" => 445), array("id_art" => 838,"id_aut" => 444), array("id_art" => 834,"id_aut" => 443), array("id_art" => 828,"id_aut" => 442), array("id_art" => 828,"id_aut" => 441), array("id_art" => 823,"id_aut" => 440), array("id_art" => 821,"id_aut" => 439), array("id_art" => 965,"id_aut" => 439), array("id_art" => 977,"id_aut" => 439), array("id_art" => 820,"id_aut" => 438), array("id_art" => 818,"id_aut" => 437), array("id_art" => 817,"id_aut" => 436), array("id_art" => 848,"id_aut" => 436), array("id_art" => 1171,"id_aut" => 436), array("id_art" => 1376,"id_aut" => 436), array("id_art" => 1454,"id_aut" => 436), array("id_art" => 813,"id_aut" => 435), array("id_art" => 813,"id_aut" => 434), array("id_art" => 811,"id_aut" => 433), array("id_art" => 811,"id_aut" => 432), array("id_art" => 806,"id_aut" => 431), array("id_art" => 930,"id_aut" => 431), array("id_art" => 1222,"id_aut" => 431), array("id_art" => 805,"id_aut" => 430), array("id_art" => 1323,"id_aut" => 430), array("id_art" => 1450,"id_aut" => 430), array("id_art" => 800,"id_aut" => 429), array("id_art" => 1168,"id_aut" => 429), array("id_art" => 1225,"id_aut" => 429), array("id_art" => 791,"id_aut" => 428), array("id_art" => 792,"id_aut" => 428), array("id_art" => 1111,"id_aut" => 428), array("id_art" => 1179,"id_aut" => 428), array("id_art" => 780,"id_aut" => 427), array("id_art" => 932,"id_aut" => 427), array("id_art" => 1053,"id_aut" => 427), array("id_art" => 1070,"id_aut" => 427), array("id_art" => 1132,"id_aut" => 427), array("id_art" => 1142,"id_aut" => 427), array("id_art" => 1447,"id_aut" => 427), array("id_art" => 767,"id_aut" => 426), array("id_art" => 688,"id_aut" => 425), array("id_art" => 808,"id_aut" => 425), array("id_art" => 673,"id_aut" => 424), array("id_art" => 673,"id_aut" => 423), array("id_art" => 666,"id_aut" => 421), array("id_art" => 666,"id_aut" => 420), array("id_art" => 927,"id_aut" => 420), array("id_art" => 666,"id_aut" => 418), array("id_art" => 966,"id_aut" => 418), array("id_art" => 666,"id_aut" => 417), array("id_art" => 779,"id_aut" => 417), array("id_art" => 940,"id_aut" => 417), array("id_art" => 1108,"id_aut" => 417), array("id_art" => 1445,"id_aut" => 417), array("id_art" => 1453,"id_aut" => 417), array("id_art" => 666,"id_aut" => 416), array("id_art" => 666,"id_aut" => 415), array("id_art" => 979,"id_aut" => 415), array("id_art" => 666,"id_aut" => 414), array("id_art" => 787,"id_aut" => 414), array("id_art" => 945,"id_aut" => 414), array("id_art" => 666,"id_aut" => 413), array("id_art" => 666,"id_aut" => 411), array("id_art" => 664,"id_aut" => 409), array("id_art" => 666,"id_aut" => 409), array("id_art" => 593,"id_aut" => 407), array("id_art" => 577,"id_aut" => 406), array("id_art" => 453,"id_aut" => 405), array("id_art" => 749,"id_aut" => 405), array("id_art" => 527,"id_aut" => 404), array("id_art" => 605,"id_aut" => 404), array("id_art" => 404,"id_aut" => 403), array("id_art" => 404,"id_aut" => 402), array("id_art" => 400,"id_aut" => 401), array("id_art" => 170,"id_aut" => 400), array("id_art" => 190,"id_aut" => 400), array("id_art" => 157,"id_aut" => 399), array("id_art" => 757,"id_aut" => 398), array("id_art" => 1257,"id_aut" => 398), array("id_art" => 1452,"id_aut" => 398), array("id_art" => 753,"id_aut" => 397), array("id_art" => 783,"id_aut" => 397), array("id_art" => 784,"id_aut" => 397), array("id_art" => 786,"id_aut" => 397), array("id_art" => 740,"id_aut" => 393), array("id_art" => 1156,"id_aut" => 393), array("id_art" => 739,"id_aut" => 392), array("id_art" => 744,"id_aut" => 392), array("id_art" => 760,"id_aut" => 392), array("id_art" => 736,"id_aut" => 391), array("id_art" => 763,"id_aut" => 391), array("id_art" => 859,"id_aut" => 391), array("id_art" => 734,"id_aut" => 390), array("id_art" => 742,"id_aut" => 390), array("id_art" => 761,"id_aut" => 390), array("id_art" => 766,"id_aut" => 390), array("id_art" => 881,"id_aut" => 390), array("id_art" => 885,"id_aut" => 390), array("id_art" => 891,"id_aut" => 390), array("id_art" => 899,"id_aut" => 390), array("id_art" => 900,"id_aut" => 390), array("id_art" => 970,"id_aut" => 390), array("id_art" => 1004,"id_aut" => 390), array("id_art" => 1009,"id_aut" => 390), array("id_art" => 1126,"id_aut" => 390), array("id_art" => 1380,"id_aut" => 390), array("id_art" => 732,"id_aut" => 389), array("id_art" => 871,"id_aut" => 389), array("id_art" => 889,"id_aut" => 389), array("id_art" => 1331,"id_aut" => 389), array("id_art" => 1445,"id_aut" => 389), array("id_art" => 731,"id_aut" => 388), array("id_art" => 321,"id_aut" => 387), array("id_art" => 731,"id_aut" => 387), array("id_art" => 733,"id_aut" => 387), array("id_art" => 735,"id_aut" => 387), array("id_art" => 737,"id_aut" => 387), array("id_art" => 738,"id_aut" => 387), array("id_art" => 764,"id_aut" => 387), array("id_art" => 807,"id_aut" => 387), array("id_art" => 876,"id_aut" => 387), array("id_art" => 1006,"id_aut" => 387), array("id_art" => 724,"id_aut" => 384), array("id_art" => 721,"id_aut" => 381), array("id_art" => 722,"id_aut" => 381), array("id_art" => 728,"id_aut" => 381), array("id_art" => 746,"id_aut" => 381), array("id_art" => 832,"id_aut" => 381), array("id_art" => 934,"id_aut" => 381), array("id_art" => 984,"id_aut" => 381), array("id_art" => 1007,"id_aut" => 381), array("id_art" => 1166,"id_aut" => 381), array("id_art" => 1266,"id_aut" => 381), array("id_art" => 716,"id_aut" => 380), array("id_art" => 707,"id_aut" => 375), array("id_art" => 707,"id_aut" => 374), array("id_art" => 707,"id_aut" => 373), array("id_art" => 704,"id_aut" => 372), array("id_art" => 701,"id_aut" => 371), array("id_art" => 756,"id_aut" => 371), array("id_art" => 688,"id_aut" => 370), array("id_art" => 1047,"id_aut" => 370), array("id_art" => 1134,"id_aut" => 370), array("id_art" => 1254,"id_aut" => 370), array("id_art" => 1291,"id_aut" => 370), array("id_art" => 1331,"id_aut" => 370), array("id_art" => 688,"id_aut" => 369), array("id_art" => 687,"id_aut" => 368), array("id_art" => 685,"id_aut" => 367), array("id_art" => 664,"id_aut" => 366), array("id_art" => 662,"id_aut" => 365), array("id_art" => 661,"id_aut" => 364), array("id_art" => 694,"id_aut" => 364), array("id_art" => 848,"id_aut" => 364), array("id_art" => 1047,"id_aut" => 364), array("id_art" => 1331,"id_aut" => 364), array("id_art" => 1445,"id_aut" => 364), array("id_art" => 659,"id_aut" => 363), array("id_art" => 658,"id_aut" => 362), array("id_art" => 793,"id_aut" => 362), array("id_art" => 834,"id_aut" => 362), array("id_art" => 638,"id_aut" => 360), array("id_art" => 666,"id_aut" => 360), array("id_art" => 679,"id_aut" => 360), array("id_art" => 637,"id_aut" => 359), array("id_art" => 620,"id_aut" => 358), array("id_art" => 620,"id_aut" => 357), array("id_art" => 666,"id_aut" => 357), array("id_art" => 782,"id_aut" => 357), array("id_art" => 1260,"id_aut" => 357), array("id_art" => 615,"id_aut" => 356), array("id_art" => 609,"id_aut" => 355), array("id_art" => 560,"id_aut" => 354), array("id_art" => 560,"id_aut" => 353), array("id_art" => 560,"id_aut" => 352), array("id_art" => 560,"id_aut" => 351), array("id_art" => 560,"id_aut" => 350), array("id_art" => 560,"id_aut" => 349), array("id_art" => 560,"id_aut" => 348), array("id_art" => 560,"id_aut" => 347), array("id_art" => 554,"id_aut" => 345), array("id_art" => 552,"id_aut" => 344), array("id_art" => 557,"id_aut" => 344), array("id_art" => 578,"id_aut" => 344), array("id_art" => 696,"id_aut" => 344), array("id_art" => 755,"id_aut" => 344), array("id_art" => 548,"id_aut" => 343), array("id_art" => 538,"id_aut" => 342), array("id_art" => 538,"id_aut" => 341), array("id_art" => 966,"id_aut" => 341), array("id_art" => 535,"id_aut" => 340), array("id_art" => 542,"id_aut" => 340), array("id_art" => 567,"id_aut" => 340), array("id_art" => 580,"id_aut" => 340), array("id_art" => 754,"id_aut" => 340), array("id_art" => 843,"id_aut" => 340), array("id_art" => 916,"id_aut" => 340), array("id_art" => 918,"id_aut" => 340), array("id_art" => 1090,"id_aut" => 340), array("id_art" => 533,"id_aut" => 339), array("id_art" => 530,"id_aut" => 338), array("id_art" => 525,"id_aut" => 337), array("id_art" => 511,"id_aut" => 336), array("id_art" => 499,"id_aut" => 335), array("id_art" => 925,"id_aut" => 335), array("id_art" => 1292,"id_aut" => 335), array("id_art" => 1331,"id_aut" => 335), array("id_art" => 1333,"id_aut" => 335), array("id_art" => 495,"id_aut" => 334), array("id_art" => 492,"id_aut" => 332), array("id_art" => 13,"id_aut" => 331), array("id_art" => 485,"id_aut" => 330), array("id_art" => 478,"id_aut" => 329), array("id_art" => 364,"id_aut" => 328), array("id_art" => 477,"id_aut" => 328), array("id_art" => 829,"id_aut" => 328), array("id_art" => 958,"id_aut" => 328), array("id_art" => 985,"id_aut" => 328), array("id_art" => 1142,"id_aut" => 328), array("id_art" => 1299,"id_aut" => 328), array("id_art" => 473,"id_aut" => 327), array("id_art" => 467,"id_aut" => 326), array("id_art" => 402,"id_aut" => 325), array("id_art" => 398,"id_aut" => 324), array("id_art" => 848,"id_aut" => 324), array("id_art" => 1171,"id_aut" => 324), array("id_art" => 1376,"id_aut" => 324), array("id_art" => 398,"id_aut" => 323), array("id_art" => 363,"id_aut" => 322), array("id_art" => 383,"id_aut" => 322), array("id_art" => 1082,"id_aut" => 322), array("id_art" => 1083,"id_aut" => 322), array("id_art" => 347,"id_aut" => 321), array("id_art" => 532,"id_aut" => 321), array("id_art" => 340,"id_aut" => 320), array("id_art" => 345,"id_aut" => 320), array("id_art" => 339,"id_aut" => 319), array("id_art" => 724,"id_aut" => 319), array("id_art" => 932,"id_aut" => 319), array("id_art" => 1393,"id_aut" => 319), array("id_art" => 321,"id_aut" => 317), array("id_art" => 313,"id_aut" => 316), array("id_art" => 296,"id_aut" => 315), array("id_art" => 289,"id_aut" => 314), array("id_art" => 705,"id_aut" => 314), array("id_art" => 288,"id_aut" => 313), array("id_art" => 280,"id_aut" => 312), array("id_art" => 279,"id_aut" => 311), array("id_art" => 731,"id_aut" => 311), array("id_art" => 279,"id_aut" => 310), array("id_art" => 273,"id_aut" => 309), array("id_art" => 267,"id_aut" => 308), array("id_art" => 249,"id_aut" => 306), array("id_art" => 244,"id_aut" => 305), array("id_art" => 243,"id_aut" => 304), array("id_art" => 239,"id_aut" => 303), array("id_art" => 237,"id_aut" => 301), array("id_art" => 236,"id_aut" => 300), array("id_art" => 234,"id_aut" => 299), array("id_art" => 232,"id_aut" => 298), array("id_art" => 391,"id_aut" => 298), array("id_art" => 231,"id_aut" => 297), array("id_art" => 231,"id_aut" => 296), array("id_art" => 229,"id_aut" => 295), array("id_art" => 228,"id_aut" => 294), array("id_art" => 227,"id_aut" => 293), array("id_art" => 225,"id_aut" => 292), array("id_art" => 836,"id_aut" => 291), array("id_art" => 278,"id_aut" => 290), array("id_art" => 836,"id_aut" => 290), array("id_art" => 966,"id_aut" => 290), array("id_art" => 218,"id_aut" => 288), array("id_art" => 217,"id_aut" => 287), array("id_art" => 215,"id_aut" => 286), array("id_art" => 215,"id_aut" => 285), array("id_art" => 983,"id_aut" => 285), array("id_art" => 215,"id_aut" => 284), array("id_art" => 214,"id_aut" => 283), array("id_art" => 219,"id_aut" => 283), array("id_art" => 206,"id_aut" => 279), array("id_art" => 203,"id_aut" => 278), array("id_art" => 201,"id_aut" => 277), array("id_art" => 201,"id_aut" => 276), array("id_art" => 707,"id_aut" => 276), array("id_art" => 710,"id_aut" => 276), array("id_art" => 200,"id_aut" => 275), array("id_art" => 199,"id_aut" => 274), array("id_art" => 194,"id_aut" => 273), array("id_art" => 189,"id_aut" => 272), array("id_art" => 188,"id_aut" => 271), array("id_art" => 396,"id_aut" => 271), array("id_art" => 533,"id_aut" => 271), array("id_art" => 537,"id_aut" => 271), array("id_art" => 538,"id_aut" => 271), array("id_art" => 714,"id_aut" => 271), array("id_art" => 187,"id_aut" => 270), array("id_art" => 205,"id_aut" => 270), array("id_art" => 264,"id_aut" => 270), array("id_art" => 184,"id_aut" => 268), array("id_art" => 181,"id_aut" => 265), array("id_art" => 707,"id_aut" => 264), array("id_art" => 175,"id_aut" => 263), array("id_art" => 169,"id_aut" => 261), array("id_art" => 167,"id_aut" => 260), array("id_art" => 204,"id_aut" => 260), array("id_art" => 858,"id_aut" => 260), array("id_art" => 164,"id_aut" => 259), array("id_art" => 163,"id_aut" => 258), array("id_art" => 155,"id_aut" => 255), array("id_art" => 154,"id_aut" => 254), array("id_art" => 153,"id_aut" => 253), array("id_art" => 161,"id_aut" => 253), array("id_art" => 168,"id_aut" => 253), array("id_art" => 180,"id_aut" => 253), array("id_art" => 151,"id_aut" => 252), array("id_art" => 144,"id_aut" => 250), array("id_art" => 141,"id_aut" => 249), array("id_art" => 138,"id_aut" => 248), array("id_art" => 137,"id_aut" => 247), array("id_art" => 136,"id_aut" => 246), array("id_art" => 576,"id_aut" => 246), array("id_art" => 133,"id_aut" => 245), array("id_art" => 758,"id_aut" => 244), array("id_art" => 126,"id_aut" => 243), array("id_art" => 121,"id_aut" => 242), array("id_art" => 119,"id_aut" => 241), array("id_art" => 195,"id_aut" => 240), array("id_art" => 115,"id_aut" => 239), array("id_art" => 114,"id_aut" => 238), array("id_art" => 113,"id_aut" => 237), array("id_art" => 109,"id_aut" => 234), array("id_art" => 110,"id_aut" => 234), array("id_art" => 107,"id_aut" => 233), array("id_art" => 106,"id_aut" => 232), array("id_art" => 104,"id_aut" => 231), array("id_art" => 101,"id_aut" => 230), array("id_art" => 100,"id_aut" => 229), array("id_art" => 96,"id_aut" => 227), array("id_art" => 95,"id_aut" => 226), array("id_art" => 94,"id_aut" => 225), array("id_art" => 93,"id_aut" => 224), array("id_art" => 90,"id_aut" => 223), array("id_art" => 968,"id_aut" => 223), array("id_art" => 89,"id_aut" => 222), array("id_art" => 85,"id_aut" => 220), array("id_art" => 82,"id_aut" => 219), array("id_art" => 81,"id_aut" => 218), array("id_art" => 81,"id_aut" => 217), array("id_art" => 75,"id_aut" => 213), array("id_art" => 74,"id_aut" => 212), array("id_art" => 73,"id_aut" => 211), array("id_art" => 72,"id_aut" => 210), array("id_art" => 66,"id_aut" => 209), array("id_art" => 66,"id_aut" => 208), array("id_art" => 266,"id_aut" => 202), array("id_art" => 708,"id_aut" => 202), array("id_art" => 709,"id_aut" => 202), array("id_art" => 712,"id_aut" => 202), array("id_art" => 785,"id_aut" => 202), array("id_art" => 35,"id_aut" => 199), array("id_art" => 655,"id_aut" => 198), array("id_art" => 824,"id_aut" => 198), array("id_art" => 984,"id_aut" => 198), array("id_art" => 1094,"id_aut" => 198), array("id_art" => 1098,"id_aut" => 198), array("id_art" => 1258,"id_aut" => 198), array("id_art" => 1356,"id_aut" => 198), array("id_art" => 650,"id_aut" => 196), array("id_art" => 994,"id_aut" => 195), array("id_art" => 1089,"id_aut" => 195), array("id_art" => 1319,"id_aut" => 195), array("id_art" => 241,"id_aut" => 194), array("id_art" => 641,"id_aut" => 194), array("id_art" => 1335,"id_aut" => 194), array("id_art" => 614,"id_aut" => 193), array("id_art" => 666,"id_aut" => 193), array("id_art" => 697,"id_aut" => 193), array("id_art" => 1298,"id_aut" => 193), array("id_art" => 623,"id_aut" => 191), array("id_art" => 623,"id_aut" => 190), array("id_art" => 610,"id_aut" => 189), array("id_art" => 789,"id_aut" => 189), array("id_art" => 810,"id_aut" => 189), array("id_art" => 837,"id_aut" => 189), array("id_art" => 851,"id_aut" => 189), array("id_art" => 947,"id_aut" => 189), array("id_art" => 968,"id_aut" => 189), array("id_art" => 983,"id_aut" => 189), array("id_art" => 1204,"id_aut" => 189), array("id_art" => 1236,"id_aut" => 189), array("id_art" => 1256,"id_aut" => 189), array("id_art" => 1294,"id_aut" => 189), array("id_art" => 1300,"id_aut" => 189), array("id_art" => 1448,"id_aut" => 189), array("id_art" => 1454,"id_aut" => 189), array("id_art" => 1455,"id_aut" => 189), array("id_art" => 654,"id_aut" => 187), array("id_art" => 660,"id_aut" => 187), array("id_art" => 1121,"id_aut" => 187), array("id_art" => 1241,"id_aut" => 187), array("id_art" => 1377,"id_aut" => 187), array("id_art" => 615,"id_aut" => 186), array("id_art" => 616,"id_aut" => 186), array("id_art" => 813,"id_aut" => 186), array("id_art" => 866,"id_aut" => 186), array("id_art" => 1251,"id_aut" => 186), array("id_art" => 1395,"id_aut" => 186), array("id_art" => 1437,"id_aut" => 186), array("id_art" => 1445,"id_aut" => 186), array("id_art" => 590,"id_aut" => 185), array("id_art" => 629,"id_aut" => 185), array("id_art" => 622,"id_aut" => 184), array("id_art" => 627,"id_aut" => 184), array("id_art" => 573,"id_aut" => 183), array("id_art" => 566,"id_aut" => 181), array("id_art" => 595,"id_aut" => 180), array("id_art" => 658,"id_aut" => 180), array("id_art" => 718,"id_aut" => 180), array("id_art" => 729,"id_aut" => 180), array("id_art" => 741,"id_aut" => 180), array("id_art" => 759,"id_aut" => 180), array("id_art" => 778,"id_aut" => 180), array("id_art" => 819,"id_aut" => 180), array("id_art" => 863,"id_aut" => 180), array("id_art" => 1147,"id_aut" => 180), array("id_art" => 1195,"id_aut" => 180), array("id_art" => 595,"id_aut" => 179), array("id_art" => 693,"id_aut" => 179), array("id_art" => 717,"id_aut" => 179), array("id_art" => 718,"id_aut" => 179), array("id_art" => 730,"id_aut" => 179), array("id_art" => 741,"id_aut" => 179), array("id_art" => 887,"id_aut" => 179), array("id_art" => 962,"id_aut" => 179), array("id_art" => 1007,"id_aut" => 179), array("id_art" => 1057,"id_aut" => 179), array("id_art" => 1058,"id_aut" => 179), array("id_art" => 1069,"id_aut" => 179), array("id_art" => 1072,"id_aut" => 179), array("id_art" => 1097,"id_aut" => 179), array("id_art" => 1102,"id_aut" => 179), array("id_art" => 1105,"id_aut" => 179), array("id_art" => 1149,"id_aut" => 179), array("id_art" => 1164,"id_aut" => 179), array("id_art" => 1190,"id_aut" => 179), array("id_art" => 1227,"id_aut" => 179), array("id_art" => 1331,"id_aut" => 179), array("id_art" => 1391,"id_aut" => 179), array("id_art" => 270,"id_aut" => 178), array("id_art" => 602,"id_aut" => 178), array("id_art" => 624,"id_aut" => 178), array("id_art" => 673,"id_aut" => 178), array("id_art" => 783,"id_aut" => 178), array("id_art" => 1117,"id_aut" => 178), array("id_art" => 1375,"id_aut" => 178), array("id_art" => 1395,"id_aut" => 178), array("id_art" => 1440,"id_aut" => 178), array("id_art" => 601,"id_aut" => 177), array("id_art" => 830,"id_aut" => 177), array("id_art" => 946,"id_aut" => 177), array("id_art" => 1219,"id_aut" => 177), array("id_art" => 599,"id_aut" => 175), array("id_art" => 673,"id_aut" => 175), array("id_art" => 956,"id_aut" => 175), array("id_art" => 992,"id_aut" => 175), array("id_art" => 1091,"id_aut" => 175), array("id_art" => 1140,"id_aut" => 175), array("id_art" => 1263,"id_aut" => 175), array("id_art" => 597,"id_aut" => 174), array("id_art" => 579,"id_aut" => 173), array("id_art" => 588,"id_aut" => 171), array("id_art" => 587,"id_aut" => 170), array("id_art" => 585,"id_aut" => 169), array("id_art" => 532,"id_aut" => 168), array("id_art" => 582,"id_aut" => 168), array("id_art" => 110,"id_aut" => 167), array("id_art" => 201,"id_aut" => 167), array("id_art" => 283,"id_aut" => 167), array("id_art" => 334,"id_aut" => 167), array("id_art" => 598,"id_aut" => 166), array("id_art" => 604,"id_aut" => 166), array("id_art" => 694,"id_aut" => 166), array("id_art" => 725,"id_aut" => 166), array("id_art" => 747,"id_aut" => 166), array("id_art" => 752,"id_aut" => 166), array("id_art" => 853,"id_aut" => 166), array("id_art" => 860,"id_aut" => 166), array("id_art" => 865,"id_aut" => 166), array("id_art" => 879,"id_aut" => 166), array("id_art" => 934,"id_aut" => 166), array("id_art" => 949,"id_aut" => 166), array("id_art" => 977,"id_aut" => 166), array("id_art" => 981,"id_aut" => 166), array("id_art" => 1001,"id_aut" => 166), array("id_art" => 1074,"id_aut" => 166), array("id_art" => 1078,"id_aut" => 166), array("id_art" => 1079,"id_aut" => 166), array("id_art" => 1094,"id_aut" => 166), array("id_art" => 1098,"id_aut" => 166), array("id_art" => 1105,"id_aut" => 166), array("id_art" => 1106,"id_aut" => 166), array("id_art" => 1128,"id_aut" => 166), array("id_art" => 1138,"id_aut" => 166), array("id_art" => 1142,"id_aut" => 166), array("id_art" => 1173,"id_aut" => 166), array("id_art" => 1185,"id_aut" => 166), array("id_art" => 1251,"id_aut" => 166), array("id_art" => 1331,"id_aut" => 166), array("id_art" => 1356,"id_aut" => 166), array("id_art" => 1444,"id_aut" => 166), array("id_art" => 1445,"id_aut" => 166), array("id_art" => 1455,"id_aut" => 166), array("id_art" => 603,"id_aut" => 165), array("id_art" => 880,"id_aut" => 165), array("id_art" => 532,"id_aut" => 163), array("id_art" => 567,"id_aut" => 163), array("id_art" => 573,"id_aut" => 163), array("id_art" => 837,"id_aut" => 163), array("id_art" => 1204,"id_aut" => 163), array("id_art" => 1208,"id_aut" => 163), array("id_art" => 1253,"id_aut" => 163), array("id_art" => 771,"id_aut" => 162), array("id_art" => 770,"id_aut" => 161), array("id_art" => 525,"id_aut" => 160), array("id_art" => 522,"id_aut" => 159), array("id_art" => 523,"id_aut" => 159), array("id_art" => 608,"id_aut" => 159), array("id_art" => 543,"id_aut" => 158), array("id_art" => 551,"id_aut" => 158), array("id_art" => 596,"id_aut" => 158), array("id_art" => 532,"id_aut" => 157), array("id_art" => 534,"id_aut" => 157), array("id_art" => 569,"id_aut" => 157), array("id_art" => 575,"id_aut" => 157), array("id_art" => 590,"id_aut" => 157), array("id_art" => 469,"id_aut" => 156), array("id_art" => 529,"id_aut" => 154), array("id_art" => 540,"id_aut" => 154), array("id_art" => 526,"id_aut" => 153), array("id_art" => 934,"id_aut" => 153), array("id_art" => 953,"id_aut" => 153), array("id_art" => 977,"id_aut" => 153), array("id_art" => 1003,"id_aut" => 153), array("id_art" => 1048,"id_aut" => 153), array("id_art" => 1057,"id_aut" => 153), array("id_art" => 1065,"id_aut" => 153), array("id_art" => 1165,"id_aut" => 153), array("id_art" => 1181,"id_aut" => 153), array("id_art" => 1189,"id_aut" => 153), array("id_art" => 1200,"id_aut" => 153), array("id_art" => 548,"id_aut" => 152), array("id_art" => 689,"id_aut" => 152), array("id_art" => 794,"id_aut" => 152), array("id_art" => 826,"id_aut" => 152), array("id_art" => 839,"id_aut" => 152), array("id_art" => 1057,"id_aut" => 152), array("id_art" => 1064,"id_aut" => 152), array("id_art" => 1213,"id_aut" => 152), array("id_art" => 1217,"id_aut" => 152), array("id_art" => 1240,"id_aut" => 152), array("id_art" => 1291,"id_aut" => 152), array("id_art" => 1427,"id_aut" => 152), array("id_art" => 547,"id_aut" => 151), array("id_art" => 665,"id_aut" => 151), array("id_art" => 850,"id_aut" => 151), array("id_art" => 952,"id_aut" => 151), array("id_art" => 1047,"id_aut" => 151), array("id_art" => 1056,"id_aut" => 151), array("id_art" => 1057,"id_aut" => 151), array("id_art" => 1291,"id_aut" => 151), array("id_art" => 1318,"id_aut" => 151), array("id_art" => 1331,"id_aut" => 151), array("id_art" => 1445,"id_aut" => 151), array("id_art" => 1456,"id_aut" => 151), array("id_art" => 514,"id_aut" => 150), array("id_art" => 507,"id_aut" => 149), array("id_art" => 617,"id_aut" => 149), array("id_art" => 802,"id_aut" => 149), array("id_art" => 966,"id_aut" => 149), array("id_art" => 999,"id_aut" => 149), array("id_art" => 1123,"id_aut" => 149), array("id_art" => 1297,"id_aut" => 149), array("id_art" => 1328,"id_aut" => 149), array("id_art" => 1387,"id_aut" => 149), array("id_art" => 1436,"id_aut" => 149), array("id_art" => 496,"id_aut" => 148), array("id_art" => 963,"id_aut" => 148), array("id_art" => 494,"id_aut" => 147), array("id_art" => 493,"id_aut" => 146), array("id_art" => 461,"id_aut" => 145), array("id_art" => 491,"id_aut" => 145), array("id_art" => 504,"id_aut" => 144), array("id_art" => 505,"id_aut" => 144), array("id_art" => 987,"id_aut" => 144), array("id_art" => 502,"id_aut" => 143), array("id_art" => 675,"id_aut" => 143), array("id_art" => 1429,"id_aut" => 143), array("id_art" => 501,"id_aut" => 142), array("id_art" => 745,"id_aut" => 142), array("id_art" => 501,"id_aut" => 141), array("id_art" => 745,"id_aut" => 141), array("id_art" => 500,"id_aut" => 140), array("id_art" => 560,"id_aut" => 139), array("id_art" => 857,"id_aut" => 139), array("id_art" => 486,"id_aut" => 138), array("id_art" => 524,"id_aut" => 138), array("id_art" => 541,"id_aut" => 138), array("id_art" => 563,"id_aut" => 138), array("id_art" => 572,"id_aut" => 138), array("id_art" => 607,"id_aut" => 138), array("id_art" => 611,"id_aut" => 138), array("id_art" => 628,"id_aut" => 138), array("id_art" => 639,"id_aut" => 138), array("id_art" => 656,"id_aut" => 138), array("id_art" => 663,"id_aut" => 138), array("id_art" => 684,"id_aut" => 138), array("id_art" => 700,"id_aut" => 138), array("id_art" => 767,"id_aut" => 138), array("id_art" => 772,"id_aut" => 138), array("id_art" => 773,"id_aut" => 138), array("id_art" => 790,"id_aut" => 138), array("id_art" => 799,"id_aut" => 138), array("id_art" => 815,"id_aut" => 138), array("id_art" => 816,"id_aut" => 138), array("id_art" => 831,"id_aut" => 138), array("id_art" => 840,"id_aut" => 138), array("id_art" => 862,"id_aut" => 138), array("id_art" => 971,"id_aut" => 138), array("id_art" => 1110,"id_aut" => 138), array("id_art" => 472,"id_aut" => 136), array("id_art" => 498,"id_aut" => 136), array("id_art" => 510,"id_aut" => 136), array("id_art" => 532,"id_aut" => 136), array("id_art" => 1112,"id_aut" => 136), array("id_art" => 1378,"id_aut" => 136), array("id_art" => 475,"id_aut" => 134), array("id_art" => 481,"id_aut" => 132), array("id_art" => 666,"id_aut" => 132), array("id_art" => 1130,"id_aut" => 132), array("id_art" => 521,"id_aut" => 129), array("id_art" => 533,"id_aut" => 129), array("id_art" => 536,"id_aut" => 129), array("id_art" => 546,"id_aut" => 129), array("id_art" => 454,"id_aut" => 126), array("id_art" => 470,"id_aut" => 126), array("id_art" => 527,"id_aut" => 126), array("id_art" => 605,"id_aut" => 126), array("id_art" => 801,"id_aut" => 126), array("id_art" => 1086,"id_aut" => 126), array("id_art" => 1291,"id_aut" => 126), array("id_art" => 449,"id_aut" => 125), array("id_art" => 482,"id_aut" => 125), array("id_art" => 510,"id_aut" => 125), array("id_art" => 517,"id_aut" => 125), array("id_art" => 561,"id_aut" => 125), array("id_art" => 877,"id_aut" => 125), array("id_art" => 944,"id_aut" => 125), array("id_art" => 1144,"id_aut" => 125), array("id_art" => 1145,"id_aut" => 125), array("id_art" => 1146,"id_aut" => 125), array("id_art" => 1147,"id_aut" => 125), array("id_art" => 1205,"id_aut" => 125), array("id_art" => 465,"id_aut" => 124), array("id_art" => 160,"id_aut" => 123), array("id_art" => 174,"id_aut" => 123), array("id_art" => 410,"id_aut" => 123), array("id_art" => 411,"id_aut" => 123), array("id_art" => 447,"id_aut" => 123), array("id_art" => 451,"id_aut" => 123), array("id_art" => 452,"id_aut" => 123), array("id_art" => 680,"id_aut" => 123), array("id_art" => 1394,"id_aut" => 123), array("id_art" => 391,"id_aut" => 122), array("id_art" => 455,"id_aut" => 122), array("id_art" => 67,"id_aut" => 121), array("id_art" => 84,"id_aut" => 121), array("id_art" => 98,"id_aut" => 121), array("id_art" => 166,"id_aut" => 121), array("id_art" => 204,"id_aut" => 121), array("id_art" => 446,"id_aut" => 121), array("id_art" => 434,"id_aut" => 120), array("id_art" => 466,"id_aut" => 120), array("id_art" => 532,"id_aut" => 120), array("id_art" => 537,"id_aut" => 120), array("id_art" => 538,"id_aut" => 120), array("id_art" => 1061,"id_aut" => 120), array("id_art" => 1210,"id_aut" => 120), array("id_art" => 1445,"id_aut" => 120), array("id_art" => 1457,"id_aut" => 120), array("id_art" => 437,"id_aut" => 119), array("id_art" => 443,"id_aut" => 119), array("id_art" => 1066,"id_aut" => 119), array("id_art" => 1199,"id_aut" => 119), array("id_art" => 436,"id_aut" => 118), array("id_art" => 504,"id_aut" => 118), array("id_art" => 505,"id_aut" => 118), array("id_art" => 512,"id_aut" => 118), array("id_art" => 743,"id_aut" => 118), array("id_art" => 762,"id_aut" => 118), array("id_art" => 775,"id_aut" => 118), array("id_art" => 781,"id_aut" => 118), array("id_art" => 894,"id_aut" => 118), array("id_art" => 929,"id_aut" => 118), array("id_art" => 932,"id_aut" => 118), array("id_art" => 986,"id_aut" => 118), array("id_art" => 1071,"id_aut" => 118), array("id_art" => 1087,"id_aut" => 118), array("id_art" => 1131,"id_aut" => 118), array("id_art" => 1142,"id_aut" => 118), array("id_art" => 1143,"id_aut" => 118), array("id_art" => 1148,"id_aut" => 118), array("id_art" => 1177,"id_aut" => 118), array("id_art" => 1194,"id_aut" => 118), array("id_art" => 1212,"id_aut" => 118), array("id_art" => 1214,"id_aut" => 118), array("id_art" => 1232,"id_aut" => 118), array("id_art" => 1233,"id_aut" => 118), array("id_art" => 1247,"id_aut" => 118), array("id_art" => 1251,"id_aut" => 118), array("id_art" => 1252,"id_aut" => 118), array("id_art" => 1291,"id_aut" => 118), array("id_art" => 1304,"id_aut" => 118), array("id_art" => 1317,"id_aut" => 118), array("id_art" => 1332,"id_aut" => 118), array("id_art" => 1374,"id_aut" => 118), array("id_art" => 429,"id_aut" => 117), array("id_art" => 987,"id_aut" => 117), array("id_art" => 428,"id_aut" => 116), array("id_art" => 444,"id_aut" => 116), array("id_art" => 453,"id_aut" => 116), array("id_art" => 458,"id_aut" => 116), array("id_art" => 459,"id_aut" => 116), array("id_art" => 509,"id_aut" => 116), array("id_art" => 544,"id_aut" => 116), array("id_art" => 427,"id_aut" => 115), array("id_art" => 423,"id_aut" => 114), array("id_art" => 171,"id_aut" => 113), array("id_art" => 196,"id_aut" => 113), array("id_art" => 422,"id_aut" => 113), array("id_art" => 749,"id_aut" => 113), array("id_art" => 1084,"id_aut" => 113), array("id_art" => 1174,"id_aut" => 113), array("id_art" => 420,"id_aut" => 112), array("id_art" => 488,"id_aut" => 112), array("id_art" => 844,"id_aut" => 112), array("id_art" => 366,"id_aut" => 111), array("id_art" => 414,"id_aut" => 111), array("id_art" => 612,"id_aut" => 111), array("id_art" => 833,"id_aut" => 111), array("id_art" => 957,"id_aut" => 111), array("id_art" => 1021,"id_aut" => 111), array("id_art" => 1024,"id_aut" => 111), array("id_art" => 1088,"id_aut" => 111), array("id_art" => 1139,"id_aut" => 111), array("id_art" => 1142,"id_aut" => 111), array("id_art" => 1204,"id_aut" => 111), array("id_art" => 1232,"id_aut" => 111), array("id_art" => 1445,"id_aut" => 111), array("id_art" => 413,"id_aut" => 110), array("id_art" => 409,"id_aut" => 109), array("id_art" => 484,"id_aut" => 109), array("id_art" => 516,"id_aut" => 109), array("id_art" => 248,"id_aut" => 108), array("id_art" => 408,"id_aut" => 108), array("id_art" => 483,"id_aut" => 108), array("id_art" => 528,"id_aut" => 108), array("id_art" => 532,"id_aut" => 108), array("id_art" => 538,"id_aut" => 108), array("id_art" => 550,"id_aut" => 108), array("id_art" => 674,"id_aut" => 108), array("id_art" => 1136,"id_aut" => 108), array("id_art" => 1401,"id_aut" => 108), array("id_art" => 397,"id_aut" => 107), array("id_art" => 406,"id_aut" => 107), array("id_art" => 412,"id_aut" => 107), array("id_art" => 418,"id_aut" => 107), array("id_art" => 424,"id_aut" => 107), array("id_art" => 439,"id_aut" => 107), array("id_art" => 464,"id_aut" => 107), array("id_art" => 405,"id_aut" => 106), array("id_art" => 440,"id_aut" => 106), array("id_art" => 393,"id_aut" => 105), array("id_art" => 939,"id_aut" => 105), array("id_art" => 1324,"id_aut" => 105), array("id_art" => 392,"id_aut" => 104), array("id_art" => 769,"id_aut" => 104), array("id_art" => 983,"id_aut" => 104), array("id_art" => 1445,"id_aut" => 104), array("id_art" => 377,"id_aut" => 103), array("id_art" => 382,"id_aut" => 103), array("id_art" => 394,"id_aut" => 102), array("id_art" => 417,"id_aut" => 102), array("id_art" => 640,"id_aut" => 102), array("id_art" => 380,"id_aut" => 101), array("id_art" => 872,"id_aut" => 101), array("id_art" => 238,"id_aut" => 100), array("id_art" => 253,"id_aut" => 100), array("id_art" => 268,"id_aut" => 100), array("id_art" => 280,"id_aut" => 100), array("id_art" => 293,"id_aut" => 100), array("id_art" => 374,"id_aut" => 100), array("id_art" => 748,"id_aut" => 100), array("id_art" => 751,"id_aut" => 100), array("id_art" => 768,"id_aut" => 100), array("id_art" => 1082,"id_aut" => 100), array("id_art" => 1083,"id_aut" => 100), array("id_art" => 216,"id_aut" => 99), array("id_art" => 351,"id_aut" => 99), array("id_art" => 373,"id_aut" => 99), array("id_art" => 397,"id_aut" => 99), array("id_art" => 414,"id_aut" => 99), array("id_art" => 445,"id_aut" => 99), array("id_art" => 560,"id_aut" => 99), array("id_art" => 695,"id_aut" => 99), array("id_art" => 804,"id_aut" => 99), array("id_art" => 812,"id_aut" => 99), array("id_art" => 950,"id_aut" => 99), array("id_art" => 951,"id_aut" => 99), array("id_art" => 977,"id_aut" => 99), array("id_art" => 1047,"id_aut" => 99), array("id_art" => 1055,"id_aut" => 99), array("id_art" => 1057,"id_aut" => 99), array("id_art" => 1073,"id_aut" => 99), array("id_art" => 1086,"id_aut" => 99), array("id_art" => 1201,"id_aut" => 99), array("id_art" => 1392,"id_aut" => 99), array("id_art" => 1452,"id_aut" => 99), array("id_art" => 387,"id_aut" => 98), array("id_art" => 222,"id_aut" => 97), array("id_art" => 707,"id_aut" => 97), array("id_art" => 1016,"id_aut" => 97), array("id_art" => 1017,"id_aut" => 97), array("id_art" => 1019,"id_aut" => 97), array("id_art" => 1022,"id_aut" => 97), array("id_art" => 1023,"id_aut" => 97), array("id_art" => 1024,"id_aut" => 97), array("id_art" => 1025,"id_aut" => 97), array("id_art" => 1026,"id_aut" => 97), array("id_art" => 1027,"id_aut" => 97), array("id_art" => 1028,"id_aut" => 97), array("id_art" => 1029,"id_aut" => 97), array("id_art" => 1030,"id_aut" => 97), array("id_art" => 1032,"id_aut" => 97), array("id_art" => 1033,"id_aut" => 97), array("id_art" => 1034,"id_aut" => 97), array("id_art" => 1035,"id_aut" => 97), array("id_art" => 1036,"id_aut" => 97), array("id_art" => 1037,"id_aut" => 97), array("id_art" => 1038,"id_aut" => 97), array("id_art" => 1039,"id_aut" => 97), array("id_art" => 1040,"id_aut" => 97), array("id_art" => 1041,"id_aut" => 97), array("id_art" => 1042,"id_aut" => 97), array("id_art" => 1046,"id_aut" => 97), array("id_art" => 1099,"id_aut" => 97), array("id_art" => 362,"id_aut" => 96), array("id_art" => 360,"id_aut" => 95), array("id_art" => 479,"id_aut" => 95), array("id_art" => 1027,"id_aut" => 95), array("id_art" => 1031,"id_aut" => 95), array("id_art" => 1044,"id_aut" => 95), array("id_art" => 357,"id_aut" => 93), array("id_art" => 434,"id_aut" => 93), array("id_art" => 346,"id_aut" => 92), array("id_art" => 354,"id_aut" => 92), array("id_art" => 367,"id_aut" => 92), array("id_art" => 376,"id_aut" => 92), array("id_art" => 443,"id_aut" => 92), array("id_art" => 176,"id_aut" => 91), array("id_art" => 197,"id_aut" => 91), array("id_art" => 347,"id_aut" => 91), array("id_art" => 353,"id_aut" => 91), array("id_art" => 414,"id_aut" => 91), array("id_art" => 687,"id_aut" => 91), array("id_art" => 691,"id_aut" => 91), array("id_art" => 368,"id_aut" => 90), array("id_art" => 463,"id_aut" => 90), array("id_art" => 1255,"id_aut" => 90), array("id_art" => 132,"id_aut" => 89), array("id_art" => 134,"id_aut" => 89), array("id_art" => 150,"id_aut" => 89), array("id_art" => 343,"id_aut" => 89), array("id_art" => 378,"id_aut" => 89), array("id_art" => 381,"id_aut" => 89), array("id_art" => 344,"id_aut" => 88), array("id_art" => 292,"id_aut" => 87), array("id_art" => 1198,"id_aut" => 87), array("id_art" => 468,"id_aut" => 85), array("id_art" => 666,"id_aut" => 85), array("id_art" => 681,"id_aut" => 85), array("id_art" => 707,"id_aut" => 85), array("id_art" => 814,"id_aut" => 85), array("id_art" => 964,"id_aut" => 85), array("id_art" => 966,"id_aut" => 85), array("id_art" => 1300,"id_aut" => 85), array("id_art" => 359,"id_aut" => 84), array("id_art" => 437,"id_aut" => 84), array("id_art" => 443,"id_aut" => 84), array("id_art" => 857,"id_aut" => 84), array("id_art" => 864,"id_aut" => 84), array("id_art" => 982,"id_aut" => 84), array("id_art" => 1066,"id_aut" => 84), array("id_art" => 331,"id_aut" => 83), array("id_art" => 339,"id_aut" => 82), array("id_art" => 593,"id_aut" => 82), array("id_art" => 339,"id_aut" => 81), array("id_art" => 337,"id_aut" => 80), array("id_art" => 440,"id_aut" => 78), array("id_art" => 457,"id_aut" => 78), array("id_art" => 549,"id_aut" => 78), array("id_art" => 653,"id_aut" => 78), array("id_art" => 686,"id_aut" => 78), array("id_art" => 810,"id_aut" => 78), array("id_art" => 822,"id_aut" => 78), array("id_art" => 1062,"id_aut" => 78), array("id_art" => 1237,"id_aut" => 78), array("id_art" => 334,"id_aut" => 77), array("id_art" => 347,"id_aut" => 77), array("id_art" => 351,"id_aut" => 77), array("id_art" => 359,"id_aut" => 77), array("id_art" => 364,"id_aut" => 77), array("id_art" => 369,"id_aut" => 77), array("id_art" => 379,"id_aut" => 77), array("id_art" => 385,"id_aut" => 77), array("id_art" => 400,"id_aut" => 77), array("id_art" => 404,"id_aut" => 77), array("id_art" => 405,"id_aut" => 77), array("id_art" => 410,"id_aut" => 77), array("id_art" => 415,"id_aut" => 77), array("id_art" => 466,"id_aut" => 77), array("id_art" => 467,"id_aut" => 77), array("id_art" => 468,"id_aut" => 77), array("id_art" => 469,"id_aut" => 77), array("id_art" => 470,"id_aut" => 77), array("id_art" => 477,"id_aut" => 77), array("id_art" => 478,"id_aut" => 77), array("id_art" => 481,"id_aut" => 77), array("id_art" => 492,"id_aut" => 77), array("id_art" => 495,"id_aut" => 77), array("id_art" => 499,"id_aut" => 77), array("id_art" => 509,"id_aut" => 77), array("id_art" => 528,"id_aut" => 77), array("id_art" => 530,"id_aut" => 77), array("id_art" => 540,"id_aut" => 77), array("id_art" => 544,"id_aut" => 77), array("id_art" => 795,"id_aut" => 77), array("id_art" => 515,"id_aut" => 76), array("id_art" => 1124,"id_aut" => 76), array("id_art" => 1370,"id_aut" => 76), array("id_art" => 308,"id_aut" => 75), array("id_art" => 235,"id_aut" => 73), array("id_art" => 262,"id_aut" => 73), array("id_art" => 263,"id_aut" => 73), array("id_art" => 361,"id_aut" => 73), array("id_art" => 388,"id_aut" => 73), array("id_art" => 706,"id_aut" => 73), array("id_art" => 1018,"id_aut" => 73), array("id_art" => 1020,"id_aut" => 73), array("id_art" => 1025,"id_aut" => 73), array("id_art" => 1043,"id_aut" => 73), array("id_art" => 1045,"id_aut" => 73), array("id_art" => 329,"id_aut" => 72), array("id_art" => 213,"id_aut" => 71), array("id_art" => 352,"id_aut" => 71), array("id_art" => 42,"id_aut" => 70), array("id_art" => 309,"id_aut" => 70), array("id_art" => 328,"id_aut" => 70), array("id_art" => 448,"id_aut" => 70), array("id_art" => 672,"id_aut" => 70), array("id_art" => 309,"id_aut" => 69), array("id_art" => 328,"id_aut" => 69), array("id_art" => 307,"id_aut" => 68), array("id_art" => 327,"id_aut" => 68), array("id_art" => 336,"id_aut" => 68), array("id_art" => 304,"id_aut" => 66), array("id_art" => 920,"id_aut" => 66), array("id_art" => 326,"id_aut" => 64), array("id_art" => 370,"id_aut" => 64), array("id_art" => 959,"id_aut" => 64), array("id_art" => 326,"id_aut" => 63), array("id_art" => 258,"id_aut" => 61), array("id_art" => 261,"id_aut" => 61), array("id_art" => 315,"id_aut" => 61), array("id_art" => 332,"id_aut" => 61), array("id_art" => 335,"id_aut" => 61), array("id_art" => 350,"id_aut" => 61), array("id_art" => 358,"id_aut" => 61), array("id_art" => 369,"id_aut" => 61), array("id_art" => 371,"id_aut" => 61), array("id_art" => 375,"id_aut" => 61), array("id_art" => 390,"id_aut" => 61), array("id_art" => 403,"id_aut" => 61), array("id_art" => 414,"id_aut" => 61), array("id_art" => 431,"id_aut" => 61), array("id_art" => 460,"id_aut" => 61), array("id_art" => 462,"id_aut" => 61), array("id_art" => 520,"id_aut" => 61), array("id_art" => 531,"id_aut" => 61), array("id_art" => 556,"id_aut" => 61), array("id_art" => 559,"id_aut" => 61), array("id_art" => 564,"id_aut" => 61), array("id_art" => 606,"id_aut" => 61), array("id_art" => 643,"id_aut" => 61), array("id_art" => 667,"id_aut" => 61), array("id_art" => 683,"id_aut" => 61), array("id_art" => 699,"id_aut" => 61), array("id_art" => 748,"id_aut" => 61), array("id_art" => 751,"id_aut" => 61), array("id_art" => 768,"id_aut" => 61), array("id_art" => 796,"id_aut" => 61), array("id_art" => 797,"id_aut" => 61), array("id_art" => 825,"id_aut" => 61), array("id_art" => 848,"id_aut" => 61), array("id_art" => 928,"id_aut" => 61), array("id_art" => 988,"id_aut" => 61), array("id_art" => 1054,"id_aut" => 61), array("id_art" => 1073,"id_aut" => 61), array("id_art" => 1092,"id_aut" => 61), array("id_art" => 1243,"id_aut" => 61), array("id_art" => 1264,"id_aut" => 61), array("id_art" => 1303,"id_aut" => 61), array("id_art" => 1326,"id_aut" => 61), array("id_art" => 1451,"id_aut" => 61), array("id_art" => 71,"id_aut" => 59), array("id_art" => 265,"id_aut" => 59), array("id_art" => 707,"id_aut" => 59), array("id_art" => 311,"id_aut" => 58), array("id_art" => 311,"id_aut" => 57), array("id_art" => 310,"id_aut" => 56), array("id_art" => 310,"id_aut" => 55), array("id_art" => 320,"id_aut" => 54), array("id_art" => 247,"id_aut" => 53), array("id_art" => 259,"id_aut" => 53), array("id_art" => 269,"id_aut" => 53), array("id_art" => 291,"id_aut" => 53), array("id_art" => 318,"id_aut" => 53), array("id_art" => 330,"id_aut" => 53), array("id_art" => 349,"id_aut" => 53), array("id_art" => 401,"id_aut" => 53), array("id_art" => 405,"id_aut" => 53), array("id_art" => 407,"id_aut" => 53), array("id_art" => 508,"id_aut" => 53), array("id_art" => 511,"id_aut" => 53), array("id_art" => 532,"id_aut" => 53), array("id_art" => 533,"id_aut" => 53), array("id_art" => 553,"id_aut" => 53), array("id_art" => 564,"id_aut" => 53), array("id_art" => 586,"id_aut" => 53), array("id_art" => 658,"id_aut" => 53), array("id_art" => 720,"id_aut" => 53), array("id_art" => 727,"id_aut" => 53), array("id_art" => 793,"id_aut" => 53), array("id_art" => 803,"id_aut" => 53), array("id_art" => 827,"id_aut" => 53), array("id_art" => 834,"id_aut" => 53), array("id_art" => 1047,"id_aut" => 53), array("id_art" => 1178,"id_aut" => 53), array("id_art" => 1398,"id_aut" => 53), array("id_art" => 333,"id_aut" => 51), array("id_art" => 651,"id_aut" => 51), array("id_art" => 295,"id_aut" => 50), array("id_art" => 294,"id_aut" => 49), array("id_art" => 307,"id_aut" => 45), array("id_art" => 314,"id_aut" => 45), array("id_art" => 327,"id_aut" => 45), array("id_art" => 336,"id_aut" => 45), array("id_art" => 365,"id_aut" => 45), array("id_art" => 372,"id_aut" => 45), array("id_art" => 399,"id_aut" => 45), array("id_art" => 448,"id_aut" => 45), array("id_art" => 456,"id_aut" => 45), array("id_art" => 503,"id_aut" => 45), array("id_art" => 513,"id_aut" => 45), array("id_art" => 548,"id_aut" => 45), array("id_art" => 666,"id_aut" => 45), array("id_art" => 1120,"id_aut" => 45), array("id_art" => 1388,"id_aut" => 45), array("id_art" => 143,"id_aut" => 43), array("id_art" => 249,"id_aut" => 43), array("id_art" => 302,"id_aut" => 42), array("id_art" => 211,"id_aut" => 41), array("id_art" => 301,"id_aut" => 41), array("id_art" => 300,"id_aut" => 40), array("id_art" => 348,"id_aut" => 40), array("id_art" => 1239,"id_aut" => 40), array("id_art" => 192,"id_aut" => 39), array("id_art" => 416,"id_aut" => 39), array("id_art" => 545,"id_aut" => 39), array("id_art" => 560,"id_aut" => 39), array("id_art" => 841,"id_aut" => 38), array("id_art" => 845,"id_aut" => 38), array("id_art" => 868,"id_aut" => 38), array("id_art" => 870,"id_aut" => 38), array("id_art" => 957,"id_aut" => 38), array("id_art" => 1093,"id_aut" => 38), array("id_art" => 305,"id_aut" => 37), array("id_art" => 788,"id_aut" => 36), array("id_art" => 208,"id_aut" => 35), array("id_art" => 395,"id_aut" => 35), array("id_art" => 852,"id_aut" => 35), array("id_art" => 233,"id_aut" => 34), array("id_art" => 274,"id_aut" => 34), array("id_art" => 386,"id_aut" => 34), array("id_art" => 421,"id_aut" => 34), array("id_art" => 435,"id_aut" => 34), array("id_art" => 441,"id_aut" => 34), array("id_art" => 450,"id_aut" => 34), array("id_art" => 490,"id_aut" => 34), array("id_art" => 230,"id_aut" => 32), array("id_art" => 242,"id_aut" => 32), array("id_art" => 246,"id_aut" => 32), array("id_art" => 251,"id_aut" => 32), array("id_art" => 252,"id_aut" => 32), array("id_art" => 260,"id_aut" => 32), array("id_art" => 277,"id_aut" => 32), array("id_art" => 287,"id_aut" => 32), array("id_art" => 290,"id_aut" => 32), array("id_art" => 303,"id_aut" => 32), array("id_art" => 316,"id_aut" => 32), array("id_art" => 319,"id_aut" => 32), array("id_art" => 338,"id_aut" => 32), array("id_art" => 355,"id_aut" => 32), array("id_art" => 425,"id_aut" => 32), array("id_art" => 438,"id_aut" => 32), array("id_art" => 647,"id_aut" => 32), array("id_art" => 648,"id_aut" => 32), array("id_art" => 649,"id_aut" => 32), array("id_art" => 257,"id_aut" => 31), array("id_art" => 276,"id_aut" => 31), array("id_art" => 433,"id_aut" => 31), array("id_art" => 977,"id_aut" => 31), array("id_art" => 275,"id_aut" => 30), array("id_art" => 365,"id_aut" => 30), array("id_art" => 410,"id_aut" => 30), array("id_art" => 411,"id_aut" => 30), array("id_art" => 626,"id_aut" => 30), array("id_art" => 639,"id_aut" => 30), array("id_art" => 666,"id_aut" => 30), array("id_art" => 673,"id_aut" => 30), array("id_art" => 220,"id_aut" => 29), array("id_art" => 221,"id_aut" => 29), array("id_art" => 245,"id_aut" => 29), array("id_art" => 419,"id_aut" => 29), array("id_art" => 777,"id_aut" => 29), array("id_art" => 901,"id_aut" => 29), array("id_art" => 902,"id_aut" => 29), array("id_art" => 903,"id_aut" => 29), array("id_art" => 904,"id_aut" => 29), array("id_art" => 905,"id_aut" => 29), array("id_art" => 907,"id_aut" => 29), array("id_art" => 908,"id_aut" => 29), array("id_art" => 909,"id_aut" => 29), array("id_art" => 910,"id_aut" => 29), array("id_art" => 912,"id_aut" => 29), array("id_art" => 915,"id_aut" => 29), array("id_art" => 917,"id_aut" => 29), array("id_art" => 919,"id_aut" => 29), array("id_art" => 921,"id_aut" => 29), array("id_art" => 922,"id_aut" => 29), array("id_art" => 923,"id_aut" => 29), array("id_art" => 255,"id_aut" => 28), array("id_art" => 256,"id_aut" => 28), array("id_art" => 322,"id_aut" => 28), array("id_art" => 324,"id_aut" => 28), array("id_art" => 913,"id_aut" => 28), array("id_art" => 914,"id_aut" => 28), array("id_art" => 1059,"id_aut" => 28), array("id_art" => 1196,"id_aut" => 28), array("id_art" => 240,"id_aut" => 27), array("id_art" => 250,"id_aut" => 27), array("id_art" => 286,"id_aut" => 27), array("id_art" => 298,"id_aut" => 27), array("id_art" => 34,"id_aut" => 26), array("id_art" => 29,"id_aut" => 25), array("id_art" => 28,"id_aut" => 24), array("id_art" => 41,"id_aut" => 24), array("id_art" => 442,"id_aut" => 24), array("id_art" => 669,"id_aut" => 24), array("id_art" => 719,"id_aut" => 24), array("id_art" => 854,"id_aut" => 24), array("id_art" => 861,"id_aut" => 24), array("id_art" => 867,"id_aut" => 24), array("id_art" => 978,"id_aut" => 24), array("id_art" => 27,"id_aut" => 23), array("id_art" => 33,"id_aut" => 23), array("id_art" => 140,"id_aut" => 23), array("id_art" => 26,"id_aut" => 22), array("id_art" => 36,"id_aut" => 22), array("id_art" => 44,"id_aut" => 22), array("id_art" => 92,"id_aut" => 22), array("id_art" => 102,"id_aut" => 22), array("id_art" => 146,"id_aut" => 22), array("id_art" => 147,"id_aut" => 22), array("id_art" => 148,"id_aut" => 22), array("id_art" => 149,"id_aut" => 22), array("id_art" => 698,"id_aut" => 22), array("id_art" => 24,"id_aut" => 21), array("id_art" => 32,"id_aut" => 21), array("id_art" => 81,"id_aut" => 21), array("id_art" => 118,"id_aut" => 21), array("id_art" => 139,"id_aut" => 21), array("id_art" => 145,"id_aut" => 21), array("id_art" => 158,"id_aut" => 21), array("id_art" => 160,"id_aut" => 21), array("id_art" => 162,"id_aut" => 21), array("id_art" => 173,"id_aut" => 21), array("id_art" => 174,"id_aut" => 21), array("id_art" => 176,"id_aut" => 21), array("id_art" => 178,"id_aut" => 21), array("id_art" => 179,"id_aut" => 21), array("id_art" => 188,"id_aut" => 21), array("id_art" => 191,"id_aut" => 21), array("id_art" => 193,"id_aut" => 21), array("id_art" => 209,"id_aut" => 21), array("id_art" => 285,"id_aut" => 21), array("id_art" => 384,"id_aut" => 21), array("id_art" => 430,"id_aut" => 21), array("id_art" => 489,"id_aut" => 21), array("id_art" => 565,"id_aut" => 21), array("id_art" => 584,"id_aut" => 21), array("id_art" => 629,"id_aut" => 21), array("id_art" => 637,"id_aut" => 21), array("id_art" => 642,"id_aut" => 21), array("id_art" => 690,"id_aut" => 21), array("id_art" => 703,"id_aut" => 21), array("id_art" => 726,"id_aut" => 21), array("id_art" => 765,"id_aut" => 21), array("id_art" => 1013,"id_aut" => 21), array("id_art" => 1085,"id_aut" => 21), array("id_art" => 32,"id_aut" => 20), array("id_art" => 46,"id_aut" => 20), array("id_art" => 72,"id_aut" => 20), array("id_art" => 89,"id_aut" => 20), array("id_art" => 15,"id_aut" => 18), array("id_art" => 63,"id_aut" => 18), array("id_art" => 135,"id_aut" => 18), array("id_art" => 20,"id_aut" => 17), array("id_art" => 20,"id_aut" => 16), array("id_art" => 16,"id_aut" => 14), array("id_art" => 152,"id_aut" => 14), array("id_art" => 560,"id_aut" => 14), array("id_art" => 594,"id_aut" => 14), array("id_art" => 625,"id_aut" => 14), array("id_art" => 666,"id_aut" => 14), array("id_art" => 14,"id_aut" => 12), array("id_art" => 12,"id_aut" => 11), array("id_art" => 17,"id_aut" => 11), array("id_art" => 25,"id_aut" => 11), array("id_art" => 28,"id_aut" => 11), array("id_art" => 37,"id_aut" => 11), array("id_art" => 45,"id_aut" => 11), array("id_art" => 70,"id_aut" => 11), array("id_art" => 83,"id_aut" => 11), array("id_art" => 91,"id_aut" => 11), array("id_art" => 583,"id_aut" => 11), array("id_art" => 670,"id_aut" => 11), array("id_art" => 671,"id_aut" => 11), array("id_art" => 11,"id_aut" => 10), array("id_art" => 81,"id_aut" => 10), array("id_art" => 750,"id_aut" => 10), array("id_art" => 210,"id_aut" => 9), array("id_art" => 224,"id_aut" => 9), array("id_art" => 271,"id_aut" => 9), array("id_art" => 306,"id_aut" => 9), array("id_art" => 307,"id_aut" => 9), array("id_art" => 311,"id_aut" => 9), array("id_art" => 314,"id_aut" => 9), array("id_art" => 317,"id_aut" => 9), array("id_art" => 322,"id_aut" => 9), array("id_art" => 324,"id_aut" => 9), array("id_art" => 327,"id_aut" => 9), array("id_art" => 336,"id_aut" => 9), array("id_art" => 409,"id_aut" => 9), array("id_art" => 474,"id_aut" => 9), array("id_art" => 484,"id_aut" => 9), array("id_art" => 506,"id_aut" => 9), array("id_art" => 516,"id_aut" => 9), array("id_art" => 609,"id_aut" => 9), array("id_art" => 646,"id_aut" => 9), array("id_art" => 558,"id_aut" => 8), array("id_art" => 578,"id_aut" => 8), array("id_art" => 581,"id_aut" => 8), array("id_art" => 591,"id_aut" => 8), array("id_art" => 592,"id_aut" => 8), array("id_art" => 594,"id_aut" => 8), array("id_art" => 600,"id_aut" => 8), array("id_art" => 619,"id_aut" => 8), array("id_art" => 625,"id_aut" => 8), array("id_art" => 630,"id_aut" => 8), array("id_art" => 636,"id_aut" => 8), array("id_art" => 644,"id_aut" => 8), array("id_art" => 657,"id_aut" => 8), array("id_art" => 692,"id_aut" => 8), array("id_art" => 931,"id_aut" => 8), array("id_art" => 144,"id_aut" => 7), array("id_art" => 272,"id_aut" => 7), array("id_art" => 299,"id_aut" => 7), array("id_art" => 342,"id_aut" => 7), array("id_art" => 568,"id_aut" => 7), array("id_art" => 589,"id_aut" => 7), array("id_art" => 613,"id_aut" => 7), array("id_art" => 635,"id_aut" => 7), array("id_art" => 676,"id_aut" => 7), array("id_art" => 677,"id_aut" => 7), array("id_art" => 678,"id_aut" => 7), array("id_art" => 682,"id_aut" => 7), array("id_art" => 1125,"id_aut" => 7), array("id_art" => 1390,"id_aut" => 7), array("id_art" => 341,"id_aut" => 6), array("id_art" => 634,"id_aut" => 6), array("id_art" => 567,"id_aut" => 5), array("id_art" => 618,"id_aut" => 5), array("id_art" => 621,"id_aut" => 5), array("id_art" => 633,"id_aut" => 5), array("id_art" => 668,"id_aut" => 5), array("id_art" => 673,"id_aut" => 5), array("id_art" => 1207,"id_aut" => 5), array("id_art" => 1399,"id_aut" => 5), array("id_art" => 59,"id_aut" => 4), array("id_art" => 202,"id_aut" => 4), array("id_art" => 226,"id_aut" => 4), array("id_art" => 284,"id_aut" => 4), array("id_art" => 356,"id_aut" => 4), array("id_art" => 371,"id_aut" => 4), array("id_art" => 385,"id_aut" => 4), array("id_art" => 414,"id_aut" => 4), array("id_art" => 480,"id_aut" => 4), array("id_art" => 532,"id_aut" => 4), array("id_art" => 537,"id_aut" => 4), array("id_art" => 567,"id_aut" => 4), array("id_art" => 574,"id_aut" => 4), array("id_art" => 798,"id_aut" => 4), array("id_art" => 952,"id_aut" => 4), array("id_art" => 1015,"id_aut" => 4), array("id_art" => 1056,"id_aut" => 4), array("id_art" => 1073,"id_aut" => 4), array("id_art" => 1086,"id_aut" => 4), array("id_art" => 1090,"id_aut" => 4), array("id_art" => 1446,"id_aut" => 4), array("id_art" => 473,"id_aut" => 3), array("id_art" => 476,"id_aut" => 3), array("id_art" => 518,"id_aut" => 3), array("id_art" => 632,"id_aut" => 3), array("id_art" => 379,"id_aut" => 2), array("id_art" => 448,"id_aut" => 2), array("id_art" => 359,"id_aut" => 1), array("id_art" => 364,"id_aut" => 1), array("id_art" => 366,"id_aut" => 1), array("id_art" => 369,"id_aut" => 1), array("id_art" => 385,"id_aut" => 1), array("id_art" => 389,"id_aut" => 1), array("id_art" => 397,"id_aut" => 1), array("id_art" => 432,"id_aut" => 1), array("id_art" => 471,"id_aut" => 1), array("id_art" => 487,"id_aut" => 1), array("id_art" => 519,"id_aut" => 1), array("id_art" => 612,"id_aut" => 1), array("id_art" => 631,"id_aut" => 1), array("id_art" => 723,"id_aut" => 1), array("id_art" => 774,"id_aut" => 1), array("id_art" => 1249,"id_aut" => 1), array("id_art" => 1288,"id_aut" => 1)
);

//
//
//
//
//
//
//
//
//


$arr_novo = array(array("id_antigo" => 193,"id_novo" => 2560), array("id_antigo" => 452,"id_novo" => 2816), array("id_antigo" => 700,"id_novo" => 3072), array("id_antigo" => 989,"id_novo" => 3328), array("id_antigo" => 1267,"id_novo" => 3584), array("id_antigo" => 194,"id_novo" => 2561), array("id_antigo" => 453,"id_novo" => 2817), array("id_antigo" => 701,"id_novo" => 3073), array("id_antigo" => 990,"id_novo" => 3329), array("id_antigo" => 1268,"id_novo" => 3585), array("id_antigo" => 195,"id_novo" => 2562), array("id_antigo" => 454,"id_novo" => 2818), array("id_antigo" => 991,"id_novo" => 3330), array("id_antigo" => 1269,"id_novo" => 3586), array("id_antigo" => 196,"id_novo" => 2563), array("id_antigo" => 455,"id_novo" => 2819), array("id_antigo" => 705,"id_novo" => 3075), array("id_antigo" => 1013,"id_novo" => 3331), array("id_antigo" => 1270,"id_novo" => 3587), array("id_antigo" => 197,"id_novo" => 2564), array("id_antigo" => 456,"id_novo" => 2820), array("id_antigo" => 706,"id_novo" => 3076), array("id_antigo" => 1271,"id_novo" => 3588), array("id_antigo" => 199,"id_novo" => 2565), array("id_antigo" => 457,"id_novo" => 2821), array("id_antigo" => 707,"id_novo" => 3077), array("id_antigo" => 993,"id_novo" => 3333), array("id_antigo" => 1272,"id_novo" => 3589), array("id_antigo" => 200,"id_novo" => 2566), array("id_antigo" => 458,"id_novo" => 2822), array("id_antigo" => 712,"id_novo" => 3078), array("id_antigo" => 994,"id_novo" => 3334), array("id_antigo" => 1273,"id_novo" => 3590), array("id_antigo" => 201,"id_novo" => 2567), array("id_antigo" => 459,"id_novo" => 2823), array("id_antigo" => 709,"id_novo" => 3079), array("id_antigo" => 995,"id_novo" => 3335), array("id_antigo" => 1274,"id_novo" => 3591), array("id_antigo" => 202,"id_novo" => 2568), array("id_antigo" => 460,"id_novo" => 2824), array("id_antigo" => 710,"id_novo" => 3080), array("id_antigo" => 996,"id_novo" => 3336), array("id_antigo" => 1275,"id_novo" => 3592), array("id_antigo" => 879,"id_novo" => 5128), array("id_antigo" => 203,"id_novo" => 2569), array("id_antigo" => 461,"id_novo" => 2825), array("id_antigo" => 759,"id_novo" => 3081), array("id_antigo" => 997,"id_novo" => 3337), array("id_antigo" => 1276,"id_novo" => 3593), array("id_antigo" => 204,"id_novo" => 2570), array("id_antigo" => 462,"id_novo" => 2826), array("id_antigo" => 998,"id_novo" => 3338), array("id_antigo" => 1277,"id_novo" => 3594), array("id_antigo" => 205,"id_novo" => 2571), array("id_antigo" => 463,"id_novo" => 2827), array("id_antigo" => 714,"id_novo" => 3083), array("id_antigo" => 1014,"id_novo" => 3339), array("id_antigo" => 1278,"id_novo" => 3595), array("id_antigo" => 206,"id_novo" => 2572), array("id_antigo" => 464,"id_novo" => 2828), array("id_antigo" => 829,"id_novo" => 3084), array("id_antigo" => 999,"id_novo" => 3340), array("id_antigo" => 1279,"id_novo" => 3596), array("id_antigo" => 573,"id_novo" => 2573), array("id_antigo" => 465,"id_novo" => 2829), array("id_antigo" => 830,"id_novo" => 3085), array("id_antigo" => 1000,"id_novo" => 3341), array("id_antigo" => 1280,"id_novo" => 3597), array("id_antigo" => 631,"id_novo" => 2574), array("id_antigo" => 467,"id_novo" => 2830), array("id_antigo" => 831,"id_novo" => 3086), array("id_antigo" => 1281,"id_novo" => 3598), array("id_antigo" => 704,"id_novo" => 2575), array("id_antigo" => 468,"id_novo" => 2831), array("id_antigo" => 832,"id_novo" => 3087), array("id_antigo" => 1002,"id_novo" => 3343), array("id_antigo" => 1282,"id_novo" => 3599), array("id_antigo" => 746,"id_novo" => 2576), array("id_antigo" => 469,"id_novo" => 2832), array("id_antigo" => 833,"id_novo" => 3088), array("id_antigo" => 1003,"id_novo" => 3344), array("id_antigo" => 1283,"id_novo" => 3600), array("id_antigo" => 1164,"id_novo" => 2577), array("id_antigo" => 470,"id_novo" => 2833), array("id_antigo" => 834,"id_novo" => 3089), array("id_antigo" => 1004,"id_novo" => 3345), array("id_antigo" => 1284,"id_novo" => 3601), array("id_antigo" => 208,"id_novo" => 2578), array("id_antigo" => 471,"id_novo" => 2834), array("id_antigo" => 716,"id_novo" => 3090), array("id_antigo" => 1005,"id_novo" => 3346), array("id_antigo" => 1285,"id_novo" => 3602), array("id_antigo" => 209,"id_novo" => 2579), array("id_antigo" => 472,"id_novo" => 2835), array("id_antigo" => 717,"id_novo" => 3091), array("id_antigo" => 1006,"id_novo" => 3347), array("id_antigo" => 1286,"id_novo" => 3603), array("id_antigo" => 210,"id_novo" => 2580), array("id_antigo" => 473,"id_novo" => 2836), array("id_antigo" => 761,"id_novo" => 3092), array("id_antigo" => 1007,"id_novo" => 3348), array("id_antigo" => 1287,"id_novo" => 3604), array("id_antigo" => 211,"id_novo" => 2581), array("id_antigo" => 474,"id_novo" => 2837), array("id_antigo" => 765,"id_novo" => 3093), array("id_antigo" => 1008,"id_novo" => 3349), array("id_antigo" => 1288,"id_novo" => 3605), array("id_antigo" => 213,"id_novo" => 2582), array("id_antigo" => 475,"id_novo" => 2838), array("id_antigo" => 718,"id_novo" => 3094), array("id_antigo" => 1009,"id_novo" => 3350), array("id_antigo" => 1289,"id_novo" => 3606), array("id_antigo" => 214,"id_novo" => 2583), array("id_antigo" => 476,"id_novo" => 2839), array("id_antigo" => 719,"id_novo" => 3095), array("id_antigo" => 1010,"id_novo" => 3351), array("id_antigo" => 1290,"id_novo" => 3607), array("id_antigo" => 215,"id_novo" => 2584), array("id_antigo" => 477,"id_novo" => 2840), array("id_antigo" => 720,"id_novo" => 3096), array("id_antigo" => 1011,"id_novo" => 3352), array("id_antigo" => 216,"id_novo" => 2585), array("id_antigo" => 478,"id_novo" => 2841), array("id_antigo" => 721,"id_novo" => 3097), array("id_antigo" => 1012,"id_novo" => 3353), array("id_antigo" => 1292,"id_novo" => 3609), array("id_antigo" => 217,"id_novo" => 2586), array("id_antigo" => 479,"id_novo" => 2842), array("id_antigo" => 722,"id_novo" => 3098), array("id_antigo" => 1016,"id_novo" => 3354), array("id_antigo" => 1293,"id_novo" => 3610), array("id_antigo" => 218,"id_novo" => 2587), array("id_antigo" => 480,"id_novo" => 2843), array("id_antigo" => 723,"id_novo" => 3099), array("id_antigo" => 1034,"id_novo" => 3355), array("id_antigo" => 1294,"id_novo" => 3611), array("id_antigo" => 219,"id_novo" => 2588), array("id_antigo" => 481,"id_novo" => 2844), array("id_antigo" => 724,"id_novo" => 3100), array("id_antigo" => 1035,"id_novo" => 3356), array("id_antigo" => 1295,"id_novo" => 3612), array("id_antigo" => 220,"id_novo" => 2589), array("id_antigo" => 482,"id_novo" => 2845), array("id_antigo" => 762,"id_novo" => 3101), array("id_antigo" => 1017,"id_novo" => 3357), array("id_antigo" => 1296,"id_novo" => 3613), array("id_antigo" => 221,"id_novo" => 2590), array("id_antigo" => 483,"id_novo" => 2846), array("id_antigo" => 725,"id_novo" => 3102), array("id_antigo" => 1018,"id_novo" => 3358), array("id_antigo" => 1297,"id_novo" => 3614), array("id_antigo" => 222,"id_novo" => 2591), array("id_antigo" => 484,"id_novo" => 2847), array("id_antigo" => 726,"id_novo" => 3103), array("id_antigo" => 1019,"id_novo" => 3359), array("id_antigo" => 1298,"id_novo" => 3615), array("id_antigo" => 836,"id_novo" => 2592), array("id_antigo" => 485,"id_novo" => 2848), array("id_antigo" => 727,"id_novo" => 3104), array("id_antigo" => 1032,"id_novo" => 3360), array("id_antigo" => 1299,"id_novo" => 3616), array("id_antigo" => 837,"id_novo" => 2593), array("id_antigo" => 486,"id_novo" => 2849), array("id_antigo" => 728,"id_novo" => 3105), array("id_antigo" => 1033,"id_novo" => 3361), array("id_antigo" => 1300,"id_novo" => 3617), array("id_antigo" => 224,"id_novo" => 2594), array("id_antigo" => 487,"id_novo" => 2850), array("id_antigo" => 729,"id_novo" => 3106), array("id_antigo" => 1031,"id_novo" => 3362), array("id_antigo" => 1301,"id_novo" => 3618), array("id_antigo" => 225,"id_novo" => 2595), array("id_antigo" => 488,"id_novo" => 2851), array("id_antigo" => 730,"id_novo" => 3107), array("id_antigo" => 1020,"id_novo" => 3363), array("id_antigo" => 1302,"id_novo" => 3619), array("id_antigo" => 226,"id_novo" => 2596), array("id_antigo" => 490,"id_novo" => 2852), array("id_antigo" => 731,"id_novo" => 3108), array("id_antigo" => 1021,"id_novo" => 3364), array("id_antigo" => 1303,"id_novo" => 3620), array("id_antigo" => 227,"id_novo" => 2597), array("id_antigo" => 491,"id_novo" => 2853), array("id_antigo" => 732,"id_novo" => 3109), array("id_antigo" => 1022,"id_novo" => 3365), array("id_antigo" => 1304,"id_novo" => 3621), array("id_antigo" => 228,"id_novo" => 2598), array("id_antigo" => 492,"id_novo" => 2854), array("id_antigo" => 733,"id_novo" => 3110), array("id_antigo" => 1023,"id_novo" => 3366), array("id_antigo" => 1305,"id_novo" => 3622), array("id_antigo" => 229,"id_novo" => 2599), array("id_antigo" => 493,"id_novo" => 2855), array("id_antigo" => 734,"id_novo" => 3111), array("id_antigo" => 1024,"id_novo" => 3367), array("id_antigo" => 1306,"id_novo" => 3623), array("id_antigo" => 230,"id_novo" => 2600), array("id_antigo" => 494,"id_novo" => 2856), array("id_antigo" => 735,"id_novo" => 3112), array("id_antigo" => 1025,"id_novo" => 3368), array("id_antigo" => 1307,"id_novo" => 3624), array("id_antigo" => 231,"id_novo" => 2601), array("id_antigo" => 495,"id_novo" => 2857), array("id_antigo" => 736,"id_novo" => 3113), array("id_antigo" => 1026,"id_novo" => 3369), array("id_antigo" => 1308,"id_novo" => 3625), array("id_antigo" => 232,"id_novo" => 2602), array("id_antigo" => 496,"id_novo" => 2858), array("id_antigo" => 737,"id_novo" => 3114), array("id_antigo" => 1027,"id_novo" => 3370), array("id_antigo" => 1309,"id_novo" => 3626), array("id_antigo" => 233,"id_novo" => 2603), array("id_antigo" => 498,"id_novo" => 2859), array("id_antigo" => 738,"id_novo" => 3115), array("id_antigo" => 1028,"id_novo" => 3371), array("id_antigo" => 1310,"id_novo" => 3627), array("id_antigo" => 234,"id_novo" => 2604), array("id_antigo" => 499,"id_novo" => 2860), array("id_antigo" => 739,"id_novo" => 3116), array("id_antigo" => 1029,"id_novo" => 3372), array("id_antigo" => 1311,"id_novo" => 3628), array("id_antigo" => 235,"id_novo" => 2605), array("id_antigo" => 500,"id_novo" => 2861), array("id_antigo" => 740,"id_novo" => 3117), array("id_antigo" => 1030,"id_novo" => 3373), array("id_antigo" => 1312,"id_novo" => 3629), array("id_antigo" => 236,"id_novo" => 2606), array("id_antigo" => 501,"id_novo" => 2862), array("id_antigo" => 741,"id_novo" => 3118), array("id_antigo" => 1036,"id_novo" => 3374), array("id_antigo" => 1313,"id_novo" => 3630), array("id_antigo" => 237,"id_novo" => 2607), array("id_antigo" => 504,"id_novo" => 2863), array("id_antigo" => 742,"id_novo" => 3119), array("id_antigo" => 1037,"id_novo" => 3375), array("id_antigo" => 238,"id_novo" => 2608), array("id_antigo" => 502,"id_novo" => 2864), array("id_antigo" => 766,"id_novo" => 3120), array("id_antigo" => 1038,"id_novo" => 3376), array("id_antigo" => 1318,"id_novo" => 3632), array("id_antigo" => 239,"id_novo" => 2609), array("id_antigo" => 503,"id_novo" => 2865), array("id_antigo" => 743,"id_novo" => 3121), array("id_antigo" => 1039,"id_novo" => 3377), array("id_antigo" => 1319,"id_novo" => 3633), array("id_antigo" => 240,"id_novo" => 2610), array("id_antigo" => 505,"id_novo" => 2866), array("id_antigo" => 763,"id_novo" => 3122), array("id_antigo" => 1040,"id_novo" => 3378), array("id_antigo" => 1320,"id_novo" => 3634), array("id_antigo" => 241,"id_novo" => 2611), array("id_antigo" => 506,"id_novo" => 2867), array("id_antigo" => 744,"id_novo" => 3123), array("id_antigo" => 1041,"id_novo" => 3379), array("id_antigo" => 1321,"id_novo" => 3635), array("id_antigo" => 242,"id_novo" => 2612), array("id_antigo" => 507,"id_novo" => 2868), array("id_antigo" => 745,"id_novo" => 3124), array("id_antigo" => 1042,"id_novo" => 3380), array("id_antigo" => 1322,"id_novo" => 3636), array("id_antigo" => 243,"id_novo" => 2613), array("id_antigo" => 508,"id_novo" => 2869), array("id_antigo" => 760,"id_novo" => 3125), array("id_antigo" => 1043,"id_novo" => 3381), array("id_antigo" => 1323,"id_novo" => 3637), array("id_antigo" => 1210,"id_novo" => 5429), array("id_antigo" => 244,"id_novo" => 2614), array("id_antigo" => 509,"id_novo" => 2870), array("id_antigo" => 767,"id_novo" => 3126), array("id_antigo" => 1044,"id_novo" => 3382), array("id_antigo" => 1324,"id_novo" => 3638), array("id_antigo" => 245,"id_novo" => 2615), array("id_antigo" => 511,"id_novo" => 2871), array("id_antigo" => 747,"id_novo" => 3127), array("id_antigo" => 1045,"id_novo" => 3383), array("id_antigo" => 1325,"id_novo" => 3639), array("id_antigo" => 246,"id_novo" => 2616), array("id_antigo" => 512,"id_novo" => 2872), array("id_antigo" => 748,"id_novo" => 3128), array("id_antigo" => 1046,"id_novo" => 3384), array("id_antigo" => 1326,"id_novo" => 3640), array("id_antigo" => 247,"id_novo" => 2617), array("id_antigo" => 513,"id_novo" => 2873), array("id_antigo" => 749,"id_novo" => 3129), array("id_antigo" => 1047,"id_novo" => 3385), array("id_antigo" => 1327,"id_novo" => 3641), array("id_antigo" => 248,"id_novo" => 2618), array("id_antigo" => 514,"id_novo" => 2874), array("id_antigo" => 750,"id_novo" => 3130), array("id_antigo" => 1048,"id_novo" => 3386), array("id_antigo" => 1328,"id_novo" => 3642), array("id_antigo" => 249,"id_novo" => 2619), array("id_antigo" => 515,"id_novo" => 2875), array("id_antigo" => 751,"id_novo" => 3131), array("id_antigo" => 1049,"id_novo" => 3387), array("id_antigo" => 1329,"id_novo" => 3643), array("id_antigo" => 250,"id_novo" => 2620), array("id_antigo" => 516,"id_novo" => 2876), array("id_antigo" => 752,"id_novo" => 3132), array("id_antigo" => 1050,"id_novo" => 3388), array("id_antigo" => 1330,"id_novo" => 3644), array("id_antigo" => 251,"id_novo" => 2621), array("id_antigo" => 517,"id_novo" => 2877), array("id_antigo" => 1051,"id_novo" => 3389), array("id_antigo" => 1454,"id_novo" => 3645), array("id_antigo" => 252,"id_novo" => 2622), array("id_antigo" => 518,"id_novo" => 2878), array("id_antigo" => 754,"id_novo" => 3134), array("id_antigo" => 1052,"id_novo" => 3390), array("id_antigo" => 1453,"id_novo" => 3646), array("id_antigo" => 253,"id_novo" => 2623), array("id_antigo" => 519,"id_novo" => 2879), array("id_antigo" => 755,"id_novo" => 3135), array("id_antigo" => 1053,"id_novo" => 3391), array("id_antigo" => 1451,"id_novo" => 3647), array("id_antigo" => 764,"id_novo" => 2624), array("id_antigo" => 520,"id_novo" => 2880), array("id_antigo" => 756,"id_novo" => 3136), array("id_antigo" => 1054,"id_novo" => 3392), array("id_antigo" => 1452,"id_novo" => 3648), array("id_antigo" => 255,"id_novo" => 2625), array("id_antigo" => 521,"id_novo" => 2881), array("id_antigo" => 757,"id_novo" => 3137), array("id_antigo" => 1055,"id_novo" => 3393), array("id_antigo" => 1449,"id_novo" => 3649), array("id_antigo" => 256,"id_novo" => 2626), array("id_antigo" => 522,"id_novo" => 2882), array("id_antigo" => 774,"id_novo" => 3138), array("id_antigo" => 1056,"id_novo" => 3394), array("id_antigo" => 1450,"id_novo" => 3650), array("id_antigo" => 257,"id_novo" => 2627), array("id_antigo" => 523,"id_novo" => 2883), array("id_antigo" => 775,"id_novo" => 3139), array("id_antigo" => 1057,"id_novo" => 3395), array("id_antigo" => 1448,"id_novo" => 3651), array("id_antigo" => 258,"id_novo" => 2628), array("id_antigo" => 524,"id_novo" => 2884), array("id_antigo" => 777,"id_novo" => 3140), array("id_antigo" => 1058,"id_novo" => 3396), array("id_antigo" => 259,"id_novo" => 2629), array("id_antigo" => 525,"id_novo" => 2885), array("id_antigo" => 778,"id_novo" => 3141), array("id_antigo" => 1059,"id_novo" => 3397), array("id_antigo" => 1447,"id_novo" => 3653), array("id_antigo" => 260,"id_novo" => 2630), array("id_antigo" => 526,"id_novo" => 2886), array("id_antigo" => 779,"id_novo" => 3142), array("id_antigo" => 1060,"id_novo" => 3398), array("id_antigo" => 1445,"id_novo" => 3654), array("id_antigo" => 261,"id_novo" => 2631), array("id_antigo" => 527,"id_novo" => 2887), array("id_antigo" => 780,"id_novo" => 3143), array("id_antigo" => 1061,"id_novo" => 3399), array("id_antigo" => 262,"id_novo" => 2632), array("id_antigo" => 528,"id_novo" => 2888), array("id_antigo" => 841,"id_novo" => 3144), array("id_antigo" => 1062,"id_novo" => 3400), array("id_antigo" => 263,"id_novo" => 2633), array("id_antigo" => 529,"id_novo" => 2889), array("id_antigo" => 842,"id_novo" => 3145), array("id_antigo" => 1063,"id_novo" => 3401), array("id_antigo" => 1333,"id_novo" => 3657), array("id_antigo" => 264,"id_novo" => 2634), array("id_antigo" => 530,"id_novo" => 2890), array("id_antigo" => 781,"id_novo" => 3146), array("id_antigo" => 1064,"id_novo" => 3402), array("id_antigo" => 1334,"id_novo" => 3658), array("id_antigo" => 265,"id_novo" => 2635), array("id_antigo" => 531,"id_novo" => 2891), array("id_antigo" => 782,"id_novo" => 3147), array("id_antigo" => 1065,"id_novo" => 3403), array("id_antigo" => 1335,"id_novo" => 3659), array("id_antigo" => 266,"id_novo" => 2636), array("id_antigo" => 532,"id_novo" => 2892), array("id_antigo" => 783,"id_novo" => 3148), array("id_antigo" => 1066,"id_novo" => 3404), array("id_antigo" => 1336,"id_novo" => 3660), array("id_antigo" => 267,"id_novo" => 2637), array("id_antigo" => 533,"id_novo" => 2893), array("id_antigo" => 784,"id_novo" => 3149), array("id_antigo" => 1067,"id_novo" => 3405), array("id_antigo" => 1337,"id_novo" => 3661), array("id_antigo" => 268,"id_novo" => 2638), array("id_antigo" => 534,"id_novo" => 2894), array("id_antigo" => 785,"id_novo" => 3150), array("id_antigo" => 1068,"id_novo" => 3406), array("id_antigo" => 1338,"id_novo" => 3662), array("id_antigo" => 269,"id_novo" => 2639), array("id_antigo" => 535,"id_novo" => 2895), array("id_antigo" => 786,"id_novo" => 3151), array("id_antigo" => 1339,"id_novo" => 3663), array("id_antigo" => 753,"id_novo" => 2640), array("id_antigo" => 536,"id_novo" => 2896), array("id_antigo" => 787,"id_novo" => 3152), array("id_antigo" => 1340,"id_novo" => 3664), array("id_antigo" => 271,"id_novo" => 2641), array("id_antigo" => 537,"id_novo" => 2897), array("id_antigo" => 788,"id_novo" => 3153), array("id_antigo" => 1341,"id_novo" => 3665), array("id_antigo" => 272,"id_novo" => 2642), array("id_antigo" => 538,"id_novo" => 2898), array("id_antigo" => 789,"id_novo" => 3154), array("id_antigo" => 1342,"id_novo" => 3666), array("id_antigo" => 273,"id_novo" => 2643), array("id_antigo" => 840,"id_novo" => 2899), array("id_antigo" => 790,"id_novo" => 3155), array("id_antigo" => 1081,"id_novo" => 3411), array("id_antigo" => 1343,"id_novo" => 3667), array("id_antigo" => 274,"id_novo" => 2644), array("id_antigo" => 540,"id_novo" => 2900), array("id_antigo" => 791,"id_novo" => 3156), array("id_antigo" => 1074,"id_novo" => 3412), array("id_antigo" => 1344,"id_novo" => 3668), array("id_antigo" => 275,"id_novo" => 2645), array("id_antigo" => 541,"id_novo" => 2901), array("id_antigo" => 792,"id_novo" => 3157), array("id_antigo" => 1075,"id_novo" => 3413), array("id_antigo" => 1345,"id_novo" => 3669), array("id_antigo" => 276,"id_novo" => 2646), array("id_antigo" => 542,"id_novo" => 2902), array("id_antigo" => 793,"id_novo" => 3158), array("id_antigo" => 1076,"id_novo" => 3414), array("id_antigo" => 1346,"id_novo" => 3670), array("id_antigo" => 277,"id_novo" => 2647), array("id_antigo" => 543,"id_novo" => 2903), array("id_antigo" => 794,"id_novo" => 3159), array("id_antigo" => 1077,"id_novo" => 3415), array("id_antigo" => 1347,"id_novo" => 3671), array("id_antigo" => 278,"id_novo" => 2648), array("id_antigo" => 544,"id_novo" => 2904), array("id_antigo" => 795,"id_novo" => 3160), array("id_antigo" => 1078,"id_novo" => 3416), array("id_antigo" => 1348,"id_novo" => 3672), array("id_antigo" => 279,"id_novo" => 2649), array("id_antigo" => 545,"id_novo" => 2905), array("id_antigo" => 796,"id_novo" => 3161), array("id_antigo" => 1079,"id_novo" => 3417), array("id_antigo" => 1349,"id_novo" => 3673), array("id_antigo" => 280,"id_novo" => 2650), array("id_antigo" => 546,"id_novo" => 2906), array("id_antigo" => 797,"id_novo" => 3162), array("id_antigo" => 1085,"id_novo" => 3418), array("id_antigo" => 1350,"id_novo" => 3674), array("id_antigo" => 1247,"id_novo" => 5466), array("id_antigo" => 283,"id_novo" => 2651), array("id_antigo" => 547,"id_novo" => 2907), array("id_antigo" => 798,"id_novo" => 3163), array("id_antigo" => 1080,"id_novo" => 3419), array("id_antigo" => 1356,"id_novo" => 3675), array("id_antigo" => 284,"id_novo" => 2652), array("id_antigo" => 548,"id_novo" => 2908), array("id_antigo" => 799,"id_novo" => 3164), array("id_antigo" => 1082,"id_novo" => 3420), array("id_antigo" => 285,"id_novo" => 2653), array("id_antigo" => 549,"id_novo" => 2909), array("id_antigo" => 801,"id_novo" => 3165), array("id_antigo" => 1083,"id_novo" => 3421), array("id_antigo" => 1353,"id_novo" => 3677), array("id_antigo" => 286,"id_novo" => 2654), array("id_antigo" => 550,"id_novo" => 2910), array("id_antigo" => 802,"id_novo" => 3166), array("id_antigo" => 1084,"id_novo" => 3422), array("id_antigo" => 1354,"id_novo" => 3678), array("id_antigo" => 287,"id_novo" => 2655), array("id_antigo" => 551,"id_novo" => 2911), array("id_antigo" => 803,"id_novo" => 3167), array("id_antigo" => 1086,"id_novo" => 3423), array("id_antigo" => 1355,"id_novo" => 3679), array("id_antigo" => 288,"id_novo" => 2656), array("id_antigo" => 552,"id_novo" => 2912), array("id_antigo" => 804,"id_novo" => 3168), array("id_antigo" => 1087,"id_novo" => 3424), array("id_antigo" => 1357,"id_novo" => 3680), array("id_antigo" => 289,"id_novo" => 2657), array("id_antigo" => 553,"id_novo" => 2913), array("id_antigo" => 805,"id_novo" => 3169), array("id_antigo" => 1088,"id_novo" => 3425), array("id_antigo" => 1358,"id_novo" => 3681), array("id_antigo" => 290,"id_novo" => 2658), array("id_antigo" => 554,"id_novo" => 2914), array("id_antigo" => 806,"id_novo" => 3170), array("id_antigo" => 1089,"id_novo" => 3426), array("id_antigo" => 1359,"id_novo" => 3682), array("id_antigo" => 291,"id_novo" => 2659), array("id_antigo" => 556,"id_novo" => 2915), array("id_antigo" => 807,"id_novo" => 3171), array("id_antigo" => 1090,"id_novo" => 3427), array("id_antigo" => 1360,"id_novo" => 3683), array("id_antigo" => 292,"id_novo" => 2660), array("id_antigo" => 557,"id_novo" => 2916), array("id_antigo" => 808,"id_novo" => 3172), array("id_antigo" => 1091,"id_novo" => 3428), array("id_antigo" => 1361,"id_novo" => 3684), array("id_antigo" => 293,"id_novo" => 2661), array("id_antigo" => 558,"id_novo" => 2917), array("id_antigo" => 810,"id_novo" => 3173), array("id_antigo" => 1092,"id_novo" => 3429), array("id_antigo" => 1362,"id_novo" => 3685), array("id_antigo" => 294,"id_novo" => 2662), array("id_antigo" => 559,"id_novo" => 2918), array("id_antigo" => 811,"id_novo" => 3174), array("id_antigo" => 1093,"id_novo" => 3430), array("id_antigo" => 1363,"id_novo" => 3686), array("id_antigo" => 295,"id_novo" => 2663), array("id_antigo" => 560,"id_novo" => 2919), array("id_antigo" => 812,"id_novo" => 3175), array("id_antigo" => 1094,"id_novo" => 3431), array("id_antigo" => 1364,"id_novo" => 3687), array("id_antigo" => 296,"id_novo" => 2664), array("id_antigo" => 561,"id_novo" => 2920), array("id_antigo" => 813,"id_novo" => 3176), array("id_antigo" => 1095,"id_novo" => 3432), array("id_antigo" => 1365,"id_novo" => 3688), array("id_antigo" => 298,"id_novo" => 2665), array("id_antigo" => 843,"id_novo" => 2921), array("id_antigo" => 814,"id_novo" => 3177), array("id_antigo" => 1096,"id_novo" => 3433), array("id_antigo" => 1366,"id_novo" => 3689), array("id_antigo" => 299,"id_novo" => 2666), array("id_antigo" => 844,"id_novo" => 2922), array("id_antigo" => 815,"id_novo" => 3178), array("id_antigo" => 1097,"id_novo" => 3434), array("id_antigo" => 1367,"id_novo" => 3690), array("id_antigo" => 300,"id_novo" => 2667), array("id_antigo" => 563,"id_novo" => 2923), array("id_antigo" => 816,"id_novo" => 3179), array("id_antigo" => 1098,"id_novo" => 3435), array("id_antigo" => 1368,"id_novo" => 3691), array("id_antigo" => 301,"id_novo" => 2668), array("id_antigo" => 564,"id_novo" => 2924), array("id_antigo" => 817,"id_novo" => 3180), array("id_antigo" => 1099,"id_novo" => 3436), array("id_antigo" => 1369,"id_novo" => 3692), array("id_antigo" => 1265,"id_novo" => 5484), array("id_antigo" => 302,"id_novo" => 2669), array("id_antigo" => 565,"id_novo" => 2925), array("id_antigo" => 818,"id_novo" => 3181), array("id_antigo" => 1100,"id_novo" => 3437), array("id_antigo" => 303,"id_novo" => 2670), array("id_antigo" => 566,"id_novo" => 2926), array("id_antigo" => 819,"id_novo" => 3182), array("id_antigo" => 1101,"id_novo" => 3438), array("id_antigo" => 304,"id_novo" => 2671), array("id_antigo" => 567,"id_novo" => 2927), array("id_antigo" => 820,"id_novo" => 3183), array("id_antigo" => 1102,"id_novo" => 3439), array("id_antigo" => 305,"id_novo" => 2672), array("id_antigo" => 568,"id_novo" => 2928), array("id_antigo" => 821,"id_novo" => 3184), array("id_antigo" => 1103,"id_novo" => 3440), array("id_antigo" => 306,"id_novo" => 2673), array("id_antigo" => 569,"id_novo" => 2929), array("id_antigo" => 822,"id_novo" => 3185), array("id_antigo" => 1104,"id_novo" => 3441), array("id_antigo" => 307,"id_novo" => 2674), array("id_antigo" => 572,"id_novo" => 2930), array("id_antigo" => 823,"id_novo" => 3186), array("id_antigo" => 1105,"id_novo" => 3442), array("id_antigo" => 308,"id_novo" => 2675), array("id_antigo" => 574,"id_novo" => 2931), array("id_antigo" => 824,"id_novo" => 3187), array("id_antigo" => 1106,"id_novo" => 3443), array("id_antigo" => 309,"id_novo" => 2676), array("id_antigo" => 575,"id_novo" => 2932), array("id_antigo" => 825,"id_novo" => 3188), array("id_antigo" => 1107,"id_novo" => 3444), array("id_antigo" => 310,"id_novo" => 2677), array("id_antigo" => 576,"id_novo" => 2933), array("id_antigo" => 826,"id_novo" => 3189), array("id_antigo" => 1108,"id_novo" => 3445), array("id_antigo" => 311,"id_novo" => 2678), array("id_antigo" => 577,"id_novo" => 2934), array("id_antigo" => 827,"id_novo" => 3190), array("id_antigo" => 1109,"id_novo" => 3446), array("id_antigo" => 313,"id_novo" => 2679), array("id_antigo" => 578,"id_novo" => 2935), array("id_antigo" => 828,"id_novo" => 3191), array("id_antigo" => 1128,"id_novo" => 3447), array("id_antigo" => 314,"id_novo" => 2680), array("id_antigo" => 579,"id_novo" => 2936), array("id_antigo" => 845,"id_novo" => 3192), array("id_antigo" => 1129,"id_novo" => 3448), array("id_antigo" => 315,"id_novo" => 2681), array("id_antigo" => 644,"id_novo" => 2937), array("id_antigo" => 846,"id_novo" => 3193), array("id_antigo" => 1130,"id_novo" => 3449), array("id_antigo" => 316,"id_novo" => 2682), array("id_antigo" => 581,"id_novo" => 2938), array("id_antigo" => 847,"id_novo" => 3194), array("id_antigo" => 1131,"id_novo" => 3450), array("id_antigo" => 317,"id_novo" => 2683), array("id_antigo" => 582,"id_novo" => 2939), array("id_antigo" => 848,"id_novo" => 3195), array("id_antigo" => 1132,"id_novo" => 3451), array("id_antigo" => 318,"id_novo" => 2684), array("id_antigo" => 583,"id_novo" => 2940), array("id_antigo" => 849,"id_novo" => 3196), array("id_antigo" => 1133,"id_novo" => 3452), array("id_antigo" => 319,"id_novo" => 2685), array("id_antigo" => 584,"id_novo" => 2941), array("id_antigo" => 850,"id_novo" => 3197), array("id_antigo" => 1134,"id_novo" => 3453), array("id_antigo" => 320,"id_novo" => 2686), array("id_antigo" => 585,"id_novo" => 2942), array("id_antigo" => 851,"id_novo" => 3198), array("id_antigo" => 1135,"id_novo" => 3454), array("id_antigo" => 321,"id_novo" => 2687), array("id_antigo" => 586,"id_novo" => 2943), array("id_antigo" => 1136,"id_novo" => 3455), array("id_antigo" => 322,"id_novo" => 2688), array("id_antigo" => 587,"id_novo" => 2944), array("id_antigo" => 853,"id_novo" => 3200), array("id_antigo" => 1137,"id_novo" => 3456), array("id_antigo" => 703,"id_novo" => 2433), array("id_antigo" => 324,"id_novo" => 2689), array("id_antigo" => 588,"id_novo" => 2945), array("id_antigo" => 854,"id_novo" => 3201), array("id_antigo" => 1138,"id_novo" => 3457), array("id_antigo" => 1391,"id_novo" => 3713), array("id_antigo" => 510,"id_novo" => 2434), array("id_antigo" => 326,"id_novo" => 2690), array("id_antigo" => 589,"id_novo" => 2946), array("id_antigo" => 855,"id_novo" => 3202), array("id_antigo" => 1139,"id_novo" => 3458), array("id_antigo" => 1392,"id_novo" => 3714), array("id_antigo" => 658,"id_novo" => 2435), array("id_antigo" => 327,"id_novo" => 2691), array("id_antigo" => 590,"id_novo" => 2947), array("id_antigo" => 856,"id_novo" => 3203), array("id_antigo" => 1140,"id_novo" => 3459), array("id_antigo" => 1393,"id_novo" => 3715), array("id_antigo" => 11,"id_novo" => 2436), array("id_antigo" => 328,"id_novo" => 2692), array("id_antigo" => 591,"id_novo" => 2948), array("id_antigo" => 857,"id_novo" => 3204), array("id_antigo" => 1141,"id_novo" => 3460), array("id_antigo" => 1394,"id_novo" => 3716), array("id_antigo" => 12,"id_novo" => 2437), array("id_antigo" => 329,"id_novo" => 2693), array("id_antigo" => 592,"id_novo" => 2949), array("id_antigo" => 858,"id_novo" => 3205), array("id_antigo" => 1142,"id_novo" => 3461), array("id_antigo" => 1395,"id_novo" => 3717), array("id_antigo" => 13,"id_novo" => 2438), array("id_antigo" => 330,"id_novo" => 2694), array("id_antigo" => 593,"id_novo" => 2950), array("id_antigo" => 859,"id_novo" => 3206), array("id_antigo" => 1143,"id_novo" => 3462), array("id_antigo" => 1396,"id_novo" => 3718), array("id_antigo" => 14,"id_novo" => 2439), array("id_antigo" => 331,"id_novo" => 2695), array("id_antigo" => 594,"id_novo" => 2951), array("id_antigo" => 860,"id_novo" => 3207), array("id_antigo" => 1144,"id_novo" => 3463), array("id_antigo" => 1397,"id_novo" => 3719), array("id_antigo" => 15,"id_novo" => 2440), array("id_antigo" => 332,"id_novo" => 2696), array("id_antigo" => 595,"id_novo" => 2952), array("id_antigo" => 861,"id_novo" => 3208), array("id_antigo" => 1145,"id_novo" => 3464), array("id_antigo" => 1398,"id_novo" => 3720), array("id_antigo" => 16,"id_novo" => 2441), array("id_antigo" => 333,"id_novo" => 2697), array("id_antigo" => 596,"id_novo" => 2953), array("id_antigo" => 862,"id_novo" => 3209), array("id_antigo" => 1146,"id_novo" => 3465), array("id_antigo" => 1399,"id_novo" => 3721), array("id_antigo" => 17,"id_novo" => 2442), array("id_antigo" => 597,"id_novo" => 2954), array("id_antigo" => 863,"id_novo" => 3210), array("id_antigo" => 1147,"id_novo" => 3466), array("id_antigo" => 1400,"id_novo" => 3722), array("id_antigo" => 20,"id_novo" => 2443), array("id_antigo" => 335,"id_novo" => 2699), array("id_antigo" => 598,"id_novo" => 2955), array("id_antigo" => 864,"id_novo" => 3211), array("id_antigo" => 1401,"id_novo" => 3723), array("id_antigo" => 773,"id_novo" => 2444), array("id_antigo" => 336,"id_novo" => 2700), array("id_antigo" => 599,"id_novo" => 2956), array("id_antigo" => 865,"id_novo" => 3212), array("id_antigo" => 1149,"id_novo" => 3468), array("id_antigo" => 1402,"id_novo" => 3724), array("id_antigo" => 24,"id_novo" => 2445), array("id_antigo" => 337,"id_novo" => 2701), array("id_antigo" => 600,"id_novo" => 2957), array("id_antigo" => 866,"id_novo" => 3213), array("id_antigo" => 1150,"id_novo" => 3469), array("id_antigo" => 1403,"id_novo" => 3725), array("id_antigo" => 25,"id_novo" => 2446), array("id_antigo" => 338,"id_novo" => 2702), array("id_antigo" => 601,"id_novo" => 2958), array("id_antigo" => 867,"id_novo" => 3214), array("id_antigo" => 1151,"id_novo" => 3470), array("id_antigo" => 1404,"id_novo" => 3726), array("id_antigo" => 26,"id_novo" => 2447), array("id_antigo" => 339,"id_novo" => 2703), array("id_antigo" => 602,"id_novo" => 2959), array("id_antigo" => 868,"id_novo" => 3215), array("id_antigo" => 1152,"id_novo" => 3471), array("id_antigo" => 1405,"id_novo" => 3727), array("id_antigo" => 27,"id_novo" => 2448), array("id_antigo" => 466,"id_novo" => 2704), array("id_antigo" => 603,"id_novo" => 2960), array("id_antigo" => 870,"id_novo" => 3216), array("id_antigo" => 1153,"id_novo" => 3472), array("id_antigo" => 1406,"id_novo" => 3728), array("id_antigo" => 28,"id_novo" => 2449), array("id_antigo" => 340,"id_novo" => 2705), array("id_antigo" => 604,"id_novo" => 2961), array("id_antigo" => 871,"id_novo" => 3217), array("id_antigo" => 1154,"id_novo" => 3473), array("id_antigo" => 1407,"id_novo" => 3729), array("id_antigo" => 29,"id_novo" => 2450), array("id_antigo" => 341,"id_novo" => 2706), array("id_antigo" => 605,"id_novo" => 2962), array("id_antigo" => 872,"id_novo" => 3218), array("id_antigo" => 1155,"id_novo" => 3474), array("id_antigo" => 1408,"id_novo" => 3730), array("id_antigo" => 32,"id_novo" => 2451), array("id_antigo" => 342,"id_novo" => 2707), array("id_antigo" => 606,"id_novo" => 2963), array("id_antigo" => 873,"id_novo" => 3219), array("id_antigo" => 1156,"id_novo" => 3475), array("id_antigo" => 1409,"id_novo" => 3731), array("id_antigo" => 33,"id_novo" => 2452), array("id_antigo" => 343,"id_novo" => 2708), array("id_antigo" => 607,"id_novo" => 2964), array("id_antigo" => 874,"id_novo" => 3220), array("id_antigo" => 1157,"id_novo" => 3476), array("id_antigo" => 1410,"id_novo" => 3732), array("id_antigo" => 34,"id_novo" => 2453), array("id_antigo" => 344,"id_novo" => 2709), array("id_antigo" => 608,"id_novo" => 2965), array("id_antigo" => 875,"id_novo" => 3221), array("id_antigo" => 1158,"id_novo" => 3477), array("id_antigo" => 1411,"id_novo" => 3733), array("id_antigo" => 35,"id_novo" => 2454), array("id_antigo" => 345,"id_novo" => 2710), array("id_antigo" => 609,"id_novo" => 2966), array("id_antigo" => 876,"id_novo" => 3222), array("id_antigo" => 1159,"id_novo" => 3478), array("id_antigo" => 1412,"id_novo" => 3734), array("id_antigo" => 36,"id_novo" => 2455), array("id_antigo" => 346,"id_novo" => 2711), array("id_antigo" => 610,"id_novo" => 2967), array("id_antigo" => 877,"id_novo" => 3223), array("id_antigo" => 1160,"id_novo" => 3479), array("id_antigo" => 1413,"id_novo" => 3735), array("id_antigo" => 37,"id_novo" => 2456), array("id_antigo" => 347,"id_novo" => 2712), array("id_antigo" => 611,"id_novo" => 2968), array("id_antigo" => 878,"id_novo" => 3224), array("id_antigo" => 1161,"id_novo" => 3480), array("id_antigo" => 1414,"id_novo" => 3736), array("id_antigo" => 41,"id_novo" => 2457), array("id_antigo" => 348,"id_novo" => 2713), array("id_antigo" => 612,"id_novo" => 2969), array("id_antigo" => 1163,"id_novo" => 3481), array("id_antigo" => 1415,"id_novo" => 3737), array("id_antigo" => 42,"id_novo" => 2458), array("id_antigo" => 349,"id_novo" => 2714), array("id_antigo" => 613,"id_novo" => 2970), array("id_antigo" => 880,"id_novo" => 3226), array("id_antigo" => 1165,"id_novo" => 3482), array("id_antigo" => 1416,"id_novo" => 3738), array("id_antigo" => 44,"id_novo" => 2459), array("id_antigo" => 350,"id_novo" => 2715), array("id_antigo" => 614,"id_novo" => 2971), array("id_antigo" => 881,"id_novo" => 3227), array("id_antigo" => 1166,"id_novo" => 3483), array("id_antigo" => 1417,"id_novo" => 3739), array("id_antigo" => 45,"id_novo" => 2460), array("id_antigo" => 351,"id_novo" => 2716), array("id_antigo" => 615,"id_novo" => 2972), array("id_antigo" => 882,"id_novo" => 3228), array("id_antigo" => 1167,"id_novo" => 3484), array("id_antigo" => 1418,"id_novo" => 3740), array("id_antigo" => 46,"id_novo" => 2461), array("id_antigo" => 352,"id_novo" => 2717), array("id_antigo" => 616,"id_novo" => 2973), array("id_antigo" => 883,"id_novo" => 3229), array("id_antigo" => 1168,"id_novo" => 3485), array("id_antigo" => 1419,"id_novo" => 3741), array("id_antigo" => 59,"id_novo" => 2462), array("id_antigo" => 353,"id_novo" => 2718), array("id_antigo" => 617,"id_novo" => 2974), array("id_antigo" => 885,"id_novo" => 3230), array("id_antigo" => 1371,"id_novo" => 3486), array("id_antigo" => 1420,"id_novo" => 3742), array("id_antigo" => 63,"id_novo" => 2463), array("id_antigo" => 354,"id_novo" => 2719), array("id_antigo" => 618,"id_novo" => 2975), array("id_antigo" => 886,"id_novo" => 3231), array("id_antigo" => 1372,"id_novo" => 3487), array("id_antigo" => 1421,"id_novo" => 3743), array("id_antigo" => 772,"id_novo" => 2464), array("id_antigo" => 355,"id_novo" => 2720), array("id_antigo" => 619,"id_novo" => 2976), array("id_antigo" => 1190,"id_novo" => 3232), array("id_antigo" => 1376,"id_novo" => 3488), array("id_antigo" => 1422,"id_novo" => 3744), array("id_antigo" => 66,"id_novo" => 2465), array("id_antigo" => 699,"id_novo" => 2721), array("id_antigo" => 620,"id_novo" => 2977), array("id_antigo" => 889,"id_novo" => 3233), array("id_antigo" => 1389,"id_novo" => 3489), array("id_antigo" => 1423,"id_novo" => 3745), array("id_antigo" => 67,"id_novo" => 2466), array("id_antigo" => 357,"id_novo" => 2722), array("id_antigo" => 621,"id_novo" => 2978), array("id_antigo" => 891,"id_novo" => 3234), array("id_antigo" => 1173,"id_novo" => 3490), array("id_antigo" => 1424,"id_novo" => 3746), array("id_antigo" => 70,"id_novo" => 2467), array("id_antigo" => 358,"id_novo" => 2723), array("id_antigo" => 622,"id_novo" => 2979), array("id_antigo" => 892,"id_novo" => 3235), array("id_antigo" => 1174,"id_novo" => 3491), array("id_antigo" => 1425,"id_novo" => 3747), array("id_antigo" => 71,"id_novo" => 2468), array("id_antigo" => 359,"id_novo" => 2724), array("id_antigo" => 623,"id_novo" => 2980), array("id_antigo" => 894,"id_novo" => 3236), array("id_antigo" => 1175,"id_novo" => 3492), array("id_antigo" => 1426,"id_novo" => 3748), array("id_antigo" => 72,"id_novo" => 2469), array("id_antigo" => 360,"id_novo" => 2725), array("id_antigo" => 1440,"id_novo" => 2981), array("id_antigo" => 895,"id_novo" => 3237), array("id_antigo" => 1176,"id_novo" => 3493), array("id_antigo" => 1427,"id_novo" => 3749), array("id_antigo" => 73,"id_novo" => 2470), array("id_antigo" => 361,"id_novo" => 2726), array("id_antigo" => 625,"id_novo" => 2982), array("id_antigo" => 896,"id_novo" => 3238), array("id_antigo" => 1332,"id_novo" => 3494), array("id_antigo" => 1428,"id_novo" => 3750), array("id_antigo" => 74,"id_novo" => 2471), array("id_antigo" => 362,"id_novo" => 2727), array("id_antigo" => 626,"id_novo" => 2983), array("id_antigo" => 900,"id_novo" => 3239), array("id_antigo" => 1178,"id_novo" => 3495), array("id_antigo" => 1429,"id_novo" => 3751), array("id_antigo" => 75,"id_novo" => 2472), array("id_antigo" => 363,"id_novo" => 2728), array("id_antigo" => 627,"id_novo" => 2984), array("id_antigo" => 899,"id_novo" => 3240), array("id_antigo" => 1179,"id_novo" => 3496), array("id_antigo" => 1430,"id_novo" => 3752), array("id_antigo" => 78,"id_novo" => 2473), array("id_antigo" => 364,"id_novo" => 2729), array("id_antigo" => 628,"id_novo" => 2985), array("id_antigo" => 901,"id_novo" => 3241), array("id_antigo" => 1180,"id_novo" => 3497), array("id_antigo" => 81,"id_novo" => 2474), array("id_antigo" => 365,"id_novo" => 2730), array("id_antigo" => 629,"id_novo" => 2986), array("id_antigo" => 902,"id_novo" => 3242), array("id_antigo" => 1181,"id_novo" => 3498), array("id_antigo" => 1432,"id_novo" => 3754), array("id_antigo" => 82,"id_novo" => 2475), array("id_antigo" => 366,"id_novo" => 2731), array("id_antigo" => 630,"id_novo" => 2987), array("id_antigo" => 903,"id_novo" => 3243), array("id_antigo" => 1182,"id_novo" => 3499), array("id_antigo" => 1433,"id_novo" => 3755), array("id_antigo" => 83,"id_novo" => 2476), array("id_antigo" => 367,"id_novo" => 2732), array("id_antigo" => 632,"id_novo" => 2988), array("id_antigo" => 904,"id_novo" => 3244), array("id_antigo" => 1183,"id_novo" => 3500), array("id_antigo" => 1434,"id_novo" => 3756), array("id_antigo" => 84,"id_novo" => 2477), array("id_antigo" => 368,"id_novo" => 2733), array("id_antigo" => 633,"id_novo" => 2989), array("id_antigo" => 905,"id_novo" => 3245), array("id_antigo" => 1184,"id_novo" => 3501), array("id_antigo" => 1435,"id_novo" => 3757), array("id_antigo" => 85,"id_novo" => 2478), array("id_antigo" => 369,"id_novo" => 2734), array("id_antigo" => 634,"id_novo" => 2990), array("id_antigo" => 907,"id_novo" => 3246), array("id_antigo" => 1242,"id_novo" => 3502), array("id_antigo" => 1436,"id_novo" => 3758), array("id_antigo" => 89,"id_novo" => 2479), array("id_antigo" => 370,"id_novo" => 2735), array("id_antigo" => 635,"id_novo" => 2991), array("id_antigo" => 908,"id_novo" => 3247), array("id_antigo" => 1186,"id_novo" => 3503), array("id_antigo" => 1437,"id_novo" => 3759), array("id_antigo" => 90,"id_novo" => 2480), array("id_antigo" => 371,"id_novo" => 2736), array("id_antigo" => 636,"id_novo" => 2992), array("id_antigo" => 909,"id_novo" => 3248), array("id_antigo" => 1187,"id_novo" => 3504), array("id_antigo" => 1438,"id_novo" => 3760), array("id_antigo" => 91,"id_novo" => 2481), array("id_antigo" => 372,"id_novo" => 2737), array("id_antigo" => 637,"id_novo" => 2993), array("id_antigo" => 910,"id_novo" => 3249), array("id_antigo" => 1188,"id_novo" => 3505), array("id_antigo" => 1439,"id_novo" => 3761), array("id_antigo" => 92,"id_novo" => 2482), array("id_antigo" => 373,"id_novo" => 2738), array("id_antigo" => 638,"id_novo" => 2994), array("id_antigo" => 911,"id_novo" => 3250), array("id_antigo" => 1189,"id_novo" => 3506), array("id_antigo" => 1446,"id_novo" => 5554), array("id_antigo" => 93,"id_novo" => 2483), array("id_antigo" => 374,"id_novo" => 2739), array("id_antigo" => 639,"id_novo" => 2995), array("id_antigo" => 912,"id_novo" => 3251), array("id_antigo" => 1441,"id_novo" => 3763), array("id_antigo" => 94,"id_novo" => 2484), array("id_antigo" => 375,"id_novo" => 2740), array("id_antigo" => 640,"id_novo" => 2996), array("id_antigo" => 913,"id_novo" => 3252), array("id_antigo" => 1191,"id_novo" => 3508), array("id_antigo" => 1442,"id_novo" => 3764), array("id_antigo" => 95,"id_novo" => 2485), array("id_antigo" => 376,"id_novo" => 2741), array("id_antigo" => 641,"id_novo" => 2997), array("id_antigo" => 914,"id_novo" => 3253), array("id_antigo" => 1192,"id_novo" => 3509), array("id_antigo" => 1443,"id_novo" => 3765), array("id_antigo" => 96,"id_novo" => 2486), array("id_antigo" => 377,"id_novo" => 2742), array("id_antigo" => 642,"id_novo" => 2998), array("id_antigo" => 915,"id_novo" => 3254), array("id_antigo" => 1193,"id_novo" => 3510), array("id_antigo" => 1444,"id_novo" => 3766), array("id_antigo" => 98,"id_novo" => 2487), array("id_antigo" => 378,"id_novo" => 2743), array("id_antigo" => 643,"id_novo" => 2999), array("id_antigo" => 916,"id_novo" => 3255), array("id_antigo" => 1455,"id_novo" => 3767), array("id_antigo" => 100,"id_novo" => 2488), array("id_antigo" => 379,"id_novo" => 2744), array("id_antigo" => 917,"id_novo" => 3256), array("id_antigo" => 1195,"id_novo" => 3512), array("id_antigo" => 1456,"id_novo" => 3768), array("id_antigo" => 101,"id_novo" => 2489), array("id_antigo" => 380,"id_novo" => 2745), array("id_antigo" => 1110,"id_novo" => 3001), array("id_antigo" => 918,"id_novo" => 3257), array("id_antigo" => 1196,"id_novo" => 3513), array("id_antigo" => 1457,"id_novo" => 3769), array("id_antigo" => 102,"id_novo" => 2490), array("id_antigo" => 381,"id_novo" => 2746), array("id_antigo" => 1111,"id_novo" => 3002), array("id_antigo" => 919,"id_novo" => 3258), array("id_antigo" => 1197,"id_novo" => 3514), array("id_antigo" => 104,"id_novo" => 2491), array("id_antigo" => 382,"id_novo" => 2747), array("id_antigo" => 1378,"id_novo" => 3003), array("id_antigo" => 920,"id_novo" => 3259), array("id_antigo" => 1198,"id_novo" => 3515), array("id_antigo" => 106,"id_novo" => 2492), array("id_antigo" => 383,"id_novo" => 2748), array("id_antigo" => 1382,"id_novo" => 3004), array("id_antigo" => 921,"id_novo" => 3260), array("id_antigo" => 1199,"id_novo" => 3516), array("id_antigo" => 107,"id_novo" => 2493), array("id_antigo" => 384,"id_novo" => 2749), array("id_antigo" => 1383,"id_novo" => 3005), array("id_antigo" => 922,"id_novo" => 3261), array("id_antigo" => 1200,"id_novo" => 3517), array("id_antigo" => 109,"id_novo" => 2494), array("id_antigo" => 385,"id_novo" => 2750), array("id_antigo" => 1384,"id_novo" => 3006), array("id_antigo" => 923,"id_novo" => 3262), array("id_antigo" => 1201,"id_novo" => 3518), array("id_antigo" => 1069,"id_novo" => 5310), array("id_antigo" => 110,"id_novo" => 2495), array("id_antigo" => 386,"id_novo" => 2751), array("id_antigo" => 1373,"id_novo" => 3007), array("id_antigo" => 924,"id_novo" => 3263), array("id_antigo" => 1202,"id_novo" => 3519), array("id_antigo" => 1071,"id_novo" => 5311), array("id_antigo" => 387,"id_novo" => 2496), array("id_antigo" => 1375,"id_novo" => 3008), array("id_antigo" => 925,"id_novo" => 3264), array("id_antigo" => 1203,"id_novo" => 3520), array("id_antigo" => 1072,"id_novo" => 5312), array("id_antigo" => 114,"id_novo" => 2497), array("id_antigo" => 388,"id_novo" => 2753), array("id_antigo" => 1379,"id_novo" => 3009), array("id_antigo" => 926,"id_novo" => 3265), array("id_antigo" => 1204,"id_novo" => 3521), array("id_antigo" => 115,"id_novo" => 2498), array("id_antigo" => 389,"id_novo" => 2754), array("id_antigo" => 1386,"id_novo" => 3010), array("id_antigo" => 927,"id_novo" => 3266), array("id_antigo" => 1205,"id_novo" => 3522), array("id_antigo" => 118,"id_novo" => 2499), array("id_antigo" => 390,"id_novo" => 2755), array("id_antigo" => 1388,"id_novo" => 3011), array("id_antigo" => 928,"id_novo" => 3267), array("id_antigo" => 1206,"id_novo" => 3523), array("id_antigo" => 119,"id_novo" => 2500), array("id_antigo" => 391,"id_novo" => 2756), array("id_antigo" => 1377,"id_novo" => 3012), array("id_antigo" => 929,"id_novo" => 3268), array("id_antigo" => 1207,"id_novo" => 3524), array("id_antigo" => 121,"id_novo" => 2501), array("id_antigo" => 392,"id_novo" => 2757), array("id_antigo" => 1381,"id_novo" => 3013), array("id_antigo" => 930,"id_novo" => 3269), array("id_antigo" => 1208,"id_novo" => 3525), array("id_antigo" => 126,"id_novo" => 2502), array("id_antigo" => 393,"id_novo" => 2758), array("id_antigo" => 1387,"id_novo" => 3014), array("id_antigo" => 931,"id_novo" => 3270), array("id_antigo" => 1209,"id_novo" => 3526), array("id_antigo" => 758,"id_novo" => 2503), array("id_antigo" => 394,"id_novo" => 2759), array("id_antigo" => 1370,"id_novo" => 3015), array("id_antigo" => 932,"id_novo" => 3271), array("id_antigo" => 839,"id_novo" => 2504), array("id_antigo" => 395,"id_novo" => 2760), array("id_antigo" => 1390,"id_novo" => 3016), array("id_antigo" => 933,"id_novo" => 3272), array("id_antigo" => 1352,"id_novo" => 3528), array("id_antigo" => 769,"id_novo" => 2505), array("id_antigo" => 396,"id_novo" => 2761), array("id_antigo" => 1380,"id_novo" => 3017), array("id_antigo" => 934,"id_novo" => 3273), array("id_antigo" => 1212,"id_novo" => 3529), array("id_antigo" => 132,"id_novo" => 2506), array("id_antigo" => 397,"id_novo" => 2762), array("id_antigo" => 646,"id_novo" => 3018), array("id_antigo" => 952,"id_novo" => 3274), array("id_antigo" => 1213,"id_novo" => 3530), array("id_antigo" => 770,"id_novo" => 2507), array("id_antigo" => 398,"id_novo" => 2763), array("id_antigo" => 647,"id_novo" => 3019), array("id_antigo" => 953,"id_novo" => 3275), array("id_antigo" => 1214,"id_novo" => 3531), array("id_antigo" => 771,"id_novo" => 2508), array("id_antigo" => 399,"id_novo" => 2764), array("id_antigo" => 648,"id_novo" => 3020), array("id_antigo" => 954,"id_novo" => 3276), array("id_antigo" => 1215,"id_novo" => 3532), array("id_antigo" => 133,"id_novo" => 2509), array("id_antigo" => 400,"id_novo" => 2765), array("id_antigo" => 649,"id_novo" => 3021), array("id_antigo" => 955,"id_novo" => 3277), array("id_antigo" => 1216,"id_novo" => 3533), array("id_antigo" => 134,"id_novo" => 2510), array("id_antigo" => 401,"id_novo" => 2766), array("id_antigo" => 650,"id_novo" => 3022), array("id_antigo" => 935,"id_novo" => 3278), array("id_antigo" => 1217,"id_novo" => 3534), array("id_antigo" => 135,"id_novo" => 2511), array("id_antigo" => 402,"id_novo" => 2767), array("id_antigo" => 651,"id_novo" => 3023), array("id_antigo" => 936,"id_novo" => 3279), array("id_antigo" => 1218,"id_novo" => 3535), array("id_antigo" => 136,"id_novo" => 2512), array("id_antigo" => 403,"id_novo" => 2768), array("id_antigo" => 653,"id_novo" => 3024), array("id_antigo" => 937,"id_novo" => 3280), array("id_antigo" => 1219,"id_novo" => 3536), array("id_antigo" => 137,"id_novo" => 2513), array("id_antigo" => 404,"id_novo" => 2769), array("id_antigo" => 654,"id_novo" => 3025), array("id_antigo" => 938,"id_novo" => 3281), array("id_antigo" => 1220,"id_novo" => 3537), array("id_antigo" => 138,"id_novo" => 2514), array("id_antigo" => 405,"id_novo" => 2770), array("id_antigo" => 655,"id_novo" => 3026), array("id_antigo" => 939,"id_novo" => 3282), array("id_antigo" => 1221,"id_novo" => 3538), array("id_antigo" => 139,"id_novo" => 2515), array("id_antigo" => 406,"id_novo" => 2771), array("id_antigo" => 656,"id_novo" => 3027), array("id_antigo" => 940,"id_novo" => 3283), array("id_antigo" => 1222,"id_novo" => 3539), array("id_antigo" => 140,"id_novo" => 2516), array("id_antigo" => 407,"id_novo" => 2772), array("id_antigo" => 657,"id_novo" => 3028), array("id_antigo" => 941,"id_novo" => 3284), array("id_antigo" => 1223,"id_novo" => 3540), array("id_antigo" => 141,"id_novo" => 2517), array("id_antigo" => 408,"id_novo" => 2773), array("id_antigo" => 659,"id_novo" => 3029), array("id_antigo" => 942,"id_novo" => 3285), array("id_antigo" => 1431,"id_novo" => 3541), array("id_antigo" => 143,"id_novo" => 2518), array("id_antigo" => 409,"id_novo" => 2774), array("id_antigo" => 660,"id_novo" => 3030), array("id_antigo" => 943,"id_novo" => 3286), array("id_antigo" => 1225,"id_novo" => 3542), array("id_antigo" => 144,"id_novo" => 2519), array("id_antigo" => 410,"id_novo" => 2775), array("id_antigo" => 661,"id_novo" => 3031), array("id_antigo" => 944,"id_novo" => 3287), array("id_antigo" => 145,"id_novo" => 2520), array("id_antigo" => 411,"id_novo" => 2776), array("id_antigo" => 662,"id_novo" => 3032), array("id_antigo" => 945,"id_novo" => 3288), array("id_antigo" => 1227,"id_novo" => 3544), array("id_antigo" => 146,"id_novo" => 2521), array("id_antigo" => 412,"id_novo" => 2777), array("id_antigo" => 663,"id_novo" => 3033), array("id_antigo" => 946,"id_novo" => 3289), array("id_antigo" => 1228,"id_novo" => 3545), array("id_antigo" => 147,"id_novo" => 2522), array("id_antigo" => 413,"id_novo" => 2778), array("id_antigo" => 664,"id_novo" => 3034), array("id_antigo" => 947,"id_novo" => 3290), array("id_antigo" => 1229,"id_novo" => 3546), array("id_antigo" => 148,"id_novo" => 2523), array("id_antigo" => 414,"id_novo" => 2779), array("id_antigo" => 665,"id_novo" => 3035), array("id_antigo" => 948,"id_novo" => 3291), array("id_antigo" => 1230,"id_novo" => 3547), array("id_antigo" => 149,"id_novo" => 2524), array("id_antigo" => 415,"id_novo" => 2780), array("id_antigo" => 666,"id_novo" => 3036), array("id_antigo" => 1001,"id_novo" => 3292), array("id_antigo" => 1231,"id_novo" => 3548), array("id_antigo" => 150,"id_novo" => 2525), array("id_antigo" => 416,"id_novo" => 2781), array("id_antigo" => 838,"id_novo" => 3037), array("id_antigo" => 950,"id_novo" => 3293), array("id_antigo" => 151,"id_novo" => 2526), array("id_antigo" => 417,"id_novo" => 2782), array("id_antigo" => 667,"id_novo" => 3038), array("id_antigo" => 951,"id_novo" => 3294), array("id_antigo" => 164,"id_novo" => 2527), array("id_antigo" => 418,"id_novo" => 2783), array("id_antigo" => 668,"id_novo" => 3039), array("id_antigo" => 992,"id_novo" => 3295), array("id_antigo" => 1234,"id_novo" => 3551), array("id_antigo" => 153,"id_novo" => 2528), array("id_antigo" => 419,"id_novo" => 2784), array("id_antigo" => 669,"id_novo" => 3040), array("id_antigo" => 957,"id_novo" => 3296), array("id_antigo" => 1235,"id_novo" => 3552), array("id_antigo" => 154,"id_novo" => 2529), array("id_antigo" => 420,"id_novo" => 2785), array("id_antigo" => 670,"id_novo" => 3041), array("id_antigo" => 958,"id_novo" => 3297), array("id_antigo" => 1236,"id_novo" => 3553), array("id_antigo" => 155,"id_novo" => 2530), array("id_antigo" => 421,"id_novo" => 2786), array("id_antigo" => 671,"id_novo" => 3042), array("id_antigo" => 959,"id_novo" => 3298), array("id_antigo" => 1237,"id_novo" => 3554), array("id_antigo" => 157,"id_novo" => 2531), array("id_antigo" => 422,"id_novo" => 2787), array("id_antigo" => 672,"id_novo" => 3043), array("id_antigo" => 961,"id_novo" => 3299), array("id_antigo" => 1238,"id_novo" => 3555), array("id_antigo" => 158,"id_novo" => 2532), array("id_antigo" => 423,"id_novo" => 2788), array("id_antigo" => 673,"id_novo" => 3044), array("id_antigo" => 962,"id_novo" => 3300), array("id_antigo" => 1239,"id_novo" => 3556), array("id_antigo" => 160,"id_novo" => 2533), array("id_antigo" => 424,"id_novo" => 2789), array("id_antigo" => 674,"id_novo" => 3045), array("id_antigo" => 974,"id_novo" => 3301), array("id_antigo" => 1240,"id_novo" => 3557), array("id_antigo" => 161,"id_novo" => 2534), array("id_antigo" => 425,"id_novo" => 2790), array("id_antigo" => 675,"id_novo" => 3046), array("id_antigo" => 963,"id_novo" => 3302), array("id_antigo" => 1241,"id_novo" => 3558), array("id_antigo" => 162,"id_novo" => 2535), array("id_antigo" => 427,"id_novo" => 2791), array("id_antigo" => 676,"id_novo" => 3047), array("id_antigo" => 964,"id_novo" => 3303), array("id_antigo" => 163,"id_novo" => 2536), array("id_antigo" => 428,"id_novo" => 2792), array("id_antigo" => 677,"id_novo" => 3048), array("id_antigo" => 965,"id_novo" => 3304), array("id_antigo" => 1243,"id_novo" => 3560), array("id_antigo" => 429,"id_novo" => 2793), array("id_antigo" => 678,"id_novo" => 3049), array("id_antigo" => 966,"id_novo" => 3305), array("id_antigo" => 1244,"id_novo" => 3561), array("id_antigo" => 166,"id_novo" => 2538), array("id_antigo" => 430,"id_novo" => 2794), array("id_antigo" => 679,"id_novo" => 3050), array("id_antigo" => 967,"id_novo" => 3306), array("id_antigo" => 1245,"id_novo" => 3562), array("id_antigo" => 167,"id_novo" => 2539), array("id_antigo" => 431,"id_novo" => 2795), array("id_antigo" => 680,"id_novo" => 3051), array("id_antigo" => 968,"id_novo" => 3307), array("id_antigo" => 1246,"id_novo" => 3563), array("id_antigo" => 168,"id_novo" => 2540), array("id_antigo" => 432,"id_novo" => 2796), array("id_antigo" => 681,"id_novo" => 3052), array("id_antigo" => 969,"id_novo" => 3308), array("id_antigo" => 169,"id_novo" => 2541), array("id_antigo" => 433,"id_novo" => 2797), array("id_antigo" => 682,"id_novo" => 3053), array("id_antigo" => 970,"id_novo" => 3309), array("id_antigo" => 1248,"id_novo" => 3565), array("id_antigo" => 170,"id_novo" => 2542), array("id_antigo" => 434,"id_novo" => 2798), array("id_antigo" => 683,"id_novo" => 3054), array("id_antigo" => 971,"id_novo" => 3310), array("id_antigo" => 1249,"id_novo" => 3566), array("id_antigo" => 852,"id_novo" => 5102), array("id_antigo" => 171,"id_novo" => 2543), array("id_antigo" => 435,"id_novo" => 2799), array("id_antigo" => 684,"id_novo" => 3055), array("id_antigo" => 976,"id_novo" => 3311), array("id_antigo" => 1250,"id_novo" => 3567), array("id_antigo" => 173,"id_novo" => 2544), array("id_antigo" => 436,"id_novo" => 2800), array("id_antigo" => 685,"id_novo" => 3056), array("id_antigo" => 972,"id_novo" => 3312), array("id_antigo" => 174,"id_novo" => 2545), array("id_antigo" => 437,"id_novo" => 2801), array("id_antigo" => 686,"id_novo" => 3057), array("id_antigo" => 973,"id_novo" => 3313), array("id_antigo" => 175,"id_novo" => 2546), array("id_antigo" => 438,"id_novo" => 2802), array("id_antigo" => 687,"id_novo" => 3058), array("id_antigo" => 975,"id_novo" => 3314), array("id_antigo" => 1253,"id_novo" => 3570), array("id_antigo" => 176,"id_novo" => 2547), array("id_antigo" => 439,"id_novo" => 2803), array("id_antigo" => 688,"id_novo" => 3059), array("id_antigo" => 1015,"id_novo" => 3315), array("id_antigo" => 1254,"id_novo" => 3571), array("id_antigo" => 178,"id_novo" => 2548), array("id_antigo" => 440,"id_novo" => 2804), array("id_antigo" => 689,"id_novo" => 3060), array("id_antigo" => 977,"id_novo" => 3316), array("id_antigo" => 1255,"id_novo" => 3572), array("id_antigo" => 179,"id_novo" => 2549), array("id_antigo" => 441,"id_novo" => 2805), array("id_antigo" => 690,"id_novo" => 3061), array("id_antigo" => 978,"id_novo" => 3317), array("id_antigo" => 1256,"id_novo" => 3573), array("id_antigo" => 180,"id_novo" => 2550), array("id_antigo" => 442,"id_novo" => 2806), array("id_antigo" => 691,"id_novo" => 3062), array("id_antigo" => 979,"id_novo" => 3318), array("id_antigo" => 1257,"id_novo" => 3574), array("id_antigo" => 181,"id_novo" => 2551), array("id_antigo" => 443,"id_novo" => 2807), array("id_antigo" => 692,"id_novo" => 3063), array("id_antigo" => 980,"id_novo" => 3319), array("id_antigo" => 1258,"id_novo" => 3575), array("id_antigo" => 768,"id_novo" => 2552), array("id_antigo" => 444,"id_novo" => 2808), array("id_antigo" => 693,"id_novo" => 3064), array("id_antigo" => 981,"id_novo" => 3320), array("id_antigo" => 1259,"id_novo" => 3576), array("id_antigo" => 184,"id_novo" => 2553), array("id_antigo" => 445,"id_novo" => 2809), array("id_antigo" => 694,"id_novo" => 3065), array("id_antigo" => 982,"id_novo" => 3321), array("id_antigo" => 1260,"id_novo" => 3577), array("id_antigo" => 334,"id_novo" => 4601), array("id_antigo" => 187,"id_novo" => 2554), array("id_antigo" => 446,"id_novo" => 2810), array("id_antigo" => 695,"id_novo" => 3066), array("id_antigo" => 983,"id_novo" => 3322), array("id_antigo" => 1261,"id_novo" => 3578), array("id_antigo" => 188,"id_novo" => 2555), array("id_antigo" => 447,"id_novo" => 2811), array("id_antigo" => 696,"id_novo" => 3067), array("id_antigo" => 984,"id_novo" => 3323), array("id_antigo" => 1262,"id_novo" => 3579), array("id_antigo" => 189,"id_novo" => 2556), array("id_antigo" => 448,"id_novo" => 2812), array("id_antigo" => 800,"id_novo" => 3068), array("id_antigo" => 985,"id_novo" => 3324), array("id_antigo" => 1263,"id_novo" => 3580), array("id_antigo" => 190,"id_novo" => 2557), array("id_antigo" => 449,"id_novo" => 2813), array("id_antigo" => 697,"id_novo" => 3069), array("id_antigo" => 1374,"id_novo" => 3325), array("id_antigo" => 1264,"id_novo" => 3581), array("id_antigo" => 191,"id_novo" => 2558), array("id_antigo" => 450,"id_novo" => 2814), array("id_antigo" => 698,"id_novo" => 3070), array("id_antigo" => 987,"id_novo" => 3326), array("id_antigo" => 192,"id_novo" => 2559), array("id_antigo" => 451,"id_novo" => 2815), array("id_antigo" => 988,"id_novo" => 3327), array("id_antigo" => 1266,"id_novo" => 3583) );


//
//
//
//
//
//
//
//


$arr_autor = array(array("id_antigo_autor" => 208,"id_novo_autor" => 2048), array("id_antigo_autor" => 542,"id_novo_autor" => 2304), array("id_antigo_autor" => 209,"id_novo_autor" => 2049), array("id_antigo_autor" => 543,"id_novo_autor" => 2305), array("id_antigo_autor" => 210,"id_novo_autor" => 2050), array("id_antigo_autor" => 544,"id_novo_autor" => 2306), array("id_antigo_autor" => 211,"id_novo_autor" => 2051), array("id_antigo_autor" => 545,"id_novo_autor" => 2307), array("id_antigo_autor" => 212,"id_novo_autor" => 2052), array("id_antigo_autor" => 546,"id_novo_autor" => 2308), array("id_antigo_autor" => 213,"id_novo_autor" => 2053), array("id_antigo_autor" => 547,"id_novo_autor" => 2309), array("id_antigo_autor" => 463,"id_novo_autor" => 2054), array("id_antigo_autor" => 548,"id_novo_autor" => 2310), array("id_antigo_autor" => 450,"id_novo_autor" => 2055), array("id_antigo_autor" => 549,"id_novo_autor" => 2311), array("id_antigo_autor" => 432,"id_novo_autor" => 2056), array("id_antigo_autor" => 550,"id_novo_autor" => 2312), array("id_antigo_autor" => 217,"id_novo_autor" => 2057), array("id_antigo_autor" => 551,"id_novo_autor" => 2313), array("id_antigo_autor" => 218,"id_novo_autor" => 2058), array("id_antigo_autor" => 552,"id_novo_autor" => 2314), array("id_antigo_autor" => 219,"id_novo_autor" => 2059), array("id_antigo_autor" => 553,"id_novo_autor" => 2315), array("id_antigo_autor" => 220,"id_novo_autor" => 2060), array("id_antigo_autor" => 554,"id_novo_autor" => 2316), array("id_antigo_autor" => 434,"id_novo_autor" => 2061), array("id_antigo_autor" => 555,"id_novo_autor" => 2317), array("id_antigo_autor" => 222,"id_novo_autor" => 2062), array("id_antigo_autor" => 556,"id_novo_autor" => 2318), array("id_antigo_autor" => 223,"id_novo_autor" => 2063), array("id_antigo_autor" => 557,"id_novo_autor" => 2319), array("id_antigo_autor" => 224,"id_novo_autor" => 2064), array("id_antigo_autor" => 558,"id_novo_autor" => 2320), array("id_antigo_autor" => 225,"id_novo_autor" => 2065), array("id_antigo_autor" => 559,"id_novo_autor" => 2321), array("id_antigo_autor" => 226,"id_novo_autor" => 2066), array("id_antigo_autor" => 560,"id_novo_autor" => 2322), array("id_antigo_autor" => 227,"id_novo_autor" => 2067), array("id_antigo_autor" => 561,"id_novo_autor" => 2323), array("id_antigo_autor" => 229,"id_novo_autor" => 2068), array("id_antigo_autor" => 562,"id_novo_autor" => 2324), array("id_antigo_autor" => 230,"id_novo_autor" => 2069), array("id_antigo_autor" => 563,"id_novo_autor" => 2325), array("id_antigo_autor" => 231,"id_novo_autor" => 2070), array("id_antigo_autor" => 564,"id_novo_autor" => 2326), array("id_antigo_autor" => 232,"id_novo_autor" => 2071), array("id_antigo_autor" => 565,"id_novo_autor" => 2327), array("id_antigo_autor" => 233,"id_novo_autor" => 2072), array("id_antigo_autor" => 234,"id_novo_autor" => 2073), array("id_antigo_autor" => 567,"id_novo_autor" => 2329), array("id_antigo_autor" => 440,"id_novo_autor" => 2074), array("id_antigo_autor" => 568,"id_novo_autor" => 2330), array("id_antigo_autor" => 237,"id_novo_autor" => 2075), array("id_antigo_autor" => 569,"id_novo_autor" => 2331), array("id_antigo_autor" => 238,"id_novo_autor" => 2076), array("id_antigo_autor" => 570,"id_novo_autor" => 2332), array("id_antigo_autor" => 239,"id_novo_autor" => 2077), array("id_antigo_autor" => 571,"id_novo_autor" => 2333), array("id_antigo_autor" => 240,"id_novo_autor" => 2078), array("id_antigo_autor" => 572,"id_novo_autor" => 2334), array("id_antigo_autor" => 241,"id_novo_autor" => 2079), array("id_antigo_autor" => 242,"id_novo_autor" => 2080), array("id_antigo_autor" => 574,"id_novo_autor" => 2336), array("id_antigo_autor" => 243,"id_novo_autor" => 2081), array("id_antigo_autor" => 575,"id_novo_autor" => 2337), array("id_antigo_autor" => 244,"id_novo_autor" => 2082), array("id_antigo_autor" => 576,"id_novo_autor" => 2338), array("id_antigo_autor" => 245,"id_novo_autor" => 2083), array("id_antigo_autor" => 577,"id_novo_autor" => 2339), array("id_antigo_autor" => 246,"id_novo_autor" => 2084), array("id_antigo_autor" => 578,"id_novo_autor" => 2340), array("id_antigo_autor" => 247,"id_novo_autor" => 2085), array("id_antigo_autor" => 579,"id_novo_autor" => 2341), array("id_antigo_autor" => 248,"id_novo_autor" => 2086), array("id_antigo_autor" => 580,"id_novo_autor" => 2342), array("id_antigo_autor" => 249,"id_novo_autor" => 2087), array("id_antigo_autor" => 581,"id_novo_autor" => 2343), array("id_antigo_autor" => 250,"id_novo_autor" => 2088), array("id_antigo_autor" => 582,"id_novo_autor" => 2344), array("id_antigo_autor" => 252,"id_novo_autor" => 2089), array("id_antigo_autor" => 583,"id_novo_autor" => 2345), array("id_antigo_autor" => 253,"id_novo_autor" => 2090), array("id_antigo_autor" => 584,"id_novo_autor" => 2346), array("id_antigo_autor" => 254,"id_novo_autor" => 2091), array("id_antigo_autor" => 585,"id_novo_autor" => 2347), array("id_antigo_autor" => 255,"id_novo_autor" => 2092), array("id_antigo_autor" => 586,"id_novo_autor" => 2348), array("id_antigo_autor" => 468,"id_novo_autor" => 2093), array("id_antigo_autor" => 587,"id_novo_autor" => 2349), array("id_antigo_autor" => 460,"id_novo_autor" => 2094), array("id_antigo_autor" => 588,"id_novo_autor" => 2350), array("id_antigo_autor" => 258,"id_novo_autor" => 2095), array("id_antigo_autor" => 589,"id_novo_autor" => 2351), array("id_antigo_autor" => 259,"id_novo_autor" => 2096), array("id_antigo_autor" => 590,"id_novo_autor" => 2352), array("id_antigo_autor" => 260,"id_novo_autor" => 2097), array("id_antigo_autor" => 591,"id_novo_autor" => 2353), array("id_antigo_autor" => 261,"id_novo_autor" => 2098), array("id_antigo_autor" => 592,"id_novo_autor" => 2354), array("id_antigo_autor" => 400,"id_novo_autor" => 2099), array("id_antigo_autor" => 593,"id_novo_autor" => 2355), array("id_antigo_autor" => 263,"id_novo_autor" => 2100), array("id_antigo_autor" => 594,"id_novo_autor" => 2356), array("id_antigo_autor" => 264,"id_novo_autor" => 2101), array("id_antigo_autor" => 595,"id_novo_autor" => 2357), array("id_antigo_autor" => 265,"id_novo_autor" => 2102), array("id_antigo_autor" => 596,"id_novo_autor" => 2358), array("id_antigo_autor" => 439,"id_novo_autor" => 2103), array("id_antigo_autor" => 597,"id_novo_autor" => 2359), array("id_antigo_autor" => 268,"id_novo_autor" => 2104), array("id_antigo_autor" => 598,"id_novo_autor" => 2360), array("id_antigo_autor" => 455,"id_novo_autor" => 2105), array("id_antigo_autor" => 599,"id_novo_autor" => 2361), array("id_antigo_autor" => 270,"id_novo_autor" => 2106), array("id_antigo_autor" => 600,"id_novo_autor" => 2362), array("id_antigo_autor" => 271,"id_novo_autor" => 2107), array("id_antigo_autor" => 601,"id_novo_autor" => 2363), array("id_antigo_autor" => 272,"id_novo_autor" => 2108), array("id_antigo_autor" => 602,"id_novo_autor" => 2364), array("id_antigo_autor" => 273,"id_novo_autor" => 2109), array("id_antigo_autor" => 603,"id_novo_autor" => 2365), array("id_antigo_autor" => 274,"id_novo_autor" => 2110), array("id_antigo_autor" => 604,"id_novo_autor" => 2366), array("id_antigo_autor" => 275,"id_novo_autor" => 2111), array("id_antigo_autor" => 605,"id_novo_autor" => 2367), array("id_antigo_autor" => 276,"id_novo_autor" => 2112), array("id_antigo_autor" => 606,"id_novo_autor" => 2368), array("id_antigo_autor" => 277,"id_novo_autor" => 2113), array("id_antigo_autor" => 607,"id_novo_autor" => 2369), array("id_antigo_autor" => 1,"id_novo_autor" => 1858), array("id_antigo_autor" => 278,"id_novo_autor" => 2114), array("id_antigo_autor" => 608,"id_novo_autor" => 2370), array("id_antigo_autor" => 2,"id_novo_autor" => 1859), array("id_antigo_autor" => 279,"id_novo_autor" => 2115), array("id_antigo_autor" => 609,"id_novo_autor" => 2371), array("id_antigo_autor" => 3,"id_novo_autor" => 1860), array("id_antigo_autor" => 456,"id_novo_autor" => 2116), array("id_antigo_autor" => 610,"id_novo_autor" => 2372), array("id_antigo_autor" => 4,"id_novo_autor" => 1861), array("id_antigo_autor" => 283,"id_novo_autor" => 2117), array("id_antigo_autor" => 611,"id_novo_autor" => 2373), array("id_antigo_autor" => 5,"id_novo_autor" => 1862), array("id_antigo_autor" => 284,"id_novo_autor" => 2118), array("id_antigo_autor" => 612,"id_novo_autor" => 2374), array("id_antigo_autor" => 6,"id_novo_autor" => 1863), array("id_antigo_autor" => 285,"id_novo_autor" => 2119), array("id_antigo_autor" => 613,"id_novo_autor" => 2375), array("id_antigo_autor" => 7,"id_novo_autor" => 1864), array("id_antigo_autor" => 286,"id_novo_autor" => 2120), array("id_antigo_autor" => 614,"id_novo_autor" => 2376), array("id_antigo_autor" => 8,"id_novo_autor" => 1865), array("id_antigo_autor" => 287,"id_novo_autor" => 2121), array("id_antigo_autor" => 615,"id_novo_autor" => 2377), array("id_antigo_autor" => 9,"id_novo_autor" => 1866), array("id_antigo_autor" => 288,"id_novo_autor" => 2122), array("id_antigo_autor" => 616,"id_novo_autor" => 2378), array("id_antigo_autor" => 10,"id_novo_autor" => 1867), array("id_antigo_autor" => 290,"id_novo_autor" => 2123), array("id_antigo_autor" => 618,"id_novo_autor" => 2379), array("id_antigo_autor" => 11,"id_novo_autor" => 1868), array("id_antigo_autor" => 291,"id_novo_autor" => 2124), array("id_antigo_autor" => 619,"id_novo_autor" => 2380), array("id_antigo_autor" => 12,"id_novo_autor" => 1869), array("id_antigo_autor" => 292,"id_novo_autor" => 2125), array("id_antigo_autor" => 620,"id_novo_autor" => 2381), array("id_antigo_autor" => 27,"id_novo_autor" => 1870), array("id_antigo_autor" => 293,"id_novo_autor" => 2126), array("id_antigo_autor" => 621,"id_novo_autor" => 2382), array("id_antigo_autor" => 14,"id_novo_autor" => 1871), array("id_antigo_autor" => 294,"id_novo_autor" => 2127), array("id_antigo_autor" => 622,"id_novo_autor" => 2383), array("id_antigo_autor" => 447,"id_novo_autor" => 1872), array("id_antigo_autor" => 295,"id_novo_autor" => 2128), array("id_antigo_autor" => 623,"id_novo_autor" => 2384), array("id_antigo_autor" => 16,"id_novo_autor" => 1873), array("id_antigo_autor" => 296,"id_novo_autor" => 2129), array("id_antigo_autor" => 624,"id_novo_autor" => 2385), array("id_antigo_autor" => 17,"id_novo_autor" => 1874), array("id_antigo_autor" => 297,"id_novo_autor" => 2130), array("id_antigo_autor" => 625,"id_novo_autor" => 2386), array("id_antigo_autor" => 18,"id_novo_autor" => 1875), array("id_antigo_autor" => 298,"id_novo_autor" => 2131), array("id_antigo_autor" => 626,"id_novo_autor" => 2387), array("id_antigo_autor" => 451,"id_novo_autor" => 1876), array("id_antigo_autor" => 299,"id_novo_autor" => 2132), array("id_antigo_autor" => 627,"id_novo_autor" => 2388), array("id_antigo_autor" => 20,"id_novo_autor" => 1877), array("id_antigo_autor" => 300,"id_novo_autor" => 2133), array("id_antigo_autor" => 628,"id_novo_autor" => 2389), array("id_antigo_autor" => 21,"id_novo_autor" => 1878), array("id_antigo_autor" => 301,"id_novo_autor" => 2134), array("id_antigo_autor" => 629,"id_novo_autor" => 2390), array("id_antigo_autor" => 22,"id_novo_autor" => 1879), array("id_antigo_autor" => 303,"id_novo_autor" => 2135), array("id_antigo_autor" => 630,"id_novo_autor" => 2391), array("id_antigo_autor" => 23,"id_novo_autor" => 1880), array("id_antigo_autor" => 304,"id_novo_autor" => 2136), array("id_antigo_autor" => 631,"id_novo_autor" => 2392), array("id_antigo_autor" => 24,"id_novo_autor" => 1881), array("id_antigo_autor" => 305,"id_novo_autor" => 2137), array("id_antigo_autor" => 632,"id_novo_autor" => 2393), array("id_antigo_autor" => 25,"id_novo_autor" => 1882), array("id_antigo_autor" => 306,"id_novo_autor" => 2138), array("id_antigo_autor" => 633,"id_novo_autor" => 2394), array("id_antigo_autor" => 26,"id_novo_autor" => 1883), array("id_antigo_autor" => 308,"id_novo_autor" => 2139), array("id_antigo_autor" => 634,"id_novo_autor" => 2395), array("id_antigo_autor" => 28,"id_novo_autor" => 1884), array("id_antigo_autor" => 309,"id_novo_autor" => 2140), array("id_antigo_autor" => 635,"id_novo_autor" => 2396), array("id_antigo_autor" => 29,"id_novo_autor" => 1885), array("id_antigo_autor" => 310,"id_novo_autor" => 2141), array("id_antigo_autor" => 636,"id_novo_autor" => 2397), array("id_antigo_autor" => 30,"id_novo_autor" => 1886), array("id_antigo_autor" => 311,"id_novo_autor" => 2142), array("id_antigo_autor" => 637,"id_novo_autor" => 2398), array("id_antigo_autor" => 31,"id_novo_autor" => 1887), array("id_antigo_autor" => 312,"id_novo_autor" => 2143), array("id_antigo_autor" => 638,"id_novo_autor" => 2399), array("id_antigo_autor" => 32,"id_novo_autor" => 1888), array("id_antigo_autor" => 313,"id_novo_autor" => 2144), array("id_antigo_autor" => 639,"id_novo_autor" => 2400), array("id_antigo_autor" => 34,"id_novo_autor" => 1889), array("id_antigo_autor" => 314,"id_novo_autor" => 2145), array("id_antigo_autor" => 640,"id_novo_autor" => 2401), array("id_antigo_autor" => 35,"id_novo_autor" => 1890), array("id_antigo_autor" => 315,"id_novo_autor" => 2146), array("id_antigo_autor" => 641,"id_novo_autor" => 2402), array("id_antigo_autor" => 36,"id_novo_autor" => 1891), array("id_antigo_autor" => 316,"id_novo_autor" => 2147), array("id_antigo_autor" => 642,"id_novo_autor" => 2403), array("id_antigo_autor" => 37,"id_novo_autor" => 1892), array("id_antigo_autor" => 317,"id_novo_autor" => 2148), array("id_antigo_autor" => 643,"id_novo_autor" => 2404), array("id_antigo_autor" => 38,"id_novo_autor" => 1893), array("id_antigo_autor" => 319,"id_novo_autor" => 2149), array("id_antigo_autor" => 644,"id_novo_autor" => 2405), array("id_antigo_autor" => 39,"id_novo_autor" => 1894), array("id_antigo_autor" => 320,"id_novo_autor" => 2150), array("id_antigo_autor" => 645,"id_novo_autor" => 2406), array("id_antigo_autor" => 40,"id_novo_autor" => 1895), array("id_antigo_autor" => 321,"id_novo_autor" => 2151), array("id_antigo_autor" => 646,"id_novo_autor" => 2407), array("id_antigo_autor" => 41,"id_novo_autor" => 1896), array("id_antigo_autor" => 322,"id_novo_autor" => 2152), array("id_antigo_autor" => 647,"id_novo_autor" => 2408), array("id_antigo_autor" => 42,"id_novo_autor" => 1897), array("id_antigo_autor" => 323,"id_novo_autor" => 2153), array("id_antigo_autor" => 648,"id_novo_autor" => 2409), array("id_antigo_autor" => 43,"id_novo_autor" => 1898), array("id_antigo_autor" => 324,"id_novo_autor" => 2154), array("id_antigo_autor" => 650,"id_novo_autor" => 2410), array("id_antigo_autor" => 461,"id_novo_autor" => 1899), array("id_antigo_autor" => 325,"id_novo_autor" => 2155), array("id_antigo_autor" => 651,"id_novo_autor" => 2411), array("id_antigo_autor" => 45,"id_novo_autor" => 1900), array("id_antigo_autor" => 326,"id_novo_autor" => 2156), array("id_antigo_autor" => 652,"id_novo_autor" => 2412), array("id_antigo_autor" => 444,"id_novo_autor" => 1901), array("id_antigo_autor" => 327,"id_novo_autor" => 2157), array("id_antigo_autor" => 653,"id_novo_autor" => 2413), array("id_antigo_autor" => 49,"id_novo_autor" => 1902), array("id_antigo_autor" => 328,"id_novo_autor" => 2158), array("id_antigo_autor" => 654,"id_novo_autor" => 2414), array("id_antigo_autor" => 50,"id_novo_autor" => 1903), array("id_antigo_autor" => 329,"id_novo_autor" => 2159), array("id_antigo_autor" => 655,"id_novo_autor" => 2415), array("id_antigo_autor" => 51,"id_novo_autor" => 1904), array("id_antigo_autor" => 330,"id_novo_autor" => 2160), array("id_antigo_autor" => 656,"id_novo_autor" => 2416), array("id_antigo_autor" => 482,"id_novo_autor" => 1905), array("id_antigo_autor" => 331,"id_novo_autor" => 2161), array("id_antigo_autor" => 657,"id_novo_autor" => 2417), array("id_antigo_autor" => 53,"id_novo_autor" => 1906), array("id_antigo_autor" => 332,"id_novo_autor" => 2162), array("id_antigo_autor" => 658,"id_novo_autor" => 2418), array("id_antigo_autor" => 54,"id_novo_autor" => 1907), array("id_antigo_autor" => 334,"id_novo_autor" => 2163), array("id_antigo_autor" => 659,"id_novo_autor" => 2419), array("id_antigo_autor" => 55,"id_novo_autor" => 1908), array("id_antigo_autor" => 335,"id_novo_autor" => 2164), array("id_antigo_autor" => 660,"id_novo_autor" => 2420), array("id_antigo_autor" => 56,"id_novo_autor" => 1909), array("id_antigo_autor" => 336,"id_novo_autor" => 2165), array("id_antigo_autor" => 661,"id_novo_autor" => 2421), array("id_antigo_autor" => 57,"id_novo_autor" => 1910), array("id_antigo_autor" => 337,"id_novo_autor" => 2166), array("id_antigo_autor" => 662,"id_novo_autor" => 2422), array("id_antigo_autor" => 58,"id_novo_autor" => 1911), array("id_antigo_autor" => 338,"id_novo_autor" => 2167), array("id_antigo_autor" => 663,"id_novo_autor" => 2423), array("id_antigo_autor" => 59,"id_novo_autor" => 1912), array("id_antigo_autor" => 339,"id_novo_autor" => 2168), array("id_antigo_autor" => 664,"id_novo_autor" => 2424), array("id_antigo_autor" => 466,"id_novo_autor" => 1913), array("id_antigo_autor" => 340,"id_novo_autor" => 2169), array("id_antigo_autor" => 666,"id_novo_autor" => 2425), array("id_antigo_autor" => 61,"id_novo_autor" => 1914), array("id_antigo_autor" => 341,"id_novo_autor" => 2170), array("id_antigo_autor" => 667,"id_novo_autor" => 2426), array("id_antigo_autor" => 63,"id_novo_autor" => 1915), array("id_antigo_autor" => 342,"id_novo_autor" => 2171), array("id_antigo_autor" => 668,"id_novo_autor" => 2427), array("id_antigo_autor" => 64,"id_novo_autor" => 1916), array("id_antigo_autor" => 343,"id_novo_autor" => 2172), array("id_antigo_autor" => 669,"id_novo_autor" => 2428), array("id_antigo_autor" => 435,"id_novo_autor" => 1917), array("id_antigo_autor" => 344,"id_novo_autor" => 2173), array("id_antigo_autor" => 670,"id_novo_autor" => 2429), array("id_antigo_autor" => 66,"id_novo_autor" => 1918), array("id_antigo_autor" => 345,"id_novo_autor" => 2174), array("id_antigo_autor" => 671,"id_novo_autor" => 2430), array("id_antigo_autor" => 68,"id_novo_autor" => 1919), array("id_antigo_autor" => 445,"id_novo_autor" => 2175), array("id_antigo_autor" => 672,"id_novo_autor" => 2431), array("id_antigo_autor" => 69,"id_novo_autor" => 1920), array("id_antigo_autor" => 347,"id_novo_autor" => 2176), array("id_antigo_autor" => 673,"id_novo_autor" => 2432), array("id_antigo_autor" => 70,"id_novo_autor" => 1921), array("id_antigo_autor" => 348,"id_novo_autor" => 2177), array("id_antigo_autor" => 71,"id_novo_autor" => 1922), array("id_antigo_autor" => 349,"id_novo_autor" => 2178), array("id_antigo_autor" => 72,"id_novo_autor" => 1923), array("id_antigo_autor" => 350,"id_novo_autor" => 2179), array("id_antigo_autor" => 73,"id_novo_autor" => 1924), array("id_antigo_autor" => 351,"id_novo_autor" => 2180), array("id_antigo_autor" => 430,"id_novo_autor" => 1925), array("id_antigo_autor" => 352,"id_novo_autor" => 2181), array("id_antigo_autor" => 75,"id_novo_autor" => 1926), array("id_antigo_autor" => 353,"id_novo_autor" => 2182), array("id_antigo_autor" => 76,"id_novo_autor" => 1927), array("id_antigo_autor" => 354,"id_novo_autor" => 2183), array("id_antigo_autor" => 77,"id_novo_autor" => 1928), array("id_antigo_autor" => 355,"id_novo_autor" => 2184), array("id_antigo_autor" => 78,"id_novo_autor" => 1929), array("id_antigo_autor" => 356,"id_novo_autor" => 2185), array("id_antigo_autor" => 452,"id_novo_autor" => 1930), array("id_antigo_autor" => 357,"id_novo_autor" => 2186), array("id_antigo_autor" => 80,"id_novo_autor" => 1931), array("id_antigo_autor" => 358,"id_novo_autor" => 2187), array("id_antigo_autor" => 81,"id_novo_autor" => 1932), array("id_antigo_autor" => 359,"id_novo_autor" => 2188), array("id_antigo_autor" => 82,"id_novo_autor" => 1933), array("id_antigo_autor" => 360,"id_novo_autor" => 2189), array("id_antigo_autor" => 83,"id_novo_autor" => 1934), array("id_antigo_autor" => 362,"id_novo_autor" => 2190), array("id_antigo_autor" => 84,"id_novo_autor" => 1935), array("id_antigo_autor" => 363,"id_novo_autor" => 2191), array("id_antigo_autor" => 85,"id_novo_autor" => 1936), array("id_antigo_autor" => 364,"id_novo_autor" => 2192), array("id_antigo_autor" => 87,"id_novo_autor" => 1937), array("id_antigo_autor" => 365,"id_novo_autor" => 2193), array("id_antigo_autor" => 88,"id_novo_autor" => 1938), array("id_antigo_autor" => 366,"id_novo_autor" => 2194), array("id_antigo_autor" => 89,"id_novo_autor" => 1939), array("id_antigo_autor" => 367,"id_novo_autor" => 2195), array("id_antigo_autor" => 90,"id_novo_autor" => 1940), array("id_antigo_autor" => 368,"id_novo_autor" => 2196), array("id_antigo_autor" => 91,"id_novo_autor" => 1941), array("id_antigo_autor" => 369,"id_novo_autor" => 2197), array("id_antigo_autor" => 92,"id_novo_autor" => 1942), array("id_antigo_autor" => 370,"id_novo_autor" => 2198), array("id_antigo_autor" => 93,"id_novo_autor" => 1943), array("id_antigo_autor" => 371,"id_novo_autor" => 2199), array("id_antigo_autor" => 480,"id_novo_autor" => 1944), array("id_antigo_autor" => 373,"id_novo_autor" => 2200), array("id_antigo_autor" => 95,"id_novo_autor" => 1945), array("id_antigo_autor" => 374,"id_novo_autor" => 2201), array("id_antigo_autor" => 96,"id_novo_autor" => 1946), array("id_antigo_autor" => 375,"id_novo_autor" => 2202), array("id_antigo_autor" => 97,"id_novo_autor" => 1947), array("id_antigo_autor" => 437,"id_novo_autor" => 2203), array("id_antigo_autor" => 98,"id_novo_autor" => 1948), array("id_antigo_autor" => 380,"id_novo_autor" => 2204), array("id_antigo_autor" => 99,"id_novo_autor" => 1949), array("id_antigo_autor" => 381,"id_novo_autor" => 2205), array("id_antigo_autor" => 100,"id_novo_autor" => 1950), array("id_antigo_autor" => 441,"id_novo_autor" => 2206), array("id_antigo_autor" => 101,"id_novo_autor" => 1951), array("id_antigo_autor" => 384,"id_novo_autor" => 2207), array("id_antigo_autor" => 102,"id_novo_autor" => 1952), array("id_antigo_autor" => 427,"id_novo_autor" => 2208), array("id_antigo_autor" => 103,"id_novo_autor" => 1953), array("id_antigo_autor" => 387,"id_novo_autor" => 2209), array("id_antigo_autor" => 104,"id_novo_autor" => 1954), array("id_antigo_autor" => 388,"id_novo_autor" => 2210), array("id_antigo_autor" => 105,"id_novo_autor" => 1955), array("id_antigo_autor" => 389,"id_novo_autor" => 2211), array("id_antigo_autor" => 106,"id_novo_autor" => 1956), array("id_antigo_autor" => 390,"id_novo_autor" => 2212), array("id_antigo_autor" => 107,"id_novo_autor" => 1957), array("id_antigo_autor" => 391,"id_novo_autor" => 2213), array("id_antigo_autor" => 108,"id_novo_autor" => 1958), array("id_antigo_autor" => 392,"id_novo_autor" => 2214), array("id_antigo_autor" => 109,"id_novo_autor" => 1959), array("id_antigo_autor" => 393,"id_novo_autor" => 2215), array("id_antigo_autor" => 110,"id_novo_autor" => 1960), array("id_antigo_autor" => 431,"id_novo_autor" => 2216), array("id_antigo_autor" => 111,"id_novo_autor" => 1961), array("id_antigo_autor" => 397,"id_novo_autor" => 2217), array("id_antigo_autor" => 112,"id_novo_autor" => 1962), array("id_antigo_autor" => 398,"id_novo_autor" => 2218), array("id_antigo_autor" => 113,"id_novo_autor" => 1963), array("id_antigo_autor" => 399,"id_novo_autor" => 2219), array("id_antigo_autor" => 114,"id_novo_autor" => 1964), array("id_antigo_autor" => 401,"id_novo_autor" => 2220), array("id_antigo_autor" => 115,"id_novo_autor" => 1965), array("id_antigo_autor" => 402,"id_novo_autor" => 2221), array("id_antigo_autor" => 116,"id_novo_autor" => 1966), array("id_antigo_autor" => 403,"id_novo_autor" => 2222), array("id_antigo_autor" => 117,"id_novo_autor" => 1967), array("id_antigo_autor" => 404,"id_novo_autor" => 2223), array("id_antigo_autor" => 118,"id_novo_autor" => 1968), array("id_antigo_autor" => 405,"id_novo_autor" => 2224), array("id_antigo_autor" => 119,"id_novo_autor" => 1969), array("id_antigo_autor" => 406,"id_novo_autor" => 2225), array("id_antigo_autor" => 372,"id_novo_autor" => 1970), array("id_antigo_autor" => 407,"id_novo_autor" => 2226), array("id_antigo_autor" => 120,"id_novo_autor" => 1971), array("id_antigo_autor" => 409,"id_novo_autor" => 2227), array("id_antigo_autor" => 121,"id_novo_autor" => 1972), array("id_antigo_autor" => 411,"id_novo_autor" => 2228), array("id_antigo_autor" => 122,"id_novo_autor" => 1973), array("id_antigo_autor" => 476,"id_novo_autor" => 2229), array("id_antigo_autor" => 123,"id_novo_autor" => 1974), array("id_antigo_autor" => 413,"id_novo_autor" => 2230), array("id_antigo_autor" => 124,"id_novo_autor" => 1975), array("id_antigo_autor" => 414,"id_novo_autor" => 2231), array("id_antigo_autor" => 125,"id_novo_autor" => 1976), array("id_antigo_autor" => 415,"id_novo_autor" => 2232), array("id_antigo_autor" => 126,"id_novo_autor" => 1977), array("id_antigo_autor" => 416,"id_novo_autor" => 2233), array("id_antigo_autor" => 129,"id_novo_autor" => 1978), array("id_antigo_autor" => 417,"id_novo_autor" => 2234), array("id_antigo_autor" => 485,"id_novo_autor" => 1979), array("id_antigo_autor" => 418,"id_novo_autor" => 2235), array("id_antigo_autor" => 132,"id_novo_autor" => 1980), array("id_antigo_autor" => 423,"id_novo_autor" => 2236), array("id_antigo_autor" => 462,"id_novo_autor" => 1981), array("id_antigo_autor" => 420,"id_novo_autor" => 2237), array("id_antigo_autor" => 134,"id_novo_autor" => 1982), array("id_antigo_autor" => 421,"id_novo_autor" => 2238), array("id_antigo_autor" => 471,"id_novo_autor" => 1983), array("id_antigo_autor" => 424,"id_novo_autor" => 2239), array("id_antigo_autor" => 136,"id_novo_autor" => 1984), array("id_antigo_autor" => 425,"id_novo_autor" => 2240), array("id_antigo_autor" => 486,"id_novo_autor" => 1985), array("id_antigo_autor" => 426,"id_novo_autor" => 2241), array("id_antigo_autor" => 138,"id_novo_autor" => 1986), array("id_antigo_autor" => 139,"id_novo_autor" => 1987), array("id_antigo_autor" => 428,"id_novo_autor" => 2243), array("id_antigo_autor" => 140,"id_novo_autor" => 1988), array("id_antigo_autor" => 458,"id_novo_autor" => 2244), array("id_antigo_autor" => 141,"id_novo_autor" => 1989), array("id_antigo_autor" => 467,"id_novo_autor" => 2245), array("id_antigo_autor" => 142,"id_novo_autor" => 1990), array("id_antigo_autor" => 446,"id_novo_autor" => 2246), array("id_antigo_autor" => 143,"id_novo_autor" => 1991), array("id_antigo_autor" => 453,"id_novo_autor" => 2247), array("id_antigo_autor" => 144,"id_novo_autor" => 1992), array("id_antigo_autor" => 484,"id_novo_autor" => 2248), array("id_antigo_autor" => 145,"id_novo_autor" => 1993), array("id_antigo_autor" => 442,"id_novo_autor" => 2249), array("id_antigo_autor" => 146,"id_novo_autor" => 1994), array("id_antigo_autor" => 470,"id_novo_autor" => 2250), array("id_antigo_autor" => 147,"id_novo_autor" => 1995), array("id_antigo_autor" => 477,"id_novo_autor" => 2251), array("id_antigo_autor" => 148,"id_novo_autor" => 1996), array("id_antigo_autor" => 436,"id_novo_autor" => 2252), array("id_antigo_autor" => 149,"id_novo_autor" => 1997), array("id_antigo_autor" => 429,"id_novo_autor" => 2253), array("id_antigo_autor" => 150,"id_novo_autor" => 1998), array("id_antigo_autor" => 443,"id_novo_autor" => 2254), array("id_antigo_autor" => 151,"id_novo_autor" => 1999), array("id_antigo_autor" => 487,"id_novo_autor" => 2255), array("id_antigo_autor" => 152,"id_novo_autor" => 2000), array("id_antigo_autor" => 488,"id_novo_autor" => 2256), array("id_antigo_autor" => 153,"id_novo_autor" => 2001), array("id_antigo_autor" => 497,"id_novo_autor" => 2257), array("id_antigo_autor" => 154,"id_novo_autor" => 2002), array("id_antigo_autor" => 490,"id_novo_autor" => 2258), array("id_antigo_autor" => 448,"id_novo_autor" => 2003), array("id_antigo_autor" => 491,"id_novo_autor" => 2259), array("id_antigo_autor" => 156,"id_novo_autor" => 2004), array("id_antigo_autor" => 493,"id_novo_autor" => 2260), array("id_antigo_autor" => 157,"id_novo_autor" => 2005), array("id_antigo_autor" => 494,"id_novo_autor" => 2261), array("id_antigo_autor" => 158,"id_novo_autor" => 2006), array("id_antigo_autor" => 495,"id_novo_autor" => 2262), array("id_antigo_autor" => 159,"id_novo_autor" => 2007), array("id_antigo_autor" => 496,"id_novo_autor" => 2263), array("id_antigo_autor" => 160,"id_novo_autor" => 2008), array("id_antigo_autor" => 498,"id_novo_autor" => 2264), array("id_antigo_autor" => 161,"id_novo_autor" => 2009), array("id_antigo_autor" => 499,"id_novo_autor" => 2265), array("id_antigo_autor" => 162,"id_novo_autor" => 2010), array("id_antigo_autor" => 527,"id_novo_autor" => 2266), array("id_antigo_autor" => 163,"id_novo_autor" => 2011), array("id_antigo_autor" => 510,"id_novo_autor" => 2267), array("id_antigo_autor" => 165,"id_novo_autor" => 2012), array("id_antigo_autor" => 503,"id_novo_autor" => 2268), array("id_antigo_autor" => 166,"id_novo_autor" => 2013), array("id_antigo_autor" => 504,"id_novo_autor" => 2269), array("id_antigo_autor" => 167,"id_novo_autor" => 2014), array("id_antigo_autor" => 511,"id_novo_autor" => 2270), array("id_antigo_autor" => 168,"id_novo_autor" => 2015), array("id_antigo_autor" => 506,"id_novo_autor" => 2271), array("id_antigo_autor" => 169,"id_novo_autor" => 2016), array("id_antigo_autor" => 507,"id_novo_autor" => 2272), array("id_antigo_autor" => 170,"id_novo_autor" => 2017), array("id_antigo_autor" => 508,"id_novo_autor" => 2273), array("id_antigo_autor" => 171,"id_novo_autor" => 2018), array("id_antigo_autor" => 509,"id_novo_autor" => 2274), array("id_antigo_autor" => 173,"id_novo_autor" => 2019), array("id_antigo_autor" => 512,"id_novo_autor" => 2275), array("id_antigo_autor" => 174,"id_novo_autor" => 2020), array("id_antigo_autor" => 513,"id_novo_autor" => 2276), array("id_antigo_autor" => 175,"id_novo_autor" => 2021), array("id_antigo_autor" => 514,"id_novo_autor" => 2277), array("id_antigo_autor" => 478,"id_novo_autor" => 2022), array("id_antigo_autor" => 515,"id_novo_autor" => 2278), array("id_antigo_autor" => 177,"id_novo_autor" => 2023), array("id_antigo_autor" => 516,"id_novo_autor" => 2279), array("id_antigo_autor" => 178,"id_novo_autor" => 2024), array("id_antigo_autor" => 517,"id_novo_autor" => 2280), array("id_antigo_autor" => 179,"id_novo_autor" => 2025), array("id_antigo_autor" => 518,"id_novo_autor" => 2281), array("id_antigo_autor" => 180,"id_novo_autor" => 2026), array("id_antigo_autor" => 519,"id_novo_autor" => 2282), array("id_antigo_autor" => 181,"id_novo_autor" => 2027), array("id_antigo_autor" => 520,"id_novo_autor" => 2283), array("id_antigo_autor" => 481,"id_novo_autor" => 2028), array("id_antigo_autor" => 521,"id_novo_autor" => 2284), array("id_antigo_autor" => 183,"id_novo_autor" => 2029), array("id_antigo_autor" => 522,"id_novo_autor" => 2285), array("id_antigo_autor" => 184,"id_novo_autor" => 2030), array("id_antigo_autor" => 523,"id_novo_autor" => 2286), array("id_antigo_autor" => 185,"id_novo_autor" => 2031), array("id_antigo_autor" => 524,"id_novo_autor" => 2287), array("id_antigo_autor" => 186,"id_novo_autor" => 2032), array("id_antigo_autor" => 525,"id_novo_autor" => 2288), array("id_antigo_autor" => 187,"id_novo_autor" => 2033), array("id_antigo_autor" => 526,"id_novo_autor" => 2289), array("id_antigo_autor" => 189,"id_novo_autor" => 2034), array("id_antigo_autor" => 528,"id_novo_autor" => 2290), array("id_antigo_autor" => 190,"id_novo_autor" => 2035), array("id_antigo_autor" => 529,"id_novo_autor" => 2291), array("id_antigo_autor" => 191,"id_novo_autor" => 2036), array("id_antigo_autor" => 530,"id_novo_autor" => 2292), array("id_antigo_autor" => 438,"id_novo_autor" => 2037), array("id_antigo_autor" => 531,"id_novo_autor" => 2293), array("id_antigo_autor" => 193,"id_novo_autor" => 2038), array("id_antigo_autor" => 532,"id_novo_autor" => 2294), array("id_antigo_autor" => 194,"id_novo_autor" => 2039), array("id_antigo_autor" => 533,"id_novo_autor" => 2295), array("id_antigo_autor" => 195,"id_novo_autor" => 2040), array("id_antigo_autor" => 534,"id_novo_autor" => 2296), array("id_antigo_autor" => 196,"id_novo_autor" => 2041), array("id_antigo_autor" => 535,"id_novo_autor" => 2297), array("id_antigo_autor" => 198,"id_novo_autor" => 2042), array("id_antigo_autor" => 536,"id_novo_autor" => 2298), array("id_antigo_autor" => 199,"id_novo_autor" => 2043), array("id_antigo_autor" => 537,"id_novo_autor" => 2299), array("id_antigo_autor" => 538,"id_novo_autor" => 2300), array("id_antigo_autor" => 202,"id_novo_autor" => 2045), array("id_antigo_autor" => 539,"id_novo_autor" => 2301), array("id_antigo_autor" => 464,"id_novo_autor" => 2046), array("id_antigo_autor" => 540,"id_novo_autor" => 2302), array("id_antigo_autor" => 433,"id_novo_autor" => 2047), array("id_antigo_autor" => 541,"id_novo_autor" => 2303));

// identificação antiga para art_aut = artigo_autor
function id_art($aut){ // busca os artigos pelo id do autor
global $arr;

	$array = array();
	$arr_results = array_keys(array_column($arr, 'id_aut'), $aut);
	
	foreach($arr_results as $r){
		array_push($array, $arr[$r]['id_art']);
	}
	
	return $array;
}


function id_aut($aut){// busca os autores pelo id do artigo
global $arr;

	$array = array();
	$arr_results = array_keys(array_column($arr, 'id_art'), $aut);
	
	foreach($arr_results as $r){
		array_push($array, $arr[$r]['id_aut']);
	}
	
	return $array;
}

function id_art_novo($auts){ // busca os artigos novos pelo id do antigo
global $arr_novo;

	$array = array();
	foreach($auts as $aut){
		$arr_results = array_keys(array_column($arr_novo, 'id_antigo'), $aut);
		
		foreach($arr_results as $r){
			array_push($array, $arr_novo[$r]['id_novo']);
		}
	}	
	return $array;
}


function id_aut_novo($auts){ // busca os artigos novos pelo id do antigo
global $arr_autor;

	$array = array();
	foreach($auts as $aut){
		$arr_results = array_keys(array_column($arr_autor, 'id_antigo_autor'), $aut);
		
		foreach($arr_results as $r){
			array_push($array, $arr_autor[$r]['id_novo_autor']);
		}
	}	
	return $array;
}




function count_id_art($aut){
	
	$args = array(
		'post_type' => 'artigos',
		'posts_per_page' => -1,
		'meta_key'     => 'id',
		'meta_value'   => id_art($aut),
		'meta_compare' => 'IN'
	);
	
	$wp_query = new WP_Query( $args );
	if ( $wp_query->have_posts() ) :
		return $wp_query->post_count;
	endif;
	wp_reset_query();
}


add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

function my_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
//		return '<meta http-equiv="refresh" content="0; url=http://pedroprado.com.br/login/?login=failed" />';
   }
}


add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}




/**
 * Register a custom menu page.
 */
function register_page_lista_usuarios(){
    add_menu_page( 
        'Usuários da biblioteca antiga',
        'Usuários da biblioteca antiga',
        'manage_options',
        'lista_usuarios',
        'page_lista_usuarios',
        false,
        6
    ); 
	
	add_submenu_page( 'lista_usuarios', 
					  'Países', 
					  'Países',
					  'manage_options', 
					  'lista_usuarios_pais',
					  'page_lista_usuarios_pais');

	add_submenu_page( 'lista_usuarios', 
					  'Escolas', 
					  'Escolas',
					  'manage_options', 
					  'lista_usuarios_escola',
					  'page_lista_usuarios_escola');

	add_submenu_page( 'lista_usuarios', 
					  'Profissões', 
					  'Profissões',
					  'manage_options', 
					  'lista_usuarios_profissao',
					  'page_lista_usuarios_profissao');
}
add_action( 'admin_menu', 'register_page_lista_usuarios' );
 
 
function register_page_lista_usuarios_novos(){
    add_menu_page( 
        'Usuários da biblioteca',
        'Usuários da biblioteca',
        'manage_options',
        'lista_usuarios_novos',
        'page_lista_usuarios_novos',
        false,
        6
    ); 
	
	add_submenu_page( 'lista_usuarios_novos', 
					  'Países', 
					  'Países',
					  'manage_options', 
					  'lista_usuarios_pais_novos',
					  'page_lista_usuarios_pais_novos');

	add_submenu_page( 'lista_usuarios_novos', 
					  'Escolas', 
					  'Escolas',
					  'manage_options', 
					  'lista_usuarios_escola_novos',
					  'page_lista_usuarios_escola_novos');

	add_submenu_page( 'lista_usuarios_novos', 
					  'Profissões', 
					  'Profissões',
					  'manage_options', 
					  'lista_usuarios_profissao_novos',
					  'page_lista_usuarios_profissao_novos');
}
add_action( 'admin_menu', 'register_page_lista_usuarios_novos' );
 
 
  
/**
 * Display a custom menu page
 */
function page_lista_usuarios(){

$args = array(
	'number' => -1,
	'orderby' => 'display_name',
	'date_query'    => array(
        array(
            'before'     => '2017-01-01 00:00:00',
            'inclusive' => true,
        ),
     ),
);

// The Query
$user_query = new WP_User_Query( $args );


		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/jquery.tablesorter.min.js"></script>';
		echo '<script type="text/javascript">
				
				$(function() {

  var $table = $("table"),
  // define pager options
  pagerOptions = {
    // target the pager markup - see the HTML block below
    container: $(".pager"),
    // output string - default is "{page}/{totalPages}";
    // possible variables: {size}, {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
    // also {page:input} & {startRow:input} will add a modifiable input in place of the value
    output: "{startRow} - {endRow} / {filteredRows} ({totalRows})",
    // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
    // table row set to a height to compensate; default is false
    fixedHeight: true,
    // remove rows from the table to speed up the sort of large tables.
    // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
    removeRows: false,
    // go to page selector - select dropdown that sets the current page
    cssGoto: ".gotoPage"
  };

  // Initialize tablesorter
  // ***********************
  $table
    .tablesorter({
      theme: "blue",
      headerTemplate : "{content} {icon}", // new in v2.7. Needed to add the bootstrap icon!
      widthFixed: true,
      widgets: ["zebra", "filter"]
    })

    // initialize the pager plugin
    // ****************************
    .tablesorterPager(pagerOptions);
    					
					$("#posts-filter").submit( function(){
						searchTable($("#post-search-input").val());
						return false;
					});
					
					$(".filtrar-coluna").each(function(){
						$("#bulk-action-selector-top").append("<option>"+$(this).text()+"</option>");
					})
					
					$("#doaction").click( function(){
						searchTable($("#bulk-action-selector-top").val());
						return false;
					})
				});

				function searchTable(inputVal){
					var table = $(".wp-list-table");
					table.find("tr").each(function(index, row){
						var allCells = $(row).find("td");
						if(allCells.length > 0){
							var found = false;
							allCells.each(function(index, td){
								var regExp = new RegExp(inputVal, "i");
								if(regExp.test($(td).text())){
									found = true;
									return false;
								}
							});
							if(found == true)$(row).show();else $(row).hide();
						}
					});
				}
				
			  </script>';
	
	echo '
<div class="wrap">
<h1 class="wp-heading-inline">Usuários da biblioteca</h1>

	<form id="posts-filter" method="get">
	
		<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Pesquisar posts:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Pesquisar posts">
		</p>
	
		<div class="tablenav top">
	
			<div class="alignleft actions bulkactions">
			</div>
							
			
			<div class="tablenav-pages one-page">
				<span class="displaying-num">'.count($user_query->results).' itens</span>
			</div>		
		</div>
	</form>
	
	<h2 class="screen-reader-text">Lista de posts</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Nome</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Email</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Profissão</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Escola</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Cadastro</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Último acesso</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Acessos</span><span class="sorting-indicator"></span></a></th>
			</tr>
		</thead>
	
	<tfoot>
		<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Nome</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Email</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Profissão</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Escola</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Cadastro</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Último acesso</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Acessos</span><span class="sorting-indicator"></span></a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
';

	// User Loop
	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			echo '
				<tr class="author-other level-0 type-usuarios status-publish hentry">
					<td class="filtrar-coluna">'.$user->display_name.'</td>
					<td>'.$user->user_email.'</td>
					<td>'.$user->pais.'</td>';

					if($user->outra_profissao){
						echo '<td>'.$user->outra_profissao.'</td>';
					}else{
						echo '<td>'.$user->profissao.'</td>';
					}
					
					echo'
					<td>'.$user->escola.'</td>
					<td>'.$user->user_registered.'</td>
					<td>'.$user->ultimo_acesso.'</td>
					<td>'.$user->acessos.'</td>
				</tr>';
		}
	} else {
		echo 'Nenhum usuário encontrado';
	}

echo '</tbody>
	</table>
	</div>
	';

}




function page_lista_usuarios_pais(){

$args = array(
	'number' => -1,
	'orderby' => 'display_name',
);


	// The Query
	$user_query = new WP_User_Query( $args );
	$arr = array();
	// User Loop
	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			$arr[] = array("pais"=>ucfirst(strtolower($user->pais)), "acessos"=>$user->acessos, "total"=>1);

//			array_push($arr, ucfirst(strtolower($user->pais)));
		}
	} else {
		echo 'Nenhum usuário encontrado';
	}

	    
	$newarray = array();
	foreach($arr as $ar)
	{
	    foreach($ar as $k => $v)
	    {
	        if(array_key_exists($v, $newarray)){
	            $newarray[$v]['acessos'] = $newarray[$v]['acessos'] + $ar['acessos'];
	            $newarray[$v]['total'] = $newarray[$v]['total'] + 1;
	        }else if($k == 'pais'){
	            $newarray[$v] = $ar;
	        }
	    }
	}
	


		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/jquery.tablesorter.min.js"></script>';
		echo '<script type="text/javascript">
				
				$(function() {
					$("table").tablesorter();
					
					$("#posts-filter").submit( function(){
						searchTable($("#post-search-input").val());
						return false;
					});
					
					$(".filtrar-coluna").each(function(){
						$("#bulk-action-selector-top").append("<option>"+$(this).text()+"</option>");
					})
					
					$("#doaction").click( function(){
						searchTable($("#bulk-action-selector-top").val());
						return false;
					})
				});

				function searchTable(inputVal){
					var table = $(".wp-list-table");
					table.find("tr").each(function(index, row){
						var allCells = $(row).find("td");
						if(allCells.length > 0){
							var found = false;
							allCells.each(function(index, td){
								var regExp = new RegExp(inputVal, "i");
								if(regExp.test($(td).text())){
									found = true;
									return false;
								}
							});
							if(found == true)$(row).show();else $(row).hide();
						}
					});
				}
				
			  </script>';
	
	echo '
<div class="wrap">
<h1 class="wp-heading-inline">Usuários por país</h1>

	<form id="posts-filter" method="get">
	
		<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Pesquisar posts:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Pesquisar posts">
		</p>
	
		<div class="tablenav top">
	
			<div class="alignleft actions bulkactions">
				<select name="action" id="bulk-action-selector-top" style="min-width:200px;">
					<option value="">Filtrar por</option>	
				</select>
				
				<input type="submit" id="doaction" class="button action" value="Aplicar">
			</div>
							
			
			<div class="tablenav-pages one-page">
				<span class="displaying-num">'.count($newarray).' itens</span>
			</div>		
		</div>
	</form>
	
	<h2 class="screen-reader-text">Lista de posts</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
			</tr>
		</thead>
	
	<tfoot>
		<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
';
	

$total_usuarios = array_sum(array_column($newarray, 'total'));
$total_acessos = array_sum(array_column($newarray, 'acessos'));

foreach($newarray as $k => $array){
	$percent_usuarios = round($array['total']/$total_usuarios*100,2);
	$percent_acessos = round($array['acessos']/$total_acessos*100,2);
	
	echo '
	<tr class="author-other level-0 type-usuarios status-publish hentry">';
		if($array['pais']){ 
			echo '<td class="filtrar-coluna">'.$array['pais'].'</td>';
		}else{
			echo'<td class="filtrar-coluna">Sem Informação</td>'; 
		}
		
	echo '		
		<td>'.$array['total'].'</td>
		<td>'.$array['acessos'].'</td>
		<td>'.$percent_usuarios.'%</td>
		<td>'.$percent_acessos.'%</td>
	</tr>';
}

	

echo '</tbody>
	</table>
	</div>
	';

}




function page_lista_usuarios_escola(){

$args = array(
	'number' => -1,
	'orderby' => 'display_name',
);


	// The Query
	$user_query = new WP_User_Query( $args );
	$arr = array();
	// User Loop
	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			$arr[] = array("escola"=>ucfirst(strtolower($user->escola)), "acessos"=>$user->acessos, "total"=>1);

//			array_push($arr, ucfirst(strtolower($user->escola)));
		}
	} else {
		echo 'Nenhum usuário encontrado';
	}

	    
	$newarray = array();
	foreach($arr as $ar)
	{
	    foreach($ar as $k => $v)
	    {
	        if(array_key_exists($v, $newarray)){
	            $newarray[$v]['acessos'] = $newarray[$v]['acessos'] + $ar['acessos'];
	            $newarray[$v]['total'] = $newarray[$v]['total'] + 1;
	        }else if($k == 'escola'){
	            $newarray[$v] = $ar;
	        }
	    }
	}
	


		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/jquery.tablesorter.min.js"></script>';
		echo '<script type="text/javascript">
				
				$(function() {
					$("table").tablesorter();
					
					$("#posts-filter").submit( function(){
						searchTable($("#post-search-input").val());
						return false;
					});
					
					$(".filtrar-coluna").each(function(){
						$("#bulk-action-selector-top").append("<option>"+$(this).text()+"</option>");
					})
					
					$("#doaction").click( function(){
						searchTable($("#bulk-action-selector-top").val());
						return false;
					})
				});

				function searchTable(inputVal){
					var table = $(".wp-list-table");
					table.find("tr").each(function(index, row){
						var allCells = $(row).find("td");
						if(allCells.length > 0){
							var found = false;
							allCells.each(function(index, td){
								var regExp = new RegExp(inputVal, "i");
								if(regExp.test($(td).text())){
									found = true;
									return false;
								}
							});
							if(found == true)$(row).show();else $(row).hide();
						}
					});
				}
				
			  </script>';
	
	echo '
<div class="wrap">
<h1 class="wp-heading-inline">Usuários por escola</h1>

	<form id="posts-filter" method="get">
	
		<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Pesquisar posts:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Pesquisar posts">
		</p>
	
		<div class="tablenav top">
	
			<div class="alignleft actions bulkactions">
				<select name="action" id="bulk-action-selector-top" style="min-width:200px;">
					<option value="">Filtrar por</option>	
				</select>
				
				<input type="submit" id="doaction" class="button action" value="Aplicar">
			</div>
							
			
			<div class="tablenav-pages one-page">
				<span class="displaying-num">'.count($newarray).' itens</span>
			</div>		
		</div>
	</form>
	
	<h2 class="screen-reader-text">Lista de posts</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Escola</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
			</tr>
		</thead>
	
	<tfoot>
		<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Escola</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
';
	

$total_usuarios = array_sum(array_column($newarray, 'total'));
$total_acessos = array_sum(array_column($newarray, 'acessos'));

foreach($newarray as $k => $array){
	$percent_usuarios = round($array['total']/$total_usuarios*100,2);
	$percent_acessos = round($array['acessos']/$total_acessos*100,2);
	
	echo '
	<tr class="author-other level-0 type-usuarios status-publish hentry">';
		if($array['escola']){ 
			echo '<td class="filtrar-coluna">'.$array['escola'].'</td>';
		}else{
			echo'<td class="filtrar-coluna">Sem Informação</td>'; 
		}
		
	echo '		
		<td>'.$array['total'].'</td>
		<td>'.$array['acessos'].'</td>
		<td>'.$percent_usuarios.'%</td>
		<td>'.$percent_acessos.'%</td>
	</tr>';
}

	

echo '</tbody>
	</table>
	</div>
	';

}




function page_lista_usuarios_profissao(){

$args = array(
	'number' => -1,
	'orderby' => 'display_name',
);


	$user_query = new WP_User_Query( $args );
	$arr = array();

	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			if($user->outra_profissao){
				$arr[] = array("profissao"=>ucfirst(strtolower($user->outra_profissao)), "acessos"=>$user->acessos, "total"=>1);	
			}else{
				$arr[] = array("profissao"=>ucfirst(strtolower($user->profissao)), "acessos"=>$user->acessos, "total"=>1);
			}
			

//			array_push($arr, ucfirst(strtolower($user->profissao)));
		}
	} else {
		echo 'Nenhum usuário encontrado';
	}

	    
	$newarray = array();
	foreach($arr as $ar)
	{
	    foreach($ar as $k => $v)
	    {
	        if(array_key_exists($v, $newarray)){
	            $newarray[$v]['acessos'] = $newarray[$v]['acessos'] + $ar['acessos'];
	            $newarray[$v]['total'] = $newarray[$v]['total'] + 1;
	        }else if($k == 'profissao'){
	            $newarray[$v] = $ar;
	        }
	    }
	}
	


		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/jquery.tablesorter.min.js"></script>';
		echo '<script type="text/javascript">
				
				$(function() {
					$("table").tablesorter();
					
					$("#posts-filter").submit( function(){
						searchTable($("#post-search-input").val());
						return false;
					});
					
					$(".filtrar-coluna").each(function(){
						$("#bulk-action-selector-top").append("<option>"+$(this).text()+"</option>");
					})
					
					$("#doaction").click( function(){
						searchTable($("#bulk-action-selector-top").val());
						return false;
					})
				});

				function searchTable(inputVal){
					var table = $(".wp-list-table");
					table.find("tr").each(function(index, row){
						var allCells = $(row).find("td");
						if(allCells.length > 0){
							var found = false;
							allCells.each(function(index, td){
								var regExp = new RegExp(inputVal, "i");
								if(regExp.test($(td).text())){
									found = true;
									return false;
								}
							});
							if(found == true)$(row).show();else $(row).hide();
						}
					});
				}
				
			  </script>';
	
	echo '
<div class="wrap">
<h1 class="wp-heading-inline">Usuários por profissão</h1>

	<form id="posts-filter" method="get">
	
		<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Pesquisar posts:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Pesquisar posts">
		</p>
	
		<div class="tablenav top">
	
			<div class="alignleft actions bulkactions">
				<select name="action" id="bulk-action-selector-top" style="min-width:200px;">
					<option value="">Filtrar por</option>	
				</select>
				
				<input type="submit" id="doaction" class="button action" value="Aplicar">
			</div>
							
			
			<div class="tablenav-pages one-page">
				<span class="displaying-num">'.count($newarray).' itens</span>
			</div>		
		</div>
	</form>
	
	<h2 class="screen-reader-text">Lista de posts</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
			</tr>
		</thead>
	
	<tfoot>
		<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
';
	

$total_usuarios = array_sum(array_column($newarray, 'total'));
$total_acessos = array_sum(array_column($newarray, 'acessos'));

foreach($newarray as $k => $array){
	$percent_usuarios = round($array['total']/$total_usuarios*100,2);
	$percent_acessos = round($array['acessos']/$total_acessos*100,2);
	
	echo '
	<tr class="author-other level-0 type-usuarios status-publish hentry">';
		if($array['profissao']){ 
			echo '<td class="filtrar-coluna">'.$array['profissao'].'</td>';
		}else{
			echo'<td class="filtrar-coluna">Sem Informação</td>'; 
		}
		
	echo '		
		<td>'.$array['total'].'</td>
		<td>'.$array['acessos'].'</td>
		<td>'.$percent_usuarios.'%</td>
		<td>'.$percent_acessos.'%</td>
	</tr>';
}

	

echo '</tbody>
	</table>
	</div>
	';

}















//////// lista nova ///////////













/**
 * Display a custom menu page
 */
function page_lista_usuarios_novos(){

$args = array(
	'number' => -1,
	'orderby' => 'display_name',
	'date_query'    => array(
        array(
            'after'     => '2017-01-01 00:00:00',
            'inclusive' => true,
        ),
     ),
);


// The Query
$user_query = new WP_User_Query( $args );


		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/jquery.tablesorter.min.js"></script>';
		echo '<script type="text/javascript">
				
				$(function() {

  var $table = $("table"),
  // define pager options
  pagerOptions = {
    // target the pager markup - see the HTML block below
    container: $(".pager"),
    // output string - default is "{page}/{totalPages}";
    // possible variables: {size}, {page}, {totalPages}, {filteredPages}, {startRow}, {endRow}, {filteredRows} and {totalRows}
    // also {page:input} & {startRow:input} will add a modifiable input in place of the value
    output: "{startRow} - {endRow} / {filteredRows} ({totalRows})",
    // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
    // table row set to a height to compensate; default is false
    fixedHeight: true,
    // remove rows from the table to speed up the sort of large tables.
    // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
    removeRows: false,
    // go to page selector - select dropdown that sets the current page
    cssGoto: ".gotoPage"
  };

  // Initialize tablesorter
  // ***********************
  $table
    .tablesorter({
      theme: "blue",
      headerTemplate : "{content} {icon}", // new in v2.7. Needed to add the bootstrap icon!
      widthFixed: true,
      widgets: ["zebra", "filter"]
    })

    // initialize the pager plugin
    // ****************************
    .tablesorterPager(pagerOptions);
    					
					$("#posts-filter").submit( function(){
						searchTable($("#post-search-input").val());
						return false;
					});
					
					$(".filtrar-coluna").each(function(){
						$("#bulk-action-selector-top").append("<option>"+$(this).text()+"</option>");
					})
					
					$("#doaction").click( function(){
						searchTable($("#bulk-action-selector-top").val());
						return false;
					})
				});

				function searchTable(inputVal){
					var table = $(".wp-list-table");
					table.find("tr").each(function(index, row){
						var allCells = $(row).find("td");
						if(allCells.length > 0){
							var found = false;
							allCells.each(function(index, td){
								var regExp = new RegExp(inputVal, "i");
								if(regExp.test($(td).text())){
									found = true;
									return false;
								}
							});
							if(found == true)$(row).show();else $(row).hide();
						}
					});
				}
				
			  </script>';
	
	echo '
<div class="wrap">
<h1 class="wp-heading-inline">Usuários da biblioteca</h1>

	<form id="posts-filter" method="get">
	
		<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Pesquisar posts:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Pesquisar posts">
		</p>
	
		<div class="tablenav top">
	
			<div class="alignleft actions bulkactions">
			</div>
							
			
			<div class="tablenav-pages one-page">
				<span class="displaying-num">'.count($user_query->results).' itens</span>
			</div>		
		</div>
	</form>
	
	<h2 class="screen-reader-text">Lista de posts</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Nome</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Email</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Profissão</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Escola</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Cadastro</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Último acesso</span><span class="sorting-indicator"></span></a></th>
				<th class="manage-column column-profissao sortable desc"><a href="#"><span>Acessos</span><span class="sorting-indicator"></span></a></th>
			</tr>
		</thead>
	
	<tfoot>
		<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Nome</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Email</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Profissão</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Escola</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Cadastro</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Último acesso</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Acessos</span><span class="sorting-indicator"></span></a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
';

	// User Loop
	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			echo '
				<tr class="author-other level-0 type-usuarios status-publish hentry">
					<td class="filtrar-coluna">'.$user->display_name.'</td>
					<td>'.$user->user_email.'</td>
					<td>'.$user->pais.'</td>';

					if($user->outra_profissao){
						echo '<td>'.$user->outra_profissao.'</td>';
					}else{
						echo '<td>'.$user->profissao.'</td>';
					}
					
					echo'
					<td>'.$user->escola.'</td>
					<td>'.$user->user_registered.'</td>
					<td>'.$user->ultimo_acesso.'</td>
					<td>'.$user->acessos.'</td>
				</tr>';
		}
	} else {
		echo 'Nenhum usuário encontrado';
	}

echo '</tbody>
	</table>
	</div>
	';

}




function page_lista_usuarios_pais_novos(){

$args = array(
	'number' => -1,
	'orderby' => 'display_name',
	'date_query'    => array(
        array(
            'after'     => '2017-01-01 00:00:00',
            'inclusive' => true,
        ),
     ),
);


	// The Query
	$user_query = new WP_User_Query( $args );
	$arr = array();
	// User Loop
	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			$arr[] = array("pais"=>ucfirst(strtolower($user->pais)), "acessos"=>$user->acessos, "total"=>1);

//			array_push($arr, ucfirst(strtolower($user->pais)));
		}
	} else {
		echo 'Nenhum usuário encontrado';
	}

	    
	$newarray = array();
	foreach($arr as $ar)
	{
	    foreach($ar as $k => $v)
	    {
	        if(array_key_exists($v, $newarray)){
	            $newarray[$v]['acessos'] = $newarray[$v]['acessos'] + $ar['acessos'];
	            $newarray[$v]['total'] = $newarray[$v]['total'] + 1;
	        }else if($k == 'pais'){
	            $newarray[$v] = $ar;
	        }
	    }
	}
	


		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/jquery.tablesorter.min.js"></script>';
		echo '<script type="text/javascript">
				
				$(function() {
					$("table").tablesorter();
					
					$("#posts-filter").submit( function(){
						searchTable($("#post-search-input").val());
						return false;
					});
					
					$(".filtrar-coluna").each(function(){
						$("#bulk-action-selector-top").append("<option>"+$(this).text()+"</option>");
					})
					
					$("#doaction").click( function(){
						searchTable($("#bulk-action-selector-top").val());
						return false;
					})
				});

				function searchTable(inputVal){
					var table = $(".wp-list-table");
					table.find("tr").each(function(index, row){
						var allCells = $(row).find("td");
						if(allCells.length > 0){
							var found = false;
							allCells.each(function(index, td){
								var regExp = new RegExp(inputVal, "i");
								if(regExp.test($(td).text())){
									found = true;
									return false;
								}
							});
							if(found == true)$(row).show();else $(row).hide();
						}
					});
				}
				
			  </script>';
	
	echo '
<div class="wrap">
<h1 class="wp-heading-inline">Usuários por país</h1>

	<form id="posts-filter" method="get">
	
		<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Pesquisar posts:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Pesquisar posts">
		</p>
	
		<div class="tablenav top">
	
			<div class="alignleft actions bulkactions">
				<select name="action" id="bulk-action-selector-top" style="min-width:200px;">
					<option value="">Filtrar por</option>	
				</select>
				
				<input type="submit" id="doaction" class="button action" value="Aplicar">
			</div>
							
			
			<div class="tablenav-pages one-page">
				<span class="displaying-num">'.count($newarray).' itens</span>
			</div>		
		</div>
	</form>
	
	<h2 class="screen-reader-text">Lista de posts</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
			</tr>
		</thead>
	
	<tfoot>
		<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
';
	

$total_usuarios = array_sum(array_column($newarray, 'total'));
$total_acessos = array_sum(array_column($newarray, 'acessos'));

foreach($newarray as $k => $array){
	$percent_usuarios = round($array['total']/$total_usuarios*100,2);
	$percent_acessos = round($array['acessos']/$total_acessos*100,2);
	
	echo '
	<tr class="author-other level-0 type-usuarios status-publish hentry">';
		if($array['pais']){ 
			echo '<td class="filtrar-coluna">'.$array['pais'].'</td>';
		}else{
			echo'<td class="filtrar-coluna">Sem Informação</td>'; 
		}
		
	echo '		
		<td>'.$array['total'].'</td>
		<td>'.$array['acessos'].'</td>
		<td>'.$percent_usuarios.'%</td>
		<td>'.$percent_acessos.'%</td>
	</tr>';
}

	

echo '</tbody>
	</table>
	</div>
	';

}




function page_lista_usuarios_escola_novos(){

$args = array(
	'number' => -1,
	'orderby' => 'display_name',
	'date_query'    => array(
        array(
            'after'     => '2017-01-01 00:00:00',
            'inclusive' => true,
        ),
     ),
);


	// The Query
	$user_query = new WP_User_Query( $args );
	$arr = array();
	// User Loop
	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			$arr[] = array("escola"=>ucfirst(strtolower($user->escola)), "acessos"=>$user->acessos, "total"=>1);

//			array_push($arr, ucfirst(strtolower($user->escola)));
		}
	} else {
		echo 'Nenhum usuário encontrado';
	}

	    
	$newarray = array();
	foreach($arr as $ar)
	{
	    foreach($ar as $k => $v)
	    {
	        if(array_key_exists($v, $newarray)){
	            $newarray[$v]['acessos'] = $newarray[$v]['acessos'] + $ar['acessos'];
	            $newarray[$v]['total'] = $newarray[$v]['total'] + 1;
	        }else if($k == 'escola'){
	            $newarray[$v] = $ar;
	        }
	    }
	}
	


		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/jquery.tablesorter.min.js"></script>';
		echo '<script type="text/javascript">
				
				$(function() {
					$("table").tablesorter();
					
					$("#posts-filter").submit( function(){
						searchTable($("#post-search-input").val());
						return false;
					});
					
					$(".filtrar-coluna").each(function(){
						$("#bulk-action-selector-top").append("<option>"+$(this).text()+"</option>");
					})
					
					$("#doaction").click( function(){
						searchTable($("#bulk-action-selector-top").val());
						return false;
					})
				});

				function searchTable(inputVal){
					var table = $(".wp-list-table");
					table.find("tr").each(function(index, row){
						var allCells = $(row).find("td");
						if(allCells.length > 0){
							var found = false;
							allCells.each(function(index, td){
								var regExp = new RegExp(inputVal, "i");
								if(regExp.test($(td).text())){
									found = true;
									return false;
								}
							});
							if(found == true)$(row).show();else $(row).hide();
						}
					});
				}
				
			  </script>';
	
	echo '
<div class="wrap">
<h1 class="wp-heading-inline">Usuários por escola</h1>

	<form id="posts-filter" method="get">
	
		<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Pesquisar posts:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Pesquisar posts">
		</p>
	
		<div class="tablenav top">
	
			<div class="alignleft actions bulkactions">
				<select name="action" id="bulk-action-selector-top" style="min-width:200px;">
					<option value="">Filtrar por</option>	
				</select>
				
				<input type="submit" id="doaction" class="button action" value="Aplicar">
			</div>
							
			
			<div class="tablenav-pages one-page">
				<span class="displaying-num">'.count($newarray).' itens</span>
			</div>		
		</div>
	</form>
	
	<h2 class="screen-reader-text">Lista de posts</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Escola</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
			</tr>
		</thead>
	
	<tfoot>
		<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Escola</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
';
	

$total_usuarios = array_sum(array_column($newarray, 'total'));
$total_acessos = array_sum(array_column($newarray, 'acessos'));

foreach($newarray as $k => $array){
	$percent_usuarios = round($array['total']/$total_usuarios*100,2);
	$percent_acessos = round($array['acessos']/$total_acessos*100,2);
	
	echo '
	<tr class="author-other level-0 type-usuarios status-publish hentry">';
		if($array['escola']){ 
			echo '<td class="filtrar-coluna">'.$array['escola'].'</td>';
		}else{
			echo'<td class="filtrar-coluna">Sem Informação</td>'; 
		}
		
	echo '		
		<td>'.$array['total'].'</td>
		<td>'.$array['acessos'].'</td>
		<td>'.$percent_usuarios.'%</td>
		<td>'.$percent_acessos.'%</td>
	</tr>';
}

	

echo '</tbody>
	</table>
	</div>
	';

}




function page_lista_usuarios_profissao_novos(){

$args = array(
	'number' => -1,
	'orderby' => 'display_name',
	'date_query'    => array(
        array(
            'after'     => '2017-01-01 00:00:00',
            'inclusive' => true,
        ),
     ),
);


	$user_query = new WP_User_Query( $args );
	$arr = array();

	if ( ! empty( $user_query->results ) ) {
		foreach ( $user_query->results as $user ) {
			if($user->outra_profissao){
				$arr[] = array("profissao"=>ucfirst(strtolower($user->outra_profissao)), "acessos"=>$user->acessos, "total"=>1);	
			}else{
				$arr[] = array("profissao"=>ucfirst(strtolower($user->profissao)), "acessos"=>$user->acessos, "total"=>1);
			}
			

//			array_push($arr, ucfirst(strtolower($user->profissao)));
		}
	} else {
		echo 'Nenhum usuário encontrado';
	}

	    
	$newarray = array();
	foreach($arr as $ar)
	{
	    foreach($ar as $k => $v)
	    {
	        if(array_key_exists($v, $newarray)){
	            $newarray[$v]['acessos'] = $newarray[$v]['acessos'] + $ar['acessos'];
	            $newarray[$v]['total'] = $newarray[$v]['total'] + 1;
	        }else if($k == 'profissao'){
	            $newarray[$v] = $ar;
	        }
	    }
	}
	


		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
		echo '<script type="text/javascript" src="'.get_template_directory_uri().'/assets/js/jquery.tablesorter.min.js"></script>';
		echo '<script type="text/javascript">
				
				$(function() {
					$("table").tablesorter();
					
					$("#posts-filter").submit( function(){
						searchTable($("#post-search-input").val());
						return false;
					});
					
					$(".filtrar-coluna").each(function(){
						$("#bulk-action-selector-top").append("<option>"+$(this).text()+"</option>");
					})
					
					$("#doaction").click( function(){
						searchTable($("#bulk-action-selector-top").val());
						return false;
					})
				});

				function searchTable(inputVal){
					var table = $(".wp-list-table");
					table.find("tr").each(function(index, row){
						var allCells = $(row).find("td");
						if(allCells.length > 0){
							var found = false;
							allCells.each(function(index, td){
								var regExp = new RegExp(inputVal, "i");
								if(regExp.test($(td).text())){
									found = true;
									return false;
								}
							});
							if(found == true)$(row).show();else $(row).hide();
						}
					});
				}
				
			  </script>';
	
	echo '
<div class="wrap">
<h1 class="wp-heading-inline">Usuários por profissão</h1>

	<form id="posts-filter" method="get">
	
		<p class="search-box">
			<label class="screen-reader-text" for="post-search-input">Pesquisar posts:</label>
			<input type="search" id="post-search-input" name="s" value="">
			<input type="submit" id="search-submit" class="button" value="Pesquisar posts">
		</p>
	
		<div class="tablenav top">
	
			<div class="alignleft actions bulkactions">
				<select name="action" id="bulk-action-selector-top" style="min-width:200px;">
					<option value="">Filtrar por</option>	
				</select>
				
				<input type="submit" id="doaction" class="button action" value="Aplicar">
			</div>
							
			
			<div class="tablenav-pages one-page">
				<span class="displaying-num">'.count($newarray).' itens</span>
			</div>		
		</div>
	</form>
	
	<h2 class="screen-reader-text">Lista de posts</h2>
	<table class="wp-list-table widefat fixed striped posts">
		<thead>
			<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
			</tr>
		</thead>
	
	<tfoot>
		<tr>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>País</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>Total de acessos</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de usuários</span><span class="sorting-indicator"></span></a></th>
			<th class="manage-column column-profissao sortable desc"><a href="#"><span>% de acessos</span><span class="sorting-indicator"></span></a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
';
	

$total_usuarios = array_sum(array_column($newarray, 'total'));
$total_acessos = array_sum(array_column($newarray, 'acessos'));

foreach($newarray as $k => $array){
	$percent_usuarios = round($array['total']/$total_usuarios*100,2);
	$percent_acessos = round($array['acessos']/$total_acessos*100,2);
	
	echo '
	<tr class="author-other level-0 type-usuarios status-publish hentry">';
		if($array['profissao']){ 
			echo '<td class="filtrar-coluna">'.$array['profissao'].'</td>';
		}else{
			echo'<td class="filtrar-coluna">Sem Informação</td>'; 
		}
		
	echo '		
		<td>'.$array['total'].'</td>
		<td>'.$array['acessos'].'</td>
		<td>'.$percent_usuarios.'%</td>
		<td>'.$percent_acessos.'%</td>
	</tr>';
}

	

echo '</tbody>
	</table>
	</div>
	';

}


// add_filter( 'login_headerurl', 'custom_loginlogo_url' );
// function custom_loginlogo_url($url) {
//    return 'http://pedroprado.com.br/';
// }

//add_filter('wp_authenticate_user', 'myplugin_auth_login',10,2);

function myplugin_auth_login ($user, $password) {
	//if (get_user_meta($user->ID, 'validacao', true) == 'ok') {
	//	return $user;		
    //}else{
		//return '<meta http-equiv="refresh" content="0; url=http://pedroprado.com.br/login/?login=invalid&email='.$user->user_email.'" />';
    //}
     
}


function wp_auth_login($user, $validacao){
    if (get_user_meta($user, 'validacao', true) == $validacao) {
		
    }else{
	    

    }
}

/*

add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');
*/

/**
 * Disable the emoji's
 */
function disable_emojis() {
 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
 remove_action( 'wp_print_styles', 'print_emoji_styles' );
 remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
 add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
 add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param array $plugins 
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
 if ( is_array( $plugins ) ) {
 return array_diff( $plugins, array( 'wpemoji' ) );
 } else {
 return array();
 }
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
 if ( 'dns-prefetch' == $relation_type ) {
 /** This filter is documented in wp-includes/formatting.php */
 $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

$urls = array_diff( $urls, array( $emoji_svg_url ) );
 }

return $urls;
}



//
// Usar primeira imagem para o facebook
// 

function get_first_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	if(isset($matches[1][0])){
		$first_img = $matches[1][0];
	}else{
		$first_img = get_template_directory_uri()."/assets/images/sem-imagem.jpg";
	}
	
	return $first_img;
}


// [OBS IMPORTANTE] devido a um erro na parte de login o arquivo wp-includes/user.php precisou ser editado na linha :160
//$user = apply_filters( 'wp_authenticate_user', $user, $password );
//if ( is_wp_error($user) )
//	return $user;


