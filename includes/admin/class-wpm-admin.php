<?php
/**
 * WooCommerce Price Matrix admin assets
 *
 * @class 		WPM_Admin 
 * @author 		Shane Welland
 * @category 	Admin
 * @version     1.0
 */
class WPM_Admin {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'includes' ) );
		add_action( 'admin_init', array( $this, 'include_meta_box_handlers' ) );

		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'price_matrix_data' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_data' ) );
		add_action( 'manage_product_posts_custom_column', array( $this, 'wpm_render_product_columns' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include( 'class-wpm-admin-assets.php' );
	}

	/**
	 * Include meta box handlers
	 */
	public function include_meta_box_handlers() {
		include( 'post-types/class-wpm-admin-meta-boxes.php' );
	}

	/**
	 * Price matrix data
	 */
	public function price_matrix_data() {
		global $post;
		$post_id = $post->ID;
		include( 'views/html-price-matrix-data.php' );
	}

	/**
	 * Save data
	 */
	public function save_product_data( $post_id ) {
		$meta_to_save = array(
			'_wpm_table_heading',
			'_wpm_attribute_one_label',
			'_wpm_attribute_two_label',
			);

		foreach( $meta_to_save as $meta_key ) {
			$value = ! empty( $_POST[ $meta_key ] ) ? sanitize_text_field( $_POST[ $meta_key ] ) : '';
			update_post_meta( $post_id, $meta_key, $value );
		}
	}

	/**
	 * Product column icon
	 */
	public function wpm_render_product_columns( $column ) {
		global $post;

		if( $column == 'product_type' ) {
			if( get_post_meta( $post->ID, '_price_matrix', true ) == 'yes' ) {
				printf( '<span class="product-type tips variable matrix" data-tip="%s" style="display: none;"></span>', __( 'Price Matrix', 'WooCommerce Price Matrix' ) );
				echo '<script>jQuery( function( a ) { a( ".product-type.matrix" ).removeAttr( "style" ).siblings( ".product-type.variable" ).remove(); });</script>';
			}
		}
	}
}

return new WPM_Admin();