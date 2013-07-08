// Just in case the files get loaded out of order
if (typeof platform === 'undefined')
{
	var platform = {};
}

// Start helpers
(function($) {

	// Define Helpers object
	platform.url = {

		urls : {
			base: null,
		},

		init: function() {

			this.urls.base = $('meta[name=base_url]').attr('content');

		},

		base: function(path) {

			if (typeof path === 'undefined')
			{
				path = '';
			}

			return this.urls.base + '/' + path;

		}

	};

	platform.url.init();

})(jQuery);


$(function(){

	// Alert Close
	$('.alert').on('click', '.close', function(e) {

		$(e.delegateTarget).slideToggle(function() {

			$(this).remove();

		});

	});

});
