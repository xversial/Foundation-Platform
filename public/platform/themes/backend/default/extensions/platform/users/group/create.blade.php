@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/users::general.groups.create.title') }}
@endsection

<!-- Page Content -->
@section('content')
<section id="groups">
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

                <a class="brand" href="#">{{ Lang::line('platform/users::general.groups.create.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <hr>

    <div class="quaternary page">
        @widget('platform/users::admin.group.form.create')
    </div>
</section>
@endsection
