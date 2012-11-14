
{{ Theme::queue_asset('bootstrap-modal', 'js/bootstrap/modal.js', 'jquery') }}
{{ Theme::queue_asset('platform-helpers', 'js/vendor/platform/helpers.js', 'bootstrap-modal') }}

<div id="platform-modal-confirm" class="modal hide fade in">
		<div class="modal-header">
			<h2>{{ Lang::line('general.warning') }}</h2>
		</div>
		<div class="modal-body">
			 <h4>{{ Lang::line('general.messages.delete') }}</h4>

		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-cancel" data-dismiss="modal" aria-hidden="true"><i class="icon-circle-arrow-left"></i> {{ Lang::line('button.cancel') }}</button>
			<a href="#" class="btn btn-primary confirm"><i class="icon-trash"></i> {{ Lang::line('button.delete') }}</a>
		</div>
</div>
