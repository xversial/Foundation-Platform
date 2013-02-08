{{ Theme::queue_asset('bootstrap-dropdown', 'js/bootstrap/dropdown.js', 'jquery') }}

<ul class="{{ $class }}">
@foreach ($items as $item)
	@render('platform/menus::widgets.nav.item', array('item' => $item, 'active_path' => $active_path, 'before_uri' => $before_uri))
@endforeach
</ul>
