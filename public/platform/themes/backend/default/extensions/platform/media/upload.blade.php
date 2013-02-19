@layout('templates.default')

<!-- This template is used when Javascript is disabled. Fallback to a standard upload form -->

<!-- Page Title -->
@section('title')
	{{ Lang::line('platform/media::media.title') }}
@endsection

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

			<a class="brand" href="#">{{ Lang::line('platform/media::media.title') }}</a>

			<!-- Everything you want hidden at 940px or less, place within here -->
			<div id="tertiary-navigation" class="nav-collapse">
				@widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</div>

			</div>
		</div>
	</header>

	<hr>

	<div class="quaternary page">

		<form action="{{ Url::to_admin('media/upload') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
			<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

			<fieldset>
				<legend>{{ Lang::line('platform/media::media.upload.title') }}</legend>

				<div class="control-grouop">
					<label class="control-label" for="form-files">{{ Lang::line('platform/media::media.upload.label') }}</label>
					<div class="controls">
						<input type="file" name="files[]" id="form-files">
					</div>
				</div>

				<div class="control-grouop">
					<div class="controls">
						<button type="submit" class="btn btn-primary">
							{{ Lang::line('platform/media::media.button.upload') }}
						</button>
						<a href="{{ URL::to_admin('media') }}" class="btn">
							{{ Lang::line('button.cancel') }}
						</a>
					</div>
				</div>

			</fieldset>

		</form>

	</div>

</section>

@endsection
