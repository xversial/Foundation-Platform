<!-- The shared upload form. This is used by the chooser widget and the media management section. It's dynamic to adapt to both scenarios. -->

<script>

// Window media object
window.media = {

	// Upload object
	upload: {

		// Errors object
		errors: {
			maxFileSize:      '{{ Lang::line('platform/media::chooser.upload.errors.max_file_size') }}',
			minFileSize:      '{{ Lang::line('platform/media::chooser.upload.errors.min_file_size') }}',
			acceptFileTypes:  '{{ Lang::line('platform/media::chooser.upload.errors.accepted_file_types') }}',
			maxNumberOfFiles: '{{ Lang::line('platform/media::chooser.upload.errors.max_number_of_files') }}',
			uploadedBytes:    '{{ Lang::line('platform/media::chooser.upload.errors.uploaded_bytes') }}',
			emptyResult:      '{{ Lang::line('platform/media::chooser.upload.errors.empty_result') }}'
		}
	}
}

</script>

<div id="media-upload-{{ $identifier }}" data-url="{{ URL::to_secure(ADMIN.'/media/upload') }}">
	<input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}" id="media-upload-csrf-{{ $identifier }}">

	<div class="clearfix fileupload-buttonbar">
		<span class="btn btn-primary fileinput-button">
			<i class="icon-plus icon-white"></i>
			<span>{{ Lang::line('platform/media::chooser.upload.add') }}</span>
			<input type="file" name="files[]" multiple>
		</span>

		<div class="pull-right">

			<div class="pull-left">
				<!-- The global progress information -->
				<div class="media-upload-progress fade">

					<!-- The global progress bar -->
					<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
						<div class="bar" style="width:0%;"></div>
					</div>

					<!-- The extended global progress information -->
					<div class="progress-extended">&nbsp;</div>
				</div>
			</div>

			<div class="pull-right">
				<button type="button" class="btn start">
					<i class="icon-upload"></i>
					<span>{{ Lang::line('platform/media::chooser.upload.start') }}</span>
				</button>
				<button type="reset" class="btn cancel">
					<i class="icon-ban-circle"></i>
					<span>{{ Lang::line('platform/media::chooser.upload.cancel') }}</span>
				</button>
			</div>

		</div>
	</div>

	<!-- The loading indicator is shown during file processing -->
	<div class="media-upload-loading"></div>

	<!-- The table listing the files available for upload/download -->
	<table role="presentation" class="table table-striped">
		<tbody class="files"></tbody>
	</table>
</div>

<!-- The template to display files available for upload -->
<script id="media-upload-template-{{ $identifier }}" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<tr class="template-upload fade">

		<td class="name"><span>{%=file.name%}</span></td>
		<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
		{% if (file.error) { %}
			<td class="error" colspan="2"><span class="label label-important">{{ Lang::line('platform/media::chooser.upload.error') }}</span> {%=media.upload.errors[file.error] || file.error%}</td>
		{% } else if (o.files.valid && !i) { %}
			<td>
				<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
			</td>
			<td class="start">{% if (!o.options.autoUpload) { %}
				<button class="btn">
					<i class="icon-upload"></i>
					<span>{{ Lang::line('platform/media::chooser.upload.start') }}</span>
				</button>
			{% } %}</td>
		{% } else { %}
			<td colspan="2"></td>
		{% } %}
		<td class="cancel">{% if (!i) { %}
			<button class="btn">
				<i class="icon-ban-circle"></i>
				<span>{{ Lang::line('platform/media::chooser.upload.cancel') }}</span>
			</button>
		{% } %}</td>
	</tr>
{% } %}
</script>

<!-- The template to display files available for download -->
<script id="media-download-template-{{ $identifier }}" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
	<tr class="template-download fade">
		{% if (file.error) { %}
			<td colspan="2"></td>
			<td class="name"><span>{%=file.name%}</span></td>
			<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			<td class="error" colspan="2"><span class="label label-important">{{ Lang::line('platform/media::chooser.upload.error') }}</span> {%=media.upload.errors[file.error] || file.error%}</td>
		{% } else { %}
			@if (isset($chooser) and $chooser === true)
				<td>
					<input type="{%=o.options.chooseStyle == 'radio' ? 'radio' : 'checkbox'%}" name="__media_chosen__" class="media-chosen" value="{%=file.id%}"
					       data-id="{%=file.id%}"
					       data-name="{%=file.name%}"
					       data-file-path="{%=file.file_path%}"
					       data-file-name="{%=file.file_name%}"
					       data-file-extension="{%=file.file_extension%}"
					       data-full-path="{%=file.full_path%}"
					       data-url="{%=file.url%}"
					       data-thumbnail-url="{%=file.thumbnail_url%}"
					       data-mime="{%=file.mime%}"
					       data-size="{%=file.size%}"
					       data-size-human="{%=file.size_human%}"
					       data-width="{%=file.width%}"
					       data-height="{%=file.height%}">
				</td>
			@endif
			<td class="name">
				<a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
			</td>
			<td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
			<td colspan="2"></td>
		{% } %}
		<td class="delete">
			<button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
				<i class="icon-trash icon-white"></i>
				<span>{{ Lang::line('platform/media::chooser.upload.destroy') }}</span>
			</button>
		</td>
	</tr>
{% } %}
</script>