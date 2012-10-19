@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('settings::general.title')->get() }}
@endsection

<!-- Queue Styles | e.g Theme::queue_asset('name', 'path_to_css', 'dependency')-->

<!-- Styles -->
@section ('styles')
@endsection

{{ Theme::queue_asset('platform-validate', 'js/vendor/platform/validate.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-tab', 'js/bootstrap/tab.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
@endsection

@section('content')
	<section id="settings">

		<header class="clearfix">
			<div class="pull-left">
				<h1>{{ Lang::line('settings::general.title') }}</h1>
				<p>{{ Lang::line('settings::general.description') }}</p>
			</div>
			<nav class="tertiary-navigation pull-right visible-desktop">
				@widget('platform.menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</nav>
		</header>

	    <hr>

	    <nav class="quaternary-navigation tabbable hidden-desktop">
	    	<ul class="nav nav-stacked nav-pills">
	            @foreach ( $settings as $extension => $data )
	            <li{{ ( $extension === 'settings' ? ' class="active"' : '' ) }}><a href="#tab_{{ $extension }}" data-toggle="tab">{{ Lang::line($extension . '::form.settings.legend')->get() }}</a></li>
	            @endforeach
	        </ul>
	    </nav>

	    <div class="quaternary-navigation">
		    <nav class="tabbable visable-desktop">
		    	<ul class="nav nav-tabs">
		            @foreach ( $settings as $extension => $data )
		            <li{{ ( $extension === 'settings' ? ' class="active"' : '' ) }}><a href="#tab_{{ $extension }}" data-toggle="tab">{{ Lang::line($extension . '::form.settings.legend')->get() }}</a></li>
		            @endforeach
		        </ul>
		    </nav>
		    <div class="tab-content">
		        @foreach ( $settings as $extension => $data )
		        <div class="tab-pane{{ ( $extension === 'settings' ? ' active' : '' ) }}" id="tab_{{ $extension }}">
		            @widget('platform.' . $extension . '::settings.index', $data)
		        </div>
		        @endforeach
		    </div>
		</div>


	</section>
@endsection
