<form action="{{ URL::to_admin('settings') }}" id="general-form" class="" method="POST" accept-char="UTF-8">
    <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

    <input type="hidden" name="extension" value="themes" />

    <fieldset>

		<legend>Theme Select</legend>

		<!-- Frontend Theme -->
    	<div class="control-group">
			<label for="theme-frontend">{{ Lang::line('themes::form.settings.fields.frontend') }}</label>
			<div class="controls">
				<div class="input-append">
					{{ Form::select('theme:frontend', $frontend_themes, array_get($settings, 'theme.frontend'), array('id' => 'theme-frontend')) }}
					<span class="add-on"><i class="icon-picture"></i></span>
				</div>
				<span class="help-block"></span>
			</div>
		</div>

		<!-- Backend Theme -->
    	<div class="control-group">
			<label for="theme-backend">{{ Lang::line('themes::form.settings.fields.backend') }}</label>
			<div class="controls">
				<div class="input-append">
					{{ Form::select('theme:backend', $backend_themes, array_get($settings, 'theme.backend'), array('id' => 'theme-backend')) }}
					<span class="add-on"><i class="icon-picture"></i></span>
				</div>
				<span class="help-block"></span>
			</div>
		</div>

    </fieldset>

    <div class="form-actions">
        <button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.update') }}</button>
    </div>
</form>
