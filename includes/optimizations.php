<?php

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


//Para el rating con estrellas
add_action('genesis_entry_content','colocarEstrellas');
function colocarEstrellas(){
  if ( is_singular('post') and  function_exists('the_ratings') ) {
        the_ratings();
      }
}


// Gutenberg
// deshabilitar para posts individuales
//add_filter('use_block_editor_for_post', '__return_false', 10);
// deshabilitar a nivel de custom post type
add_filter('use_block_editor_for_post_type', '__return_false', 10);

function dcms_enable_gutenberg_cpt($is_enabled, $post_type) {
	if ($post_type === 'page') return true;
	return $is_enabled;
}
add_filter('use_block_editor_for_post_type', 'dcms_enable_gutenberg_cpt', 10, 2);






//Excluir páginas de la búsqueda
function dcms_search_filter( $query ) {
    if ( $query->is_search && $query->is_main_query() ) {
      $query->set( 'post__not_in', array( 102,103 ) );
    }
  }
  add_action( 'pre_get_posts', 'dcms_search_filter' );

