<?php
/**
 * Load WPM Admin Assets
 *
 * @author 		Shane Welland
 * @category 	Admin
 * @version     2.0
 */

class WPM_Admin_Assets {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_filter( 'product_type_options', array( $this, 'admin_toggle_option' ) );
	}

	/**
	 * Enqueue scripts
	 */
	public function admin_scripts() {
		global $wp_query, $post;

		$screen = get_current_screen();

		// Register scripts
		wp_register_script( 'wpm_admin_meta_boxes', WPM()->plugin_url() . '/assets/js/admin/meta-boxes.js', array( 'jquery' ), WPM_VERSION );

		// WooCommerce Price Matrix admin pages
		if ( in_array( $screen->id, array( 'edit-product', 'product' ) ) )
			wp_enqueue_script( 'wpm_admin_meta_boxes' );

		do_action( 'wpm_admin_scripts' );
	}

	/**
	 * Add admin option
	 */
	public function admin_toggle_option( $options ) {
		$options['price_matrix'] = array(
			'id'            => '_price_matrix',
			'wrapper_class' => 'show_if_variable',
			'label'         => __( 'Price Matrix', 'WooCommerce Price Matrix' ),
			'description'   => __( 'Replace front-end dropdowns with a price matrix. This option limits "Used for varations" to 2.', 'WooCommerce Price Matrix' ),
			'default'       => 'no',
		);

		return $options;
	}
}

return new WPM_Admin_Assets();