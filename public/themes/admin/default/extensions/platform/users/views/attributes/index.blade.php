@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{{ trans('platform/users::attributes/general.title') }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">

	<div class="col-md-12">

		{{-- Page header --}}
		<div class="page-header">

			<h1>{{{ trans('platform/users::attributes/general.title') }}}</h1>

		</div>

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th data-sort="first_name" data-grid="main" class="col-md-2 sortable">* Attribute Name</th>
					<th class="col-md-2"></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($attributes as $attribute)
				<tr>
					<td>{{{ $attribute->name }}}</td>
					<td>

					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>

</div>

@stop
