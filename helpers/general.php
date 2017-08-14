<?php

function dcms_get_pagina_nivel(){
	return 333;
}

function dcms_get_nivel_array(){
	return ['basico'=>'Básico', 'intermedio'=>'Intermedio', 'avanzado'=>'Avanzado'];
}


//Funcion para retornar el parámetro de nivel de la url
// $get_alias , para retornar el key/alias, o el valor del array $niveles
function dcms_get_nivel( $get_alias = true ){
	global $wp_query;

	$pagina	 = dcms_get_pagina_nivel();
	$niveles = dcms_get_nivel_array();

	if ( is_page( $pagina ) )
	{
		$nivel = $wp_query->query_vars['nivel'];

		if ( array_key_exists( $nivel, $niveles ) )
		{
			if ( $get_alias )
				return $nivel;
			else
				return $niveles[ $nivel ];
		}

	}

	return '';
}
