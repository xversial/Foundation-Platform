@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('localisation::languages/general.title') }}
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

                <a class="brand" href="{{ URL::to_admin('localisation/languages') }}">{{ Lang::line('localisation::languages/general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform.menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <form action="{{ URL::to_admin('localisation/languages/create') }}" id="languages-create-form" class="form-horizontal" method="POST" accept-char="UTF-8">
            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

            <fieldset>
                <legend>{{ Lang::line('localisation::languages/general.description.create') }}</legend>

                <div class="control-group">
                    <label class="control-label" for="name">{{ Lang::line('localisation::languages/table.name') }}</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="{{ Input::old('name'); }}" placeholder="{{ Lang::line('localisation::languages/table.name') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="abbreviation">{{ Lang::line('localisation::languages/table.abbreviation') }}</label>
                    <div class="controls">
                        <input type="text" name="abbreviation" id="abbreviation" value="{{ Input::old('abbreviation'); }}" placeholder="{{ Lang::line('localisation::languages/table.abbreviation') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="locale">{{ Lang::line('localisation::languages/table.locale') }}</label>
                    <div class="controls">
                        <input type="text" name="locale" id="locale" value="{{ Input::old('locale'); }}" placeholder="{{ Lang::line('localisation::languages/table.locale') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="status">{{ Lang::line('localisation::languages/table.status') }}</label>
                    <div class="controls">
                        {{ Form::select('status', general_statuses()); }}
                        <span class="help-block"></span>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <a class="btn btn-large" href="{{ URL::to_admin('localisation/languages') }}">{{ Lang::line('button.cancel') }}</a>
                <button class="btn btn-large btn-primary" type="submit" name="save" id="save" value="1">{{ Lang::line('button.create') }}</button>
                <button class="btn btn-large btn-primary" type="submit" name="save_exit" id="save_exit" value="1">{{ Lang::line('button.create_exit') }}</button>
            </div>
        </form>
    </div>
</section>
@endsection