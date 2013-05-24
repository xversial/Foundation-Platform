// Just in case the files get loaded out of order
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
		},

		init: function() {
			this.urls.base  = $('meta[name=base_url]').attr('content');
		},

		base: function(path) {
			if (path === undefined) {
				path = ''
			}

			return this.urls.base + '/' + path;
		}

	};

	platform.url.init();

})(jQuery);


$(function(){

	//Alert Close
	$(".alert").on('click', '.close', function(e){

		$(e.delegateTarget).slideToggle(function(){
			$(this).remove();
		});

	});

	//Hide Alert after Time
	var timer;

	if($('.alert').is(':visible')){

		timer = setTimeout(function(){

			$('.alert').slideToggle();

		}, 10000);

	}

});
