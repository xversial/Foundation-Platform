<!-- Page -->
<div class="control-group">
	<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-page-id">{{ Lang::line('menus::form.child.type.page') }}</label>
	<div class="controls">
		<select name="children[{{ array_get($child, 'id', '[%id%]') }}][page_id]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-page-id" class="child-page-id" {{ ( ! array_key_exists('page-id', $child)) ? '[%control.page_id%]' : null }} {{ (array_key_exists('user_editable', $child) and ( ! array_get($child, 'user_editable'))) ? 'disabled' : 'required' }}>
			@foreach ($pages as $page)
				<option value="{{ $page['id'] }}" {{ (array_get($child, 'page_id') == $page['id']) ? 'selected' : null }}>{{ $page['name'] }}</option>
			@endforeach
		</select>
	</div>
</div>