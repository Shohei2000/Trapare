(function($) {
	var $body   = $('body');
	var $btn   = $('.toggle_btn');
	var $mask  = $('#mask');
	var open   = 'open'; // class
	// menu open close
	$btn.on( 'click', function() {
		if ( ! $body.hasClass( open ) ) {
			$body.addClass( open );
		} else {
			$body.removeClass( open );
		}
	});
	// mask close
	$mask.on('click', function() {
		$body.removeClass( open );
	});
} )(jQuery);