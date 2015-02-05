<?php
/**
 * WPM Template Hooks
 *
 * Action/filter hooks used for WooCommerce Price Matrix templates
 *
 * @author 		Shane Welland
 * @category 	Core
 * @package 	WooCommerce Price Matrix
 * @version     1.0
 */

/**
 * Product summary
 */
add_action( 'woocommerce_single_product_summary', 'wpm_variation_grid', 25 );

/**
 * WC Hooks
 */
add_action( 'wp_head', 'wpm_remove_wc_hooks' );

function wpm_remove_wc_hooks() {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
}