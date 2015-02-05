<?php
/**
* Plugin Name: WooCommerce Price Matrix
* Plugin URI: http:// www.creare.co.uk/
* Description: A small, useful plugin for replacing variable price dropdowns with a price matrix.
* Version: 1.0.1
* Author: Shane Welland
* Author URI: http:// www.creare.co.uk/
* License: GPL2
*
* @package WooCommerce Price Matrix
* @author Shane Welland
*/

class WPM
{
	/**
	 * WooCommerce Price Matrix 1.0
	 */
	public $version = '1.0';

	/**
	 * Single instance of WooCommerce Price Matrix
	 */
	protected static $_instance = null;

	/**
	 * Ensure only one instance of the plugin is available
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * WPM Constructor
	 */
	public function __construct() {

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			// Defines
			$this->define_constants();

			// Core includes
			$this->includes();
			$this->admin_includes();

			// Hooks
			$this->include_template_functions();
		}
	}

	/**
	 * Require all core includes
	 */
	private function includes() {
		if ( ! is_admin() )
			$this->frontend_includes();
	}

	/**
	 * Admin includes
	 */
	private function admin_includes() {
		include_once( 'includes/admin/class-wpm-admin.php' );
	}

	/**
	 * Frontend includes
	 */
	private function frontend_includes() {
		include_once( 'includes/class-wpm-frontend-scripts.php' );
	}

	/**
	 * Init templating functions
	 */
	public function include_template_functions() {
		// Hooks
		include_once( 'includes/wpm-template-hooks.php' );
		include_once( 'includes/wpm-template-functions.php' );
	}

	/**
	 * Add admin option
	 */
	public function admin_price_matrix_option( $options ) {
		return array_merge( $options, array(
			'wc_booking_has_persons' => array(
				'id'            => '_price_matrix',
				'wrapper_class' => 'woocommerce-price-matrix',
				'label'         => __( 'Price Matrix', 'WooCommerce Price Matrix' ),
				'description'   => __( 'Enable this front-end option to replace dropdowns with a price matrix.', 'WooCommerce Price Matrix' ),
				'default'       => 'no'
			),
		) );
	}

	/**
	 * Define WPM Constants
	 */
	private function define_constants() {
		define( 'WPM_PLUGIN_FILE', __FILE__ );
		define( 'WPM_VERSION', $this->version );
		define( 'WPM_TEMPLATE_PATH', $this->template_path() );
	}

	/*
	 * Template path
	 */
	public function template_path() {
		return apply_filters( 'NC_TEMPLATE_PATH', 'woocommerce/wpm/' );
	}

	/*
	 * Get the plugin URL
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
}

/**
 * Returns the main instance of WPM
 */
function WPM() {
	return WPM::instance();
}

$GLOBALS['Woocommerce_Price_Matrix'] = WPM();