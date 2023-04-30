<style>
header {
	width: 100%;
	overflow: hidden;
}

html {
	width: auto; /* autoによる既定値 */
	margin: 0;
}

p,a {
	margin: 0;
	padding: 0;
	font-family: initial;
}

    a,a:hover{
        text-decoration: none;
        color: black;
    }

/*nv1*/
    .subtitle{
        font-size: 2vw;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        line-height: 180%;
        padding: 1vh 1.5vw;
        background:#8DA0B6;
    }
/*header2*/
    
    .toggle_btn:hover{
        opacity: 0.5;
    }
    
</style>

<script>
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
</script>