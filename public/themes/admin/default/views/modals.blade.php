{{ Asset::queue('platform-helpers', 'js/vendor/platform/helpers.js', 'bootstrap-modal') }}
{{ Asset::queue('modal', 'js/vendor/bootstrap/modal.js', 'jquery') }}

<div id="platform-modal-confirm" class="modal hide fade">

	<div class="modal-header">

		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h2>{{ trans('general.warning') }}</h2>

	</div>

	<div class="modal-body">

		<h4>{{ trans('general.delete_record') }}</h4>

	</div>

	<div class="modal-footer">
		<button class="btn btn-cancel" data-dismiss="modal" aria-hidden="true"><i class="icon-circle-arrow-left"></i> {{ trans('button.cancel') }}</button>
		<a href="#" class="btn btn-primary confirm"><i class="icon-trash"></i> {{ trans('button.delete') }}</a>
	</div>

</div>
