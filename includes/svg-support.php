<?php

/* Soporte para cargar archivos svg*/
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

add_filter( 'wp_check_filetype_and_ext', function($filetype_ext_data, $file, $filename, $mimes) {
  if ( substr($filename, -4) === '.svg' ) {
    $filetype_ext_data['ext'] = 'svg';
    $filetype_ext_data['type'] = 'image/svg+xml';
  }
  return $filetype_ext_data;
}, 100, 4 );