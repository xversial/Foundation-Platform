@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/extensions::general.title') }}
@endsection

<!-- Page Content -->
@section('content')
<section id="extensions">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                    <span class="icon-reorder"></span>
                </a>

                <a class="brand" href="#">{{ Lang::line('platform/extensions::general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <table id="extensions-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="span2">{{ Lang::line('platform/extensions::table.name') }}</th>
                    <th class="span2">{{ Lang::line('platform/extensions::table.vendor') }}</th>
                    <th class="span1">{{ Lang::line('platform/extensions::table.version') }}</th>
                    <th class="span4">{{ Lang::line('platform/extensions::table.description') }}</th>
                    <th class="span3">{{ Lang::line('platform/extensions::table.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($extensions as $vendors)
                @foreach ($vendors as $extension)

                <tr>
                    <td>{{ array_get($extension, 'info.name') }}</td>
                    <td>{{ array_get($extension, 'info.vendor') }}</td>
                    <td>{{ array_get($extension, 'info.version') }}</td>
                    <td>
                        {{ array_get($extension, 'info.description') }}

                        @if ( ! $manager->is_installed(array_get($extension, 'info.slug')) and ! $manager->can_install(array_get($extension, 'info.slug')) )
                            <span class="pull-right label label-warning">{{ Lang::line('general.required') }}: {{ implode(', ', $manager->required_extensions(array_get($extension, 'info.slug')) ) }}</span>
                        @endif
                        @if ( $manager->has_update(array_get($extension, 'info.slug')) )
                            <span class="pull-right label label-info">{{ Lang::line('platform/extensions::table.has_updates') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ URL::to_admin('extensions/view/' . array_get($extension, 'info.formatted_slug') ) }}" class="btn btn-small">{{ Lang::line('button.details') }}</a>

                            @if ( $manager->is_installed(array_get($extension, 'info.slug')) )

                                @if ( $manager->is_enabled(array_get($extension, 'info.slug')) )
                                    @if ( $manager->can_disable(array_get($extension, 'info.slug')) )
                                        <a class="btn btn-small" href="{{ URL::to_admin('extensions/disable/' . array_get($extension, 'info.formatted_slug')) }}">{{ Lang::line('platform/extensions::button.disable') }}</a>
                                    @else
                                        <a class="btn btn-small disabled">{{ Lang::line('platform/extensions::button.disable') }}</a>
                                    @endif
                                @else
                                    @if ( $manager->can_enable(array_get($extension, 'info.slug')) )
                                        <a class="btn btn-small" href="{{ URL::to_admin('extensions/enable/' . array_get($extension, 'info.formatted_slug')) }}">{{ Lang::line('platform/extensions::button.enable') }}</a>
                                    @else
                                        <a class="btn btn-small disabled">{{ Lang::line('platform/extensions::button.enable') }}</a>
                                    @endif
                                @endif

                                @if ( $manager->can_uninstall(array_get($extension, 'info.slug')) )
                                    <a class="btn btn-small btn-danger" href="{{ URL::to_admin('extensions/uninstall/' . array_get($extension, 'info.formatted_slug')) }}">{{ Lang::line('platform/extensions::button.uninstall') }}</a>
                                @else
                                    <a class="btn btn-small disabled">{{ Lang::line('platform/extensions::button.uninstall') }}</a>
                                @endif

                                @if ( $manager->has_update(array_get($extension, 'info.slug')))
                                    <a class="btn btn-small" href="{{ URL::to_admin('extensions/update/' . array_get($extension, 'info.formatted_slug')) }}">{{ Lang::line('platform/extensions::button.update') }}</a>
                                @endif
                            @else
                                @if ( $manager->can_install(array_get($extension, 'info.slug')) )
                                    <a class="btn btn-small btn-info" href="{{ URL::to_admin('extensions/install/' . array_get($extension, 'info.formatted_slug')) }}">{{ Lang::line('platform/extensions::button.install') }}</a>
                                @else
                                    <a class="btn btn-small disabled">{{ Lang::line('platform/extensions::button.install') }}</a>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>

                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
