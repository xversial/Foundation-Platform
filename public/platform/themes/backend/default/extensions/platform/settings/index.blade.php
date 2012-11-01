@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/settings::general.title') }}
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency')-->

<!-- Styles -->
@section ('styles')
@endsection

{{ Theme::queue_asset('platform-validate', 'js/vendor/platform/validate.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-tab', 'js/bootstrap/tab.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')

<script>
    $(document).ready(function() {
        Validate.setup($("#general-form"), $("#login-form"), $("#login-form"));
    });
</script>

@endsection

@section('content')
<section id="settings">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">

            <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
            <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <a class="brand" href="#">{{ Lang::line('platform/settings::general.title') }}</a>

            <!-- Everything you want hidden at 940px or less, place within here -->
            <div id="tertiary-navigation" class="nav-collapse">
                @widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
            </div>

            </div>
        </div>
    </header>

    <!-- Quaternary Desktop Navigation -->
    <nav class="quaternary-navigation tabbable visible-desktop">
        <ul class="nav nav-tabs">
            @foreach ($tabs as $tab => $extension)
            <li{{ ( $extension === 'platform/settings' ? ' class="active"' : '' ) }}><a href="#tab_{{ $tab }}" data-toggle="tab">{{ Lang::line($extension . '::form.settings.legend') }}</a></li>
            @endforeach
        </ul>
    </nav>

    <div class="quaternary page">
         <!-- Quaternary Mobile Navigation -->
        <nav class="hidden-desktop">
            <ul class="nav nav-stacked nav-pills">
                @foreach ($tabs as $tab => $extension)
                <li{{ ( $extension === 'platform/settings' ? ' class="active"' : '' ) }}><a href="#tab_{{ $tab }}" data-toggle="tab">{{ Lang::line($extension . '::form.settings.legend') }}</a></li>
                @endforeach
            </ul>
        </nav>

        <div class="tab-content">
            @foreach ($tabs as $tab => $extension)
            <div class="tab-pane{{ ( $extension === 'platform/settings' ? ' active' : '' ) }}" id="tab_{{ $tab }}">
                <form method="POST" accept-char="UTF-8" autocomplete="off" id="{{ $tab }}_form">
                    <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

                    <input type="hidden" name="extension" value="{{ $extension }}">

                    @foreach ($settings[ $tab ] as $vendor => $data)
                        <div>@widget($extension . '::settings.index', $data)</div>
                    @endforeach

                    <hr>

                    <div class="actions">
                        <button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.update') }}</button>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection