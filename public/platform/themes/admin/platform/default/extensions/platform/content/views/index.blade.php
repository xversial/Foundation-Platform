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
			<th>{{ Lang::get('table.actions') }}</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($contentRows as $content)
			<tr>
				<td>
					{{ $content->id }}
				</td>
				<td>
					{{ $content->name }}
				</td>
				<td class="span2">
					<div class="btn-group">
						<a href="{{ URL::to(ADMIN_URI . "/content/edit/{$content->id}") }}" class="btn btn-small">
							{{ Lang::get('button.edit') }}
						</a>
						<a href="{{ URL::to(ADMIN_URI . "/content/delete/{$content->id}") }}" class="btn btn-small btn-danger">
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
					{{ $contentRows->links() }}
				</div>
			</td>
		</tr>
	</tfoot>
</table>


@stop
