(function($) {
	platform.table.init($('#media-table'), {
		'url': platform.url.admin('media'),
	});
})(jQuery);


$(document).ready(function() {

	var $modal = $('#media-upload-modal');

	$('#media-upload-link').on('click', function(e) {
		e.preventDefault();

		$modal.modal('show');
	});

	// When the modal is closed, update the table
	$modal.on('hide', function() {
		platform.table.fetch();
	});
});