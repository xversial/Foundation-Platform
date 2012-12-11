(function($) {
	var buttons = ['html',
	'|', 'formatting',
	'|', 'bold', 'italic', 'deleted',
	'|', 'unorderedlist', 'orderedlist', 'outdent', 'indent',
	'|', 'video', 'file', 'table', 'link',
	'|', 'fontcolor', 'backcolor',
	'|', 'alignment',
	'|', 'horizontalrule'];

	$('textarea#value').redactor({
		convertDivs: false,
		wym: true,
		buttons: buttons,
		plugins: ['content', 'media', 'fullscreen', 'preview'],
	});
})(jQuery);
