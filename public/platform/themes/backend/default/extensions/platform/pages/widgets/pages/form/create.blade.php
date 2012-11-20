<form action="{{ URL::to_admin('pages/create') }}" id="create-form" class="form-horizontal" method="POST" accept-char="UTF-8">
	<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

	<fieldset>
		<legend>{{ Lang::line('platform/pages::form.pages.create.legend') }}</legend>

		<!-- Name -->
		<div class="control-group">
			<label class="control-label" for="name">{{ Lang::line('platform/pages::form.pages.create.name') }}:</label>
			<div class="controls">
				<input type="text" name="name" id="name" value="{{ Input::old('name') }}" placeholder="Name" required>
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.create.name_help') }}</span>
			</div>
		</div>

		<!-- Slug -->
		<div class="control-group">
			<label class="control-label" for="slug">{{ Lang::line('platform/pages::form.pages.create.slug') }}:</label>
			<div class="controls">
				<input type="text" name="slug" id="slug" value="{{ Input::old('slug') }}" placeholder="Slug" required>
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.create.slug_help') }}</span>
			</div>
		</div>

		<!-- Status -->
		<div class="control-group">
			<label for="status" class="control-label">{{ Lang::line('platform/pages::form.pages.create.status') }}</label>
			<div class="controls">
				{{ Form::select('status', $status) }}
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.create.status_help') }}</span>
			</div>
		</div>

		<!-- Templates -->
		<div class="control-group">
			<label for="template" class="control-label">{{ Lang::line('platform/pages::form.pages.create.template') }}:</label>
			<div class="controls">
				{{ Form::select('templates', $templates, Input::old('template')) }}
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.create.template_help') }}</span>
			</div>
		</div>

		<!-- Value -->
		<div class="control-group">
			<label class="control-label" for="value">{{ Lang::line('platform/pages::form.pages.create.value') }}:</label>
			<div class="controls">
				<textarea rows="10" name="value" id="value" placeholder="content" required>{{ Input::old('value') }}</textarea>
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.create.value_help') }}</span>
			</div>
		</div>

	</fieldset>

	<p class="messages"></p>
	<hr>

	<div class="form-actions">
		<a class="btn btn-large" href="{{ URL::to_admin('pages') }}">{{ Lang::line('button.cancel') }}</a>
		<button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.create') }}</button>
	</div>

</form>
