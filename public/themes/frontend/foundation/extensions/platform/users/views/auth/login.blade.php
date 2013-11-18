@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{{ trans('platform/users::auth/form.login.legend') }}} -
@parent
@stop

{{-- Queue Assets --}}
{{ Asset::queue('platform-validate', 'js/platform/validate.js', 'jquery') }}

{{-- Inline Scripts --}}
@section('scripts')
@parent
<script>
	H5F.setup(document.getElementById('login-form'));
</script>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="{{ count($connections) > 0 ? 'col-md-6' :  'col-md-6 col-md-offset-3' }}">

		<form id="login-form" class="form-horizontal" role="form" method="post" accept-char="UTF-8">

			{{-- CSRF Token --}}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			{{-- Redirect url --}}
			<input type="hidden" name="redirect" value="{{ Input::old('redirect', Session::get('redirect')) }}">

			<div class="panel panel-default">

				<div class="panel-heading">{{{ trans('platform/users::auth/form.login.legend') }}}</div>

				<div class="panel-body">

					{{-- Email Address --}}
					<div class="form-group{{ $errors->first('email', ' has-error') }}">
						<label class="col-lg-4 control-label" for="email">{{ trans('platform/users::auth/form.email') }}</label>

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
							<input class="form-control" type="password" name="password" id="password" placeholder="{{{ trans('platform/users::auth/form.password') }}}" required>

							<span class="help-block">
								{{{ $errors->first('password', ':message') ?: trans('platform/users::auth/form.password_help') }}}
							</span>
						</div>
					</div>

					{{-- Remember me --}}
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-9">
							<label for="remember" class="checkbox">
								<input type="checkbox" name="remember" id="remember" value="1"{{ Input::old('remember') ? ' checked="checked"' : null }} />
								{{{ trans('platform/users::auth/form.login.remember-me') }}}
							</label>
						</div>
					</div>

					{{-- Form actions --}}
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-9">
							<button class="btn btn-default" type="submit">{{{ trans('platform/users::auth/form.login.submit') }}}</button>

							<a class="btn" href="{{ URL::route('reset-password') }}">{{{ trans('platform/users::auth/form.login.reset-password') }}}</a>
						</div>
					</div>

				</div>

			</div>

		</form>

	</div>

	@if (count($connections) > 0)
	<div class="col-md-6">

		<div class="panel panel-default">

			<div class="panel-heading">Social Logins</div>

			<div class="panel-body">

			@foreach ($connections as $slug => $connection)

			<div class="col-sm-6 col-md-3">
				<a href="{{ URL::to("oauth/authorize/{$slug}") }}" class="btn btn-default thumbnail">
				{{ $connection['driver'] }}
				</a>
			</div>

			@endforeach

			</div>

		</div>

	</div>
	@endif

</div>

@stop
