<?php

// Removemos el sidebar principal y usamos el sidebar para cursos dependiendo de la página
// para cursos usamos sidebar alterno y para lecciones quitamos sidebar y breadcrumbs
add_action( 'get_header', 'remove_primary_sidebar_single_pages' );
function remove_primary_sidebar_single_pages() {
  if ( is_post_type_archive('course') || is_singular('course')){
    remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  }

  if ( is_singular('lesson') ){
    remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
  }

  if ( is_singular('lesson') ){
    remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
    add_action('genesis_sidebar', function(){
                                    dynamic_sidebar( 'sidebar-alt' );
                                  });
  }
}

// Agregamos la clase a la página de listado de cursos
add_filter('body_class','dcms_add_class_sensei_body');
function dcms_add_class_sensei_body( $classes ) {
	if ( is_post_type_archive('course') ) {
	    $classes[] = 'archive-course';
	}

  if (is_user_logged_in()) {
    $classes[] = 'logged-in';
  } else {
    $classes[] = 'logged-out';
  }
	return $classes;
}

add_filter('course_archive_title', function(){
  $img = "<img src='" . get_stylesheet_directory_uri() . "/images/computer.svg' width='52' height='50' />";
  echo "<header class='archive-header'><h1>" . $img . " Cursos WordPress</h1></header>";
  return;
});

add_action('sensei_loop_course_before', function(){
    global $id_my_courses_page;

   $id_my_courses_page = get_post_field('post_name', get_the_ID());
  if (is_post_type_archive('course')){

    if ( $id_my_courses_page == 'mis-cursos' ){
        echo '<section class="des-courses">
                <p>Aqui se listan todos los <strong>cursos disponibles para tu cuenta</strong> y el avance en porcentaje.</p>
            </section>';
    } else {
        echo '<section class="des-courses">
                <p>Te presento los <strong>cursos que tienes disponibles en DecodeCMS</strong>, para llevar tu WordPress a otro nivel, algunos son <strong>gratuitos y otros de pago</strong>. Si todavía no eres alumno te invito a registrarte para acceder a los cursos. Si ya eres alumno, simplemente ingresa con tus datos de acceso.</p>
            </section>';
    }

  } else {
    $id_my_courses_page ='';
  }
});


add_filter('get_the_excerpt', function($excerpt){
  if (is_post_type_archive('course')){
    $link = '<div class="buttons-course">
            <a class="btn-course go-course" href="' . get_permalink() . '">
            <i class="fa fa-arrow-right"></i> Ir al curso
            </a>
            </div>';

    return $excerpt.$link;
  }
  return $excerpt;
});


// Add user menu with name
add_filter( 'wp_nav_menu_objects', 'my_dynamic_menu_items' );

function my_dynamic_menu_items( $menu_items ) {
	$final_menu = [];
    foreach ( $menu_items as $menu_item ) {
        if ( '#mi-cuenta#' == $menu_item->title ) {
        	 $user=wp_get_current_user();
        	if ( $user->ID ){
        		 $menu_item->title = $user->user_firstname?$user->user_firstname:$user->user_login;
        		 $final_menu[] = $menu_item;
            }
          else {
            $menu_item->title = 'Acceder';
            $final_menu[] = $menu_item;
          }
        } else {
        	$final_menu[] = $menu_item;
        }
    }
    return $final_menu;
}


// Active menu courses
add_filter('nav_menu_css_class' , 'item_menu_courses_class' , 10 , 2);

function item_menu_courses_class ($classes, $item) {

      if ($item->title == 'Cursos'){
        if ( is_post_type_archive('course') || is_singular(['course', 'lesson']) ) {
          $classes[] = 'current-menu-item';
        }
      }

      return $classes;
}


// Cambio textos
add_filter( 'gettext', 'dcms_change_traduction_text', 10, 3 );
function dcms_change_traduction_text( $translated, $original, $domain ) {
    if ( $original == "Back to: " && $domain == 'sensei-lms' ) {
        $translated = "";
    }
    return $translated;
}


// Agregar imagen antes

add_action('sensei_course_content_inside_before', 'add_featured_image_course');

function add_featured_image_course( $id_course ){
  global $id_my_courses_page;

    if ( isset($id_my_courses_page) && $id_my_courses_page == 'mis-cursos' ){
        $image_url = get_the_post_thumbnail_url($id_course);
        echo "<img class='mi-courses-featured' src='${image_url}' width='150' height='150' />";
    }
}




// Remove fields from checkout page
add_filter('woocommerce_billing_fields','wpb_custom_billing_fields');
function wpb_custom_billing_fields( $fields = array() ) {

	unset($fields['billing_company']);
	unset($fields['billing_address_1']);
	unset($fields['billing_address_2']);
	unset($fields['billing_state']);
	unset($fields['billing_city']);
	unset($fields['billing_phone']);
	unset($fields['billing_postcode']);
	unset($fields['billing_country']);

	return $fields;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields_ek', 99 );
function custom_override_checkout_fields_ek( $fields ) {
     unset($fields['billing']['billing_company']);
     unset($fields['billing']['billing_address_1']);
     unset($fields['billing']['billing_postcode']);
     unset($fields['billing']['billing_state']);

     return $fields;
}

add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );