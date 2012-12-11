if (typeof RedactorPlugins === 'undefined') var RedactorPlugins = {};

RedactorPlugins.preview = {

	init: function() {
		var self = this;

		//insert iframe
		$('body').append('<div class="page-preview"><span class="close-preview">Close</span><br /><iframe></iframe></div>');

		var preview = $('.page-preview');
		var close = preview.find('.close-preview');

		close.css({
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

		preview.hide().css({
			'position': 'absolute',
			'top': 0,
			'left': 0,
		});

		this.addBtn('preview', 'Preview', function() {
			preview.find('iframe')
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
	},

};