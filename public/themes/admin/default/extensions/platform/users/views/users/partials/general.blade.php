{{-- Email --}}
<div class="form-group{{ $errors->first('email', ' has-error') }}">
	<label for="email" class="col-lg-3 control-label">{{{ trans('platform/users::users/form.email') }}}</label>
	<div class="col-lg-9">
		<input type="text" class="form-control" name="email" id="email" placeholder="{{{ trans('platform/users::users/form.email') }}}" value="{{{ Input::old('email', ! empty($user) ? $user->email : null) }}}">

		<span class="help-block">
			{{{ $errors->first('email', ':message') ?: trans('platform/users::users/form.email_help') }}}
		</span>
	</div>
</div>

{{-- Groups --}}
<div class="form-group{{ $errors->first('groups', ' has-error') }}">
	<label for="groups" class="col-lg-3 control-label">{{{ trans('platform/users::users/form.groups') }}}</label>
	<div class="col-lg-9">
		<select class="form-control" name="groups[]" id="groups[]" multiple="multiple">
			@foreach ($groups as $group)
			<option value="{{ $group->id }}"{{ array_key_exists($group->id, $userGroups) ? ' selected="selected"' : null }}>{{ $group->name }}</option>
			@endforeach
		</select>

		<span class="help-block">
			{{{ $errors->first('groups', ':message') ?: trans('platform/users::users/form.groups_help') }}}
		</span>
	</div>
</div>

{{-- Activation status --}}
<div class="form-group{{ $errors->first('activated', ' has-error') }}">
	<label for="activated" class="col-lg-3 control-label">{{{ trans('platform/users::users/form.activated') }}}</label>
	<div class="col-lg-9">
		<select class="form-control" name="activated" id="activated" required>
			<option value="1"{{ Input::old('activated', ! empty($user) ? (int) $user->isActivated() : 0) === 1 ? ' selected="selected"' : null }}>{{ trans('general.yes') }}</option>
			<option value="0"{{ Input::old('activated', ! empty($user) ? (int) $user->isActivated() : 0) === 0 ? ' selected="selected"' : null }}>{{ trans('general.no') }}</option>
		</select>

		<span class="help-block">
			{{{ $errors->first('activated', ':message') ?: trans('platform/users::users/form.activated_help') }}}
		</span>
	</div>
</div>

{{-- Password --}}
<div class="form-group{{ $errors->first('password', ' has-error') }}">
	<label for="password" class="col-lg-3 control-label">{{{ trans("platform/users::users/form.{$pageSegment}.password") }}}</label>
	<div class="col-lg-9">
		<input type="password" class="form-control" name="password" id="password" placeholder="{{{ trans("platform/users::users/form.{$pageSegment}.password") }}}">

		<span class="help-block">
			{{{ $errors->first('password', ':message') ?: trans("platform/users::users/form.{$pageSegment}.password_help") }}}
		</span>
	</div>
</div>

{{-- Confirm Password --}}
<div class="form-group{{ $errors->first('password_confirm', ' has-error') }}">
	<label for="password_confirm" class="col-lg-3 control-label">{{{ trans("platform/users::users/form.{$pageSegment}.password_confirm") }}}</label>
	<div class="col-lg-9">
		<input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="{{{ trans("platform/users::users/form.{$pageSegment}.password_confirm") }}}">

		<span class="help-block">
			{{{ $errors->first('password_confirm', ':message') ?: trans("platform/users::users/form.{$pageSegment}.password_confirm_help") }}}
		</span>
	</div>
</div>

