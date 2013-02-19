@layout('templates.default')

<!-- This template is used when viewing uploaded media items -->

<!-- Page Title -->
@section('title')
	{{ Lang::line('platform/media::media.general.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('table', 'css/table.css', 'style') }}

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('media', 'platform/media::css/media.less', 'style') }}

{{ Theme::queue_asset('table', 'js/vendor/platform/table.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-modal', 'js/bootstrap/modal.js', 'jquery') }}
{{ Theme::queue_asset('media', 'platform/media::js/media.js', array('jquery', 'bootstrap-modal')) }}

<!-- Scripts -->
@section('scripts')
@endsection

<!-- Page Content -->
@section('content')
<section id="media-manager">

	<!-- Tertiary Navigation & Actions -->
	<header class="navbar">
		<div class="navbar-inner">
			<div class="container">

			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<a class="brand" href="#">{{ Lang::line('platform/media::media.view.title') }} - {{ $media['name'] }}</a>

			<!-- Everything you want hidden at 940px or less, place within here -->
			<div id="tertiary-navigation" class="nav-collapse">
				@widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</div>

			</div>
		</div>
	</header>

	<hr>

	<div class="quaternary page">
		@if ( $media['file_extension'] == 'pdf' )
			<img src="{{ Theme::asset('platform/media::img/thumbnail-pdf.png') }}" class="img-polaroid">
		@else
			<img src="{{ $media['thumbnail_url'] }}" class="img-polaroid">
		@endif


		<dl class="dl-horizontal">
			<!-- Extension -->
			<dt>{{ Lang::line('platform/media::media.general.extension') }}</dt>
			<dd>{{ $media['extension'] }}</dd>

			<!-- Name -->
			<dt>{{ Lang::line('platform/media::media.general.name') }}</dt>
			<dd>{{ $media['name'] }}</dd>

			<!-- File Path -->
			<dt>{{ Lang::line('platform/media::media.general.file_path') }}</dt>
			<dd>{{ $media['file_path'] }}</dd>

			<!-- File Name -->
			<dt>{{ Lang::line('platform/media::media.general.file_name') }}</dt>
			<dd>{{ $media['file_name'] }}</dd>

			<!-- File Extension -->
			<dt>{{ Lang::line('platform/media::media.general.file_extension') }}</dt>
			<dd>{{ $media['file_extension'] }}</dd>

			<!-- MIME Type -->
			<dt>{{ Lang::line('platform/media::media.general.mime') }}</dt>
			<dd>{{ $media['mime'] }}</dd>

			<!-- Size -->
			<dt>{{ Lang::line('platform/media::media.general.size') }}</dt>
			<dd>{{ $media['size_human'] ?: $media['size'] }}</dd>

			<!-- Width -->
			@if ($media['width'])
				<dt>{{ Lang::line('platform/media::media.general.width') }}</dt>
				<dd>{{ $media['width'] }} px</dd>
			@endif

			<!-- Height -->
			@if ($media['width'])
				<dt>{{ Lang::line('platform/media::media.general.height') }}</dt>
				<dd>{{ $media['height'] }} px</dd>
			@endif

			<!-- Uploaded -->
			<dt>{{ Lang::line('platform/media::media.general.updated_at') }}</dt>
			<dd>{{ date('g:ia - m.d.y', $media['created_at']) }}</dd>

		</dl>

		<div class="form-actions">
			<a class="btn" href="{{ URL::to_secure(ADMIN.'/media') }}">{{ Lang::line('button.back') }}</a>
		</div>

	</div>

</section>

@endsection
