<!-- pull in login options via plugin? -->
<div class="tabbable">
	<ul class="nav nav-pills">
		<li class="active">
			<a href="#login-platform" data-toggle="tab">Platform</a>
		</li>
		@foreach ($providers as $provider)
		<li>
			<a href="#login-{{ $provider }}" data-toggle="tab">{{ $provider }}</a>

		</li>
		@endforeach
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="login-platform">
			<p class="social-messages" data-wait="{{ lang::line('platform/users::messages.auth.wait') }}" data-redirecting="{{ lang::line('platform/users::messages.auth.redirect') }}"></p>

			<form id="social-login-form" class="form-horizontal" method="POST" accept-char="UTF-8">
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
		</div>
		@foreach ($providers as $provider)
		<div class="tab-pane" id="login-{{ $provider }}">
			<a href="{{ URL::to('social/social/session/'.$provider) }}">
				<img src="{{ Theme::asset('platform/social::img/login/'.$provider.'.jpg') }}" />
			</a>
		</div>
		@endforeach
	</div>
</div>
