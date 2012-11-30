<li class="{{ in_array($item['id'], $active_path) ? 'active' : null }}">
	<a href="{{ $item['uri'] }}" target="{{ $item['target'] }}" title="{{ $item['name'] }}">
		@if ($item['class'])
			<i class="{{ $item['class'] }}"></i>
		@endif
		<span>
			{{ $item['name'] }}
		</span>
	</a>

	@if ($item['children'])
		<ul>
			@foreach ($item['children'] as $child)
				@render('platform/menus::widgets.nav.item', array('item' => $child, 'active_path' => $active_path, 'before_uri' => $before_uri))
			@endforeach
		</ul>
	@endif
</li>
