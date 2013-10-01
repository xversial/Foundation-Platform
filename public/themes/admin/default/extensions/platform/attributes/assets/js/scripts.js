	$(document).ready(function()
	{
		var totalRows = $('table tbody tr').length;

		if (totalRows >= 3)
		{
			$('[data-options-empty').addClass('hide');
		}
	});

	$(document).on('click', '#addOption', function()
	{
		var totalRows = $('table tbody tr').length;

		if (totalRows === 2)
		{
			$('[data-options-empty').addClass('hide');
		}

		var $tr = $('[data-option-clone]').clone();

		$tr.removeClass('hide').removeAttr('data-option-clone');

		$tr.find('input').each(function()
		{
			$(this).val('').attr('name', $(this).attr('name').replace(/(\d+)/, totalRows + 1));
		});

		$('table tbody').append($tr);
	});

	$(document).on('click', '[data-remove-option]', function()
	{
		$(this).closest('tr').remove();

		var totalRows = $('table tbody tr').length;

		if (totalRows === 2)
		{
			$('[data-options-empty').removeClass('hide');
		}
	});

	// Sortable rows
	$('table').sortable({
		handle: '[data-move]',
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		nested: true,
		distance: 10,
		placeholder: '<tr><td class="placeholder" colspan="4">Drop here</td></tr>',
	});
