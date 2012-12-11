<form action="{{ URL::to_admin('pages/create') }}" id="create-form" class="form-horizontal" method="POST" accept-char="UTF-8">
	<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

	<fieldset>
		<legend>{{ Lang::line('platform/pages::form.pages.create.legend') }}</legend>

		<ul class="nav nav-tabs">
			<li class="active"><a href="#general" data-toggle="tab">General</a></li>
			<li><a href="#visibility" data-toggle="tab">Visibility</a></li>
		</ul>

		<div class="tab-content">

			<div class="tab-pane active" id="general">

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

			</div>

			<div class="tab-pane" id="visibility">

				<!-- Visibility -->
				<div class="control-group">
					<label for="visibility" class="control-label">{{ Lang::line('platform/pages::form.pages.create.visibility') }}</label>
					<div class="controls">
						{{ form::select('visibility', $visibility_options, Input::old('visibility')) }}
						<span class="help-block">{{ Lang::line('platform/pages::form.pages.create.visibility_help') }}</span>
					</div>
				</div>

				<!-- Groups -->
				<div class="control-group">
					<label for="groups" class="control-label">{{ Lang::line('platform/pages::form.pages.create.groups') }}</label>
					<div class="controls">
						{{ form::select('groups[]', $groups, Input::old('groups'), array('multiple' => true) )}}
						<span class="help-block">{{ Lang::line('platform/pages::form.pages.create.groups_help') }}</span>
					</div>
				</div>

			</div>

		</div>

	</fieldset>

	<p class="messages"></p>
	<hr>

	<div class="form-actions">
		<a class="btn btn-large" href="{{ URL::to_admin('pages') }}">{{ Lang::line('button.cancel') }}</a>
		<button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.create') }}</button>
		<button class="btn btn-large btn-info pull-right" id="preview" type="button">Preview</button>
	</div>

</form>
@widget('platform/media::media.chooser', 'platform/pages::redactor_media', array('limit' => 1, 'js' => false, 'link' => false))

{{ Theme::queue_asset('redactor', 'platform/pages::css/redactor.css', 'styles') }}
{{ Theme::queue_asset('redactor', 'platform/pages::js/redactor.min.js', 'jquery') }}
{{ Theme::queue_asset('redactor-plugins', 'platform/pages::js/redactor-plugins.js', 'redactor') }}
{{ Theme::queue_asset('preview', 'platform/pages::js/preview.js', 'redactor') }}
{{ Theme::queue_asset('editor', 'platform/pages::js/editor.js', 'media-chooser') }}