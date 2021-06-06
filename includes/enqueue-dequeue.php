<?php

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
  wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Ubuntu:400,500|Open+Sans:400,400i,700', array(), "1.0" );
}


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


// Custom script
add_action( 'wp_enqueue_scripts', 'custom_stript');
function custom_stript() {
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


//Para el boletin de suscripciones
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




