<?php

// Register Custom Post Type
function custom_post_type_cursos() {

	$labels = array(
		'name'                  => _x( 'Cursos', 'Post Type General Name', 'domain_cursos' ),
		'singular_name'         => _x( 'Curso', 'Post Type Singular Name', 'domain_cursos' ),
		'menu_name'             => __( 'cursos', 'domain_cursos' ),
		'name_admin_bar'        => __( 'Cursos', 'domain_cursos' ),
		'archives'              => __( 'Cursos', 'domain_cursos' ),
		'attributes'            => __( 'Atributos', 'domain_cursos' ),
		'parent_item_colon'     => __( 'Curso Padre', 'domain_cursos' ),
		'all_items'             => __( 'Todos los Cursos', 'domain_cursos' ),
		'add_new_item'          => __( 'Agregar nuevo', 'domain_cursos' ),
		'add_new'               => __( 'Añadir Nuevo', 'domain_cursos' ),
		'new_item'              => __( 'Nuevo Curso', 'domain_cursos' ),
		'edit_item'             => __( 'Editar Curso', 'domain_cursos' ),
		'update_item'           => __( 'Actualizar Curso', 'domain_cursos' ),
		'view_item'             => __( 'Ver Curso', 'domain_cursos' ),
		'view_items'            => __( 'Ver Cursos', 'domain_cursos' ),
		'search_items'          => __( 'Buscar Curso', 'domain_cursos' ),
		'not_found'             => __( 'No encontrado', 'domain_cursos' ),
		'not_found_in_trash'    => __( 'No encontrado', 'domain_cursos' ),
		'featured_image'        => __( 'Imagen destacada', 'domain_cursos' ),
		'set_featured_image'    => __( 'Establecer imagen', 'domain_cursos' ),
		'remove_featured_image' => __( 'Eliminar imagen', 'domain_cursos' ),
		'use_featured_image'    => __( 'Usar imagen', 'domain_cursos' ),
		'insert_into_item'      => __( 'Insertar', 'domain_cursos' ),
		'uploaded_to_this_item' => __( 'Subir', 'domain_cursos' ),
		'items_list'            => __( 'lista cursos', 'domain_cursos' ),
		'items_list_navigation' => __( 'lista cursos nav', 'domain_cursos' ),
		'filter_items_list'     => __( 'Filtrar cursos', 'domain_cursos' ),
	);
	$rewrite = array(
		'slug'                  => '',
		'with_front'            => false,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Curso', 'domain_cursos' ),
		'description'           => __( 'Entradas para cursos', 'domain_cursos' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'            => array( 'category' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-book',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'cursos', $args );

}
add_action( 'init', 'custom_post_type_cursos', 0 );