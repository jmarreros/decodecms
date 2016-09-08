<?php
  
 function dc_related_after_content( $content ) 
 { 
    
    if ( !is_singular('post') ) return $content;	
	
	$cad			= "";
	$template_li 	= '<li>
							<a class="thumb_rel" href="{url}">{thumb}</a>
							<a class="title_rel" href="{url}">{title}</a>
						</li>';
	$template_rel	= '<div class="rel_posts">
							<h3>Artículos Relacionados</h3>
							<ul>
								{list}
							</ul>
					   </div>';

    $terms = get_the_terms( get_the_ID(), 'category');
    $categ = array();
    
    foreach ($terms as $term) 
    {
    	$categ[] = $term->term_id;
    }

    $loop	= new WP_QUERY(array(
    				'cat__in'			=> $categ,
    				'posts_per_page'	=> 4,
    				'post__not_in'		=>array(get_the_ID()),
    				'orderby'			=>'rand'
    				));

    if ( $loop->have_posts() )
    {

    	while ( $loop->have_posts() )
    	{
    		$loop->the_post();

    		$search	 = Array('{url}','{thumb}','{title}');
	  		$replace = Array(get_permalink(),get_the_post_thumbnail(),get_the_title());
    	
    		$cad .= str_replace($search,$replace, $template_li);
    		// echo "hola";
    	}

    	if ( $cad ) 
    	{
		  	$content .= str_replace('{list}', $cad, $template_rel);
    	}

    }
   	wp_reset_query();

    return $content;
}

add_filter( 'the_content', 'dc_related_after_content'); 	


// function dc_related_post_catg()
// {
// 	add_filter( 'the_content', 'dc_related_after_content'); 	
// }

// add_action( 'genesis_entry_footer', 'dc_related_post_catg' );


// add_action( 'genesis_entry_footer', 'dc_related_post_tags');


/*
function dc_related_post()
{
	if ( !is_single() ) return;

	// $orig_post 	 	= $post;
	global $post;
	$tags = wp_get_post_tags($post->ID);

	$cad			= "";
	$template_li 	= '<li>
							<a class="thumb_rel" href="{url}">{thumb}</a>
							<a class="title_rel" href="{url}">{title}</a>
						</li>';
	$template_rel	= '<div class="rel_posts">
							<h3>Artículos Relacionados</h3>
							<ul>
								{list}
							</ul>
					   </div>';

	  if ($tags) 
	  {
		  $tag_ids = array();

		  foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		  
		  $args=array(
			  'tag__in' => $tag_ids,
			  'post__not_in' => array($post->ID),
			  'posts_per_page'=>4,
			  'caller_get_posts'=>1
		  );
		   
		  $my_query = new wp_query( $args );
			
		  while( $my_query->have_posts() )
		  {
		  	$my_query->the_post();
		  	
		  	$search	 = Array('{url}','{thumb}','{title}');
		  	$replace = Array(get_permalink(),get_the_post_thumbnail(),get_the_title());

		  	$cad .= str_replace($search,$replace, $template_li);
		   
		  } //while

		  if ( $cad ) 
		  	return str_replace('{list}', $cad, $template_rel);

	} //if

	// $post = $orig_post;
	wp_reset_postdata();

}*/