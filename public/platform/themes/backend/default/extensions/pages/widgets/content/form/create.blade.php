<form action="{{ URL::to_admin('pages/content/create') }}" id="create-form" class="form-horizontal" method="POST" accept-char="UTF-8">
	<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

	<fieldset>
		<legend>{{ lang::line('pages::form.content.create.legend') }}</legend>

		<!-- Name -->
		<div class="control-group">
			<label class="control-label" for="name">{{ lang::line('pages::form.content.create.name') }}:</label>
			<div class="controls">
				<input type="text" name="name" id="name" value="{{ Input::old('name') }}" placeholder="Name" required>
				<span class="help-block">{{ lang::line('pages::form.content.create.name_help') }}</span>
			</div>
		</div>

		<!-- Slug -->
		<div class="control-group">
			<label class="control-label" for="slug">{{ lang::line('pages::form.content.create.slug') }}:</label>
			<div class="controls">
				<input type="text" name="slug" id="slug" value="{{ Input::old('slug') }}" placeholder="Slug" required>
				<span class="help-block">{{ lang::line('pages::form.content.create.slug_help') }}</span>
			</div>
		</div>

		<!-- Value -->
		<div class="control-group">
			<label class="control-label" for="value">{{ lang::line('pages::form.content.create.value') }}:</label>
			<div class="controls">
				<textarea rows="10" name="value" id="value" placeholder="content" required>{{ Input::old('value') }}</textarea>
				<span class="help-block">{{ lang::line('pages::form.content.create.value_help') }}</span>
			</div>
		</div>

	</fieldset>

	<p class="messages"></p>
	<hr>

	<div class="form-actions">
		<a class="btn btn-large" href="{{ URL::to_admin('pages/content') }}">{{ Lang::line('button.cancel') }}</a>
		<button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.create') }}</button>
	</div>

</form>
