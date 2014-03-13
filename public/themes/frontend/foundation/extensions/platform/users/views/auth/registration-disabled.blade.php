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

				{{{ trans('platform/users::auth/form.register.disabled') }}}

			</div>

		</div>

	</div>

</div>

@stop
