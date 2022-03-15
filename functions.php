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
define ('CHILD_THEME_VERSION', '1.1.34' );

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
include_once('includes/landing.php');
include_once('includes/sensei.php');
include_once('includes/woocommerce.php');






// Inserta el pixel de Facebook en todas las páginas y añade el evento de conversión de compra para medir las compras finalizadas
if ( in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ) ) && version_compare( WC()->version , '3.0.0', '>' ) ){
	add_action( 'wp_head', 'fb_pixel_purchases_traking' );
	function fb_pixel_purchases_traking() {

		$fb_pixel_id = '492510214278379'; // Debes reemplazar el texto <FB_PIXEL_ID> por tu código identificador del pixel manteniendo las comillas

		ob_start()
		?>
		<!-- Start FB Tracking -->
		<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
				document,'script','//connect.facebook.net/en_US/fbevents.js');
			fbq('init', <?php echo '\''. $fb_pixel_id .'\'';?>);
			fbq('track', 'PageView');
		</script>
		<noscript>
			<img height="1" width="1" border="0" alt="" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $fb_pixel_id;?>&amp;ev=PageView&amp;noscript=1" />
		</noscript>
		<!-- END FB Tracking -->
		<?php

		if ( is_wc_endpoint_url( get_option( 'woocommerce_checkout_order_received_endpoint' ) ) && isset( $_GET[ 'key' ] ) ) {

			$order = new WC_Order( wc_get_order_id_by_order_key( $_GET[ 'key' ] ) );
			$order_total = $order->get_total();
			?>
			<script>
				fbq('track', 'Purchase', {
					value: <?php echo '\''. $order_total .'\''; ?>,
					currency: <?php echo '\''. get_woocommerce_currency() .'\''; ?>
				});
			</script>
			<?php
		}

		$fb_pixel_script = ob_get_contents();
		ob_end_clean();
		echo $fb_pixel_script;
	}
}

