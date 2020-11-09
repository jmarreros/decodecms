<?php

//Seguridad
add_action( 'send_headers', 'add_header_seguridad' );
function add_header_seguridad() {
  header( 'X-Content-Type-Options: nosniff' );
  header( 'X-Frame-Options: SAMEORIGIN' );
  header( 'X-XSS-Protection: 1;mode=block' );
}

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );
include_once('helpers/general.php');
include_once('helpers/comments.php');
include_once('helpers/breadcrumbs.php');
include_once('helpers/related.php');
include_once('helpers/social.php');


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'DecodeCMS' );
define( 'CHILD_THEME_URL', 'https://www.decodecms.com/' );
define ('CHILD_THEME_VERSION', '1.1.21' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
  //wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Ubuntu:400,500|Lora:400,700', array(), CHILD_THEME_VERSION );
//  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Ubuntu:400,500|Open+Sans:400,600|Crimson+Text:400,700', array(), CHILD_THEME_VERSION );
  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Ubuntu:400,500|Open+Sans:400,400i,600', array(), "1.0" );
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

add_filter( 'wp_check_filetype_and_ext', function($filetype_ext_data, $file, $filename, $mimes) {
  if ( substr($filename, -4) === '.svg' ) {
    $filetype_ext_data['ext'] = 'svg';
    $filetype_ext_data['type'] = 'image/svg+xml';
  }
  return $filetype_ext_data;
}, 100, 4 );




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
//       wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js",false, '1.11.3', true);
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
      wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js",false, '1.11.3', true);
      wp_enqueue_script( 'jquery');

      wp_register_script('apigoogle', "https://apis.google.com/js/platform.js", false, '1.0', true);
      wp_enqueue_script('apigoogle');
}
//Fin Jquery al final

add_action( 'wp_enqueue_scripts', 'custom_stript');
function custom_stript() {

    // wp_enqueue_script( 'decode_script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery'), '1.0', true );

    wp_enqueue_script( 'decode_script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.5.5', true );
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
add_action( 'wp_print_scripts', 'dequeue_script_prism' );
function dequeue_script_prism() {
  if ( !is_single() ) wp_deregister_style( 'prism' );
  else wp_enqueue_script( 'prism' );

}

add_action( 'wp_print_scripts', 'dequeue_style_prism' );
function dequeue_style_prism() {
  if ( !is_single() ) wp_deregister_style( 'prism' );
  else wp_enqueue_style( 'prism' );
}
//


//Para el rating con estrellas
add_action('genesis_entry_content','colocarEstrellas');
function colocarEstrellas(){
  if ( is_single() and  function_exists('the_ratings') ) the_ratings();
}

// genesis_after_header posicion búsqueda
//---------------------------------------
genesis_register_sidebar( array(
  'id'      => 'bottom-header',
  'name'      => 'Bottom header position',
  'description' =>  'Bottom header',
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

//Para la paginación del home
add_filter( 'wpseo_genesis_force_adjacent_rel_home', '__return_true' );


// Add To Top button
//--------
add_action( 'genesis_before', 'genesis_to_top');
function genesis_to_top() {
   echo '<a href="#0" class="to-top" title="Back To Top"></a>';
}


//Metadata
//--

remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action('genesis_entry_content', 'genesis_post_info',1);
add_action('genesis_entry_content', 'genesis_post_meta',2);


add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {

  $dates_post = '<span>[ [post_date format="j F Y"] ]</span> ';
  if ( get_the_date() !=  get_the_modified_date() ){
    $dates_post .= '<span>[ Actualizado: [post_modified_date format="j F Y"] ]</span>';
    if ( ! is_single() ) $dates_post .= "<br>";
  }

  $post_info =  $dates_post.
                '<span> [ Autor: [post_author_link before=""] ]</span>'.
                '<span>[ [post_categories before=""] - '.
                getCustomfieldNivel()."</span>".
                '<span>[ <i class="fa fa-video-camera"></i> ]';

                //'[post_comments zero="0" one="1" more="%" hide_if_off="disabled"]'.
                //' [post_edit]';

  return $post_info;
}

//[post_comments zero="0" one="1" more="%" hide_if_off="disabled"]

add_filter( 'genesis_post_meta', 'sp_post_meta_filter' );
function sp_post_meta_filter($post_meta) {
if ( !is_page() ) {
  $post_meta = '[post_tags before="" sep=" "]';
  return $post_meta;
}}

function getCustomfieldNivel(){
  $nivel_val  = genesis_get_custom_field( 'Nivel' );
  $nivel_key  = array_search( $nivel_val, dcms_get_nivel_array() );
  $url        = home_url()."/wordpress-nivel/".$nivel_key;

  return "<span class='custom-nivel'><a href='".$url."'>".$nivel_val."</a></span>] ";
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
// add_filter( 'the_content_more_link', 'sp_read_more_link' );
// function sp_read_more_link() {
//   return ' <a class="link-featured" href="' . get_permalink() . '">Leer más ...</a>';
// }


//Navigation
//--------------
add_filter ( 'genesis_next_link_text' , 'sp_next_page_link' );
function sp_next_page_link ( $text ) {
    return '&#x000BB;';
}

add_filter ( 'genesis_prev_link_text' , 'sp_previous_page_link' );
function sp_previous_page_link ( $text ) {
    return '&#x000AB;';
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


//Excluir páginas de la búsqueda
function dcms_search_filter( $query ) {
  if ( $query->is_search && $query->is_main_query() ) {
    $query->set( 'post__not_in', array( 102,103 ) );
  }
}
add_action( 'pre_get_posts', 'dcms_search_filter' );


//Para reescritura de la Url, para link niveles basico,intermedio,avanzado
function dcms_custom_rewrite_tag() {
  add_rewrite_tag('%nivel%', '([^&]+)');
}
add_action('init', 'dcms_custom_rewrite_tag', 10, 0);


function dcms_custom_rewrite_rule() {
  $pagina_nivel = dcms_get_pagina_nivel();
  add_rewrite_rule('^wordpress-nivel/([^/]+)/?','index.php?page_id='.$pagina_nivel.'&nivel=$matches[1]','top');
  //add_rewrite_rule('^wordpress-nivel/([^/]+)/page/([0-9]+)?$','index.php?page_id=333&nivel=$matches[1]&paged=$matches[2]','top');
}
add_action('init', 'dcms_custom_rewrite_rule', 10, 0);



// Content Banner
genesis_register_sidebar( array(
  'id' => 'content-banner',
  'name' => __( 'Content Banner', 'genesis' ),
  'description' => __( 'Content Banner Area', 'genesis' ),
) );

add_action( 'genesis_before_loop', 'add_genesis_content_banner' );
function add_genesis_content_banner() {
  if ( is_singular('post') || is_home() || is_category() ){
        genesis_widget_area( 'content-banner', array(
          'before' => '<div class="content-banner">',
          'after'  => '</div>',
    ) );
  }
}


// Agregar estilo al backend de Wordpress
function my_login_stylesheet() {
    wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/css/style-login.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );



function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Sitio Web DECODECMS';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );


// Gutenberg
// deshabilitar para posts individuales
//add_filter('use_block_editor_for_post', '__return_false', 10);
// deshabilitar a nivel de custom post type
add_filter('use_block_editor_for_post_type', '__return_false', 10);


// Sensei Modifications
// =====================

// Change number courses column
add_filter('sensei_course_loop_number_of_columns', 'dcms_course_loop_number_of_columns');
function dcms_course_loop_number_of_columns(){
  return 2;
}

// Sidebar in courses
remove_action('sensei_after_main_content', 'gcfws_genesis_sensei_wrapper_end', 10); // remover la función del plugin de integración genesis-sensei
add_action( 'sensei_after_main_content', 'dcms_sensei_wrapper_end', 10 );

function dcms_sensei_wrapper_end() {
        echo '</main> <!-- end main-->';
        if(is_singular('course')) {
          get_sidebar('alt');
        }
        echo '</div> <!-- end .content-sidebar-wrap-->';
}

// Remove unwanted fields WooCommerce checkout
add_filter( 'woocommerce_checkout_fields' , 'woo_remove_billing_checkout_fields' );

function woo_remove_billing_checkout_fields( $fields ) {
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_city']);
    return $fields;
}





// Items menu

// if (is_post_type_archive('course')){
//   //get_sidebar('alt');
// }

// Removemos el sidebar principal y usamos el sidebar para cursos
// add_action( 'get_header', 'remove_primary_sidebar_single_pages' );
// function remove_primary_sidebar_single_pages() {
//   remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
//   add_action('genesis_sidebar', 'dcms_genesis_alt_sidebar');
// }

// function dcms_genesis_alt_sidebar(){
//   dynamic_sidebar( 'sidebar-alt' );
// }






//* Mover javascripts al footer
/*
function scripts_footer() {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);

    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
}

add_action( 'wp_enqueue_scripts', 'scripts_footer' );
*/


// Rest API add post meta
/*
add_action( 'rest_api_init', 'create_api_posts_meta_field' );

function create_api_posts_meta_field() {
 register_rest_field( 'post', 'post_meta_fields', array(
 'get_callback' => 'get_post_meta_for_api',
 'schema' => null,
 )
 );
}

function get_post_meta_for_api( $object ) {
 $post_id = $object['id'];
 return get_post_meta( $post_id );
}
*/


