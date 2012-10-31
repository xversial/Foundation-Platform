<form method="POST" accept-char="UTF-8" autocomplete="off" id="localisation_settings_form">

    <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

    <input type="hidden" name="vendor" value="platform">
    <input type="hidden" name="extension" value="localisation">

    <fieldset>
        <div>
            <label for="site-country">{{ Lang::line('platform/localisation::form.settings.fields.country') }}</label>
            {{ Form::select('site:country', countries(), array_get($settings, 'site.country'), array('id' => 'site-country')) }}
            <span class="help"></span>
        </div>

        <div>
            <label for="site-language">{{ Lang::line('platform/localisation::form.settings.fields.language') }}</label>
            {{ Form::select('site:language', languages(), array_get($settings, 'site.language'), array('id' => 'site-language')) }}
            <span class="help"></span>
        </div>

        <div>
            <label for="site-currency">{{ Lang::line('platform/localisation::form.settings.fields.currency') }}</label>
            {{ Form::select('site:currency', currencies(), array_get($settings, 'site.currency'), array('id' => 'site-currency')) }}
            <span class="help"></span>
        </div>

        <div>
            <label for="site-currency_api_key">{{ Lang::line('platform/localisation::form.settings.fields.currency_api_key') }}</label>
            <input type="text" name="site:currency_api_key" id="site-currency_api_key" value="@get.localisation.site.currency_api_key">
            <span class="help"></span>
        </div>

        <div>
            <label for="site-currency-auto-update">{{ Lang::line('platform/localisation::form.settings.fields.currency_auto') }}</label>
            {{ Form::select('site:currency_auto_update', currencies_update_intervals(), array_get($settings, 'site.currency_auto_update'), array('id' => 'site-currency-auto-update')) }}
            <span class="help"></span>
        </div>

        <div>
            <label for="site-timezone">{{ Lang::line('platform/localisation::form.settings.fields.timezone') }}</label>
            {{ Form::select('site:timezone', timezones(), array_get($settings, 'site.timezone'), array('id' => 'site-timezone')) }}
            <span class="help"></span>
        </div>

        <div>
            <label for="site-date_format">{{ Lang::line('platform/localisation::form.settings.fields.date_format') }}</label>
            {{ Form::select('site:date_format', date_formats(), array_get($settings, 'site.date_format'), array('id' => 'site-date_format')) }}
            <span class="help"></span>
        </div>

        <div>
            <label for="site-time_format">{{ Lang::line('platform/localisation::form.settings.fields.time_format') }}</label>
            {{ Form::select('site:time_format', time_formats(), array_get($settings, 'site.time_format'), array('id' => 'site-time_format')) }}
            <span class="help"></span>
        </div>
    </fieldset>

    <hr>

    <div class="actions">
        <button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.update') }}</button>
    </div>
</form>