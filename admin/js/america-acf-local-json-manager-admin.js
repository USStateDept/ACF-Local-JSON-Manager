(function( $ ) {
	'use strict';

	function toggle_button_select( $select, $button ) {
		if ($select.val() !== 'default') {
			$select.removeClass('required');
			$button.removeClass('disabled');
			return;
		}

		$select.addClass('required');
		$button.addClass('disabled');
	}

	$(document).ready(function() {
		var $select = $('#acf_save_location[required]');
		var $publish = $('.post-type-acf-field-group #publish');

		toggle_button_select($select, $publish);

		$select.on('change', function() {
			var $this = $(this);
			toggle_button_select($this, $publish);
		});
	});
})( jQuery );
