@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/themes::general.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('themes','platform/themes::css/themes.less', 'style') }}

<!-- Styles -->
@section('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('themes','platform/themes::js/themes.js', 'jquery') }}

<!-- Scripts -->      
@section('scripts')      
@endsection

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

                <a class="brand" href="#">{{ Lang::line('platform/themes::general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <hr>

    <div class="quaternary page">
        <div class="selections row-fluid">
            @foreach ($themes as $theme)
            <div class="active span3">
                <div class="thumbnail">
                    <img src="{{ $theme['thumbnail'] }}" title="{{ $theme['name'] }}">
                    <div class="caption">
                        <h5>{{ $theme['name'] }}</h5>

                        <p class="version">{{ Lang::line('platform/themes::general.version') }} {{ $theme['version'] }}</p>

                        <p class="author">{{ Lang::line('platform/themes::general.author') }}  {{ $theme['author'] }}</p>

                        <p>{{ $theme['description'] }}</p>
                        @if ($theme['active'])
                        <a href="{{ URL::to_admin('themes/edit/' . $type . '/' . $theme['theme']) }}" class="btn" data-theme="{ $active['theme'] }}" data-type="backend">{{ Lang::line('button.edit') }}</a>
                        @else
                        <a href="{{ URL::to_admin('themes/activate/' . $type . '/' . $theme['theme']) }}" class="btn activate" data-token="{{ Session::token() }}" data-theme="{{ $theme['theme'] }}" data-type="{{ $type }}">{{ Lang::line('button.enable') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection