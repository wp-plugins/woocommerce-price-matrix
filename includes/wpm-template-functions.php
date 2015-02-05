<?php
/**
 * WooCommerce Price Matrix template functions
 *
 * Functions for templating (hooked functions)
 *
 * @author 		Shane Welland
 * @category 	Core
 * @package 	WooCommerce Price Matrix
 * @version     1.0
 */

/**
 * Front-end price matrix
 */
function wpm_variation_grid( $price_markup = false, $taken = array() ) {
	global $product, $post;

	if ( $product->product_type != 'variable' )
		return false;

	// Arrays
	$attribute_array = array();
	$children = array();	
	$accepted_keys = array(
		'_regular_price',
		'_sale_price',
		);
	$active_attribute_one = array(
		'name'		=>	false,
		'values'	=>	array(),
		);
	$active_attribute_two = array(
		'name'		=>	false,
		'values'	=>	array(),
		);

	$price_matrix = get_post_meta( $product->id, '_price_matrix', true );

	if( $price_matrix !== 'yes' )
		return;
	
	$attributes = get_post_meta( $product->id, '_product_attributes', true );

	if( empty( $product->children ) || empty( $attributes ) )
		return;

	// Set allowed keys
	foreach( $attributes as $k => $v ) {
		$accepted_keys[] = 'attribute_' . strtolower( $k );

		if( $v['is_variation'] !== 1 )
			continue;
		
		if( ! $active_attribute_one['name'] ) {
			$active_attribute_one['name'] = 'attribute_' . strtolower( $k );
			$active_attribute_one['label'] = get_post_meta( $post->ID, '_wpm_attribute_one_label', true ) ? get_post_meta( $post->ID, '_wpm_attribute_one_label', true ) : ucwords( $k );
		} else {
			$active_attribute_two['name'] = 'attribute_' . strtolower( $k );
			$active_attribute_two['label'] = get_post_meta( $post->ID, '_wpm_attribute_two_label', true ) ? get_post_meta( $post->ID, '_wpm_attribute_two_label', true ) : ucwords( $k );
		}
	}

	if( $active_attribute_one['name'] == false || $active_attribute_two['name'] == false ) {
		?>
		
		<style>
		form.variations_form table.variations {
			display: block !important;
		}
		</style>

		<?php
		return;
	}

	// Store child product data
	foreach( $product->children as $child_id ) {
		$child_data = get_post_meta( $child_id );
		
		if( ! empty( $child_data ) )
			$children[$child_id] = maybe_unserialize( $child_data );
	}

	if( empty( $children ) )
		return;

	// Clean array up
	foreach( $children as $key => $value ) {
		unset( $children[$key] );

		if( is_array( $value ) ) {

			foreach( $value as $meta_key => $meta_value ) {

				if( in_array( strtolower( $meta_key ), $accepted_keys ) ) {
					
					if( strpos( $meta_key, 'attribute_' ) === 0 ) {
						
						if( $meta_key == $active_attribute_one['name'] ) {

							if( ! in_array( $meta_value[0], $active_attribute_one['values'] ) )
								$active_attribute_one['values'][] = $meta_value[0];
					
						} elseif( $meta_key == $active_attribute_two['name'] ) {
							
							if( ! in_array( $meta_value[0], $active_attribute_two['values'] ) )
								$active_attribute_two['values'][] = $meta_value[0];
						}
					}
					
					$children[$key][$meta_key] = $meta_value;
				}
			}
		}
	}

	$table_heading = get_post_meta( $post->ID, '_wpm_table_heading', true ) ? apply_filters( 'wpm_table_heading_' . $post->ID, __( get_post_meta( $post->ID, '_wpm_table_heading', true ), 'WooCommerce Price Matrix' ) ) : false;

	if( $table_heading )
		echo apply_filters( 'wpm_table_heading_start_tag', '<h3>' ) . $table_heading . apply_filters( 'wpm_table_heading_end_tag', '</h3>' );

	echo sprintf( '<table id="woocommerce-price-matrix" class="shop_table price-matrix-%s">',  $post->ID );

	// Find active row/column count
	$col_count = intval( count( $active_attribute_two['values'] ) ) + 1;
	$row_count = intval( count( $active_attribute_one['values'] ) ) + 1;

	for( $i = 0; $i <= $row_count; $i++ ) {
		echo '<colgroup></colgroup>';
	}

	echo sprintf( '<th class="placeholder hidden"></th><th class="wpm-label label-2" colspan="%s"><span>%s</span></th></tr>', $col_count, apply_filters( 'wpm_table_attribute_two_label', $active_attribute_two['label'] ) );

	for( $r = 0; $r < $row_count; $r++ ) {

		echo '<tr>';
		
			for( $c = 0; $c < $col_count; $c++ ) {

				if( $r == 0 && $c == 0 ) {
					echo sprintf( '<th class="wpm-label label-1" rowspan="%s"><span>%s</span></th>', $row_count, apply_filters( 'wpm_table_attribute_one_label', $active_attribute_one['label'] ) );
					echo '<th class="placeholder"></th>';

					continue;
				}

				if( $r == 0 ) {

					echo sprintf( '<th>%s</th>', $active_attribute_two['values'][$c-1] );

				} else {

					if( $c == 0 ) {

						echo sprintf( '<th>%s</th>', $active_attribute_one['values'][$r-1] );

					} else {

						echo '<td>';
				
						foreach( $children as $child ) {

							$att1 = $active_attribute_one['values'][$r-1];
							$att2 = $active_attribute_two['values'][$c-1];
							
							$child1 = isset( $child[$active_attribute_one['name']][0] ) ?  $child[$active_attribute_one['name']][0] : false;
							$child2 = isset( $child[$active_attribute_two['name']][0] ) ?  $child[$active_attribute_two['name']][0] : false;

							if( $att1 == $child1 && $att2 == $child2 ) {

								if( in_array( array( $child1, $child2 ), $taken ) )
									continue;

								// Avoid duplicate variations
								$taken[] = array(
									$child1,
									$child2,
								);

								// Create price markup
								$regular_price = $child['_regular_price'][0] > 0 ? wc_price( $child['_regular_price'][0] ) : false ;
								$sale_price = $child['_sale_price'][0] > 0 ? wc_price( $child['_sale_price'][0] ) : false ;

								if( ! $sale_price ) {
									
									$price_markup = sprintf( '<p class="price">%s</p>', $regular_price );
									
								} else {
						
									$price_markup = sprintf( '<p class="price"><del>%s</del><ins>%s</ins></p>', $regular_price, $sale_price );
						
								}

								echo sprintf( '<div class="has_price price-selector" data-attribute-1-name="%s" data-attribute-1-value="%s" data-attribute-2-name="%s" data-attribute-2-value="%s">%s</div>', str_replace( 'attribute_', '', $active_attribute_one['name'] ), $active_attribute_one['values'][$r-1], str_replace( 'attribute_', '', $active_attribute_two['name'] ), $active_attribute_two['values'][$c-1], $price_markup );
							}
						
						}

						echo '</td>';
					
					}
				}
			}

		echo '</tr>';
	}

	echo '</table>';

}