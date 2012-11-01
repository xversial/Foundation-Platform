@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/localisation::currencies/general.title')->get() }}
@endsection

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

                <a class="brand" href="{{ URL::to_admin('localisation/currencies') }}">{{ Lang::line('platform/localisation::currencies/general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <h2>{{ Lang::line('platform/localisation::currencies/general.description.delete', array('currency' => $currency['name'])) }}</h2>

    <form action="{{ URL::to_admin('localisation/currencies/delete/' . $currency['slug']) }}" id="currencies-delete-form" class="form-horizontal" method="POST" accept-char="UTF-8">
        <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

        <div class="alert alert-error">
            <h3>{{ Lang::line('general.warning')->get() }}</h3>

            @if ( $currency['default'] )
            <p>{{ Lang::line('platform/localisation::currencies/message.delete.single.being_used', array('currency' => $currency['name']))->get() }}</p>
            @else
            <p>{{ Lang::line('platform/localisation::currencies/message.delete.single.confirm', array('currency' => $currency['name']))->get() }}</p>

            <button class="btn btn-danger"><i class="icon-ok icon-white"></i> Delete</button>
            <a href="{{ URL::to_admin('localisation/currencies') }}" class="btn btn-success"><i class="icon-remove icon-white"></i> {{ Lang::line('button.cancel')->get() }}</a>
            @endif
        </div>
    </form>
</section>
@endsection