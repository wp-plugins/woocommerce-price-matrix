jQuery( function( a ) {
	var toggle = a( 'input[name="_price_matrix"]' ),
		attributes = get_attributes(),
		active_attributes = get_active_attributes(),
		save_button = a( 'button.save_attributes' ),
		is_price_matrix = a('input[name="_price_matrix"]:checked').size();

	wpm_show_and_hide_panels();

	a( attributes ).not( ':checked' ).attr( 'disabled' , true );

	toggle.change( function( e ) {
		wpm_show_and_hide_panels();

		if( is_checked( a( this ) ) === false )
			return;

		process_checkboxes();
		trigger_save();
	});

	function wpm_show_and_hide_panels() {
		is_price_matrix = a('input[name="_price_matrix"]:checked').size(),
		show_classes = '.show_if_price_matrix';

		a( show_classes ).hide();

		if( is_price_matrix ) {
			a( '.show_if_price_matrix' ).show();
		}
	}

	attributes.on( 'click', process_checkboxes );

	function process_checkboxes() {
		if( is_checked( toggle ) == true ) {
			var disabled = get_active_attributes().length >= 2;
			a( attributes ).not( ':checked' ).attr( 'disabled' , disabled );
		}
	}

	function is_checked( e ) {
		return ( e.attr( 'checked' ) == 'checked' ) ? true : false;
	}

	// Get all checkboxes
	function get_attributes() {
		return a( '.enable_variation :checkbox' );
	}

	// Get checked attributes
	function get_active_attributes() {
		return a( '.enable_variation :checkbox:checked' );
	}

	function trigger_save() {
		save_button.trigger( 'click' );
	}
});