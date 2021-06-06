<?php

remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header_right', 'genesis_do_subnav' );

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

// Content Banner
genesis_register_sidebar( array(
    'id' => 'content-banner',
    'name' => __( 'Content Banner', 'genesis' ),
    'description' => __( 'Content Banner Area', 'genesis' ),
));

add_action( 'genesis_before_loop', 'add_genesis_content_banner' );
function add_genesis_content_banner() {
    if ( !is_page() ){
            genesis_widget_area( 'content-banner', array(
            'before' => '<div class="content-banner">',
            'after'  => '</div>',
        ) );
    }
}

