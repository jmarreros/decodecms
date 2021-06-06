<?php

//Para reescritura de la Url, para link niveles basico,intermedio,avanzado
function dcms_custom_rewrite_tag() {
	add_rewrite_tag('%nivel%', '([^&]+)');
}
add_action('init', 'dcms_custom_rewrite_tag', 10, 0);

function dcms_custom_rewrite_rule() {
	$pagina_nivel = dcms_get_pagina_nivel();
	add_rewrite_rule('^wordpress-nivel/([^/]+)/?','index.php?page_id='.$pagina_nivel.'&nivel=$matches[1]','top');
	//add_rewrite_rule('^wordpress-nivel/([^/]+)/page/([0-9]+)?$','index.php?page_id=333&nivel=$matches[1]&paged=$matches[2]','top');
}
add_action('init', 'dcms_custom_rewrite_rule', 10, 0);

