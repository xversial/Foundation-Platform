@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{{ trans('platform/users::auth/form.register.legend') }}} -
@parent
@stop

{{-- Queue Assets --}}
{{ Asset::queue('platform-validate', 'js/platform/validate.js', 'jquery') }}

{{-- Inline Scripts --}}
@section('scripts')
@parent
<script>
	H5F.setup($('#register-form'));
</script>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-6 col-md-offset-3">

		<form id="register-form" class="form-horizontal" role="form" method="post" accept-char="UTF-8" autocomplete="off">

			{{-- CSRF Token --}}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="panel panel-default">

				<div class="panel-heading">{{{ trans('platform/users::auth/form.register.legend') }}}</div>

				<div class="panel-body">

					{{-- Email Address --}}
					<div class="form-group{{ $errors->first('email', ' has-error') }}">
						<label class="col-lg-4 control-label" for="email">{{{ trans('platform/users::auth/form.email') }}}</label>

						<div class="col-lg-8">
							<input class="form-control" type="email" name="email" id="email" value="{{{ Input::old('email') }}}" placeholder="{{{ trans('platform/users::auth/form.email') }}}" required>

							<span class="help-block">
								{{{ $errors->first('email', ':message') ?: trans('platform/users::auth/form.email_help') }}}
							</span>
						</div>
					</div>

					{{-- Password --}}
					<div class="form-group{{ $errors->first('password', ' has-error') }}">
						<label class="col-lg-4 control-label" for="password">{{{ trans('platform/users::auth/form.password') }}}</label>

						<div class="col-lg-8">
							<input class="form-control" type="password" name="password" id="password" value="{{{ Input::old('password') }}}" placeholder="{{{ trans('platform/users::auth/form.password') }}}" required>

							<span class="help-block">
								{{{ $errors->first('password', ':message') ?: trans('platform/users::auth/form.password_help') }}}
							</span>
						</div>
					</div>

					{{-- Confirm Password --}}
					<div class="form-group{{ $errors->first('password_confirm', ' has-error') }}">
						<label class="col-lg-4 control-label" for="password_confirm">{{{ trans('platform/users::auth/form.password_confirm') }}}</label>

						<div class="col-lg-8">
							<input class="form-control" type="password" name="password_confirm" id="password_confirm" value="{{{ Input::old('password_confirm') }}}" placeholder="{{{ trans('platform/users::auth/form.password_confirm') }}}" required>

							<span class="help-block">
								{{{ $errors->first('password_confirm', ':message') ?: trans('platform/users::auth/form.password_confirm_help') }}}
							</span>
						</div>
					</div>

					{{-- Form actions --}}
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-9">
							<button class="btn btn-default" type="submit">{{{ trans('platform/users::auth/form.register.submit') }}}</button>

							<a class="btn" href="{{ URL::to('/') }}">{{{ trans('button.cancel') }}}</a>
						</div>
					</div>

				</div>

			</div>

		</form>

	</div>

</div>

@stop
