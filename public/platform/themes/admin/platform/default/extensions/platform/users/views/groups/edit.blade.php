@extends('templates/default')

@section('title')
{{ Lang::get('platform/users::general.users.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')

<form class="form-horizontal" action="{{ Request::fullUrl() }}" method="POST" accept-char="UTF-8">
	<input type="hidden" name="csrf_token" value="{{ Session::getToken() }}">

	<fieldset>
		<legend>{{ Lang::get('platform/users::form.users.edit.legend') }}</legend>

		<!-- First Name -->
		<div class="control-group">
			<label class="control-label" for="first_name">{{ Lang::get('platform/users::form.users.create.first_name') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="text" name="first_name" id="first_name" value="{{ Input::old('metadata.first_name', $user->first_name); }}" placeholder="{{ Lang::get('platform/users::form.users.create.first_name') }}" required>
					<span class="add-on"><i class="icon-user"></i></span>
				</div>
				<span class="help-block">{{ Lang::get('platform/users::form.users.create.first_name_help') }}</span>
			</div>
		</div>

		<!-- Last Name -->
		<div class="control-group">
			<label class="control-label" for="last_name">{{ Lang::get('platform/users::form.users.create.last_name') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="text" name="last_name" id="last_name" value="{{ Input::old('metadata.last_name', $user->last_name); }}" placeholder="{{ Lang::get('platform/users::form.users.create.last_name') }}" required>
					<span class="add-on"><i class="icon-user"></i></span>
				</div>
				<span class="help-block">{{ Lang::get('platform/users::form.users.create.last_name_help') }}</span>
			</div>
		</div>

		<!-- Email Address -->
		<div class="control-group">
			<label class="control-label" for="email">{{ Lang::get('platform/users::form.users.create.email') }}:</label>
			<div class="controls">
				<div class="input-append">
					<input type="email" name="email" id="email" value="{{ Input::old('email', $user->email); }}" placeholder="{{ Lang::get('platform/users::form.users.create.email') }}" required>
					<span class="add-on"><i class="icon-envelope"></i></span>
				</div>
				<span class="help-block">{{ Lang::get('platform/users::form.users.create.email_help') }}</span>
			</div>
		</div>

		<div class="form-actions">
			<a class="btn btn-large" href="{{ URL::to(ADMIN_URI.'/users') }}">{{ Lang::get('button.cancel') }}</a>
			<button class="btn btn-large btn-primary" type="submit">{{ Lang::get('button.update') }}</button>
		</div>

	</fieldset>

</form>

@stop