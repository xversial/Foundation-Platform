$(function() {

	// Activate tooltips
	$('.tip, .tooltip, [data-toogle=tooltip]').tooltip();

	// Activate modals
	$(document).on('click', '[data-toggle="modal"]', function(event) {
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

	// Activate tabs
	$('[data-toogle="tab"] a').click(function(event) {
		event.preventDefault();

		$(this).tab('show');
	});

});
