<form action="{{ URL::to_admin('settings') }}" id="general-form" class="" method="POST" accept-char="UTF-8">
    <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

    <input type="hidden" name="vendor" value="platform">
    <input type="hidden" name="extension" value="settings">

    <fieldset>

        <legend>Site Basics</legend>

        <!-- Site Title -->
        <div class="control-group">
            <label for="site-title">{{ Lang::line('platform/settings::form.settings.fields.title') }}</label>
            <div class="controls">
                <div class="input-append">
                    <input type="text" id="site-title" name="site:title" value="{{ array_get($settings, 'site.title') }}" required />
                    <span class="add-on"><i class="icon-cog"></i></span>
                </div>
                <span class="help-block"></span>
            </div>
        </div>

        <!-- Site Tagline -->
        <div class="control-group">
            <label for="site-tagline">{{ Lang::line('platform/settings::form.settings.fields.tagline') }}</label>
            <div class="controls">
                <div class="input-append">
                    <input type="text" id="site-tagline" name="site:tagline" value="{{ array_get($settings, 'site.tagline') }}" required />
                    <span class="add-on"><i class="icon-cog"></i></span>
                </div>
                <span class="help-block"></span>
            </div>
        </div>

        <!-- Site Email Address -->
        <div class="control-group">
            <label for="site-email">{{ Lang::line('platform/settings::form.settings.fields.email') }}</label>
            <div class="controls">
                <div class="input-append">
                     <input type="email" id="site-email" name="site:email" value="{{ array_get($settings, 'site.email') }}" required />
                    <span class="add-on"><i class="icon-envelope"></i></span>
                </div>
                <span class="help-block"></span>
            </div>
        </div>

    </fieldset>

    <fieldset>

        <legend>Frontend Filesystem Messages</legend>

        <!-- Frontend Fallback Message -->
        <div class="control-group">
            <label for="filesysem-frontend-fallback-message">{{ Lang::line('platform/settings::form.settings.fields.filesystem_fallback') }}</label>
            <div class="controls">
                <div class="input-append">
                    {{ Form::select('filesystem:frontend_fallback_message', $filesystem_options, $settings['filesystem']['frontend_fallback_message'], array('id' => 'frontend-fallback-message')) }}
                    <span class="add-on"><i class="icon-bell"></i></span>
                </div>
                <span class="help-block"></span>
            </div>
        </div>

        <!-- Frontend Failed Message -->
        <div class="control-group">
            <label for="filesysem-frontend-failed-message">{{ Lang::line('platform/settings::form.settings.fields.filesystem_failed') }}</label>
            <div class="controls">
                <div class="input-append">
                    {{ Form::select('filesystem:frontend_failed_message', $filesystem_options, $settings['filesystem']['frontend_failed_message'], array('id' => 'frontend-failed-message')) }}
                    <span class="add-on"><i class="icon-bell"></i></span>
                </div>
                <span class="help-block"></span>
            </div>
        </div>

    </fieldset>

    <fieldset>

        <legend>Backend Filesystem Messages</legend>

        <!-- Backend Fallback Message -->
        <div class="control-group">
            <label for="filesysem-backend-fallback-message">{{ Lang::line('platform/settings::form.settings.fields.filesystem_fallback') }}</label>
            <div class="controls">
                <div class="input-append">
                    {{ Form::select('filesystem:backend_fallback_message', $filesystem_options, $settings['filesystem']['backend_fallback_message'], array('id' => 'filesystem-fallback-message')) }}
                    <span class="add-on"><i class="icon-bell"></i></span>
                </div>
                <span class="help-block"></span>
            </div>
        </div>

        <!-- Backend Failed Message -->
        <div class="control-group">
            <label for="filesysem-backend-failed-message">{{ Lang::line('platform/settings::form.settings.fields.filesystem_failed') }}</label>
            <div class="controls">
                <div class="input-append">
                    {{ Form::select('filesystem:backend_failed_message', $filesystem_options, $settings['filesystem']['backend_failed_message'], array('id' => 'filesystem-failed-message')) }}
                    <span class="add-on"><i class="icon-bell"></i></span>
                </div>
                <span class="help-block"></span>
            </div>
        </div>

    </fieldset>

    <div class="form-actions">
        <button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.update') }}</button>
    </div>
{{ Form::close() }}
