<?php


//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );
include_once('helpers/comments.php');
include_once('helpers/breadcrumbs.php');
// include_once('helpers/related.php');
include_once('helpers/social.php');

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'DecodeCMS' );
define( 'CHILD_THEME_URL', 'http://www.decodecms.com/' );
define ('CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
  //wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Ubuntu:400,500|Lora:400,700', array(), CHILD_THEME_VERSION );
//  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Ubuntu:400,500|Open+Sans:400,600|Crimson+Text:400,700', array(), CHILD_THEME_VERSION );
  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Ubuntu:400,500|Crimson+Text:400,600', array(), CHILD_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );


//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );


//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

/* Soporte para cargar archivos svg*/
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header_right', 'genesis_do_subnav' );


//Eliminar Emotions Emoji
function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) 
    return array_diff( $plugins, array( 'wpemoji' ) );
  else 
    return array();
}

function disable_wp_emojicons() {

  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}

add_action( 'init', 'disable_wp_emojicons' );



// Sustituimos la versión de jQuery local por la del CDN de Google

// function dequeue_script_jquery() {
//    if( !is_admin()){
//       wp_deregister_script('jquery');
//       wp_register_script('jquery', "http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js",false, '1.11.3', true);
//       wp_enqueue_script('jquery');
//     }
// }
// add_action('genesis_after_footer', 'dequeue_script_jquery');


//Jquery al final
add_action('wp_enqueue_scripts', 'jquery_script_remove_header');
function jquery_script_remove_header() {
      wp_deregister_script( 'jquery' );
}
 
add_action('genesis_after_footer', 'jquery_script_add_footer',0);
function jquery_script_add_footer() {
      wp_register_script('jquery', "http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js",false, '1.11.3', true);
      wp_enqueue_script( 'jquery');
}
//Fin Jquery al final

add_action( 'wp_enqueue_scripts', 'custom_stript');
function custom_stript() {
    wp_enqueue_script( 'decode_script', get_stylesheet_directory_uri() . '/js/script.js', false, '1.0', true );
}


//Skip-links at the bottom
function dequeue_script_skip_links() {
    wp_dequeue_script('skip-links');
    wp_enqueue_script('skip-links',GENESIS_JS_URL . "/skip-links.js",array(),'',true);
}
add_action( 'wp_print_scripts', 'dequeue_script_skip_links', 100 );


//Para el lightbox
function dequeue_script_lightbox(){
  wp_dequeue_script('enqueue_client_files_footer');
}
add_action('wp_print_scripts','dequeue_script_lightbox');


//Para el boletin de suscirpciones
function dequeue_style_boletin(){
  if ( !is_admin() ){
    wp_deregister_style('validate-engine-css'); 
  }
}
add_action( 'wp_print_styles', 'dequeue_style_boletin', 100 );


//Para el plugin prism
// add_action( 'wp_print_scripts', 'dequeue_script_prism' );
// function dequeue_script_prism() {
//   if ( !is_single() ) wp_deregister_style( 'prism' );
// }

// add_action( 'wp_print_scripts', 'dequeue_style_prism' );
// function dequeue_style_prism() {
//   if ( !is_single() ) wp_deregister_style( 'prism' );
// }
// //



//Para el rating con estrellas
add_action('genesis_entry_content','colocarEstrellas');
function colocarEstrellas(){
  if ( is_single() and  function_exists('the_ratings') ) the_ratings();  
}


// genesis_after_header posicion búsqueda
//---------------------------------------
genesis_register_sidebar( array(
	'id'			=> 'bottom-header',
	'name'			=> 'Bottom header position',
	'description'	=>  'Bottom header',
) );

function positionBottomHeader() {

	genesis_widget_area( 'bottom-header', array(
		'before' => '<div id="search"><div class="wrap">',
		'after' => '</div></div>'
	) );

}

add_action( 'genesis_after_header', 'positionBottomHeader' );


//Para la búsqueda
//-----------------
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( 'Buscar...' );
}


add_filter( 'genesis_search_button_text', 'wpsites_search_button_icon' );
function wpsites_search_button_icon( $text ) {
  return esc_attr( '&#xf002;' );
}


remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'sp_custom_footer' );
function sp_custom_footer() {
	$year = date("Y");
	$img  = "<img src='".get_stylesheet_directory_uri()."/images/logo-pie.svg' alt='logo decode pie' width='134' height='17' />";
	$str  = "<p class='copy'>&copy $img  <span> Copyright $year | </span> <span> Todos los derechos reservados | <a class='politica' href='/politica-de-privacidad/' >Política de Privacidad</a></span> </p> ";
	echo $str;
}


// Add To Top button
//--------
add_action( 'genesis_before', 'genesis_to_top');
function genesis_to_top() {
	 echo '<a href="#0" class="to-top" title="Back To Top">Top</a>';
}


//Metadata 
//--

remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action('genesis_entry_content', 'genesis_post_info',1);
add_action('genesis_entry_content', 'genesis_post_meta',2);

add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {
	$post_info =  '<span>[ [post_date format="j F Y"] ]</span> '.
                '<span> [ Autor: [post_author_link before=""] ]</span> '.
                '<span>[ [post_categories before=""] - '.
                getCustomfield()."</span>".
                '<span>[ <i class="fa fa-video-camera"></i> ]';

                //'[post_comments zero="0" one="1" more="%" hide_if_off="disabled"]'.
                //' [post_edit]';

	return $post_info;
}

add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
if ( !is_page() ) {
	$post_meta = '[post_tags before="" sep=" "]';
	return $post_meta;
}}

function getCustomfield($field='Nivel'){
  return "<span class='custom".$field."'>".genesis_get_custom_field( $field)."]</span> ";
}

// Featured images
//-----------------
add_action( 'genesis_before_entry_content', 'featured_post_image', 1 );
function featured_post_image() {
  if ( is_singular( 'page' ) )  return;
	//the_post_thumbnail('post-image');
  echo "<div class='thumbnail'>".get_the_post_thumbnail()."</div>";
}



//Read more
//----------
add_filter( 'the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return ' [<a href="' . get_permalink() . '">Leer más</a>]';
}


//Navigation
//--------------
add_filter ( 'genesis_next_link_text' , 'sp_next_page_link' );
function sp_next_page_link ( $text ) {
    return '&#x000BB;';
}

add_filter ( 'genesis_prev_link_text' , 'sp_previous_page_link' );
function sp_previous_page_link ( $text ) {
    //return '&#x000AB;';
    return '<span class="arrow-right"> </span>';
}

add_action( 'wp_enqueue_scripts', 'sp_disable_hoverIntent' );
function sp_disable_hoverIntent() {
	wp_deregister_script( 'hoverIntent' );
}


//Eliminar la carga de archivo contact form 7
add_action( 'wp_print_scripts', 'dequeue_script_cf7', 15 );
function dequeue_script_cf7() {
    if ( !is_page(19) ) {
        wp_deregister_script( 'contact-form-7' );
    }
}
add_filter( 'wpcf7_load_css', '__return_false' );



//Eliminamos el CSS de ratings
function dequeue_style_ratings() {
  wp_deregister_style('wp-postratings');
}
add_action('wp_print_styles', 'dequeue_style_ratings', 100);


//Para el js embed
function dequeue_script_embed(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'dequeue_script_embed' );


//Para la página del video-curso

function enqueue_styles_scripts_video_curso() {
  if ( is_page(289) ){
    wp_enqueue_style( 'video-curso-estilo', get_stylesheet_directory_uri().'/css/video-curso.css');
    wp_enqueue_script( 'video-curso-script', get_stylesheet_directory_uri() .'/js/video-curso.js', array(), '1.0.0', true );
  }
}

add_action( 'wp_enqueue_scripts', 'enqueue_styles_scripts_video_curso' );
