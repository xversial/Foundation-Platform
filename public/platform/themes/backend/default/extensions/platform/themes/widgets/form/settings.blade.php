    <fieldset>
        <legend>Theme Select</legend>

        <!-- Frontend Theme -->
        <div class="control-group">
            <label for="theme-frontend">{{ Lang::line('platform/themes::form.settings.fields.frontend') }}</label>
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
            <label for="theme-backend">{{ Lang::line('platform/themes::form.settings.fields.backend') }}</label>
            <div class="controls">
                <div class="input-append">
                    {{ Form::select('theme:backend', $backend_themes, array_get($settings, 'theme.backend'), array('id' => 'theme-backend')) }}
                    <span class="add-on"><i class="icon-picture"></i></span>
                </div>
                <span class="help-block"></span>
            </div>
        </div>
    </fieldset>