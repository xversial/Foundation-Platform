@extends('layouts/default')

{{-- Page title --}}
@section('title', trans("platform/users::users/general.{$pageSegment}.title"))

{{-- Queue assets --}}
{{ Asset::queue('validate', 'js/platform/validate.js', 'jquery') }}
{{ Asset::queue('tabs', 'js/bootstrap/tab.js', 'jquery') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
<script type="text/javascript">
	H5F.setup(document.getElementById('users-form'));
</script>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-12">

		{{-- Page header --}}
		<div class="page-header">

			<h1>{{{ trans("platform/users::users/general.{$pageSegment}.title") }}} <small>{{{ ! empty($user) ? ($user->name ?: $user->email) : null }}}</small></h1>

			<span>{{{ trans("platform/users::users/general.{$pageSegment}.description") }}}</span>

		</div>

		{{-- Users form --}}
		<form id="users-form" class="form-horizontal" action="{{ Request::fullUrl() }}" method="post" accept-char="UTF-9" autocomplete="off">

			{{-- CSRF Token --}}
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			{{-- Tabs --}}
			<ul class="nav nav-tabs" data-toogle="tab">
				<li class="active"><a href="#general">{{{ trans('platform/users::general.tabs.general') }}}</a></li>
				<li><a href="#permissions">{{{ trans('platform/users::general.tabs.permissions') }}}</a></li>
				<li><a href="#attributes">{{{ trans('platform/users::general.tabs.attributes') }}}</a></li>
			</ul>

			{{-- Tabs content --}}
			<div class="tab-content tab-bordered">

				{{-- General tab --}}
				<div class="tab-pane active" id="general">

					@include('platform/users::users/partials/general')

				</div>

				{{-- Permissions tab --}}
				<div class="tab-pane" id="permissions">

					@include('platform/users::users/partials/permissions')

				</div>
				{{-- Attributes tab --}}
				<div class="tab-pane" id="attributes">

					@include('platform/users::users/partials/attributes')

				</div>

			</div>

			{{-- Form actions --}}
			<div class="form-group">

				<div class="col-lg-12">
					<button class="btn btn-success" type="submit">{{{ trans('button.save') }}}</button>

					<a class="btn btn-default" href="{{{ URL::toAdmin('users') }}}">{{{ trans('button.cancel') }}}</a>

					@if ( ! empty($user) and $user->id != Sentry::getId())
					<div class="pull-right">
						<a class="btn btn-danger" data-toggle="modal" data-target="modal-confirm" href="{{ URL::toAdmin("users/delete/{$user->id}") }}">{{{ trans('button.delete') }}}</a>

						<a class="btn btn-info tip" data-placement="bottom" title="{{{ trans('platform/users::users/button.send_welcome_email') }}}" href="{{ URL::toAdmin("users/welcome-email/{$user->id}") }}"><i class="icon-envelope"></i></a>

						@if ( ! $user->isActivated())
							<a class="btn btn-info tip" data-placement="bottom" title="{{{ trans('platform/users::users/button.send_activation_email') }}}" href="{{ URL::toAdmin("users/activation-email/{$user->id}") }}"><i class="icon-envelope"></i></a>
						@endif

						@if ( ! $user->isSuperUser() or $user->isSuperUser() and Sentry::getUser()->isSuperUser())

							@if ($userThrottle->isSuspended())
								<a class="btn btn-warning tip" data-placement="bottom" title="{{{ trans('platform/users::users/button.unsuspend') }}}" href="{{ URL::toAdmin("users/unsuspend/{$user->id}") }}"><i class="icon-lock"></i></a>
							@else
								<a class="btn btn-danger tip" data-placement="bottom" title="{{{ trans('platform/users::users/button.suspend') }}}" href="{{ URL::toAdmin("users/suspend/{$user->id}") }}"><i class="icon-lock"></i></a>
							@endif

							@if ($userThrottle->isBanned())
								<a class="btn btn-warning tip" data-placement="bottom" title="{{{ trans('platform/users::users/button.unban') }}}" href="{{ URL::toAdmin("users/unban/{$user->id}") }}"><i class="icon-ban-circle"></i></a>
							@else
								<a class="btn btn-danger tip" data-placement="bottom" title="{{{ trans('platform/users::users/button.ban') }}}" href="{{ URL::toAdmin("users/ban/{$user->id}") }}"><i class="icon-ban-circle"></i></a>
							@endif

						@endif

					</div>
					@endif
				</div>

			</div>

		</form>

	</div>

</div>

@stop
