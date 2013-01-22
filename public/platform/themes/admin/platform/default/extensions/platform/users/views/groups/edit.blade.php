@extends('templates/default')

@section('title')
{{ Lang::get('platform/users::groups/general.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')
<div class="page-header">
	<h3>
		{{ Lang::get('platform/users::groups/form.edit.legend') }}

		<small>{{ Lang::get('platform/users::groups/form.edit.summary') }}</small>

		<div class="pull-right">
			<a href="{{ URL::to(ADMIN_URI . '/users/groups') }}" class="btn btn-inverse btn-small">{{ Lang::get('button.back') }}</a>
		</div>
	</h3>
</div>

<form class="form-horizontal" action="{{ Request::fullUrl() }}" method="POST" accept-char="UTF-8">
	<!-- CSRF Token -->
	<input type="hidden" name="csrf_token" value="{{ Session::getToken() }}">

	<!-- Name -->
	<div class="control-group">
		<label class="control-label" for="name">{{ Lang::get('platform/users::groups/form.name') }}:</label>
		<div class="controls">
			<div class="input-append">
				<input type="text" name="name" id="name" value="{{ Input::old('name', $group->name); }}" placeholder="{{ Lang::get('platform/users::users/form.first_name') }}">
				<span class="add-on"><i class="icon-user"></i></span>
			</div>
			<span class="help-block">{{ Lang::get('platform/users::groups/form.name_help') }}</span>
		</div>
	</div>


	<div class="form-actions">
		<a class="btn btn-small" href="{{ URL::to(ADMIN_URI.'/users') }}">{{ Lang::get('button.cancel') }}</a>
		<button class="btn btn-small btn-primary" type="submit">{{ Lang::get('button.update') }}</button>
	</div>
</form>
@stop
