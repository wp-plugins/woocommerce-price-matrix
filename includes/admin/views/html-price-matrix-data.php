<div class="options_group show_if_price_matrix hide_if_simple hide_if_grouped hide_if_external hide_if_affiliate hide_if_booking">

	<?php
	$table_heading = get_post_meta( $post_id, '_wpm_table_heading', true );
	$attribute_one_label = get_post_meta( $post_id, '_wpm_attribute_one_label', true );
	$attribute_two_label = get_post_meta( $post_id, '_wpm_attribute_two_label', true );
	?>

	<p class="form-field _wpm_table_heading_field">
		<label for="_wpm_table_heading"><?php _e( 'Table Heading', 'WooCommerce Price Matrix' ); ?></label>
		<input type="text" class="short" name="_wpm_table_heading" id="_wpm_table_heading" value="<?php echo $table_heading; ?>" placeholder="None">
		<img class="help_tip" data-tip='<?php _e( 'Title the front-end pricing table. Leave blank for no title.', 'WooCommerce Price Matrix' ) ?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
	</p>

	<p class="form-field _wpm_attribute_one_label_field">
		<label for="_wpm_attribute_one_label"><?php _e( 'Attribute 1 Label', 'WooCommerce Price Matrix' ); ?></label>
		<input type="text" class="short" name="_wpm_attribute_one_label" id="_wpm_attribute_one_label" value="<?php echo $attribute_one_label; ?>" placeholder="">
		<img class="help_tip" data-tip='<?php _e( 'The second attribute appears on the vertical axis of your front-end price table. Leave Blank for attribute name.', 'WooCommerce Price Matrix' ) ?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
	</p>

	<p class="form-field _wpm_attribute_two_label_field">
		<label for="_wpm_attribute_two_label"><?php _e( 'Attribute 2 Label', 'WooCommerce Price Matrix' ); ?></label>
		<input type="text" class="short" name="_wpm_attribute_two_label" id="_wpm_attribute_two_label" value="<?php echo $attribute_two_label; ?>" placeholder="">
		<img class="help_tip" data-tip='<?php _e( 'The second attribute appears on the horizontal axis of your front-end price table. Leave Blank for attribute name.', 'WooCommerce Price Matrix' ) ?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" />
	</p>

</div>