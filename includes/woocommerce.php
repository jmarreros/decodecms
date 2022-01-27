<?php

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

// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


// Remove streng password
add_action( 'wp_print_scripts', 'iconic_remove_password_strength', 10 );
function iconic_remove_password_strength() {
  wp_dequeue_script( 'wc-password-strength-meter' );
}


// Remove elements my-account navigation
add_filter( 'woocommerce_account_menu_items', 'dcms_remove_items_menu_my_account' , 99, 1);
function dcms_remove_items_menu_my_account($items) {
    error_log(print_r($items,true));
    unset($items['downloads']);
    unset($items['edit-address']);

    return $items;
}