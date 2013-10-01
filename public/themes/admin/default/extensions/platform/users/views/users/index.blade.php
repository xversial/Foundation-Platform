@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{{ trans('platform/users::users/general.title') }}} ::
@parent
@stop

{{-- Queue assets --}}
{{ Asset::queue('tempo', 'js/tempo/tempo.js', 'jquery') }}
{{ Asset::queue('data-grid', 'js/cartalyst/data-grid.js', 'tempo') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
<script>
$(function()
{

	$.datagrid('main', '.data-grid', '.data-grid_pagination', '.data-grid_applied', {
		loader: '.loading',
		type: 'single',
		sort: {
			column: 'created_at',
			direction: 'desc'
		},
		callback: function(obj) {

			$('.total').html(obj.filterCount);
			$('.tip').tooltip();

		}
	});

});
</script>
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-12">

		{{-- Page header --}}
		<div class="page-header">

			<span class="pull-right">

				<form method="post" action="" accept-charset="utf-8" data-search data-grid="main" class="form-inline" role="form">

					<div class="form-group">

						<div class="loading"></div>

					</div>

					<div class="form-group">
						<select class="form-control" name="column">
							<option value="all">{{{ trans('general.all') }}}</option>
							<option value="first_name">{{{ trans('platform/users::users/table.first_name') }}}</option>
							<option value="last_name">{{{ trans('platform/users::users/table.last_name') }}}</option>
							<option value="email">{{{ trans('platform/users::users/table.email') }}}</option>
							<option value="created_at">{{{ trans('platform/users::users/table.created_at') }}}</option>
						</select>
					</div>

					<div class="form-group">
						<input name="filter" type="text" placeholder="{{{ trans('general.search') }}}" class="form-control">
					</div>

					<button class="btn btn-default"><i class="icon-search"></i></button>
				</form>

			</span>

			<h1>{{{ trans('platform/users::users/general.title') }}}</h1>

		</div>

		{{-- Data Grid : Applied Filters --}}
		<div class="clearfix">

			<div class="pull-right">
				<a class="btn btn-warning tip" href="{{ URL::toAdmin('users/create') }}" title="{{{ trans('button.create') }}}"><i class="icon-plus"></i></a></li>
			</div>

			<div class="data-grid_applied" data-grid="main">

				<span data-template style="display: none;">

					<button type="button" class="btn btn-info tip" title="Remove filter">
						[? if column == undefined ?]
							[[ valueLabel ]]
						[? else ?]
							[[ valueLabel ]] {{{ trans('general.in') }}} <em>[[ columnLabel ]]</em>
						[? endif ?]
						<i class="icon-remove-sign"></i>
					</button>

				</span>

			</div>

		</div>

		<br />

		<table data-source="{{ URL::toAdmin('users/grid') }}" data-grid="main" class="data-grid table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th data-sort="first_name" data-grid="main" class="col-md-2 sortable">{{{ trans('platform/users::users/table.first_name') }}}</th>
					<th data-sort="last_name" data-grid="main" class="col-md-2 sortable">{{{ trans('platform/users::users/table.last_name') }}}</th>
					<th data-sort="email" data-grid="main" class="col-md-2 sortable">{{{ trans('platform/users::users/table.email') }}}</th>
					<th data-sort="activated" data-grid="main" class="col-md-2 sortable">{{{ trans('platform/users::users/table.activated') }}}</th>
					<th data-sort="created_at" data-grid="main" class="col-md-2 sortable">{{{ trans('platform/users::users/table.created_at') }}}</th>
					<th class="col-md-2"></th>
				</tr>
			</thead>
			<tbody>
				<tr data-template style="display: none;">
					<td>[[ first_name ]]</td>
					<td>[[ last_name ]]</td>
					<td><a href="mailto:[[ email ]]">[[ email ]]</a></td>
					<td>
						[? if activated ?]
							{{{ trans ('general.yes') }}}
						[? else ?]
							{{{ trans ('general.yes') }}}
						[? endif ?]
					</td>
					<td>[[ created_at ]]</td>
					<td>
						[? if id != {{ Sentry::getId() }} ?]
						<a class="btn btn-danger tip" data-toggle="modal" data-target="modal-confirm" href="{{ URL::toAdmin('users/delete/[[ id ]]') }}" data-title="{{{ trans('button.delete') }}}"><i class="icon-trash"></i></a>
						[? endif ?]

						<a class="btn btn-primary tip" href="{{ URL::toAdmin('users/edit/[[ id ]]') }}" title="{{{ trans('button.edit') }}}"><i class="icon-edit"></i></a>
					</td>
				</tr>
				<tr data-results-fallback style="display: none;">
					<td colspan="6" class="no-results">
						{{{ trans('table.no_results') }}}
					</td>
				</tr>
			</tbody>
		</table>

		{{-- Data Grid : Pagination --}}
		<div class="data-grid_pagination" data-grid="main">
			<div data-template style="display: none;">

				<div class="pull-right">

					<ul class="pagination pagination-sm">
						[? if prevPage !== null ?]
						<li><a data-page="[[ prevPage ]]"><i class="icon-chevron-left"></i></a></li>
						[? else ?]
						<li class="disabled"><a><i class="icon-chevron-left"></i></a></li>
						[? endif ?]

						[? if nextPage !== null ?]
						<li><a  data-page="[[ nextPage ]]"><i class="icon-chevron-right"></i></a></li>
						[? else ?]
						<li class="disabled"><a><i class="icon-chevron-right"></i></a></li>
						[? endif ?]
					</ul>

				</div>

				<div class="count">Showing [[ pageStart ]] to [[ pageLimit ]] {{{ trans('general.of') }}} <span class="total"></span> entries</div>

			</div>
		</div>

	</div>

</div>

@stop
