<li class="divider"></li>
<li class="{{ $child->isActive ? 'active' : null }} {{ $child->hasSubItems ? 'has-dropdown' : null }}">

	<a target="{{ $child->target }}" href="{{ $child->uri }}"@if ($child->children) id="drop-{{ $child->slug }}" @endif>
		<i class="{{ $child->class }}"></i>
		{{ $child->name }}
		@if ($child->children and ! $child->hasSubItems)
		<b class="caret"></b>
		@endif
	</a>

	@if ($child->children)
		<ul class="dropdown">
			@each('platform/menus::widgets/nav/child', $child->children, '')
		</ul>
	@endif

</li>
