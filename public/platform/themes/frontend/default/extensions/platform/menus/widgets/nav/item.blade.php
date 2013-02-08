@if ($item['children'])
<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		@if ($item['class'])
			<i class="{{ $item['class'] }}"></i>
		@endif
		<span>
			{{ $item['name'] }}
		</span> <b class="caret"></b>
	</a>

	<ul class="dropdown-menu">
		@foreach ($item['children'] as $child)
			@render('platform/menus::widgets.nav.item', array('item' => $child, 'active_path' => $active_path, 'before_uri' => $before_uri))
		@endforeach
	</ul>


@else
<li class="{{ in_array($item['id'], $active_path) ? 'active' : null }}">

	<a href="{{ $item['uri'] }}" target="{{ $item['target'] }}" title="{{ $item['name'] }}">
		@if ($item['class'])
			<i class="{{ $item['class'] }}"></i>
		@endif
		<span>
			{{ $item['name'] }}
		</span>
	</a>
@endif

</li>
