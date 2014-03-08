$(function()
{
	// Activate tooltips
	$('.tip, .tooltip, [data-tooltip], [data-toggle="tooltip"]').tooltip();

	// Activate popovers
	$('.popover, [data-popover], [data-toggle="popover"]').popover({
		trigger : 'hover'
	});

	// Activate modal windows
	$(document).on('click', '[data-modal], [data-toggle="modal"]', function(e)
	{
		e.preventDefault();

		// Get the modal target
		var target = $(this).data('target');

		// Is this modal target a confirmation?
		if (target === 'modal-confirm')
		{
			$('#modal-confirm .confirm').attr('href', $(this).attr('href'));

			$('#modal-confirm').modal({
				show: true,
				remote: false
			});

			return false;
		}
	});
});
