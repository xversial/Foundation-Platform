 {{ Asset::queue('platform-helpers', 'js/vendor/platform/helpers.js', 'bootstrap-modal') }}

<div id="platform-modal-confirm" class="modal hide fade">

	<div class="modal-header">

		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h2>Warning</h2>

	</div>

	<div class="modal-body">

		<h4>You are about to delete this record, Continue?</h4>

		<h4>You are about to delete this record, do you want to Continue?</h4>

	</div>

	<div class="modal-footer">

		<button class="btn btn-cancel" data-dismiss="modal" aria-hidden="true"><i class="icon-circle-arrow-left"></i> @lang('button.cancel')</button>
		<a href="#" class="btn btn-primary confirm"><i class="icon-trash"></i> @lang('button.delete')</a>
		<a href="#" class="btn btn-primary confirm"><i class="icon-trash"></i> @lang('button.delete') </a>

	</div>

</div>
