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
define ('CHILD_THEME_VERSION', '1.1.27' );

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
// para cursos usamos sidebar alterno y para lecciones quitamos sidebar y breadcrumbs
add_action( 'get_header', 'remove_primary_sidebar_single_pages' );
function remove_primary_sidebar_single_pages() {
  if ( is_post_type_archive('course') ){
    remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
  }

  if ( is_singular('lesson') ){
    remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
  }

  if ( is_singular('course') || is_singular('lesson') ){
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
  if (is_post_type_archive('course')){
    echo '<section class="des-courses">
            <p>Te presento los <strong>cursos que tienes disponibles en DecodeCMS</strong>, para llevar tu WordPress a otro nivel, algunos son <strong>gratuitos y otros de pago</strong>. Si todavía no eres alumno te invito a registrarte para acceder a los cursos. Si ya eres alumno, simplemente ingresa con tus datos de acceso.</p>
          </section>
      ';
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




// add_action( 'after_setup_theme', 'declare_sensei_support' );
// function declare_sensei_support() {
//     add_theme_support( 'sensei' );
// }




