@extends('templates/default')

@section('title')
{{ Lang::get('platform/pages::general.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')
<div class="page-header">
	<h3>
		{{ Lang::get('platform/pages::general.title') }}

		<div class="pull-right">
			<a href="{{ URL::to(ADMIN_URI . '/pages/create') }}" class="btn btn-info btn-small">{{ Lang::get('button.create') }}</a>
		</div>
	</h3>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ Lang::get('platform/pages::table.id') }}</th>
			<th>{{ Lang::get('platform/pages::table.slug') }}</th>
			<th>{{ Lang::get('platform/pages::table.name') }}</th>
			<th>{{ Lang::get('table.actions') }}</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">
				<div class="pull-right">
					{ $pages->links() }}
				</div>
			</td>
		</tr>
	</tfoot>
</table>


@stop
