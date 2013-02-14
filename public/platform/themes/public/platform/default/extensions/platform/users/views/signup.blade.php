@extends('templates/default')

<!-- Site title -->
@section('title')
@parent
- Sign up
@stop

<!-- Queue assets -->
{{ Asset::queue('platform-validate', 'js/vendor/platform/validate.js', 'jquery') }}

<!-- -->
@section('scripts')
<script>
	jQuery(document).ready(function($) {
		Validate.setup($('#signup-form'));
	});
</script>
@stop

<!-- Page content -->
@section('content')
<form id="signup-form" class="form-horizontal" method="POST" accept-char="UTF-8" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

	<fieldset>
		<legend>{{ Lang::get('platform/users::auth/form.signup.legend') }}</legend>

		<p class="summary">{{ Lang::get('platform/users::auth/form.signup.summary') }}</p>

		<hr>

		<!-- Email Address -->
		<div class="control-group{{ $errors->has('email') ? ' error' : '' }}">
			<label class="control-label" for="email">{{ Lang::get('platform/users::auth/form.email') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="email" name="email" id="email" value="{{ Input::old('email') }}" placeholder="{{ Lang::get('platform/users::auth/form.email_help') }}" required>
					<span class="add-on"><i class="icon-envelope"></i></span>
				</div>
				{{{ $errors->first('email', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>

		<!-- Email Address Confirmation -->
		<div class="control-group{{ $errors->has('email_confirmation') ? ' error' : '' }}">
			<label class="control-label" for="email_confirmation">{{ Lang::get('platform/users::auth/form.email_confirm') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="email" name="email_confirmation" id="email_confirmation" value="{{ Input::old('email_confirmation') }}" placeholder="{{ Lang::get('platform/users::auth/form.email_confirm_help') }}" required>
					<span class="add-on"><i class="icon-envelope"></i></span>
				</div>
				{{{ $errors->first('email_confirmation', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>

		<!-- Password -->
		<div class="control-group{{ $errors->has('password') ? ' error' : '' }}">
			<label class="control-label" for="password">{{ Lang::get('platform/users::auth/form.password') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="password" name="password" id="password" placeholder="{{ Lang::get('platform/users::auth/form.password_help') }}" required>
					<span class="add-on"><i class="icon-key"></i></span>
				</div>
				{{{ $errors->first('password', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>

		<!-- Password Confirmation -->
		<div class="control-group{{ $errors->has('password_confirmation') ? ' error' : '' }}">
			<label class="control-label" for="password_confirmation">{{ Lang::get('platform/users::auth/form.password_confirm') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="password" name="password_confirmation" id="password_confirmation" placeholder="{{ Lang::get('platform/users::auth/form.password_confirm_help') }}" required>
					<span class="add-on"><i class="icon-key"></i></span>
				</div>
				{{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}}
			</div>
		</div>
	</fieldset>

	<div class="form-actions">
		<a class="btn" href="{{ URL::to('/') }}">{{ Lang::get('button.cancel') }}</a>
		<button class="btn btn-primary" type="submit">{{ Lang::get('platform/users::auth/form.signup.submit') }}</button>
	</div>
</form>
@stop
