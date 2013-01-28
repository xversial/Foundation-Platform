@extends('templates/default')

@section('title')
{{ Lang::get('platform/users::users/general.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')
<div class="page-header">
	<h3>
		{{ Lang::get('platform/users::users/form.create.legend') }}

		<small>{{ Lang::get('platform/users::users/form.create.summary') }}</small>

		<div class="pull-right">
			<a href="{{ URL::to(ADMIN_URI . '/users') }}" class="btn btn-inverse btn-small">{{ Lang::get('button.back') }}</a>
		</div>
	</h3>
</div>

<form class="form-horizontal" action="{{ Request::fullUrl() }}" method="POST" accept-char="UTF-8">
	<!-- CSRF Token -->
	<input type="hidden" name="csrf_token" value="{{ Session::getToken() }}">

	<!-- First Name -->
	<div class="control-group">
		<label class="control-label" for="first_name">{{ Lang::get('platform/users::users/form.first_name') }}:</label>
		<div class="controls">
			<div class="input-append">
				<input type="text" name="first_name" id="first_name" value="{{ Input::old('first_name'); }}" placeholder="{{ Lang::get('platform/users::users/form.first_name') }}">
				<span class="add-on"><i class="icon-user"></i></span>
			</div>
			<span class="help-block">{{ Lang::get('platform/users::users/form.first_name_help') }}</span>
		</div>
	</div>

	<!-- Last Name -->
	<div class="control-group">
		<label class="control-label" for="last_name">{{ Lang::get('platform/users::users/form.last_name') }}:</label>
		<div class="controls">
			<div class="input-append">
				<input type="text" name="last_name" id="last_name" value="{{ Input::old('last_name'); }}" placeholder="{{ Lang::get('platform/users::users/form.last_name') }}">
				<span class="add-on"><i class="icon-user"></i></span>
			</div>
			<span class="help-block">{{ Lang::get('platform/users::users/form.last_name_help') }}</span>
		</div>
	</div>

	<!-- Email Address -->
	<div class="control-group">
		<label class="control-label" for="email">{{ Lang::get('platform/users::users/form.email') }}:</label>
		<div class="controls">
			<div class="input-append">
				<input type="email" name="email" id="email" value="{{ Input::old('email'); }}" placeholder="{{ Lang::get('platform/users::users/form.email') }}">
				<span class="add-on"><i class="icon-envelope"></i></span>
			</div>
			<span class="help-block">{{ Lang::get('platform/users::users/form.email_help') }}</span>
		</div>
	</div>

	<!-- Password -->
	<div class="control-group">
		<label class="control-label" for="password">{{ Lang::get('platform/users::users/form.password') }}:</label>
		<div class="controls">
			<div class="input-append">
				<input type="password" name="password" id="password" value="{{ Input::old('password'); }}" placeholder="{{ Lang::get('platform/users::users/form.password') }}">
				<span class="add-on"><i class="icon-envelope"></i></span>
			</div>
			<span class="help-block">{{ Lang::get('platform/users::users/form.password_help') }}</span>
		</div>
	</div>

	<!-- Groups -->
	<div class="control-group">
		<label class="control-label" for="groups">{{ Lang::get('platform/users::users/form.groups') }}:</label>
		<div class="controls">
			<div class="input-append">
				<select name="groups[]" id="groups[]" multiple="multiple">
					@foreach ($groups as $group)
					<option value="{{ $group->id }}">{{ $group->name }}</option>
					@endforeach
				</select>
			</div>
			<span class="help-block">{{ Lang::get('platform/users::users/form.groups_help') }}</span>
		</div>
	</div>

	<div class="form-actions">
		<a class="btn btn-small" href="{{ URL::to(ADMIN_URI.'/users') }}">{{ Lang::get('button.cancel') }}</a>
		<button class="btn btn-small btn-primary" type="submit">{{ Lang::get('button.update') }}</button>
	</div>
</form>
@stop