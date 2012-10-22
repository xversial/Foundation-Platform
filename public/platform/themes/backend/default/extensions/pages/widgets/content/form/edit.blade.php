<form action="{{ URL::to_admin('pages/content/edit/'.$content['id']) }}" id="edit-form" class="form-horizontal" method="POST" accept-char="UTF-8">
	<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

	<fieldset>

		<!-- Name -->
		<div class="control-group">
			<label class="control-label" for="name">Name:</label>
			<div class="controls">
				<input type="text" name="name" id="name" value="{{ Input::old('name', $content['name']) }}" placeholder="Name" required>
				<span class="help-block">Descriptive name for your content.</span>
			</div>
		</div>

		<!-- Slug -->
		<div class="control-group">
			<label class="control-label" for="slug">Slug:</label>
			<div class="controls">
				<input type="text" name="slug" id="slug" value="{{ Input::old('slug', $content['slug']) }}" placeholder="Slug" required>
				<span class="help-block">Slug to find content by</span>
			</div>
		</div>

		<!-- Value -->
		<div class="control-group">
			<label class="control-label" for="content">Content:</label>
			<div class="controls">
				<textarea name="content" id="Value" placeholder="content" required>{{ Input::old('content', $content['content']) }}</textarea>
				<span class="help-block">Value of your content.</span>
			</div>
		</div>

	</fieldset>

	<p class="messages"></p>
	<hr>

	<div class="form-actions">
		<a class="btn btn-large" href="{{ URL::to_admin('pages/content') }}">{{ Lang::line('button.cancel') }}</a>
		<button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.update') }}</button>
	</div>

</form>