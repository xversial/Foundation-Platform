// A URL helper for Platform
// Just incase the files get loaded out of order
if (platform == undefined)
{
	var platform = {};
}

// start helpers
(function($) {
	// define Helpers object
	platform.url = {

		urls : {
			base: null,
			admin: null,
		},

		init: function() {
			this.urls.base  = $('meta[name=base_url]').attr('content');
			this.urls.admin = $('meta[name=admin_url]').attr('content');
		},

		base: function(path) {
			if (path === undefined) {
				path = ''
			}

			return this.urls.base + path;
		},

		admin: function(path) {
			if (path === undefined) {
				path = ''
			}

			return this.urls.admin + path;
		}

	};

	platform.url.init();

})(jQuery);


// Tiny plugin to serialise an object
(function($) {
	$.fn.serializeObject = function() {

		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (o[this.name] !== undefined) {
				if ( ! o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};
})(jQuery);

// Confirmation Modal
// Shows a confirmation modal on click
(function($) {

	$('table').on('click', '[data-toggle="modal"]', function(e) {
		e.preventDefault();

		$('#platform-modal-confirm .confirm').attr('href', $(this).attr('href'));
		$('#platform-modal-confirm').modal({show:true, remote:false});

		return false;
	});

})(jQuery);
