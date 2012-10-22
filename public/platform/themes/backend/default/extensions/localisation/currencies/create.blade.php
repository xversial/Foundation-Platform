@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('localisation::currencies/general.title') }}
@endsection

<!-- Page Content -->
@section('content')
<section id="currencies">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                    <span class="icon-reorder"></span>
                </a>

                <a class="brand" href="{{ URL::to_admin('localisation/currencies') }}">{{ Lang::line('localisation::currencies/general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform.menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <form action="{{ URL::to_admin('localisation/currencies/create') }}" id="currencies-create-form" class="form-horizontal" method="POST" accept-char="UTF-8">
            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

            <fieldset>
                <legend>{{ Lang::line('localisation::currencies/general.description.create') }}</legend>

                <div class="control-group">
                    <label class="control-label" for="name">{{ Lang::line('localisation::currencies/table.name') }}</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="{{ Input::old('name'); }}" placeholder="{{ Lang::line('localisation::currencies/table.name') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="code">{{ Lang::line('localisation::currencies/table.code') }}</label>
                    <div class="controls">
                        <input type="text" name="code" id="code" value="{{ Input::old('code'); }}" placeholder="{{ Lang::line('localisation::currencies/table.code') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="symbol_left">{{ Lang::line('localisation::currencies/table.symbol_left') }}</label>
                    <div class="controls">
                        <input type="text" name="symbol_left" id="symbol_left" value="{{ Input::old('symbol_left'); }}" placeholder="{{ Lang::line('localisation::currencies/table.symbol_left') }}" />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="symbol_right">{{ Lang::line('localisation::currencies/table.symbol_right') }}</label>
                    <div class="controls">
                        <input type="text" name="symbol_right" id="symbol_right" value="{{ Input::old('symbol_right'); }}" placeholder="{{ Lang::line('localisation::currencies/table.symbol_right') }}" />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="decimal_place">{{ Lang::line('localisation::currencies/table.decimal_place') }}</label>
                    <div class="controls">
                        <input type="text" name="decimal_place" id="decimal_place" value="{{ Input::old('decimal_place'); }}" placeholder="{{ Lang::line('localisation::currencies/table.decimal_place') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="rate">{{ Lang::line('localisation::currencies/table.rate') }}</label>
                    <div class="controls">
                        <input type="text" name="rate" id="rate" value="{{ Input::old('rate'); }}" placeholder="{{ Lang::line('localisation::currencies/table.rate') }}" required />
                        <span class="help-block"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="status">{{ Lang::line('localisation::currencies/table.status') }}</label>
                    <div class="controls">
                        {{ Form::select('status', general_statuses()); }}
                        <span class="help-block"></span>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <a class="btn btn-large" href="{{ URL::to_admin('localisation/currencies') }}">{{ Lang::line('button.cancel') }}</a>
                <button class="btn btn-large btn-primary" type="submit" name="save" id="save" value="1">{{ Lang::line('button.create') }}</button>
                <button class="btn btn-large btn-primary" type="submit" name="save_exit" id="save_exit" value="1">{{ Lang::line('button.create_exit') }}</button>
            </div>
        </form>
    </div>
</section>
@endsection