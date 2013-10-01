{{-- Queue assets --}}
{{ Asset::queue('collapse', 'js/bootstrap/collapse.js', 'jquery') }}

<div class="panel-group" id="accordion">

	@foreach ($permissions as $extension => $_permissions)
	<div class="panel panel-default">

		<div class="panel-heading">
			<h4 class="panel-title">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#{{{ $extension }}}">
					{{{ $extension }}}
				</a>
			</h4>
		</div>

		<div id="{{{ $extension }}}" class="panel-collapse collapse">

			<div class="panel-body">

				@foreach ($_permissions as $permission)
				<div class="form-group">

					<label class="col-lg-3 control-label">{{ $permission['label'] }}</label>

					<div class="col-lg-9">

						<label class="radio-inline" for="{{ $permission['permission'] }}_allow">
							<input type="radio" value="1" id="{{ $permission['permission'] }}_allow" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($userPermissions, $permission['permission']) == 1 ? ' checked="checked"' : null) }}>
							{{{ trans('platform/users::permissions.allow') }}}
						</label>

						<label class="radio-inline" for="{{ $permission['permission'] }}_deny">
							<input type="radio" value="-1" id="{{ $permission['permission'] }}_deny" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($userPermissions, $permission['permission']) == -1 ? ' checked="checked"' : null) }}>
							{{{ trans('platform/users::permissions.deny') }}}
						</label>

						@if ($permission['can_inherit'])
						<label class="radio-inline" for="{{ $permission['permission'] }}_inherit">
							<input type="radio" value="0" id="{{ $permission['permission'] }}_inherit" name="permissions[{{ $permission['permission'] }}]"{{ ( ! array_get($userPermissions, $permission['permission']) ? ' checked="checked"' : null) }}>
							{{{ trans('platform/users::permissions.inherit') }}}
						</label>
						@endif

					</div>

				</div>
				@endforeach

			</div>

		</div>

	</div>
	@endforeach

</div>
