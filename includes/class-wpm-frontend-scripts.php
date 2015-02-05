<?php
/**
 * Handle frontend elements
 *
 * @class 		WPM_Frontend_Scripts
 * @author 		Shane Welland
 * @version		1.0
 * @category	Class
 */

class WPM_Frontend_Scripts {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Return array for frontend styles
	 */
	public static function get_styles() {
		return apply_filters( 'wpm_enqueue_styles', array(
			'woocommerce-price-matrix-frontend-styles' => array(
				'src'     => WPM()->plugin_url() . '/assets/css/frontend/wpm.css',
				'deps'    => '',
				'version' => '',
				'media'   => 'all',
			),
		) );
	}

	/**
	 * Conditionally enqueue scripts
	 */
	public function load_scripts() {
		global $post;

		if( ! $post )
			return;

		// Enqueue styles
		$styles = self::get_styles();

		// Register script for dependancies
		wp_register_script( 'wpm-frontend-js', WPM()->plugin_url() . '/assets/js/frontend/wpm.js', array( 'jquery' ), '', true );

		if ( is_product() && get_post_meta( $post->ID, '_price_matrix', true ) === 'yes' ) {
			wp_enqueue_script( 'wpm-frontend-js' );

			foreach ( $styles as $handle => $args ) {
				if( strpos( $handle, 'frontend-styles' ) !== false )
					wp_enqueue_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'] );
			}
		}
	}
}

return new WPM_Frontend_Scripts();