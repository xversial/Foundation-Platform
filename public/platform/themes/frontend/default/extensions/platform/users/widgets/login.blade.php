<form id="login-form" class="form-horizontal" method="POST" accept-char="UTF-8">
<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">
<input type="hidden" name="redirect" value="{{ Input::old('redirect', Session::get('login_redirect')) }}">
	<fieldset>
		<legend>{{ Lang::line('platform/users::form.auth.login.legend') }}</legend>
		<p class="summary">{{ Lang::line('platform/users::form.auth.login.summary') }}</p>
		<hr>

		<!-- Email Address -->
		<div class="control-group">
			<label class="control-label" for="email">{{ Lang::line('platform/users::form.auth.login.email') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="email" name="email" id="email" value="{{ Input::old('email') }}" placeholder="{{ Lang::line('platform/users::form.auth.login.email') }}" required>
					<span class="add-on"><i class="icon-envelope"></i></span>
				</div>
				<span class="help-block">{{ Lang::line('platform/users::form.auth.login.email_help') }}</span>
			</div>
		</div>

		<!-- Password -->
		<div class="control-group">
			<label class="control-label" for="password">{{ Lang::line('platform/users::form.auth.login.password') }}:</label>
			<div class="controls">
					<div class="input-append">
						<input type="password" name="password" id="password" placeholder="{{ Lang::line('platform/users::form.auth.login.password') }}" required>
						<span class="add-on"><i class="icon-key"></i></span>
					</div>
					<span class="help-block">{{ Lang::line('platform/users::form.auth.login.password_help') }}</span>
			</div>
		</div>

	</fieldset>

	<div class="form-actions">
		<a class="btn" href="{{ URL::to_secure('/reset_password') }}">{{ Lang::line('platform/users::form.auth.login.reset_password') }}</a>
		<button class="btn btn-primary" type="submit">{{ Lang::line('platform/users::form.auth.login.submit') }}</button>
	</div>
</form>
