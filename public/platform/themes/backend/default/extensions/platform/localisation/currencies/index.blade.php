@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('localisation::currencies/general.title') }}
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('table', 'js/vendor/platform/table.js', 'jquery') }}
{{ Theme::queue_asset('currencies', 'localisation::js/currencies.js', 'jquery') }}

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

                <a class="brand" href="#">{{ Lang::line('localisation::currencies/general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform.menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <div id="table">
            <div class="actions clearfix">
                <div id="table-filters" class="form-inline pull-left"></div>
                <div class="processing pull-left"></div>
                <div class="pull-right">
                    <a class="btn btn-large btn-primary" href="{{ URL::to_admin('localisation/currencies/create') }}">{{ Lang::line('button.create') }}</a>
                </div>
            </div>

            <div id="table-filters-applied"></div>

            <hr>

            <div class="tabbable tabs-right">
                <ul id="table-pagination" class="nav nav-tabs"></ul>
                <div class="tab-content">
                    <table id="currencies-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th data-table-key="name" class="span4">{{ Lang::line('localisation::currencies/table.name') }}</th>
                                <th data-table-key="code"class="span2">{{ Lang::line('localisation::currencies/table.code') }}</th>
                                <th class="span2"></th>
                            </tr>
                        <thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection