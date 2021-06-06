<?php

//Metadata

remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

add_action('genesis_entry_content', 'genesis_post_info',1);
add_action('genesis_entry_content', 'genesis_post_meta',2);


add_filter( 'genesis_post_info', 'post_info_filter' );
function post_info_filter($post_info) {

  $dates_post = '<span>[ [post_date format="j F Y"] ]</span> ';
  if ( get_the_date() !=  get_the_modified_date() ){
    $dates_post .= '<span>[ Actualizado: [post_modified_date format="j F Y"] ]</span>';
    $dates_post .= "<br>";
  }

  $post_info =  $dates_post.
                '<span> [ Autor: [post_author_link before=""] ]</span>'.
                '<span>[ [post_categories before=""] - '.
                getCustomfieldNivel();

                //'[post_comments zero="0" one="1" more="%" hide_if_off="disabled"]'.
                //' [post_edit]';

  // Ocultar icono video
  if ( ! get_post_meta(get_the_ID(),'quitar-icono-video', true) ){
    $post_info .= '</span>'.
                  '<span>[ <i class="fa fa-video-camera"></i> ]';
  }

  // Patrocinado

  if ( get_post_meta(get_the_ID(),'patrocinado', true) ){
    $post_info .= '</span>'.
                  '<span class="sponsored">[ Patrocinado ]';
  }


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

