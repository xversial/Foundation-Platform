@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/developers::general.theme.creator.title') }}
@endsection

<!-- Queue Styles -->

<!-- Queue Scripts -->

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

                <a class="brand" href="#">{{ Lang::line('platform/developers::general.theme.creator.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <hr>

    <div class="quaternary page">

        <form action="{{ URL::to_admin('developers/theme_creator') }}" method="POST" class="form-horizontal">
            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

            <fieldset>
                <legend>Theme Information</legend>

                <p class="muted">
                    In Platform, themes are very simple and designer friendly. Themes require just one, designer friendly configuration file, <kbd>theme.info</kbd>. It's a JSON file specifying options for your theme. We'll go through the process of creating this file here.
                </p>

                <div class="control-group">
                    <label class="control-label" for="form-name">Name</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="name" id="form-name" required>
                            <span class="add-on">
                                <i class="icon-font"></i>
                            </span>
                        </div>
                        <div class="help-block">
                            A user friendly name describing the theme.
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-description">Description</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="description" id="form-description">
                            <span class="add-on">
                                <i class="icon-info-sign"></i>
                            </span>
                        </div>
                        <div class="help-block">
                            A short, one or two sentence description identifying your theme.
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-author">Author</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="author" id="form-author" required>
                            <span class="add-on">
                                <i class="icon-user"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-version">Version</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="version" id="form-version" required pattern="^\d{1,2}(?:\.\d{1,2})?(?:\.\d{1,2})?$">
                            <span class="add-on">
                                <i class="icon-leaf"></i>
                            </span>
                        </div>
                        <div class="help-block">
                            We use <a href="http://php.net/manual/en/function.version-compare.php" target="_blank"><kbd>version_compare()</kbd></a> when dealing with themes. We suggest 1.0 is a good starting version.
                        </div>
                    </div>
                </div>

            </fieldset>

            <fieldset>
                <br>

                <div class="control-group">
                    <div class="controls">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">
                                Create
                            </button>
                            <button type="reset" class="btn">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
            </fieldset>

        </form>

    </div>
</section>
@endsection