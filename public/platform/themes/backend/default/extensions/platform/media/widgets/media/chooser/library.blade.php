<!-- Library tab of the media chooser widget -->

<div id="media-chooser-library-table-{{ $identifier }}">
	<div class="actions clearfix">
		<div id="table-filters" class="form-inline pull-left"></div>
	</div>

	<div id="table-filters-applied"></div>
	<hr>
	<div class="tabbable tabs-right">
		<ul id="table-pagination" class="nav nav-tabs"></ul>
		<div class="tab-content">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						@foreach ($library['columns'] as $key => $col)
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