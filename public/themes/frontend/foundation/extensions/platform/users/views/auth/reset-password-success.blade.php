@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{{ trans('platform/users::auth/form.reset-password.legend') }}} -
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-6 col-md-offset-3">

		<div class="panel panel-default">

			<div class="panel-heading">{{{ trans('platform/users::auth/form.reset-password.legend') }}}</div>

			<div class="panel-body">

				<p>Password reset sent successfully!</p>

				<p>We’ve sent an email to <strong>{{ $user->email }}</strong> containing a temporary link that will allow you to reset your password for the next 24 hours.</p>

				<p>Please check your spam folder if the email doesn’t appear within a few minutes.</p>

			</div>

		</div>

	</div>

</div>

@stop

