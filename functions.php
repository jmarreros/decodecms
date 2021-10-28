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
include_once('includes/sensei.php');


// add_action( 'after_setup_theme', 'declare_sensei_support' );
// function declare_sensei_support() {
//     add_theme_support( 'sensei' );
// }




