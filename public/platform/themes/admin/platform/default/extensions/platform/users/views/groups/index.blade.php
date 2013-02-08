@extends('templates/default')

@section('title')
{{ Lang::get('platform/users::groups/general.title') }}
@stop

@section('assets')

{{ Asset::queue('tab', 'js/vendor/bootstrap/tab.js', 'jquery') }}
{{ Asset::queue('tempo', 'js/vendor/tempo/tempo.js', 'jquery') }}
{{ Asset::queue('data-grid', 'js/vendor/cartalyst/data-grid.js', 'tempo') }}

@stop

@section('scripts')

<script>
jQuery(document).ready(function($) {
	$('#grid').dataGrid();
});
</script>

@stop

@section('content')
<div class="page-header">
	<h3>
		{{ Lang::get('platform/users::groups/general.title') }}

		<div class="pull-right">
			<a href="{{ URL::to(ADMIN_URI . '/users/groups/create') }}" class="btn btn-info btn-small">{{ Lang::get('button.create') }}</a>
		</div>
	</h3>
</div>


<div id="grid" data-source="{{ URL::to(ADMIN_URI.'/users/groups/grid') }}" data-results=".grid-results" data-filters=".grid-filters" data-applied-filters=".grid-applied-filters" data-pagination=".grid-pagination">

	<div class="grid-filters">

		<div class="clearfix">
			<div class="form-inline">

				<div class="pull-left">
					<div class="input-append">
						<input type="text" placeholder="Filter All">
						<button class="btn add-global-filter">
							Add
						</button>
					</div>
					&nbsp;
				</div>

				<div class="pull-left" data-template>

					<!-- Build different HTML based on the type -->
					[? if type == 'select' ?]
						<select class="input-small" id="grid-filters-[[column]]" data-column="[[column]]">
							<option>
								-- [[label]] --
							</option>

							<!-- Need to work out how to embed each <option> inside the <optgroup> data-template... -->
							<option data-template-for="mappings" value="[[value]]">
								[[label]]
							</option>
						</select>

						<button class="btn add-filter">
							Add
						</button>
					[? else ?]
						<div class="input-append">
							<input type="text" class="input-small" id="grid-filters-[[column]]" data-column="[[column]]" placeholder="[[label]]">

							<button class="btn add-filter">
								Add
							</button>
						</div>
						&nbsp;
					[? endif ?]

				</div>

			</div>
		</div>

	</div>

	<br>

	<ul class="nav nav-tabs grid-applied-filters">
		<li data-template>
			<a href="#" class="remove-filter">
				[? if type == 'global' ?]
					<strong>[[value]]</strong>
				[? else ?]
					<small><em>([[column]])</em></small> <strong>[[value]]</strong>
				[? endif ?]
				<span class="close" style="float: none;">&times;</span>
			</a>
		</li>
	</ul>

	<div class="tabbable tabs-right">

		<ul class="nav nav-tabs grid-pagination">
			<li data-template class="[? if active ?] active [? endif ?]">
				<a href="#" data-page="[[page]]" data-toggle="tab" class="goto-page">
					Page #[[page]]
				</a>
			</li>
		</ul>

		<div class="tab-content">

			<table class="table table-striped table-bordered grid-results">
				<thead>
					<tr>
						<th data-column="id">{{ Lang::get('platform/users::groups/table.id') }}</th>
						<th data-column="first_name">{{ Lang::get('platform/users::groups/table.name') }}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

					<tr data-template>

						<td data-column="id" class="span1">[[id]]</td>
						<td data-column="name">[[name]]</td>
						<td data-static class="span1">

							<div class="btn-group">
								<a href="{{ URL::to(ADMIN_URI.'/users/groups/edit') }}/[[id]]" class="btn btn-small">
									{{ Lang::get('button.edit') }}
								</a>
								<a href="{{ URL::to(ADMIN_URI .'/users/groups/delete') }}/[[id]]" class="btn btn-small btn-danger">
									{{ Lang::get('button.delete') }}
								</a>
							</div>

						</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>

</div>

@stop
