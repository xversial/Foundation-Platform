@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{{ trans('platform/users::auth/form.register.legend') }}} -
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-6 col-md-offset-3">

		<div class="panel panel-default">

			<div class="panel-heading">{{{ trans('platform/users::auth/form.register.legend') }}}</div>

			<div class="panel-body">

				<p>Your account has been created.</p>

				<p>However, this website requires account activation by the administrator group.</p>

				<p>An e-mail has been sent to them and you will be informed when your account has been activated.</p>

			</div>

		</div>

	</div>

</div>

@stop
