(function( $ ) {
'use strict';

$(function() {

 	if ( taw_wheel_filter === null ) {
 		return;
 	}


	$('.js-wheel-type').on('change', function(){
		var chk = this.checked; 
		$('.js-wheel-type').prop('checked', false); 
		if ( chk )
			$(this).prop('checked', true); 

		return false;
	})

	$('.js-spokes').on('change', function(){
		var chk = this.checked; 
		$('.js-spokes').prop('checked', false); 
		if ( chk )
			$(this).prop('checked', true); 
		return false;
	})

	$('.js-spokes-style').on('change', function(){
		var chk = this.checked; 
		$('.js-spokes-style').prop('checked', false); 
		if ( chk )
			$(this).prop('checked', true); 
		return false;
	})

	$('.js-wheel-brand').on('change', function(){
		var all_chk = $('#tw-wheel-brand-all').prop('checked');
		
		if ( this.id == 'tw-wheel-brand-all' )
		{
			var chk = this.checked; 
			$('.js-wheel-brand').prop('checked', false); 
			if ( chk )
				$(this).prop('checked', true); 
			return;
		}
		else
		{
			var chk = this.checked; 
			$('#tw-wheel-brand-all').prop('checked', false);
			if ( chk )
				$(this).prop('checked', true); 
		}
		return false;
	})

	$('.js-twf-wheel-filter-reset').on('click', function(){
		$('.taw-filter .js-wheel-type').prop('checked', false); 
		$('.taw-filter .js-wheel-type-all').prop('checked', true); 

		$('.taw-filter .js-spokes').prop('checked', false); 
		$('.taw-filter .js-spokes-all').prop('checked', true); 

		$('.taw-filter .js-spokes-style').prop('checked', false); 
		$('.taw-filter .js-spokes-style-all').prop('checked', true); 

		$('.taw-filter .js-wheel-brand').prop('checked', false); 
		$('.taw-filter .js-wheel-brand-all').prop('checked', true); 

		$('.taw-filter select').val('');

		return false;
	});
});

})( jQuery );
