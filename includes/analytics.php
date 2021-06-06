<?php

// Google Tag Manager
// ====================
// Codigo Google Tag Manager Head
add_action( 'wp_head', 'dcms_tag_manager_head' );
function dcms_tag_manager_head() { ?>
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-T8JGC9S');</script>
<?php }

// Codigo Google Tag Manager Body
add_action( 'genesis_before', 'dcms_tag_manager_body' );
function dcms_tag_manager_body() { ?>
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T8JGC9S"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<?php }