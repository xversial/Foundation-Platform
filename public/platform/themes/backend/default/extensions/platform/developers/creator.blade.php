@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('themes::general.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('themes','platform/themes::css/themes.less', 'style') }}

<!-- Queue Scripts -->
{{ Theme::queue_asset('themes','platform/themes::js/themes.js', 'jquery') }}

<!-- Page Content -->
@section('content')
<section id="themes">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                    <span class="icon-reorder"></span>
                </a>

                <a class="brand" href="#">{{ Lang::line('developers::general.creator.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform.menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <hr>

    <div class="quaternary page">
        Aenean lacinia bibendum nulla sed consectetur. Vestibulum id ligula porta felis euismod semper. Donec sed odio dui. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Vestibulum id ligula porta felis euismod semper. Vestibulum id ligula porta felis euismod semper.
    </div>
</section>
@endsection