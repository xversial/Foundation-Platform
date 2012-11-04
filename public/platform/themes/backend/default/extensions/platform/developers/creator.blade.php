@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/developers::general.creator.title') }}
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
                <legend>1. Extension Information</legend>

                <p class="muted">
                    Whether you're distributing your extension or just keeping it for yourself, it's good to have a visual reference of what the extension is. We will provide some basic information about the extension here, which will save you putting it in later on.
                </p>

                <div class="control-group">
                    <label class="control-label" for="form-extension">Name</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="extension" id="form-extension" required>
                            <span class="add-on">
                                <i class="icon-font"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-extension">Author</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text" name="extension" id="form-extension" required>
                            <span class="add-on">
                                <i class="icon-font"></i>
                            </span>
                        </div>
                    </div>
                </div>

            </fieldset>

            <fieldset>
                <legend>2. Code Settings</legend>

                <p class="muted">
                    Now we have the pretty stuff out of the way, it's time to get down to business. Here, we'll setup the code side of the extension. It's ideal to put some thought into this section of the extension, because if you decide to change these properties after you've developed and integrated your extension, there can be a lot of find and replace work to do to achieve this change.
                </p>

                <div class="control-group">
                    <label class="control-label" for="form-vendor">Vendor</label>
                    <div class="controls">
                        <div class="input-append">
                            <input type="text"
                                   name="vendor"
                                   id="form-vendor"
                                   required
                                   @if ($reserved_vendors)
                                       pattern="(?!^{{ implode('|', $reserved_vendors) }}$).*"
                                   @endif>
                            <span class="add-on">
                                <i class="icon-group"></i>
                            </span>
                        </div>
                        <div class="help-block">
                            <p>
                                A vendor name is the namespace for your extension when people refer to it in code. It will most likely match your Author name, however you may wish to shorten it here or change it.
                                @if ($reserved_vendors)
                                    The following vendors are reserved and should not be used:
                                    <br>

                                    @foreach ($reserved_vendors as $reserved_vendor)
                                        <span class="label">
                                            <kbd>{{ $reserved_vendor }}</kbd>
                                        </span>&nbsp;
                                    @endforeach
                                @endif
                            </p>
                        </div>
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
                        <div class="help-block">
                            <p>
                                Like the vendor name above, Extension refers to the extension name. All extensions named the same become grouped when collected. For example, if you name your extension <kbd>users</kbd>, it will be grouped with the <kbd>users</kbd> extension that ships with Platform. Only one extension can respond to a URI route, (such as <kbd>/users</kbd>). If you are using the same name as another extension, you are encouraged to make sure you override it below, so that your extension essentially extends the other one. The following extension names are currently being used:
                                <br>
                                @foreach ($extensions as $extension_name => $vendors)
                                    <span class="label">
                                        <kbd>{{ $extension_name }}</kbd>
                                    </span>&nbsp;
                                @endforeach
                            </p>
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