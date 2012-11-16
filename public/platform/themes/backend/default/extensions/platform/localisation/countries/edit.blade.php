@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/localisation::countries/general.title') }}
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency')-->

<!-- Styles -->
@section('styles')
@endsection

<!-- Queue Scripts | e.g. Theme::queue_asset('name', 'path_to_js', 'dependency')-->

<!-- Scripts -->
@section('scripts')
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

                <a class="brand" href="{{ URL::to_admin('localisation/countries') }}">{{ Lang::line('platform/localisation::countries/general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <form action="{{ URL::to_admin('localisation/countries/edit/' . $country['slug']) }}" id="country-edit-form" class="form-horizontal" method="POST" accept-char="UTF-8">
            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

            <fieldset>
                <legend>{{ Lang::line('platform/localisation::countries/general.description.edit', array('country' => $country['name'])) }}</legend>

                <div class="control-group">
                    <label class="control-label" for="name">{{ Lang::line('platform/localisation::countries/form.name') }}</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="{{ Input::old('name', $country['name']); }}" required />
                        <span class="help-block">{{ Lang::line('platform/localisation::countries/form.name_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="iso_code_2">{{ Lang::line('platform/localisation::countries/form.iso_code_2') }}</label>
                    <div class="controls">
                        <input type="text" name="iso_code_2" id="iso_code_2" value="{{ Input::old('iso_code_2', $country['iso_code_2']); }}" required />
                        <span class="help-block">{{ Lang::line('platform/localisation::countries/form.iso_code_2_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="iso_code_3">{{ Lang::line('platform/localisation::countries/form.iso_code_3') }}</label>
                    <div class="controls">
                        <input type="text" name="iso_code_3" id="iso_code_3" value="{{ Input::old('iso_code_3', $country['iso_code_3']); }}" required />
                        <span class="help-block">{{ Lang::line('platform/localisation::countries/form.iso_code_3_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="iso_code_numeric_3">{{ Lang::line('platform/localisation::countries/form.iso_code_numeric_3') }}</label>
                    <div class="controls">
                        <input type="text" name="iso_code_numeric_3" id="iso_code_numeric_3" value="{{ Input::old('iso_code_numeric_3', $country['iso_code_numeric_3']); }}" required />
                        <span class="help-block">{{ Lang::line('platform/localisation::countries/form.iso_code_numeric_3_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="region">{{ Lang::line('platform/localisation::countries/form.region') }}</label>
                    <div class="controls">
                        <input type="text" name="region" id="region" value="{{ Input::old('region', $country['region']); }}" />
                        <span class="help-block">{{ Lang::line('platform/localisation::countries/form.region_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="subregion">{{ Lang::line('platform/localisation::countries/form.subregion') }}</label>
                    <div class="controls">
                        <input type="text" name="subregion" id="subregion" value="{{ Input::old('subregion', $country['subregion']); }}" />
                        <span class="help-block">{{ Lang::line('platform/localisation::countries/form.subregion_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="status">{{ Lang::line('platform/localisation::countries/form.status') }}</label>
                    <div class="controls">
                        {{ Form::select('status', general_statuses(), $country['status']); }}
                        <span class="help-block">{{ Lang::line('platform/localisation::countries/form.status_help') }}</span>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <a class="btn btn-large" href="{{ URL::to_admin('localisation/countries') }}">{{ Lang::line('button.cancel') }}</a>
                <button class="btn btn-large btn-primary" type="submit" name="save" id="save" value="1">{{ Lang::line('button.update') }}</button>
            </div>
        </form>
    </div>
</section>
@endsection