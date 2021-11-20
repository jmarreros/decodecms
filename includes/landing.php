<?php

add_filter( 'body_class', 'prefix_custom_body_class' );

function prefix_custom_body_class( $classes ) {
    $id_page = get_the_ID();
    $is_landing = boolval(get_post_meta( $id_page, 'is_landing' , true));

    if ( $is_landing ){
        //* Remove site header elements
        remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
        remove_action( 'genesis_header', 'genesis_do_header' );
        remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
        remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
        remove_action('genesis_after_header', 'genesis_do_nav');
        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

        $classes[] = 'is_landing';
    }

    return $classes;
}