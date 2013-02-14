@extends('templates/default')

<!-- Site title -->
@section('title')
@parent
- Forgot Password
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
<form id="forgot-password-form" class="form-horizontal" method="POST" accept-char="UTF-8" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="csrf_token" value="{{ csrf_token() }}">

	<fieldset>
		<legend>{{ Lang::get('platform/users::auth/form.forgot-password.legend') }}</legend>

		<p class="summary">{{ Lang::get('platform/users::auth/form.forgot-password.summary') }}</p>

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
	</fieldset>

	<div class="form-actions">
		<a class="btn" href="{{ URL::to('/') }}">{{ Lang::get('button.cancel') }}</a>
		<button class="btn btn-primary" type="submit">{{ Lang::get('button.submit') }}</button>
	</div>
</form>
@stop
