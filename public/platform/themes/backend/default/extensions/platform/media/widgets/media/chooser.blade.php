<!-- This view is loaded when somebody calls @widget('platform/media::media.chooser', 'ownervendor/ownerextension::chooser_identifier', array(options)) -->

<!-- Queue Styles -->
{{ Theme::queue_asset('media', 'platform/media::css/media.less', 'style') }}

<!-- Queue Global Scripts -->
{{ Theme::queue_asset('table', 'js/vendor/platform/table.js', array('jquery', 'url')) }}
{{ Theme::queue_asset('bootstrap-modal', 'js/bootstrap/modal.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-tab', 'js/bootstrap/tab.js', 'jquery') }}

<!-- Queue App Specific Scripts -->
{{ Theme::queue_asset('media-chooser', 'platform/media::js/jquery/mediachooser-1.0.js', array('jquery', 'file-upload-media')) }}

<!-- We wrap the entire chooser in a HTML tag with the identifier. We also use this to embed some HTML attributes for configuration options. This way, we can pass them elegently through to the jQuery plugin that handles the media choosing. -->
<div id="{{ $identifier }}" data-limit="{{ $limit }}" data-extensions='{{ implode(',', $extensions) }}' data-mimes='{{ implode(',', $mimes) }}'>

	<!-- If the user has requested a link, we show the link with the provided attributes -->
	@if ($link)
		{{ HTML::link('#', $link['title'], $link['attributes']) }}
	@endif

	<!-- The way people choose items is through a modal window. Build a unique modal window for each chooser configuration. This is because some choosers may opt out of allowing uploads or library choosing for instance. -->
	<div class="modal hide media-modal" id="media-chooser-modal-{{ $identifier }}">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>{{ Lang::line('platform/media::chooser.title') }}</h3>
		</div>
		<div class="modal-body">

			<!-- Tab divide choose methods -->
			<ul class="nav nav-tabs" id="media-chooser-tabs-{{ $identifier }}">

				<!-- Conditionally show choose methods -->
				@if ($upload !== false)
					<li>
						<a href="#media-chooser-upload-{{ $identifier }}"
							data-toggle="tab"
							@if ($default === 'upload')
								data-default-tab-{{ $identifier }}
							@endif
							data-method="upload"
						>
							{{ Lang::line('platform/media::chooser.tabs.upload') }}
						</a>
					</li>
				@endif
				@if ($library !== false)
					<li>
						<a href="#media-chooser-library-{{ $identifier }}"
							data-toggle="tab"
							@if ($default === 'library')
								data-default-tab-{{ $identifier }}
							@endif
							data-method="library"
						>
							{{ Lang::line('platform/media::chooser.tabs.library') }}
						</a>
					</li>
				@endif
			</ul>

			<div class="tab-content">

				<!-- Conditionally show choose methods -->
				@if ($upload !== false)
					<div class="tab-pane" id="media-chooser-upload-{{ $identifier }}">
						@include('platform/media::widgets.media.chooser.upload')
					</div>
				@endif
				@if ($library !== false)
					<div class="tab-pane" id="media-chooser-library-{{ $identifier }}">
						@include('platform/media::widgets.media.chooser.library')
					</div>
				@endif
			</div>
		</div>

		<div class="modal-footer">

			<!-- Validation feedback on choosing items -->
			<div class="pull-left">
				<div class="alert alert-info media-chooser-alert" id="media-chooser-under-limit-{{ $identifier }}">
					{{ Lang::line('platform/media::chooser.errors.no_files.'.(($limit == 0) ? 'no_limit' : (($limit > 1) ? 'limit' : 'single')), array('limit' => $limit)) }}
				</div>
				<div class="alert alert-error media-chooser-alert hide" id="media-chooser-over-limit-{{ $identifier }}">
					{{ Lang::line('platform/media::chooser.errors.max_number_of_files', array('limit' => $limit)) }}
				</div>
			</div>

			<!-- Choose button, closes modal window and fires callback -->
			<button type="button" class="btn btn-primary" id="media-chooser-choose-{{ $identifier }}">
				{{ Lang::line('platform/media::chooser.button.choose') }}
			</button>

			<!-- Cancel button -->
			<a href="#" class="btn" data-dismiss="modal">{{ Lang::line('button.cancel') }}</a>
		</div>
	</div>

</div>

@if ($js)
	<script>

	// Set a timeout to wait for jQuery to be available to execute it.
	(function() {
		var timeout = setInterval(function() {
			if (typeof jQuery !== 'undefined' && $.fn.mediaChooser) {

				loadMediaChooser();

				clearInterval(timeout);
			}
		}, 25);

		function loadMediaChooser() {
			$(document).ready(function() {
				$('#{{ $identifier }}').mediaChooser();
			});
		}
	})();
	</script>
@endif