@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/localisation::languages/general.title') }}
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
<section id="languages">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                    <span class="icon-reorder"></span>
                </a>

                <a class="brand" href="{{ URL::to_admin('localisation/languages') }}">{{ Lang::line('platform/localisation::languages/general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <form action="{{ URL::to_admin('localisation/languages/edit/' . $language['slug']) }}" id="languages-edit-form" class="form-horizontal" method="POST" accept-char="UTF-8">
            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

            <fieldset>
                <legend>{{ Lang::line('platform/localisation::languages/general.description.edit', array('language' => $language['name'])) }}</legend>

                <div class="control-group">
                    <label class="control-label" for="name">{{ Lang::line('platform/localisation::languages/form.name') }}</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="{{ Input::old('name', $language['name']); }}" required />
                        <span class="help-block">{{ Lang::line('platform/localisation::languages/form.name_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="abbreviation">{{ Lang::line('platform/localisation::languages/form.abbreviation') }}</label>
                    <div class="controls">
                        <input type="text" name="abbreviation" id="abbreviation" value="{{ Input::old('abbreviation', $language['abbreviation']); }}" required />
                        <span class="help-block">{{ Lang::line('platform/localisation::languages/form.abbreviation_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="locale">{{ Lang::line('platform/localisation::languages/form.locale') }}</label>
                    <div class="controls">
                        <input type="text" name="locale" id="locale" value="{{ Input::old('locale', $language['locale']); }}" required />
                        <span class="help-block">{{ Lang::line('platform/localisation::languages/form.locale_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="status">{{ Lang::line('platform/localisation::languages/form.status') }}</label>
                    <div class="controls">
                        {{ Form::select('status', general_statuses(), $language['status']); }}
                        <span class="help-block">{{ Lang::line('platform/localisation::languages/form.status_help') }}</span>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <a class="btn btn-large" href="{{ URL::to_admin('localisation/languages') }}">{{ Lang::line('button.cancel') }}</a>
                <button class="btn btn-large btn-primary" type="submit" name="save" id="save" value="1">{{ Lang::line('button.update') }}</button>
            </div>
        </form>
    </div>
</section>
@endsection