@extends('templates/default')

@section('title')
{{ Lang::get('platform/content::general.title') }}
@stop

@section('assets')

@stop

@section('scripts')

@stop

@section('content')
<div class="page-header">
	<h3>
		{{ Lang::get('platform/content::general.title') }}

		<div class="pull-right">
			<a href="{{ URL::to(ADMIN_URI . '/content/create') }}" class="btn btn-info btn-small">{{ Lang::get('button.create') }}</a>
		</div>
	</h3>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>{{ Lang::get('platform/content::table.id') }}</th>
			<th>{{ Lang::get('platform/content::table.name') }}</th>
			<th>{{ Lang::get('platform/content::table.slug') }}</th>
			<th class="span2">{{ Lang::get('table.status') }}</th>
			<th class="span2">{{ Lang::get('table.actions') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($content as $row)
			<tr>
				<td class="span1">
					{{ $row->id }}
				</td>
				<td>
					{{ $row->slug }}
				</td>
				<td>
					{{ $row->name }}
				</td>
				<td>
					{{ Lang::get('general.' . ($row->status ? 'enabled' : 'disabled')) }}
				</td>
				<td>
					<div class="btn-group">
						<a href="{{ URL::to(ADMIN_URI . "/content/edit/{$row->id}") }}" class="btn btn-mini">
							{{ Lang::get('button.edit') }}
						</a>
						<a href="{{ URL::to(ADMIN_URI . "/content/clone/{$row->id}") }}" class="btn btn-mini btn-info">
							{{ Lang::get('button.clone') }}
						</a>
						<a href="{{ URL::to(ADMIN_URI . "/content/delete/{$row->id}") }}" class="btn btn-mini btn-danger">
							{{ Lang::get('button.delete') }}
						</a>
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6">
				<div class="pull-right">
					{{ $content->links() }}
				</div>
			</td>
		</tr>
	</tfoot>
</table>


@stop
