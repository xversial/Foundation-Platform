(function($) {
	'use strict';

	$.widget('platform.fileupload', $.blueimp.fileupload, {

		options: {

			// The add callback is invoked as soon as files are added to the fileupload
			// widget (via file input selection, drag & drop or add API call).
			// See the basic file upload widget for more information:
			add: function (e, data) {
				var that = $(this).data('fileupload'),
					options = that.options,
					files = data.files;

				$(this).fileupload('process', data).done(function () {
					that._adjustMaxNumberOfFiles(-files.length);
					data.isAdjusted = true;
					data.files.valid = data.isValidated = that._validate(files);
					data.context = that._renderUpload(files).data('data', data);
					options.filesContainer[
						options.prependFiles ? 'prepend' : 'append'
					](data.context);
					that._forceReflow(data.context);
					that._transition(data.context).done(
						function () {
							if ((that._trigger('added', e, data) !== false) &&
									(options.autoUpload || data.autoUpload) &&
									data.autoUpload !== false && data.isValidated) {
								data.submit();
							}
						}
					);
				});
			},

			// // Tempo variables
			// tempoVarBraces : '\\[\\%\\%\\]',
			// tempoTagBraces : '\\[\\?\\?\\]',

			// uploadTemplate: function(options, data) {

			// 	// Grab our Tempo instance
			// 	var tempo = options.uploadTemplateTempo,

			// 	// And the upload dom
			// 	$uploadDom = $(options.uploadTemplateId);

			// 	// Render!
			// 	tempo.render(data);

			// 	// Result to return
			// 	var result = $uploadDom.find('tr');

			// 	// Reset Tempo
			// 	tempo.clear();

			// 	return result;
			// },

			// downloadTemplate: function(options, data) {

			// 	// Grab our Tempo instance
			// 	var tempo = options.downloadTemplateTempo,

			// 	// And the download dom
			// 	$downloadDom = $(options.downloadTemplateId);

			// 	// Render!
			// 	tempo.render(data);

			// 	// Result to return
			// 	var result = $downloadDom.find('tr');

			// 	// Reset Tempo
			// 	tempo.clear();

			// 	return result;
			// },

		}// ,

		// _initTemplates: function() {

		// 	if ((typeof Tempo === 'undefined') || ( ! Tempo)) {
		// 		$.error('TempoJS is required for cartalyst media file uploads.');
		// 	}

		// 	var $uploadDom = $(this.options.uploadTemplateId);
		// 	$uploadDom.css({
		// 		'display' : 'none'
		// 	});
		// 	this.options.uploadTemplateTempo = Tempo.prepare($uploadDom.attr('id'), {
		// 		'var_braces' : this.options.tempoVarBraces,
		// 		'tag_braces' : this.options.tempoTagBraces
		// 	});

		// 	var $downloadDom = $(this.options.downloadTemplateId);
		// 	$downloadDom.css({
		// 		'display' : 'none'
		// 	});
		// 	this.options.downloadTemplateTempo = Tempo.prepare($downloadDom.attr('id'), {
		// 		'var_braces' : this.options.tempoVarBraces,
		// 		'tag_braces' : this.options.tempoTagBraces
		// 	});
		// },

		// _renderTemplate: function(func, files) {
		// 	var that = this;

		// 	if ( ! func) {
  //               return $();
  //           }

  //           if ( ! Tempo) {
		// 		$.error('TempoJS is required for cartalyst media file uploads.');
		// 	}

  //           // Data to render
  //           var data = [];

  //           // Loop through passed data and format
		// 	// for Tempo
		// 	$.each(files, function(index, file) {
		// 		var _file = {};

		// 		$.extend(true, _file, file);

		// 		// Add some more data for Tempo
		// 		_file.sizeHuman = that._formatFileSize(_file.size);

		// 		// Attach options for Tempo
		// 		_file.options   = that.options;

		// 		data.push(_file);
		// 	});

		// 	// Get result
		// 	var result = func(that.options, data);

		// 	// If we have a string abck
		// 	if (typeof result === 'string') {
		// 		// result = $().append(result);
		// 		result = $(result);
		// 	}

		// 	return result;
		// }

	});

})(jQuery);