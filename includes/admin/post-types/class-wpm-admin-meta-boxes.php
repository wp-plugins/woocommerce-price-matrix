<?php
/**
 * WPM Meta Boxes
 *
 * Sets up panels in the product post type
 *
 * @author 		Shane Welland
 * @category 	Admin
 * @version     1.0
 */

class WPM_Admin_Meta_Boxes {
	private $post_id;

	/**
	 * Constructor
	 */
	public function __construct() {
		// Save price matrix option used in product data metabox
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
	}

	/**
	 * Save WPM meta box data
	 */
	public function save( $post_id, $post ) {
		global $post;

		$is_price_matrix = isset( $_POST['_price_matrix'] ) ? 'yes' : 'no';

		update_post_meta( $post_id, '_price_matrix', $is_price_matrix );
	}
}

new WPM_Admin_Meta_Boxes();