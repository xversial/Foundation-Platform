<li {{ (isset($template) and $template) ? 'data-template' : null }} data-item="item_{{ array_get($child, 'id', '[%id%]') }}">
	<div class="child">

		<header class="child-header">
			<span class="child-sort">
				<i class="icon-move"></i>
			</span>
			{{ array_get($child, 'name', '[%control.name%]') }}

			<span class="child-toggle-details">
				<i class="icon-edit"></i>
			</span>
		</header>

		<section class="child-details form-horizontal">
			<fieldset>
				<legend>{{ Lang::line('platform/menus::form.update.child.legend') }}</legend>

				@if (array_get($child, 'id'))
					<input type="hidden" name="children[{{ array_get($child, 'id', '[%id%]') }}][id]">
				@else
					<input type="hidden" name="children[[%id%]][is_new]" value="1">
				@endif

				<!-- Name -->
				<div class="control-group">
					<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-name">{{ Lang::line('platform/menus::form.child.name') }}</label>
					<div class="controls">
						<input type="text" name="children[{{ array_get($child, 'id', '[%id%]') }}][name]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-name" class="child-name" value="{{ array_get($child, 'name', '[%control.name%]') }}" required>
					</div>
				</div>

				<!-- Slug -->
				<div class="control-group">
					<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-slug">{{ Lang::line('platform/menus::form.child.slug') }}</label>
					<div class="controls">
						<input type="text" name="children[{{ array_get($child, 'id', '[%id%]') }}][slug]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-slug" class="child-slug" value="{{ array_get($child, 'slug', '[%control.slug%]') }}" {{ (array_key_exists('user_editable', $child) and ( ! array_get($child, 'user_editable'))) ? 'disabled' : 'required' }}>
					</div>
				</div>

				@if (array_get($child, 'id'))
					<div class="hide">
						<input type="hidden" name="children[{{ array_get($child, 'id') }}][type]" value="{{ array_get($child, 'type', Platform\Menus\Menu::TYPE_STATIC) }}">
					</div>

					@if (array_get($child, 'type', Platform\Menus\Menu::TYPE_STATIC) == Platform\Menus\Menu::TYPE_STATIC)
						@render('platform/menus::edit.child.static', array('child' => $child))
					@elseif (array_get($child, 'type', Platform\Menus\Menu::TYPE_STATIC) == Platform\Menus\Menu::TYPE_PAGE)
						@render('platform/menus::edit.child.page', array('child' => $child, 'pages' => $pages))
					@endif
				@else
					<div class="hide">
						<input type="hidden" name="children[[%id%]][type]" value="[% raw.type %]">
					</div>

					[? if raw.type == '{{ Platform\Menus\Menu::TYPE_STATIC }}' ?]
						@render('platform/menus::edit.child.static', array('child' => $child))
					[? endif ?]
					[? if raw.type == '{{ Platform\Menus\Menu::TYPE_PAGE }}' ?]
						@render('platform/menus::edit.child.page', array('child' => $child, 'pages' => $pages))
					[? endif ?]
				@endif

				<!-- Secure -->
				<div class="control-group">
					<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-secure">{{ Lang::line('platform/menus::form.child.secure') }}</label>
					<div class="controls">
						<label class="checkbox">
							<input type="checkbox" name="children[{{ array_get($child, 'id', '[%id%]') }}][secure]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-secure" class="child-secure" value="1" {{ (array_key_exists('secure', $child)) ? ((array_get($child, 'secure')) ? 'checked' : null) : '[%control.secure%]' }}>
							{{ Lang::line('platform/menus::form.child.secure') }}
						</label>
					</div>
				</div>

				<!-- Visibility -->
				<div class="control-group">
					<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-visibility">{{ Lang::line('platform/menus::form.child.visibility.title') }}</label>
					<div class="controls">
						<select name="children[{{ array_get($child, 'id', '[%id%]') }}][visibility]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-visibility" class="child-visibility" {{ ( ! array_key_exists('visibility', $child)) ? '[%control.visibility%]' : null }} required>
							<option value="{{ Platform\Menus\Menu::VISIBILITY_ALWAYS }}" {{ (array_get($child, 'visibility') == Platform\Menus\Menu::VISIBILITY_ALWAYS) ? 'selected' : null }}>{{ Lang::line('platform/menus::form.child.visibility.always') }}</option>
							<option value="{{ Platform\Menus\Menu::VISIBILITY_LOGGED_IN }}" {{ (array_get($child, 'visibility') == Platform\Menus\Menu::VISIBILITY_LOGGED_IN) ? 'selected' : null }}>{{ Lang::line('platform/menus::form.child.visibility.logged_in') }}</option>
							<option value="{{ Platform\Menus\Menu::VISIBILITY_LOGGED_OUT }}" {{ (array_get($child, 'visibility') == Platform\Menus\Menu::VISIBILITY_LOGGED_OUT) ? 'selected' : null }}>{{ Lang::line('platform/menus::form.child.visibility.logged_out') }}</option>
							<option value="{{ Platform\Menus\Menu::VISIBILITY_ADMIN }}" {{ (array_get($child, 'visibility') == Platform\Menus\Menu::VISIBILITY_ADMIN) ? 'selected' : null }}>{{ Lang::line('platform/menus::form.child.visibility.admin') }}</option>
						</select>
					</div>
				</div>

				@if (count($groups) > 0)

					<!-- Groups -->
					<div class="control-group">
						<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-group-visibility">{{ Lang::line('platform/menus::form.child.groups.title') }}</label>
						<div class="controls">
							<select name="children[{{ array_get($child, 'id', '[%id%]') }}][group_visibility][]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-group-visibility" class="child-group-visibility" multiple="multiple" {{ ( ! array_key_exists('group_visibility', $child)) ? '[%control.group_visibility%]' : null }}>
								@foreach ($groups as $group)
									<option value="{{ $group['id'] }}" {{ ( in_array($group['id'], array_get($child, 'group_visibility', array())) ) ? 'selected' : null }}>{{ $group['name'] }}</option>
								@endforeach
							</select>
						</div>
					</div>

				@endif

				<!-- Target -->
				<div class="control-group">
					<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-target">{{ Lang::line('platform/menus::form.child.target.title') }}</label>
					<div class="controls">
						<select name="children[{{ array_get($child, 'id', '[%id%]') }}][target]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-target" class="child-target" {{ ( ! array_key_exists('target', $child)) ? '[%control.target%]' : null }}>
							<option value="{{ Platform\Menus\Menu::TARGET_SELF }}" {{ (array_get($child, 'target') == Platform\Menus\Menu::TARGET_SELF) ? 'selected' : null }}>{{ Lang::line('platform/menus::form.child.target.self') }}</option>
							<option value="{{ Platform\Menus\Menu::TARGET_BLANK }}" {{ (array_get($child, 'target') == Platform\Menus\Menu::TARGET_BLANK) ? 'selected' : null }}>{{ Lang::line('platform/menus::form.child.target.blank') }}</option>
							<option value="{{ Platform\Menus\Menu::TARGET_PARENT }}" {{ (array_get($child, 'target') == Platform\Menus\Menu::TARGET_PARENT) ? 'selected' : null }}>{{ Lang::line('platform/menus::form.child.target.parent') }}</option>
							<option value="{{ Platform\Menus\Menu::TARGET_TOP }}" {{ (array_get($child, 'target') == Platform\Menus\Menu::TARGET_TOP) ? 'selected' : null }}>{{ Lang::line('platform/menus::form.child.target.top') }}</option>
						</select>
					</div>
				</div>

				<!-- CSS Class -->
				<div class="control-group">
					<label class="control-label" for="menu-children-{{ array_get($child, 'id', '[%id%]') }}-class">{{ Lang::line('platform/menus::form.child.class') }}</label>
					<div class="controls">
						<input type="text" name="children[{{ array_get($child, 'id', '[%id%]') }}][class]" id="menu-children-{{ array_get($child, 'id', '[%id%]') }}-class" class="child-class" value="{{ array_get($child, 'class', '[%control.class%]') }}">
					</div>
				</div>

				<div class="form-actions">
					<a href="#" class="pull-right btn btn-mini child-remove btn-{{ (array_key_exists('user_editable', $child) and ( ! array_get($child, 'user_editable'))) ? 'inverse disabled' : 'danger' }}">
						{{ Lang::line('platform/menus::button.remove_child'.((array_key_exists('user_editable', $child) and ( ! array_get($child, 'user_editable'))) ? '_disabled' : null)) }}
					</a>
				</div>

			</fieldset>
		</section>

	</div>
	<!-- /end - child -->

	@if (isset($child['children']) and is_array($child['children']) and count($child['children']) > 0)
		<ol>
			@foreach ($child['children'] as $grand_child)
				@render('platform/menus::edit.child', array('child' => $grand_child, 'pages' => $pages, 'groups' => $groups))
			@endforeach
		</ol>
	@endif

</li>
