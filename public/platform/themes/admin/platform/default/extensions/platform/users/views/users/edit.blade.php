@extends('templates/default')

@section('title')
{{ Lang::get('platform/users::general.users.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')

<form>

	<fieldset>

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

	</fieldset>

</form>

@stop