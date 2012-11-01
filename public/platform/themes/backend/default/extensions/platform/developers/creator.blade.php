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

                <a class="brand" href="#">{{ Lang::line('platform/developers::general.creator.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <hr>

    <div class="quaternary page">

        <form action="{{ URL::to_admin('developers/creator') }}" method="POST" class="form-horizontal">
            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

            <fieldset>
                <legend>1. Required</legend>

                <div class="control-group">
                    <label class="control-label" for="form-vendor">Vendor</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="vendor" id="form-vendor" required>
                            <span class="add-on">
                                <i class="icon-group"></i>
                            </span>
                        </div>
                        <span class="help-block">
                            <strong>Note:</strong> {{ 'platform' }} is a reserved vendor and should not be used.
                        </span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-extension">Extension</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="extension" id="form-extension" required>
                            <span class="add-on">
                                <i class="icon-folder-open"></i>
                            </span>
                        </div>
                    </div>
                </div>


            </fieldset>

            <fieldset>
                <legend>2. Optional</legend>

                <div class="control-group">
                    <label class="control-label">Vendor</label>
                    <div class="controls">
                        <input type="text" name="a" required>
                    </div>
                </div>

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