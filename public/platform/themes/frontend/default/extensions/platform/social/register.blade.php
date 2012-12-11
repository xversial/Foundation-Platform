@layout('templates.default')

<!-- Page Title -->
@section('title')
	Platform Social Registration
@endsection

<!-- Queue Styles -->

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('validate', 'js/validate.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
@endsection

<!-- Page Content -->
@section('content')

<section id="social_registration" class="container">
	<fieldset>
		<legend>Sign In</legend>

		<form id="login-form" class="form-horizontal" method="POST" accept-char="UTF-8" action="{{ URL::to('social/social/login') }}">
			<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">
			{{ Session::get('login_error') }}

			<!-- Email -->
			<div class="control-group">
				<label class="control-label" for="email">Email:</label>
				<div class="controls">
					<input type="text" id="email" name="email" value="{{ Input::old('email') }}" />
				</div>
			</div>

			<!-- Password -->
			<div class="control-group">
				<label class="control-label" for="password">Password:</label>
				<div class="controls">
					<input type="password" id="password" name="password" value="" />
				</div>
			</div>

			<!-- form actions -->
			<div class="form-actions">
				<button class="btn" type="submit">Login</button>
			</div>
		</form>
	</fieldset>

	<fieldset>
		<legend>Register</legend>

		<form id="login-form" class="form-horizontal" method="POST" accept-char="UTF-8" action="{{ URL::to('social/social/register') }}">
			<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

			<!-- Email -->
			@if ($errors->first('email'))
			<div class="control-group error">
			@else
			<div class="control-group">
			@endif
				<label class="control-label" for="email">Email:</label>
				<div class="controls">
					<input type="text" id="email" name="email" value="{{ Input::old('email') }}" />
					<span class="help-inline">{{ $errors->first('email') }}</span>
				</div>
			</div>

			<!-- Confirm Email -->
			@if ($errors->first('email_confirm'))
			<div class="control-group error">
			@else
			<div class="control-group">
			@endif
				<label class="control-label" for="email_confirm">Email Confirm:</label>
				<div class="controls">
					<input type="text" id="email_confirm" name="email_confirm" value="{{ Input::old('email_confirm') }}" />
					<span class="help-inline">{{ $errors->first('email_confirm') }}</span>
				</div>
			</div>

			<!-- form actions -->
			<div class="form-actions">
				<button class="btn" type="submit">Register</button>
			</div>

		</form>
	</fieldset>

</section>

@endsection
