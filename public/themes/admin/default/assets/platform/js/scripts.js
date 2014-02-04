$(function() {

	$('ul li.active').each(function() {

		$(this).parent().parent().addClass('active');

	});

	// Activate tooltips
	$('.tip, .tooltip, [data-tooltip], [data-toggle="tooltip"]').tooltip();

	// Activate popovers
	$('.popover, [data-popover], [data-toggle="popover"]').popover({
		trigger : 'hover'
	});

	// Activate modal windows
	$(document).on('click', '[data-modal], [data-toggle="modal"]', function(event) {

		event.preventDefault();

		// Get the modal target
		var target = $(this).data('target');

		// Is this modal target a confirmation?
		if (target === 'modal-confirm')
		{
			$('#modal-confirm .confirm').attr('href', $(this).attr('href'));

			$('#modal-confirm').modal({show:true, remote:false});

			return false;
		}

	});

});
