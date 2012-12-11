<form action="{{ URL::to_admin('pages/create') }}" id="copy-form" class="form-horizontal" method="POST" accept-char="UTF-8">
	<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

	<fieldset>
		<legend>{{ Lang::line('platform/pages::form.pages.copy.legend') }}</legend>

		<!-- Name -->
		<div class="control-group">
			<label class="control-label" for="name">{{ Lang::line('platform/pages::form.pages.copy.name') }}:</label>
			<div class="controls">
				<input type="text" name="name" id="name" value="{{ Input::old('name', $page['name']) }}" placeholder="Name" required>
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.copy.name_help') }}</span>
			</div>
		</div>

		<!-- Slug -->
		<div class="control-group">
			<label class="control-label" for="slug">{{ Lang::line('platform/pages::form.pages.copy.slug') }}:</label>
			<div class="controls">
				<input type="text" name="slug" id="slug" value="{{ Input::old('slug', $page['slug']) }}" placeholder="Slug" required>
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.copy.slug_help') }}</span>
			</div>
		</div>

		<!-- Status -->
		<div class="control-group">
			<label for="status" class="control-label">{{ Lang::line('platform/pages::form.pages.create.status') }}</label>
			<div class="controls">
				{{ Form::select('status', $status, Input::old('status', $page['status'], array('id' => 'status'))) }}
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.create.status_help') }}</span>
			</div>
		</div>

		<!-- Visibility -->
		<div class="control-group">
			<label for="visibility" class="control-label">{{ Lang::line('platform/menus::form.child.visibility.title') }}</label>
			<div class="controls">
				{{ form::select('visibility', $visibility_options, Input::old('visibility', $page['visibility']), array('id' => 'visibilty')) }}
				<span class="help-block">{{ Lang::line('platform/pages::form.edit.visibility_help') }}</span>
			</div>
		</div>

		<!-- Groups -->
		<div class="control-group">
			<label for="groups" class="control-label">{{ Lang::line('platform/pages::form.copy.groups') }}</label>
			<div class="controls">
				{{ form::select('groups[]', $groups, Input::old('groups', $page['groups']), array('multiple' => true) )}}
				<span class="help-block">{{ Lang::line('platform/pages::form.copy.groups_help') }}</span>
			</div>
		</div>

		<!-- Templates -->
		<div class="control-group">
			<label for="template" class="control-label">{{ Lang::line('platform/pages::form.pages.copy.template') }}:</label>
			<div class="controls">
				{{ Form::select('template', $templates, Input::old('template', $page['template'], array('id' => 'template'))) }}
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.copy.template_help') }}</span>
			</div>
		</div>

		<!-- Value -->
		<div class="control-group">
			<label class="control-label" for="value">{{ Lang::line('platform/pages::form.pages.copy.value') }}:</label>
			<div class="controls">
				<textarea rows="10" class="field" name="value" id="value" placeholder="content" required>{{ Input::old('value', $page['value']) }}</textarea>
				<span class="help-block">{{ Lang::line('platform/pages::form.pages.copy.value_help') }}</span>
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
@widget('platform/media::media.chooser', 'platform/pages::redactor_media', array('limit' => 1, 'js' => false, 'link' => false))

{{ Theme::queue_asset('redactor', 'platform/pages::css/redactor.css', 'styles') }}
{{ Theme::queue_asset('redactor', 'platform/pages::js/redactor.min.js', 'jquery') }}
{{ Theme::queue_asset('redactor-content', 'platform/pages::js/plugin.content.js', 'redactor') }}
{{ Theme::queue_asset('redactor-media', 'platform/pages::js/plugin.media.js', 'redactor') }}
{{ Theme::queue_asset('redactor-fullscreen', 'platform/pages::js/plugin.fullscreen.js', 'redactor') }}
{{ Theme::queue_asset('redactor-preview', 'platform/pages::js/plugin.preview.js', 'redactor') }}
{{ Theme::queue_asset('editor', 'platform/pages::js/editor.js', 'media-chooser') }}