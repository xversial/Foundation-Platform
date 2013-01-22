// preview
(function($) {

	$('body').append('<div class="page-preview"><span class="close-preview">Close</span><br /><iframe></iframe></div>');

	var preview = $('.page-preview')
			.hide()
			.css({
				'position': 'absolute',
				'top': 0,
				'left': 0,
			});

	var previewFrame = preview.find('iframe');

	var close = preview.find('.close-preview')
			.css({
				'display': 'block',
				'background-color': '#000',
				'color': '#efefef',
				'text-align': 'center',
				'position': 'absolute',
				'font-weight': 'bold',
				'height': '50px',
				'line-height': '50px',
				'cursor': 'pointer'
			})
			.on('click', function(e) {
				preview.hide();
			});

	$('#preview').on('click', function() {
		previewFrame
				.attr('src', platform.url.admin('pages/preview?'+$('form').serialize()))
				.css({
					'position': 'absolute',
					'top': close.height()+'px',
					'height': $(document).height()-close.height()+'px',
					'width': $(document).width()+'px'
				});
			close.css({
				'width': $(document).width()+'px'
			});

			preview.show();
			window.scrollTo(0,0);
	});

})(jQuery);

// shown editor
(function($) {

	var types = $('select#type');
	var editor = $('#editor-container');
	var files  = $('#file-container').hide();

	// load proper view
	swap();

	// check page type to see if editor or file list should be shown
	types.on('change', swap);

	function swap() {
		console.log('hi');
		if (types.val() == 'db')
		{
			files.hide();
			editor.show();
		}
		else
		{
			editor.hide();
			files.show();
		}
	}

})(jQuery);