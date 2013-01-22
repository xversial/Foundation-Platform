@extends('templates/default')

@section('assets')

{{ Asset::queue('tempo', 'js/vendor/tempo/tempo.js', 'jquery') }}
{{ Asset::queue('data-grid', 'js/vendor/cartalyst/data-grid.js', 'tempo') }}

@stop

@section('scripts')

<script>

$('#grid').dataGrid();

</script>

@stop

@section('content')

<div id="grid" data-source="{{ URL::to('grid/source') }}" data-results=".grid-results" data-filters=".grid-filters" data-applied-filters=".grid-applied-filters" data-pagination=".grid-pagination">

	<div class="grid-filters">
		<ul class="nav">
			<li>
				<div class="form-inline">
					<input type="text">
					<button class="btn add-global-filter">
						Add Global Filter
					</button>
				</div>
			</li>
			<li data-template>
				<div class="form-inline">

					<!-- Label -->
					<label for="grid-filters-[[index]]">[[label]]</label>

					<!-- Build different HTML based on the type -->
					[? if type == 'select' ?]
						<select data-index="[[index]]" id="grid-filters-[[index]]">
							<option value="">
								-- Please Select --
							</option>

							<!-- Need to work out how to embed each <option> inside the <optgroup> data-template... -->
							<optgroup data-template-for="mappings" label="Option">
								<option value="[[index]]">
									[[label]]
								</option>
							</optgroup>
						</select>
					[? else ?]
						<input type="text" data-index="[[index]]" id="grid-filters-[[index]]">
					[? endif ?]

					<!-- "Add Filter" button -->
					<button class="btn add-filter">
						Add Filter
					</button>

				</div>
			</li>
		</ul>
	</div>

	<ul class="nav nav-tabs grid-applied-filters">
		<li data-template>
			<a href="#" class="remove-filter">
				[? if type == 'global' ?]
					<strong>[[value]]</strong>
				[? else ?]
					<small><em>([[index]])</em></small> <strong>[[value]]</strong>
				[? endif ?]
				<span class="close" style="float: none;">&times;</span>
			</a>
		</li>
	</ul>

	<div class="tabbable tabs-right">

		<ul class="nav nav-tabs grid-pagination">
			<li data-template>
				<a href="#" data-page="[[number]]" class="goto-page">
					Page #[[page]]
				</a>
			</li>
		</ul>

		<div class="tab-content">

			<table class="table table-striped table-bordered grid-results">
				<thead>
					<tr>
						<th>ID</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Country</th>
						<th>Activated</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr data-template>
						<td data-index="id">[[id]]</td>
						<td data-index="first_name">[[first_name]]</td>
						<td data-index="last_name">[[last_name]]</td>
						<td data-index="country">
							[? if country ?]
								[[country]]
							[? endif ?]
						</td>
						<td data-type="select" data-index="activated" data-mappings="Yes:1|No:0">
							[? if activated == 1 ?]
								Yes
							[? else ?]
								No
							[? endif ?]
						</td>
						<td data-no-filters>
							<a href="{{ URL::to(ADMIN_URI.'/users/edit') }}/[[id]]">Edit [[first_name]]</a>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>

</div>

@stop
