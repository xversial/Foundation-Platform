@extends('templates/default')

<!-- Site title -->
@section('title')
@parent
- Sign in
@stop

<!-- Queue assets -->
{{ Asset::queue('platform-validate', 'js/vendor/platform/validate.js', 'jquery') }}

<!-- -->
@section('scripts')
<script>
	jQuery(document).ready(function($) {
		Validate.setup($('#forgot-password-form'));
	});
</script>
@stop

<!-- Page content -->
@section('content')
<form id="forgot-password-form" class="form-horizontal" method="POST" accept-char="UTF-8">
	<input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

	<input type="hidden" name="redirect" value="{{ Input::old('redirect', Session::get('forgot-password_redirect')) }}">

	<fieldset>
		<legend>{{ Lang::get('platform/users::auth/form.forgot-password-confirm.legend') }}</legend>

		<p class="">{{ Lang::get('platform/users::auth/form.forgot-password-confirm.summary') }}</p>

		<hr>

		<!-- Password -->
		<div class="control-group{{ $errors->has('password') ? ' error' : '' }}">
			<label class="control-label" for="password">{{ Lang::get('platform/users::auth/form.forgot-password.password') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="password" name="password" id="password" placeholder="{{ Lang::get('platform/users::auth/form.forgot-password.password_help') }}" requiredx>
					<span class="add-on"><i class="icon-key"></i></span>
				</div>
				{{{ $errors->first('password', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>

		<!-- Password Confirmation -->
		<div class="control-group{{ $errors->has('password_confirmation') ? ' error' : '' }}">
			<label class="control-label" for="password_confirmation">{{ Lang::get('platform/users::auth/form.forgot-password.password_confirm') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ Lang::get('platform/users::auth/form.forgot-password.password_confirm_help') }}" requiredx>
					<span class="add-on"><i class="icon-key"></i></span>
				</div>
				{{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>
	</fieldset>

	<div class="form-actions">
		<a class="btn" href="{{ URL::to('/') }}">{{ Lang::get('button.cancel') }}</a>
		<button class="btn btn-primary" type="submit">{{ Lang::get('platform/users::auth/form.forgot-password.submit') }}</button>
	</div>
</form>
@stop
