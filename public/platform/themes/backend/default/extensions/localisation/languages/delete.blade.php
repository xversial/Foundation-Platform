@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('localisation::languages/general.title') }}
@endsection

<!-- Page Content -->
@section('content')
<section id="languages">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                    <span class="icon-reorder"></span>
                </a>

                <a class="brand" href="#">{{ Lang::line('localisation::languages/general.description.delete', array('language' => $language['name'])) }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform.menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    {{ Form::open() }}
        {{ Form::token() }}

        <div class="alert alert-error">
            <h3>{{ Lang::line('general.warning') }}</h3>
            
            @if ( $language['default'] )
            <p>{{ Lang::line('localisation::languages/message.delete.single.being_used', array('language' => $language['name'])) }}</p>
            @else
            <p>{{ Lang::line('localisation::languages/message.delete.single.confirm', array('language' => $language['name'])) }}</p>
            
            <button class="btn btn-danger"><i class="icon-ok icon-white"></i> Delete</button> 
            <a href="{{ URL::to_admin('localisation/languages') }}" class="btn btn-success"><i class="icon-remove icon-white"></i> {{ Lang::line('button.cancel') }}</a>
            @endif
        </div>
    {{ Form::close() }}
</section>
@endsection