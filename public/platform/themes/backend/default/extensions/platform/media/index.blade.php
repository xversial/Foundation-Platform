@layout('templates.default')

<!-- Lists all uploaded media. -->

<!-- Page Title -->
@section('title')
	{{ Lang::line('platform/media::media.title') }}
@endsection

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('media', 'platform/media::css/media.less', 'style') }}
{{ Theme::queue_asset('media-upload', 'platform/media::css/upload.less', 'style') }}

<!-- Queue Global Scripts -->
{{ Theme::queue_asset('table', 'js/vendor/platform/table.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-modal', 'js/bootstrap/modal.js', 'jquery') }}
{{ Theme::queue_asset('jquery-ui', 'js/vendor/jquery/ui-1.9.1.min.js', 'jquery') }}

<!-- Queue App Specific Scripts -->
{{ Theme::queue_asset('tmpl', 'platform/media::js/tmpl.min.js') }}
{{ Theme::queue_asset('iframe-transport', 'platform/media::js/jquery/iframe-transport-1.5.js', 'jquery') }}
{{ Theme::queue_asset('file-upload', 'platform/media::js/jquery/fileupload-5.19.3.js', array('jquery', 'jquery-ui')) }}
{{ Theme::queue_asset('file-upload-fp', 'platform/media::js/jquery/fileupload-fp-1.2.js', 'file-upload') }}
{{ Theme::queue_asset('file-upload-ui', 'platform/media::js/jquery/fileupload-ui-6.11.js', 'file-upload-fp') }}
{{ Theme::queue_asset('file-upload-media', 'platform/media::js/jquery/fileupload-media-1.0.js', 'file-upload-ui', 'tmpl') }}
{{ Theme::queue_asset('media', 'platform/media::js/media.js', array('jquery', 'bootstrap-button')) }}

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

		<div id="table">
			<div class="actions clearfix">
				<div id="table-filters" class="form-inline pull-left"></div>
				<div class="pull-right">
					<a class="btn btn-large btn-primary" href="{{ URL::to_secure(ADMIN.'/media/upload') }}" id="media-upload-link" data-loading-text="{{ Lang::line('button.loading') }}">{{ Lang::line('platform/media::media.button.upload') }}</a>
				</div>
			</div>

			<div id="table-filters-applied"></div>
			<hr>
			<div class="tabbable tabs-right">
				<ul id="table-pagination" class="nav nav-tabs"></ul>
				<div class="tab-content">
					<table id="media-table" class="table table-bordered table-striped">
						<thead>
							<tr>
								@foreach ($columns as $key => $col)
								<th data-table-key="{{ $key }}">{{ $col }}</th>
								@endforeach
								<th></th>
							</tr>
						<thead>
						<tbody></tbody>
					</table>
				</div>
			</div>

		</div>

	</div>

	<div class="modal hide media-modal media-upload-modal" id="media-upload-modal">
		<div class="modal-header">
			<h3>{{ Lang::line('platform/media::media.upload.title') }}</h3>
		</div>
		<div class="modal-body">
			@render('platform/media::upload.form', array('identifier' => $identifier, 'choose' => false))
		</div>
		<div class="modal-footer">
			<div class="pull-left">
				<a href="{{ URL::to_admin('media/upload') }}">
					{{ Lang::line('platform/media::media.upload.native_link') }}
				</a>
			</div>

			<a href="#" class="btn btn-primary" data-dismiss="modal">
				{{ Lang::line('button.done') }}
			</a>
		</div>
	</div>

</section>

@widget('platform/application::modal.confirm')

@endsection


<!-- Scripts -->
@section('scripts')
<script>
$(document).ready(function() {

	var data = {
		formData : {
			vendor:    '{{ $vendor }}',
			extension: '{{ $extension }}'
		},
		acceptFileTypes: /^({{ str_replace('/', '\/', implode('|', $mimes)) }})$/i,
		uploadTemplateId: 'media-upload-template-static',
		downloadTemplateId: 'media-download-template-static',

		// jQuery plugin requires size in Bytes, Laravel uses KB
		maxFileSize: {{ ($_valid = (int) $max_file_size) ? $_valid * 1024 : 'undefined' }}
	}

	// Grab the CSRF data
	if ((csrf = $('#media-upload-csrf-static')) && csrf.length) {
		data.formData[csrf.attr('name')] = csrf.val();
	}

	$('#media-upload-static').fileupload(data);
});
</script>
@endsection