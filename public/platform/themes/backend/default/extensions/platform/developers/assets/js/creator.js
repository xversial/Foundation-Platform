$(document).ready(function() {

	// Prefill code settings based on extension settings
	$('#form-name').on('blur', function() {
		$('#form-extension').val($(this).slugify('_')).trigger('blur');
	});

	$('#form-author').on('blur', function() {
		$('#form-vendor').val($(this).slugify('_')).trigger('blur');
	});

	// When somebody blurs on the form extension
	$('#form-vendor, #form-extension').bind('blur', function() {
		if ($(this).val()) {
			$('#created-slug-vendor').text($('#form-vendor').val());
			$('#created-slug-extension').text($('#form-extension').val());
			$('#created-slug').removeClass('hide');
		} else {
			$('#created-slug').addClass('hide');
		}
	});
});