@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('[[slug_designer]]::general.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('[[extension]]','[[slug_designer]]::css/main.less', array('jquery')) }}

<!-- Queue Scripts -->
{{ Theme::queue_asset('[[extension]]','[[slug_designer]]::js/main.js', array('jquery')) }}

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

                <a class="brand" href="#">{{ Lang::line('[[slug_designer]]::general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <hr>

    <div class="quaternary page">
        <p>
            Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Vestibulum id ligula porta felis euismod semper. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.
        </p>

        <h2>Widgets</h2>
        @widget('[[slug_designer]]::example.test')
        <br>
        @widget('[[slug_designer]]::example.test2')
    </div>
</section>
@endsection
