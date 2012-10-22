<form action="{{ URL::to_admin('pages/create') }}" id="create-form" class="form-horizontal" method="POST" accept-char="UTF-8">
	<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

	<fieldset>

		<!-- Name -->
		<div class="control-group">
			<label class="control-label" for="name">Name:</label>
			<div class="controls">
				<input type="text" name="name" id="name" value="{{ Input::old('name') }}" placeholder="Name" required>
				<span class="help-block">Descriptive name for your page.</span>
			</div>
		</div>

		<!-- Slug -->
		<div class="control-group">
			<label class="control-label" for="slug">Slug:</label>
			<div class="controls">
				<input type="text" name="slug" id="slug" value="{{ Input::old('slug') }}" placeholder="Slug" required>
				<span class="help-block">Slug to find page by</span>
			</div>
		</div>

		<!-- Templates -->
		<div class="control-group">
			<label for="template" class="control-label">Template:</label>
			<div class="controls">
				{{ Form::select('templates', $templates) }}
				<span class="help-block">Page Template to use.</span>
			</div>
		</div>

		<!-- Content -->
		<div class="control-group">
			<label class="control-label" for="content">Content:</label>
			<div class="controls">
				<textarea name="content" id="content" placeholder="content" required>{{ Input::old('content') }}</textarea>
				<span class="help-block">Contents of your page.</span>
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