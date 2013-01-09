<li class="{{ $child->in_active_path ? 'active' : null }}">
	<a href="{{ URL::to($child->uri) }}">{{ $child->name }}</a>

	@if ($child->children)
		@each('platform/menus::widgets/nav/child', $child->children, 'child')
	@endif
</li>