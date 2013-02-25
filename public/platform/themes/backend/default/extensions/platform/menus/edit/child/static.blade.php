<!-- URI -->
<div class="control-group">
	<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-uri">{{ Lang::line('platform/menus::form.child.uri') }}</label>
	<div class="controls">
		<input type="text" name="children[{{ array_get($child, 'id', '[%id%]') }}][uri]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-uri" class="child-uri" value="{{ array_get($child, 'uri', '[%control.uri%]') }}" {{ (array_key_exists('uri', $child) and ( ! array_get($child, 'user_editable'))) ? 'disabled' : 'required' }}>
	</div>
</div>
