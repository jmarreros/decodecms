<?php
include_once 'helpers/general.php';

if ( ! dcms_get_nivel() ){
  wp_redirect( home_url() );
  exit;
}


function dcms_do_custom_loop() {

    $current_url = explode('/',$_SERVER['REQUEST_URI']);
    $paged = (int)$current_url[count($current_url)-2];

    $nivel = dcms_get_nivel(false);

    $args = array(
        'post_type'   => 'post',
        'post_status' => 'publish',
        'paged'       => $paged,
        'meta_key'		=> 'nivel',
        'meta_value'  => $nivel
    );

    genesis_custom_loop( $args );

}

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'dcms_do_custom_loop' );

genesis();
