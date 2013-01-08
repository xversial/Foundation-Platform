<li>
	<a href="{{ URL::to($child->uri) }}">{{ $child->name }}</a>

	@if ($child->children)
		@each('platform/menus::widgets/nav/child', $child->children, 'child')
	@endif
</li>