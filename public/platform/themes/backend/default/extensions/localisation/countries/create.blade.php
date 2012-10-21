@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('localisation::countries/general.title') }}
@endsection

<!-- Page Content -->
@section('content')
<section id="countries">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                    <span class="icon-reorder"></span>
                </a>

                <a class="brand" href="#">{{ Lang::line('localisation::countries/general.description.create') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform.menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        {{ Form::open() }}
            {{ Form::token() }}
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="name">{{ Lang::line('localisation::countries/table.name') }}</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="{{ Input::old('name'); }}" placeholder="{{ Lang::line('localisation::countries/table.name') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="iso_code_2">{{ Lang::line('localisation::countries/table.iso_code_2') }}</label>
                    <div class="controls">
                        <input type="text" name="iso_code_2" id="iso_code_2" value="{{ Input::old('iso_code_2'); }}" placeholder="{{ Lang::line('localisation::countries/table.iso_code_2') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="iso_code_3">{{ Lang::line('localisation::countries/table.iso_code_3') }}</label>
                    <div class="controls">
                        <input type="text" name="iso_code_3" id="iso_code_3" value="{{ Input::old('iso_code_3'); }}" placeholder="{{ Lang::line('localisation::countries/table.iso_code_3') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="iso_code_numeric_3">{{ Lang::line('localisation::countries/table.iso_code_numeric_3') }}</label>
                    <div class="controls">
                        <input type="text" name="iso_code_numeric_3" id="iso_code_numeric_3" value="{{ Input::old('iso_code_numeric_3'); }}" placeholder="{{ Lang::line('localisation::countries/table.iso_code_numeric_3') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="region">{{ Lang::line('localisation::countries/table.region') }}</label>
                    <div class="controls">
                        <input type="text" name="region" id="region" value="{{ Input::old('region'); }}" placeholder="{{ Lang::line('localisation::countries/table.region') }}" />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="subregion">{{ Lang::line('localisation::countries/table.subregion') }}</label>
                    <div class="controls">
                        <input type="text" name="subregion" id="subregion" value="{{ Input::old('subregion'); }}" placeholder="{{ Lang::line('localisation::countries/table.subregion') }}" />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="status">{{ Lang::line('localisation::countries/table.status') }}</label>
                    <div class="controls">
                        {{ Form::select('status', general_statuses()); }}
                        <span class="help-block"></span>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <a class="btn btn-large" href="{{ URL::to_admin('localisation/countries') }}">{{ Lang::line('button.cancel') }}</a>
                <button class="btn btn-large btn-primary" type="submit" name="save" id="save" value="1">{{ Lang::line('button.create') }}</button>
                <button class="btn btn-large btn-primary" type="submit" name="save_exit" id="save_exit" value="1">{{ Lang::line('button.create_exit') }}</button>
            </div>
        {{ Form::close() }}
    </div>
</section>
@endsection