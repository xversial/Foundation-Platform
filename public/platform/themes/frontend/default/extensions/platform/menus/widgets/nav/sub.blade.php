<li class="{{ in_array($item['id'], $active_path) ? 'active' : null }} @if($item['children'])dropdown-submenu@endif">
	<a data-target="#" href="{{ $item['uri'] }}"@if($item['children']) target="{{ $item['target'] }}" class="dropdown-toggle" data-toggle="dropdown"@endif>
		@if ($item['class'])
		<i class="{{ $item['class'] }}"></i>
		@endif

		{{ $item['name'] }}
	</a>

	@if ($item['children'])
		<ul class="dropdown-menu">
			@foreach ($item['children'] as $child)
				@render('platform/menus::widgets.nav.sub', array('item' => $child, 'active_path' => $active_path, 'before_uri' => $before_uri))
			@endforeach
		</ul>
	@endif
</li>
