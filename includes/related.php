<?php

function dc_related_after_content( $content )
{
    global $wp;
    $is_amp = substr($wp->request,-4) == '/amp';

    $number_related = 4;
    $custom_field = 'relacionados';
    $counter = 0;
    $cad = "";
    if ( !is_singular('post') ) return $content;

    $template_li    = '<li>';
    $template_li    .= ( !$is_amp ) ? '<a class="thumb_rel" href="{url}">{thumb}</a>':'';
    $template_li    .= '<a class="title_rel" href="{url}">{title}</a>
                        </li>';

    $template_rel   = '<div class="rel_posts">
                            <h3>Artículos Relacionados</h3>
                            <ul>
                                {list}
                            </ul>
                       </div>';
    // -- Entradas relacionadas específicas
    $related = get_post_meta( get_the_ID(), $custom_field, true );
    $related = array_filter(explode(',', $related), 'ctype_digit');
    $loop   = new WP_QUERY(array(
                'post__in'          => $related,
                'posts_per_page'    => $number_related,
                'post__not_in'      => array(get_the_ID()),
                ));

     $cad = dc_loop_related($loop, $template_li, $counter);

    // -- Entradas de acuerdo a la categoría
    if ( $number_related - $counter > 0 ){
        $terms = get_the_terms( get_the_ID(), 'category');
        $categ = array();

        if ( $terms ){
            foreach ($terms as $term) $categ[] = $term->term_id;
        }

        if ( count($categ) ){
            $loop   = new WP_QUERY(array(
                        'category__in'      => $categ,
                        'posts_per_page'    => $number_related - $counter,
                        'post__not_in'      => array( get_the_ID().','. implode(',',$related) ),
                        'orderby'           =>'rand'
                        ));
            $cad .= dc_loop_related($loop, $template_li, $counter);
        }
    }

    if ( $cad ) $content .= str_replace('{list}', $cad, $template_rel);
    return $content;
}

function dc_loop_related($loop, $template_li, &$counter){

    $str = "";
    if ( $loop->have_posts() )
    {
        while ( $loop->have_posts() )
        {
            $loop->the_post();
            $search  = Array('{url}','{thumb}','{title}');
            $replace = Array(get_permalink(),get_the_post_thumbnail(),get_the_title());

            // error_log(print_r('--->',true));
            // error_log(get_the_post_thumbnail());
            // error_log(print_r($cad,true));

            $str .= str_replace($search,$replace, $template_li);

            // error_log(print_r($str,true));

            $counter++;
        }
    }
    wp_reset_query();
    return $str;
}
add_filter( 'the_content', 'dc_related_after_content');

