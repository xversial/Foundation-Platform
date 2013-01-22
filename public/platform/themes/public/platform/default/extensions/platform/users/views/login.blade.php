@extends('templates/default')

@section('assets')

{{ Asset::queue('platform-validate', 'js/vendor/platform/validate.js', 'jquery') }}
{{ Asset::queue('login', 'platform/users::js/login.js', 'jquery') }}

@stop


@section('scripts')

<script>
	jQuery(document).ready(function($) {
		Validate.setup($("#login-form"));
	});
</script>

@stop

@section('content')

<form id="login-form" class="form-horizontal" method="POST" accept-char="UTF-8">
	<input type="hidden" name="csrf_token" value="{{ Session::getToken() }}">
	<input type="hidden" name="redirect" value="{{ Input::old('redirect', Session::get('login_redirect')) }}">

	<fieldset>
		<legend>{{ Lang::get('platform/users::auth/form.login.legend') }}</legend>
		<p class="summary">{{ Lang::get('platform/users::auth/form.login.summary') }}</p>

		<hr>

		<!-- Email Address -->
		<div class="control-group">
			<label class="control-label" for="email">{{ Lang::get('platform/users::auth/form.login.email') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="email" name="email" id="email" value="{{ Input::old('email') }}" placeholder="{{ Lang::get('platform/users::auth/form.login.email') }}" required>
					<span class="add-on"><i class="icon-envelope"></i></span>
				</div>
				<span class="help-block">{{ Lang::get('platform/users::auth/form.login.email_help') }}</span>
			</div>
		</div>

		<!-- Password -->
		<div class="control-group">
			<label class="control-label" for="password">{{ Lang::get('platform/users::auth/form.login.password') }}:</label>
			<div class="controls">
					<div class="input-append">
						<input type="password" name="password" id="password" placeholder="{{ Lang::get('platform/users::auth/form.login.password') }}" required>
						<span class="add-on"><i class="icon-key"></i></span>
					</div>
					<span class="help-block">{{ Lang::get('platform/users::auth/form.login.password_help') }}</span>
			</div>
		</div>

	</fieldset>

	<div class="form-actions">
		<a class="btn" href="{{ URL::secure('/reset_password') }}">{{ Lang::get('platform/users::auth/form.login.reset_password') }}</a>
		<button class="btn btn-primary" type="submit">{{ Lang::get('platform/users::auth/form.login.submit') }}</button>
	</div>
</form>

@stop
