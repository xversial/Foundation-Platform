@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('extensions::general.title') }}
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

                <a class="brand" href="#">{{ Lang::line('extensions::general.description.view', array('extension' => array_get($extension, 'info.name'))) }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <h5>{{ Lang::line('extensions::general.heading.view.information') }}</h5>

        <div id="extension-table">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td width="15%">{{ Lang::line('extensions::table.name') }}</td>
                        <td>{{ array_get($extension, 'info.name') }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('extensions::table.slug') }}</td>
                        <td>{{ array_get($extension, 'info.slug') }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('extensions::table.version') }}</td>
                        <td>{{ array_get($extension, 'info.version') }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('extensions::table.author') }}</td>
                        <td>{{ array_get($extension, 'info.author') }}</td>
                    </tr>
                    <tr>
                        <td>{{ Lang::line('extensions::table.description') }}</td>
                        <td>{{ array_get($extension, 'info.description') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{ Form::open() }}
            {{ Form::token() }}

            @if ( $dependencies = Platform::extensions_manager()->dependencies(array_get($extension, 'info.slug')) )
            <h5>{{ Lang::line('extensions::general.heading.view.dependencies') }}</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="16%">{{ Lang::line('extensions::table.name') }}</th>
                        <th width="16%">{{ Lang::line('extensions::table.slug') }}</th>
                        <th width="40%">{{ Lang::line('general.status') }}</th>
                    </tr>
                <thead>
                <tbody>
                    @foreach ( $dependencies as $dependent )
                    <tr>
                        <td><a href="{{ URL::to_admin('extensions/view/' . array_get($extensions, $dependent . '.info.slug')) }}">{{ array_get($extensions, $dependent . '.info.name', $dependent) }}</a></td>
                        <td>{{ $dependent }}</td>
                        <td>
                            @if ( Platform::extensions_manager()->is_installed($dependent) )
                                <span class="label label-success">{{ Lang::line('extensions::table.installed') }}</span>

                                @if ( Platform::extensions_manager()->is_disabled($dependent) )
                                    <span class="label label-warning">{{ Lang::line('extensions::table.disabled') }}</span>
                                    <span class="pull-right">
                                        <button class="btn btn-small" type="submit" name="enable_required" value="{{ $dependent }}">{{ Lang::line('extensions::button.enable') }}</button>
                                    </span>
                                @else
                                    <span class="label label-success">{{ Lang::line('extensions::table.enabled') }}</span>
                                @endif
                            @elseif( Platform::extensions_manager()->is_uninstalled($dependent) )
                                @if ( Platform::extensions_manager()->can_install($dependent) )
                                    <span class="label label-warning">{{ Lang::line('extensions::table.uninstalled') }}</span>
                                    <span class="pull-right">
                                        <button class="btn btn-small" type="submit" name="install_required" value="{{ $dependent }}">{{ Lang::line('extensions::button.install') }}</button>
                                    </span>
                                @else
                                    @if ( Platform::extensions_manager()->exists($dependent) )
                                    <span class="label label-important">{{ Lang::line('extensions::messages.error.dependencies') }}</span>
                                    @else
                                    <span class="label label-important">{{ Lang::line('extensions::messages.error.not_found', array('extension' => $dependent)) }}</span>
                                    @endif
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            @if ( $dependents = Platform::extensions_manager()->dependents(array_get($extension, 'info.slug')) )
            <h5>{{ Lang::line('extensions::general.heading.view.dependents') }}</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="16%">{{ Lang::line('extensions::table.name') }}</th>
                        <th width="16%">{{ Lang::line('extensions::table.slug') }}</th>
                        <th width="40%">{{ Lang::line('general.status') }}</th>
                    </tr>
                <thead>
                <tbody>
                    @foreach ( $dependents as $dependent )
                    <tr>
                        <td><a href="{{ URL::to_admin('extensions/view/' . array_get($extensions, $dependent . '.info.slug')) }}">{{ array_get($extensions, $dependent . '.info.name') }}</a></td>
                        <td>{{ $dependent }}</td>
                        <td>
                            @if ( Platform::extensions_manager()->is_installed($dependent) )
                                <span class="label label-success">{{ Lang::line('extensions::table.installed') }}</span>

                                @if ( Platform::extensions_manager()->is_disabled($dependent) )
                                    <span class="label label-warning">{{ Lang::line('extensions::table.disabled') }}</span>
                                    <span class="pull-right">
                                        <button class="btn btn-small" type="submit" name="enable_required" value="{{ $dependent }}">{{ Lang::line('extensions::buttons.enable') }}</button>
                                    </span>
                                @else
                                    <span class="label label-success">{{ Lang::line('extensions::table.enabled') }}</span>
                                @endif
                            @elseif( Platform::extensions_manager()->is_uninstalled($dependent) )
                                <span class="label label-{{ ( Platform::extensions_manager()->can_install($dependent) ? 'warning' : 'important' ) }}">{{ Lang::line('extensions::table.uninstalled') }}</span>
                                @if( Platform::extensions_manager()->can_install($dependent) )
                                    <span class="pull-right">
                                        <button class="btn btn-small" type="submit" name="install_required" value="{{ $dependent }}">{{ Lang::line('extensions::button.install') }}</button>
                                    </span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @endif

            <h5>{{ Lang::line('extensions::general.heading.view.actions') }}</h5>

            @if ( Platform::extensions_manager()->is_installed(array_get($extension, 'info.slug')) )
                @if ( Platform::extensions_manager()->is_core(array_get($extension, 'info.slug')) )
                    @if ( Platform::extensions_manager()->has_update(array_get($extension, 'info.slug')) )
                        <button class="btn" type="submit" name="update" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('extensions::button.update') }}</button>
                    @else
                        <span class="label label-important">{{ Lang::line('extensions.is_core') }}</span>
                    @endif
                @else
                    @if ( Platform::extensions_manager()->can_uninstall(array_get($extension, 'info.slug')) )
                        @if ( Platform::extensions_manager()->is_enabled(array_get($extension, 'info.slug')) )
                            <button class="btn" type="submit" name="disable" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('extensions::button.disable') }}</button>
                        @else
                            <button class="btn" type="submit" name="enable" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('extensions::button.enable') }}</button>
                        @endif

                        @if ( Platform::extensions_manager()->has_update(array_get($extension, 'info.slug')) )
                            <button class="btn" type="submit" name="update" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('extensions::button.update') }}</button>
                        @endif

                        <button class="btn btn-danger" type="submit" name="uninstall" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('extensions::button.uninstall') }}</button>
                    @else
                        <span class="label label-info">{{ Lang::line('extensions.required') }}</span>
                    @endif
                @endif
            @else
                @if ( ! Platform::extensions_manager()->can_install(array_get($extension, 'info.slug')) )
                    <span class="label label-warning">{{ Lang::line('extensions.requires') }}</span>
                @else
                    <div class="btn-group">
                        <button class="btn" type="submit" name="install" value="{{ array_get($extension, 'info.slug') }}">{{ Lang::line('extensions::button.install') }}</button>
                    </div>
                @endif
            @endif
        {{ Form::close() }}
    </div>
</section>
@endsection