// A URL helper for Platform
// Just incase the files get loaded out of order
if (platform == undefined)
{
	var platform = { };
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

// Function taken from http://dense13.com/blog/2009/05/03/converting-string-to-slug-javascript/
// Some extra special characters added.
(function($) {
	$.fn.slugify = function(separator) {

		if (typeof separator === 'undefined') {
			separator = '-';
		}

		// Get value attribute
		var str = this;
		if (typeof this !== 'string') {
			var str = this.val();
		}

		str = str.replace(/^\s+|\s+$/g, ''); // trim
		str = str.toLowerCase();

		// remove accents, swap ñ for n, etc
		var from = "ĺěščřžýťňďàáäâèéëêìíïîòóöôùůúüûñç·/_,:;";
		var to   = "lescrzytndaaaaeeeeiiiioooouuuuunc------";
		for (var i=0, l=from.length ; i<l ; i++) {
			str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
		}

		return str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
					          .replace(/\s+/g, separator) // collapse whitespace and replace by _
					          .replace(/-+/g, separator) // collapse dashes
					          .replace(new RegExp(separator+'+$'), '') // Trim separator from start
					          .replace(new RegExp('^'+separator+'+'), ''); // Trim separator from end
	}
})(jQuery);

// Confirmation Modal
// Shows a confirmation modal on click
(function($) {

	$('table').on('click', '#modal-confirm', function(e) {
		e.preventDefault();

		$('#platform-modal-confirm .confirm').attr('href', $(this).attr('href'));
		$('#platform-modal-confirm').modal({show:true});

		return false;
	});

})(jQuery);
