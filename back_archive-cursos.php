<?php



 // function yoast_og_tag ($tag) {
 //    return false;
 // }
 // $yfilters = [ 'wpseo_opengraph_desc','wpseo_opengraph_image','wpseo_twitter_description','wpseo_twitter_image' ];
 // foreach ($yfilters as $k => $f) {
 //      add_filter( $f, 'yoast_og_tag', 10, 1 );
 // }



function custom_loop_cursos(){
  $page     = get_post(250); 
  $content  = apply_filters( 'the_content', $page->post_content );
  echo $content;
}

add_action( 'genesis_loop', 'custom_loop_cursos' );
remove_action( 'genesis_loop', 'genesis_do_loop' );

genesis();