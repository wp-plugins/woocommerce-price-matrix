jQuery( function( a ) {
	a( 'table#woocommerce-price-matrix .price-selector' ).on( 'click', function() {

		var att1 = a( this ).data( 'attribute-1-name' ),
			att2 = a( this ).data( 'attribute-2-name' ),
			val1 = a( this ).data( 'attribute-1-value' ),
			val2 = a( this ).data( 'attribute-2-value' );

		if( a( 'select#' + att1 ).length && a( 'select#' + att2 ).length ) {
			a( 'select#' + att1 ).find( 'option[value="' + val1 + '"]' ).prop( 'selected', true );
			a( 'select#' + att2 ).find( 'option[value="' + val2 + '"]' ).prop( 'selected', true );

			a( 'select#' + att1 ).trigger( 'change' );
			a( 'select#' + att2 ).trigger( 'change' );
		}

		a( 'table#woocommerce-price-matrix td' ).removeClass( 'active' );
		a( this ).parent().addClass( 'active' );
		return false;
	});

	a( 'table#woocommerce-price-matrix' ).delegate( 'td', 'mouseover mouseleave', function( e ) {
		if( e.type == 'mouseover') {
			a( this ).parent().addClass( 'hover' );
			a( 'colgroup' ).eq( a( this ).index() + 1 ).addClass( 'hover' );
		} else {
			a( this ).parent().removeClass( 'hover' );
			a( 'colgroup' ).eq (a( this ).index() + 1 ).removeClass( 'hover' );
		}
	});
});