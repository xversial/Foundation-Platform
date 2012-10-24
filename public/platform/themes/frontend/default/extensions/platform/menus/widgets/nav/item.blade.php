<li class="{{ in_array($item['id'], $active_path) ? 'active' : null }}">

	@if ($item['type'] == Platform\Menus\Menu::TYPE_STATIC)
		@if (URL::valid($item['uri']))
			<a href="{{ $item['uri'] }}"}} target="{{ ($item['target'] == 0) ? '_self' : '_blank' }}" title="{{ $item['name'] }}">
		@else
			<a href="{{ URL::to(($before_uri ? $before_uri.'/' : null).$item['uri'], $item['secure']) }}" target="{{ ($item['target'] == 0) ? '_self' : '_blank' }}" title="{{ $item['name'] }}">
		@endif
	@elseif ($item['type'] == Platform\Menus\Menu::TYPE_PAGE)
		<a href="{{ URL::to($item['page_uri']) }}" target="{{ ($item['target'] == 0) ? '_self' : '_blank' }}" title="{{ $item['name'] }}">
	@endif

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
				@render('platform.menus::widgets.nav.item', array('item' => $child, 'active_path' => $active_path, 'before_uri' => $before_uri))
			@endforeach
		</ul>
	@endif
</li>
