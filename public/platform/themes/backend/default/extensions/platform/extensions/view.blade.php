@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/extensions::general.title') }}
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency')-->

<!-- Styles -->
@section('styles')
@endsection

<!-- Queue Scripts | e.g. Theme::queue_asset('name', 'path_to_js', 'dependency')-->

<!-- Scripts -->      
@section('scripts')      
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

                <a class="brand" href="#">{{ Lang::line('platform/extensions::general.description.view', array('extension' => array_get($extension, 'info.name'))) }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <h5>{{ Lang::line('platform/extensions::general.heading.view.information') }}</h5>

        <div id="extension-table">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td width="15%">{{ Lang::line('platform/extensions::table.name') }}</td>
                        <td>{{ array_get($extension, 'info.name') }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('platform/extensions::table.slug') }}</td>
                        <td>{{ array_get($extension, 'info.formatted_slug') }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('platform/extensions::table.is_core') }}</td>
                        <td>{{ ( array_get($extension, 'info.is_core') ? Lang::line('general.yes') : Lang::line('general.no') ) }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('platform/extensions::table.version') }}</td>
                        <td>{{ array_get($extension, 'info.version') }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('platform/extensions::table.author') }}</td>
                        <td>{{ array_get($extension, 'info.author') }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('platform/extensions::table.description') }}</td>
                        <td>{{ array_get($extension, 'info.description') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form action="{{ URL::to_admin('extensions/view/' . array_get($extension, 'info.formatted_slug')) }}" id="languages-create-form" class="form-horizontal" method="POST" accept-char="UTF-8">
            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">



            @if ($dependencies = $manager->dependencies(array_get($extension, 'info.slug')))
            <h5>{{ Lang::line('platform/extensions::general.heading.view.dependencies') }}</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="16%">{{ Lang::line('platform/extensions::table.name') }}</th>
                        <th width="16%">{{ Lang::line('platform/extensions::table.slug') }}</th>
                        <th width="40%">{{ Lang::line('general.status') }}</th>
                    </tr>
                <thead>
                <tbody>
                    @foreach ($dependencies as $dependent)
                    <?php $dependent_slug = $manager->reverse_slug($dependent); ?>
                    <tr>
                        <td><a href="{{ URL::to_admin('extensions/view/' . array_get($extensions, $dependent_slug . '.info.formatted_slug')) }}">{{ array_get($extensions, $dependent_slug . '.info.name') }}</a></td>
                        <td>{{ array_get($extensions, $dependent_slug . '.info.formatted_slug') }}</td>
                        <td>
                            @if ($manager->is_installed(array_get($extensions, $dependent_slug . '.info.slug')))
                                <span class="label label-success">{{ Lang::line('platform/extensions::table.installed') }}</span>

                                @if ($manager->is_disabled(array_get($extensions, $dependent_slug . '.info.slug')))
                                    <span class="label label-warning">{{ Lang::line('platform/extensions::table.disabled') }}</span>
                                    <span class="pull-right">
                                        <button class="btn btn-small" type="submit" name="enable_required" value="{{ $dependent }}">{{ Lang::line('platform/extensions::button.enable') }}</button>
                                    </span>
                                @else
                                    <span class="label label-success">{{ Lang::line('platform/extensions::table.enabled') }}</span>
                                @endif
                            @elseif ($manager->is_uninstalled(array_get($extensions, $dependent_slug . '.info.slug')))
                                @if ($manager->can_install(array_get($extensions, $dependent_slug . '.info.slug')))
                                    <span class="label label-warning">{{ Lang::line('platform/extensions::table.uninstalled') }}</span>
                                    <span class="pull-right">
                                        <button class="btn btn-small" type="submit" name="install_required" value="{{ $dependent }}">{{ Lang::line('platform/extensions::button.install') }}</button>
                                    </span>
                                @else
                                    @if ($manager->exists(array_get($extensions, $dependent_slug . '.info.slug')))
                                    <span class="label label-important">{{ Lang::line('extensions.dependencies') }}</span>
                                    @else
                                    <span class="label label-important">{{ Lang::line('extensions.not_found', array('extension' => $dependent)) }}</span>
                                    @endif
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if ($dependents = $manager->dependents(array_get($extension, 'info.slug')))
            <h5>{{ Lang::line('platform/extensions::general.heading.view.dependents') }}</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="16%">{{ Lang::line('platform/extensions::table.name') }}</th>
                        <th width="16%">{{ Lang::line('platform/extensions::table.slug') }}</th>
                        <th width="40%">{{ Lang::line('general.status') }}</th>
                    </tr>
                <thead>
                <tbody>
                    @foreach ($dependents as $dependent)
                    <?php $dependent_slug = $manager->reverse_slug($dependent); ?>
                    <tr>
                        <td><a href="{{ URL::to_admin('extensions/view/' . array_get($extensions, $dependent_slug . '.info.formatted_slug')) }}">{{ array_get($extensions, $dependent_slug . '.info.name') }}</a></td>
                        <td>{{ array_get($extensions, $dependent_slug . '.info.formatted_slug') }}</td>
                        <td>
                            @if ($manager->is_installed(array_get($extensions, $dependent_slug . '.info.slug')))
                                <span class="label label-success">{{ Lang::line('platform/extensions::table.installed') }}</span>

                                @if ($manager->is_disabled(array_get($extensions, $dependent_slug . '.info.slug')))
                                    <span class="label label-warning">{{ Lang::line('platform/extensions::table.disabled') }}</span>
                                    <span class="pull-right">
                                        <button class="btn btn-small" type="submit" name="enable_required" value="{{ array_get($extensions, $dependent_slug . '.info.formatted_slug') }}">{{ Lang::line('platform/extensions::button.enable') }}</button>
                                    </span>
                                @else
                                    <span class="label label-success">{{ Lang::line('platform/extensions::table.enabled') }}</span>
                                @endif
                            @elseif ($manager->is_uninstalled(array_get($extensions, $dependent_slug . '.info.slug')))
                                <span class="label label-{{ ( $manager->can_install(array_get($extensions, $dependent_slug . '.info.slug')) ? 'warning' : 'important' ) }}">{{ Lang::line('platform/extensions::table.uninstalled') }}</span>
                                @if ($manager->can_install(array_get($extensions, $dependent_slug . '.info.slug')))
                                    <span class="pull-right">
                                        <button class="btn btn-small" type="submit" name="install_required" value="{{ array_get($extensions, $dependent_slug . '.info.formatted_slug') }}">{{ Lang::line('platform/extensions::button.install') }}</button>
                                    </span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @endif

            <h5>{{ Lang::line('platform/extensions::general.heading.view.actions') }}</h5>

            @if ( $manager->is_installed(array_get($extension, 'info.slug')) )
                @if ( $manager->is_core(array_get($extension, 'info.slug')) )
                    @if ( $manager->has_update(array_get($extension, 'info.slug')) )
                        <button class="btn" type="submit" name="update" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('platform/extensions::button.update') }}</button>
                    @else
                        <span class="label label-important">{{ Lang::line('extensions.is_core') }}</span>
                    @endif
                @else
                    @if ( $manager->can_uninstall(array_get($extension, 'info.slug')) )
                        @if ( $manager->is_enabled(array_get($extension, 'info.slug')) )
                            <button class="btn" type="submit" name="disable" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('platform/extensions::button.disable') }}</button>
                        @else
                            <button class="btn" type="submit" name="enable" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('platform/extensions::button.enable') }}</button>
                        @endif

                        @if ( $manager->has_update(array_get($extension, 'info.slug')) )
                            <button class="btn" type="submit" name="update" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('platform/extensions::button.update') }}</button>
                        @endif

                        <button class="btn btn-danger" type="submit" name="uninstall" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('platform/extensions::button.uninstall') }}</button>
                    @else
                        <span class="label label-info">{{ Lang::line('extensions.required') }}</span>
                    @endif
                @endif
            @else
                @if ( ! $manager->can_install(array_get($extension, 'info.slug')) )
                    <span class="label label-warning">{{ Lang::line('extensions.requires') }}</span>
                @else
                    <div class="btn-group">
                        <button class="btn btn-info" type="submit" name="install" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('platform/extensions::button.install') }}</button>
                    </div>
                @endif
            @endif
        </form>
    </div>
</section>
@endsection