<?php


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

  $str  = "<div class='copy'>";
  $str .= "&copy {$img} <br>";
  $str .= "<a class='politica' href='/politica-de-privacidad/' >Política de Privacidad</a> | <a class='politica' href='/reembolso_devoluciones/' >Política de devoluciones</a><br>";
  $str .= "<span> Copyrigth $year </span> <span> Todos los derechos reservados </span><br>" ;
  $str .= "</div>";

  echo $str;
}

//Para la paginación del home
add_filter( 'wpseo_genesis_force_adjacent_rel_home', '__return_true' );


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



// Featured images
//-----------------
add_action( 'genesis_before_entry_content', 'featured_post_image', 1 );
function featured_post_image() {
  if ( is_singular( ['page','post']) || empty(get_the_post_thumbnail()) )  return;
  echo "<div class='thumbnail'>".get_the_post_thumbnail()."</div>";
}


// Add To Top button
//--------
add_action( 'genesis_before', 'genesis_to_top');
function genesis_to_top() {
   echo '<a href="#0" class="to-top" title="Back To Top"></a>';
}


// Move video Youtube below the title in articles
//add_filter('the_content', 'dcms_move_content_youtube', 1, 1);
//function dcms_move_content_youtube($content){
//  if ( ! is_singular('post') ) return $content;
//
//  $pattern = '/<p class="aligncenter borde-video-sus">(.*)/s';
//
//  preg_match($pattern, $content, $matches);
//
//  error_log(print_r($content,true));
//  error_log(print_r($matches,true));
//
//  $replacement = '';
////  $content = preg_replace($pattern, $replacement, $content);
//
//  return $content;
//}






