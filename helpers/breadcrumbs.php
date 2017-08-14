<?php
function sp_breadcrumb_args( $args ) {
	$args['home'] = 'Inicio';
	$args['sep'] = ' / ';
	$args['list_sep'] = ', ';
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
	$args['heirarchial_attachments'] = true;
	$args['heirarchial_categories'] = true;
	$args['display'] = true;
	$args['labels']['prefix'] = '';
	$args['labels']['author'] = 'autor ';
	$args['labels']['category'] = '';
	$args['labels']['tag'] = 'tag ';
	$args['labels']['date'] = 'fecha ';
	$args['labels']['search'] = 'búsqueda ';
	$args['labels']['tax'] = 'tax ';
	$args['labels']['post_type'] = '';
	$args['labels']['404'] = 'No encontrado: ';

	$nivel =  dcms_get_nivel(false);
	if ( $nivel ){
		$args['suffix'] = '/ '. $nivel.$args['suffix'];
	}
	
return $args;
}

add_filter( 'genesis_breadcrumb_args', 'sp_breadcrumb_args' );
