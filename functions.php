<?php

//Seguridad
add_action( 'send_headers', 'add_header_seguridad' );
function add_header_seguridad() {
  header( 'X-Content-Type-Options: nosniff' );
  header( 'X-Frame-Options: SAMEORIGIN' );
  header( 'X-XSS-Protection: 1;mode=block' );
}

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'DecodeCMS' );
define( 'CHILD_THEME_URL', 'https://www.decodecms.com/' );
define ('CHILD_THEME_VERSION', '1.1.26' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );


// Modificaciones
include_once('helpers/general.php');
include_once('includes/levels.php');
include_once('includes/design.php');
include_once('includes/login-backend.php');
include_once('includes/comments.php');
include_once('includes/breadcrumbs.php');
include_once('includes/related.php');
include_once('includes/social.php');
include_once('includes/enqueue-dequeue.php');
include_once('includes/svg-support.php');
include_once('includes/optimizations.php');
include_once('includes/meta.php');
include_once('includes/analytics.php');
include_once('includes/positions.php');




// Sensei Modifications
// =====================


// Removemos el sidebar principal y usamos el sidebar para cursos dependiendo de la página
add_action( 'get_header', 'remove_primary_sidebar_single_pages' );
function remove_primary_sidebar_single_pages() {
  if (is_post_type_archive('course')){
    remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  }

  if (is_singular('course')){
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
	return $classes;
}

add_filter('course_archive_title', function(){
  $img = "<img src='" . get_stylesheet_directory_uri() . "/images/computer.svg' width='52' height='50' />";
  echo "<header class='archive-header'><h1>" . $img . " Cursos WordPress</h1></header>";
  return;
});

add_action('sensei_loop_course_before', function(){
  if (is_post_type_archive('course')){
    echo '<section class="des-courses">
            <p>Te presento los <strong>cursos que tienes disponibles en DecodeCMS</strong>, para llevar tu WordPress a otro nivel, algunos son <strong>gratuitos y otros de pago</strong>. Si todavía no eres alumno te invito a registrarte para acceder a los cursos. Si ya eres alumno, simplemente ingresa con tus datos de acceso.</p>
          </section>
      ';
  }
});





// // Change number courses column
// add_filter('sensei_course_loop_number_of_columns', 'dcms_course_loop_number_of_columns');
// function dcms_course_loop_number_of_columns(){
//   return 3;
// }

// // Sidebar in courses
// remove_action('sensei_after_main_content', 'gcfws_genesis_sensei_wrapper_end', 10); // remover la función del plugin de integración genesis-sensei
// add_action( 'sensei_after_main_content', 'dcms_sensei_wrapper_end', 10 );

// function dcms_sensei_wrapper_end() {
//         echo '</main> <!-- end main-->';
//         if(is_singular('course')) {
//           get_sidebar('alt');
//         }
//         echo '</div> <!-- end .content-sidebar-wrap-->';
// }

// // Remove unwanted fields WooCommerce checkout
// add_filter( 'woocommerce_checkout_fields' , 'woo_remove_billing_checkout_fields' );

// function woo_remove_billing_checkout_fields( $fields ) {
//     unset($fields['billing']['billing_company']);
//     unset($fields['billing']['billing_address_1']);
//     unset($fields['billing']['billing_address_2']);
//     unset($fields['billing']['billing_city']);
//     unset($fields['billing']['billing_postcode']);
//     unset($fields['billing']['billing_country']);
//     unset($fields['billing']['billing_state']);
//     unset($fields['billing']['billing_phone']);
//     unset($fields['order']['order_comments']);
//     unset($fields['billing']['billing_address_2']);
//     unset($fields['billing']['billing_postcode']);
//     unset($fields['billing']['billing_company']);
//     unset($fields['billing']['billing_city']);
//     return $fields;
// }





// Items menu

// if (is_post_type_archive('course')){
//   get_sidebar('alt');
// }





//* Mover javascripts al footer
/*
function scripts_footer() {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);

    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
}

add_action( 'wp_enqueue_scripts', 'scripts_footer' );
*/


// Rest API add post meta
/*
add_action( 'rest_api_init', 'create_api_posts_meta_field' );

function create_api_posts_meta_field() {
 register_rest_field( 'post', 'post_meta_fields', array(
 'get_callback' => 'get_post_meta_for_api',
 'schema' => null,
 )
 );
}

function get_post_meta_for_api( $object ) {
 $post_id = $object['id'];
 return get_post_meta( $post_id );
}
*/


