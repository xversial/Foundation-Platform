(function($) {

	// redactor buttons
	var buttons = ['html',
	'|', 'formatting',
	'|', 'bold', 'italic', 'deleted',
	'|', 'unorderedlist', 'orderedlist', 'outdent', 'indent',
	'|', 'video', 'file', 'table', 'link',
	'|', 'fontcolor', 'backcolor',
	'|', 'alignment',
	'|', 'horizontalrule'];

	// instantiate redactor
	$('textarea#value').redactor({
		convertDivs: false,
		wym: true,
		buttons: buttons,
		plugins: ['content', 'media', 'fullscreen', 'preview'],
	});

})(jQuery);
